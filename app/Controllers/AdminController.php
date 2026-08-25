<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Crud;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Mailer;
use App\Core\Settings;
use App\Core\Uploader;
use App\Core\View;

class AdminController
{
    /** @var array */
    private $recursos;

    public function __construct()
    {
        $this->recursos = require APP_PATH . '/Admin/recursos.php';
        View::share('recursos', $this->recursos);
        View::share('usuario', Auth::check() ? Auth::user() : null);
        View::share('pendientes', Auth::check()
            ? (int) Database::value("SELECT COUNT(*) FROM messages WHERE status = 'nuevo'")
            : 0);
    }

    private function vista($nombre, array $datos = [])
    {
        return View::render('admin/' . $nombre, $datos, 'admin/layout');
    }

    private function suelta($nombre, array $datos = [])
    {
        return View::render('admin/' . $nombre, $datos, null);
    }

    // ------------------------------------------------------------- Acceso
    public function login()
    {
        if (Auth::check()) {
            \redirect('/admin/');
        }
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::verifyOrFail();
            $r = Auth::attempt(
                isset($_POST['email']) ? $_POST['email'] : '',
                isset($_POST['password']) ? $_POST['password'] : '',
                isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : ''
            );
            if ($r['ok']) {
                \redirect(!empty($_SESSION['must_change_password']) ? '/admin/cuenta/' : '/admin/');
            }
            $error = $r['error'];
        }

