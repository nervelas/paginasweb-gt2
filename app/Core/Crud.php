<?php
namespace App\Core;

/** Motor genérico de listado, edición y guardado para los módulos del panel. */
class Crud
{
    /** @var array */
    private $def;
    /** @var string */
    private $clave;

    public function __construct($clave, array $def)
    {
        $this->clave = $clave;
        $this->def   = $def;
    }

    public function def()
    {
        return $this->def;
    }

    public function clave()
    {
        return $this->clave;
    }

    public function permiteCrear()
    {
        return !isset($this->def['crear']) || $this->def['crear'] !== false;
    }

    public function permiteBorrar()
    {
        return !isset($this->def['borrar']) || $this->def['borrar'] !== false;
    }

    public function listar()
    {
        return Database::all('SELECT * FROM ' . $this->def['tabla'] . ' ORDER BY ' . $this->def['orden']);
    }

    public function obtener($id)
    {
        return Database::first('SELECT * FROM ' . $this->def['tabla'] . ' WHERE id = ?', [$id]);
    }

    /** Opciones de un campo tipo selección que se alimenta de otra tabla. */
    public function opciones(array $campo)
    {
        if (isset($campo['opciones'])) {
            return $campo['opciones'];
        }
        if (!isset($campo['origen'])) {
            return [];
        }
        $o = $campo['origen'];
        $filas = Database::all('SELECT ' . $o['valor'] . ' AS v, ' . $o['texto'] . ' AS t FROM ' . $o['tabla'] . ' ORDER BY t');
        $out = [];
        foreach ($filas as $f) {
            $out[$f['v']] = $f['t'] === '' ? '(Inicio)' : $f['t'];
        }
        return $out;
    }

    /**
     * Valida y arma los datos a guardar a partir de $_POST.
     * @return array ['datos' => array, 'errores' => array]
     */
    public function preparar(array $post, $registro = null)
    {
        $datos   = [];
        $errores = [];

        foreach ($this->def['campos'] as $nombre => $campo) {
            $tipo = $campo['tipo'];

            if ($tipo === 'oculto') {
                continue;
            }

            if ($tipo === 'casilla') {
                $datos[$nombre] = !empty($post[$nombre]) ? 1 : 0;
                continue;
            }

            $valor = isset($post[$nombre]) ? $post[$nombre] : '';
            if (is_array($valor)) {
                $valor = '';
            }
            $valor = trim($valor);

            switch ($tipo) {
                case 'html':
                    $valor = \clean_html($valor);
                    break;
                case 'lista':
                    $lineas = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $valor)));
                    $valor = implode("\n", $lineas);
                    break;
                case 'slug':
                    if ($valor === '' && isset($campo['desde']) && !empty($post[$campo['desde']])) {
                        $valor = \slugify($post[$campo['desde']]);
                    } else {
                        $valor = $valor === '' ? '' : \slugify($valor);
                    }
                    break;
                case 'numero':
                    $valor = $valor === '' ? 0 : (int) $valor;
                    break;
                case 'precio':
                    $valor = $valor === '' ? null : (float) str_replace([',', 'Q', ' '], '', $valor);
                    break;
                case 'fecha':
                    $valor = $valor === '' ? null : date('Y-m-d H:i:s', strtotime($valor));
                    break;
                case 'seleccion':
                    if ($valor === '') {
                        $valor = null;
                    }
                    break;
            }

            if (!empty($campo['requerido']) && ($valor === '' || $valor === null)) {
                $errores[$nombre] = 'Este campo es obligatorio.';
            }
            if (isset($campo['max']) && is_string($valor) && mb_strlen($valor) > $campo['max']) {
                $errores[$nombre] = 'Máximo ' . $campo['max'] . ' caracteres (llevás ' . mb_strlen($valor) . ').';
            }

            $datos[$nombre] = $valor;
        }

        // Unicidad de slug donde corresponde
        if (isset($this->def['campos']['slug']) && array_key_exists('slug', $datos)) {
            $sql = 'SELECT COUNT(*) FROM ' . $this->def['tabla'] . ' WHERE slug = ?';
            $params = [$datos['slug']];
            if ($registro) {
                $sql .= ' AND id <> ?';
                $params[] = $registro['id'];
            }
            if (Database::value($sql, $params)) {
                $errores['slug'] = 'Ya existe otro registro con esta dirección.';
            }
        }

        return ['datos' => $datos, 'errores' => $errores];
    }

    public function guardar(array $datos, $id = null)
    {
        $columnas = $this->columnasTabla();
        if (in_array('updated_at', $columnas, true)) {
            $datos['updated_at'] = date('Y-m-d H:i:s');
        }
        if ($id) {
            Database::update($this->def['tabla'], $datos, 'id = :__id', ['__id' => $id]);
            return $id;
        }
        // Al insertar hay que llenar las columnas obligatorias que no están en el formulario.
        if (in_array('created_at', $columnas, true) && !isset($datos['created_at'])) {
            $datos['created_at'] = date('Y-m-d H:i:s');
        }
        return Database::insert($this->def['tabla'], $datos);
    }

    public function borrar($id)
    {
        return Database::delete($this->def['tabla'], 'id = ?', [$id]);
    }

    private function columnasTabla()
    {
        static $cache = [];
        $tabla = $this->def['tabla'];
        if (isset($cache[$tabla])) {
            return $cache[$tabla];
        }
        $cols = [];
        if (Database::driver() === 'sqlite') {
            foreach (Database::all('PRAGMA table_info(' . $tabla . ')') as $c) {
                $cols[] = $c['name'];
            }
        } else {
            foreach (Database::all('SHOW COLUMNS FROM ' . $tabla) as $c) {
                $cols[] = $c['Field'];
            }
        }
        $cache[$tabla] = $cols;
        return $cols;
    }
}