        return $this->suelta('login', ['error' => $error]);
    }

    public function logout()
    {
        Auth::logout();
        \redirect('/admin/entrar/');
    }

    // ---------------------------------------------------------- Escritorio
    public function dashboard()
    {
        $resumen = [
            ['etiqueta' => 'Páginas publicadas', 'valor' => Database::value('SELECT COUNT(*) FROM pages WHERE visible = 1'), 'url' => '/admin/paginas/'],
            ['etiqueta' => 'Artículos del blog', 'valor' => Database::value('SELECT COUNT(*) FROM posts WHERE visible = 1'), 'url' => '/admin/blog/'],
            ['etiqueta' => 'Proyectos del portafolio', 'valor' => Database::value('SELECT COUNT(*) FROM portfolio WHERE visible = 1'), 'url' => '/admin/portafolio/'],
            ['etiqueta' => 'Mensajes sin leer', 'valor' => Database::value("SELECT COUNT(*) FROM messages WHERE status = 'nuevo'"), 'url' => '/admin/mensajes/'],
        ];

        $avisos = [];
        if (is_file(PUBLIC_PATH . '/install.php')) {
            $avisos[] = ['tipo' => 'error', 'texto' => 'El archivo public/install.php todavía está en el servidor. Borralo por seguridad.'];
        }
        if (Settings::get('site_noindex', '0') === '1') {
            $avisos[] = ['tipo' => 'error', 'texto' => 'El sitio está bloqueado para buscadores. Al terminar las pruebas, desactivá esa opción en Configuración.'];
        }
        if (!Settings::get('ga4_id')) {
            $avisos[] = ['tipo' => 'aviso', 'texto' => 'Todavía no configuraste Google Analytics 4. Podés pegarlo en Configuración.'];
        }
        if (!Database::value('SELECT COUNT(*) FROM testimonials')) {
            $avisos[] = ['tipo' => 'aviso', 'texto' => 'No hay testimonios cargados. La sección se muestra vacía a propósito hasta que agregués testimonios reales.'];
        }
        if (!Uploader::soportaWebp()) {
            $avisos[] = ['tipo' => 'aviso', 'texto' => 'Este servidor no tiene soporte WebP en GD. Las imágenes que subas se guardarán en JPG.'];
        }

        return $this->vista('dashboard', [
            'titulo'   => 'Escritorio',
            'resumen'  => $resumen,
            'avisos'   => $avisos,
            'ultimos'  => Database::all('SELECT * FROM messages ORDER BY created_at DESC LIMIT 5'),
        ]);
    }

    // ------------------------------------------------------------- Recursos
    private function crud($clave)
    {
        if (!isset($this->recursos[$clave])) {
            http_response_code(404);
            exit('Módulo no encontrado.');
        }
        return new Crud($clave, $this->recursos[$clave]);
    }

    public function lista($clave)
    {
        $crud = $this->crud($clave);
        return $this->vista('lista', [
            'titulo' => $crud->def()['titulo'],
            'crud'   => $crud,
            'filas'  => $crud->listar(),
        ]);
    }

    public function editar($clave, $id = null)
    {
        $crud = $this->crud($clave);
        $registro = $id ? $crud->obtener($id) : null;
        if ($id && !$registro) {
            http_response_code(404);
            exit('Registro no encontrado.');
        }
        if (!$id && !$crud->permiteCrear()) {
            \redirect('/admin/' . $clave . '/');
        }

        $errores = [];
        $valores = $registro ? $registro : $this->valoresPorDefecto($crud);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::verifyOrFail();
            $r = $crud->preparar($_POST, $registro);
            $errores = $r['errores'];
            $valores = array_merge($valores, $r['datos']);
            if (!$errores) {
                $nuevoId = $crud->guardar($r['datos'], $id);
                \flash('Se guardaron los cambios.');
                \redirect('/admin/' . $clave . '/' . $nuevoId . '/');
            }
            \flash('Revisá los campos marcados.', 'error');
        }

        return $this->vista('formulario', [
            'titulo'   => ($id ? 'Editar ' : 'Nuevo ') . $crud->def()['singular'],
            'crud'     => $crud,
            'registro' => $registro,
            'valores'  => $valores,
            'errores'  => $errores,
            'secciones' => (!empty($crud->def()['secciones']) && $registro)
                ? Database::all('SELECT * FROM page_sections WHERE page_id = ? ORDER BY sort_order, id', [$registro['id']])
                : [],
        ]);
    }

    private function valoresPorDefecto(Crud $crud)
    {
        $v = ['id' => null];
        foreach ($crud->def()['campos'] as $nombre => $campo) {
            $v[$nombre] = isset($campo['defecto']) ? $campo['defecto'] : '';
        }
        return $v;
    }

    public function borrar($clave, $id)
    {
        Csrf::verifyOrFail();
        $crud = $this->crud($clave);
        if (!$crud->permiteBorrar()) {
            \flash('Este módulo no permite borrar registros.', 'error');
            \redirect('/admin/' . $clave . '/');
        }
        $crud->borrar($id);
        \flash('Registro eliminado.');
        \redirect('/admin/' . $clave . '/');
    }

    // ------------------------------------------- Secciones de una página
    public function seccion($id)
    {
        $seccion = Database::first('SELECT * FROM page_sections WHERE id = ?', [$id]);
        if (!$seccion) {
            http_response_code(404);
            exit('Sección no encontrada.');
        }
        $pagina = Database::first('SELECT * FROM pages WHERE id = ?', [$seccion['page_id']]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::verifyOrFail();
            $extra = trim(isset($_POST['extra']) ? $_POST['extra'] : '');
            $extraOk = true;
            if ($extra !== '') {
                json_decode($extra, true);
                $extraOk = json_last_error() === JSON_ERROR_NONE;
            }
            if (!$extraOk) {
                \flash('El campo de datos adicionales no es JSON válido. No se guardó nada.', 'error');
            } else {
                Database::update('page_sections', [
                    'eyebrow'    => trim($_POST['eyebrow']),
                    'heading'    => trim($_POST['heading']),
                    'subheading' => trim($_POST['subheading']),
                    'body'       => \clean_html(isset($_POST['body']) ? $_POST['body'] : ''),
                    'image'      => trim($_POST['image']),
                    'image_alt'  => trim($_POST['image_alt']),
                    'cta_text'   => trim($_POST['cta_text']),
                    'cta_url'    => trim($_POST['cta_url']),
                    'extra'      => $extra === '' ? null : $extra,
                    'sort_order' => (int) $_POST['sort_order'],
                    'visible'    => !empty($_POST['visible']) ? 1 : 0,
                ], 'id = :id', ['id' => $id]);
                Database::update('pages', ['updated_at' => date('Y-m-d H:i:s')], 'id = :id', ['id' => $pagina['id']]);
                \flash('Sección actualizada.');
                \redirect('/admin/secciones/' . $id . '/');
            }
        }

        return $this->vista('seccion', [
            'titulo'  => 'Sección de ' . $pagina['name'],
            'seccion' => Database::first('SELECT * FROM page_sections WHERE id = ?', [$id]),
            'pagina'  => $pagina,
        ]);
    }

    // -------------------------------------------------------------- Medios
    public function medios()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::verifyOrFail();
            if (isset($_POST['eliminar'])) {
                Uploader::eliminar((int) $_POST['eliminar']);
                \flash('Imagen eliminada.');
            } elseif (isset($_FILES['archivo'])) {
                $r = Uploader::guardar($_FILES['archivo'], isset($_POST['alt']) ? $_POST['alt'] : '');
                \flash($r['ok'] ? 'Imagen subida: ' . $r['ruta'] : $r['error'], $r['ok'] ? 'ok' : 'error');
            }
            \redirect('/admin/medios/');
        }

        return $this->vista('medios', [
            'titulo' => 'Medios',
            'items'  => Database::all('SELECT * FROM media ORDER BY created_at DESC, id DESC LIMIT 300'),
        ]);
    }

    // ------------------------------------------------------------ Mensajes
    public function mensajes($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::verifyOrFail();
            if (isset($_POST['eliminar'])) {
                Database::delete('messages', 'id = ?', [(int) $_POST['eliminar']]);
                \flash('Mensaje eliminado.');
            } elseif (isset($_POST['leido'])) {
                Database::update('messages', ['status' => 'leido', 'read_at' => date('Y-m-d H:i:s')], 'id = :id', ['id' => (int) $_POST['leido']]);
            }
            \redirect('/admin/mensajes/');
        }

        if ($id) {
            $mensaje = Database::first('SELECT * FROM messages WHERE id = ?', [$id]);
            if (!$mensaje) {
                http_response_code(404);
                exit('Mensaje no encontrado.');
            }
            if ($mensaje['status'] === 'nuevo') {
                Database::update('messages', ['status' => 'leido', 'read_at' => date('Y-m-d H:i:s')], 'id = :id', ['id' => $id]);
                $mensaje['status'] = 'leido';
            }
            return $this->vista('mensaje', ['titulo' => 'Mensaje', 'mensaje' => $mensaje]);
        }

        return $this->vista('mensajes', [
            'titulo'   => 'Bandeja de mensajes',
            'mensajes' => Database::all('SELECT * FROM messages ORDER BY created_at DESC LIMIT 500'),
        ]);
    }

    // -------------------------------------------------------- Configuración
    public function configuracion()
    {
        $grupos = require APP_PATH . '/Admin/configuracion.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::verifyOrFail();
            foreach ($grupos as $grupo) {
                foreach ($grupo['campos'] as $clave => $campo) {
                    if ($campo['tipo'] === 'casilla') {
                        Settings::set($clave, !empty($_POST[$clave]) ? '1' : '0');
                        continue;
                    }
                    if (!array_key_exists($clave, $_POST)) {
                        continue;
                    }
                    $valor = trim($_POST[$clave]);
                    if ($campo['tipo'] === 'color' && $valor !== '' && !preg_match('/^#[0-9A-Fa-f]{6}$/', $valor)) {
                        continue;
                    }
                    Settings::set($clave, $valor);
                }
            }
            \flash('Configuración guardada.');
            \redirect('/admin/configuracion/');
        }

        return $this->vista('configuracion', [
            'titulo' => 'Configuración',
            'grupos' => $grupos,
        ]);
    }

    // ---------------------------------------------------------------- Cuenta
    public function cuenta()
    {
        $usuario = Auth::user();
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::verifyOrFail();
            $actual = isset($_POST['actual']) ? $_POST['actual'] : '';
            $nueva  = isset($_POST['nueva']) ? $_POST['nueva'] : '';
            $repetir = isset($_POST['repetir']) ? $_POST['repetir'] : '';
            $nombre = trim(isset($_POST['nombre']) ? $_POST['nombre'] : '');

            if ($nombre === '') {
                $errores['nombre'] = 'Escribí tu nombre.';
            }
            if ($nueva !== '' || $repetir !== '' || !empty($_SESSION['must_change_password'])) {
                if (!password_verify($actual, $usuario['password_hash'])) {
                    $errores['actual'] = 'La contraseña actual no es correcta.';
                }
                if (strlen($nueva) < 10) {
                    $errores['nueva'] = 'La nueva contraseña debe tener al menos 10 caracteres.';
                }
                if ($nueva !== $repetir) {
                    $errores['repetir'] = 'Las dos contraseñas no coinciden.';
                }
            }

            if (!$errores) {
                $datos = ['name' => $nombre];
                if ($nueva !== '') {
                    $datos['password_hash'] = password_hash($nueva, PASSWORD_DEFAULT);
                    $datos['must_change_password'] = 0;
                    $_SESSION['must_change_password'] = 0;
                }
                Database::update('users', $datos, 'id = :id', ['id' => $usuario['id']]);
                $_SESSION['user_name'] = $nombre;
                \flash('Datos actualizados.');
                \redirect('/admin/cuenta/');
            }
            \flash('Revisá los campos marcados.', 'error');
        }

        return $this->vista('cuenta', [
            'titulo'  => 'Mi cuenta',
            'errores' => $errores,
            'perfil'  => $usuario,
        ]);
    }

    // ------------------------------------------------------------ Herramientas
    public function herramientas()
    {
        $resultado = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Csrf::verifyOrFail();
            if (isset($_POST['probar_correo'])) {
                $destino = Settings::get('form_notify_email', Settings::get('email'));
                $ok = Mailer::send(
                    $destino,
                    'Prueba de correo de paginasweb.gt',
                    '<p>Si recibiste este mensaje, el envío de formularios está funcionando.</p>'
                );
                $resultado = $ok
                    ? 'Se envió un correo de prueba a ' . $destino . '. Revisá también la carpeta de spam.'
                    : 'No se pudo enviar. Revisá la configuración de correo en config/config.php.';
            }
        }

        return $this->vista('herramientas', [
            'titulo'    => 'Herramientas',
            'resultado' => $resultado,
            'entorno'   => [
                'Versión de PHP'      => PHP_VERSION,
                'Motor de base de datos' => Database::driver(),
                'Soporte WebP'        => Uploader::soportaWebp() ? 'Sí' : 'No (se guardará JPG)',
                'Extensión GD'        => extension_loaded('gd') ? 'Activa' : 'No disponible',
                'install.php'         => is_file(PUBLIC_PATH . '/install.php') ? 'Presente (borralo)' : 'Eliminado',
                'Carpeta uploads'     => is_writable(PUBLIC_PATH . '/uploads') ? 'Con permiso de escritura' : 'Sin permiso de escritura',
            ],
        ]);
    }
}
