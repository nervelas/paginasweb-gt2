<?php
namespace App\Core;

/**
 * Subida de imágenes con validación estricta, redimensión y conversión a WebP.
 * Si el servidor no soporta WebP, guarda JPG y avisa.
 */
class Uploader
{
    const MAX_BYTES = 8388608; // 8 MB
    const MAX_ANCHO = 1920;

    /** Extensiones y tipos permitidos. Nada de SVG por subida: puede llevar scripts. */
    private static $permitidos = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];

    public static function soportaWebp()
    {
        return function_exists('imagewebp');
    }

    /**
     * @return array ['ok' => bool, 'error' => string, 'ruta' => string, 'id' => int]
     */
    public static function guardar(array $archivo, $alt = '')
    {
        if (!isset($archivo['error']) || is_array($archivo['error'])) {
            return ['ok' => false, 'error' => 'Subida inválida.'];
        }
        switch ($archivo['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return ['ok' => false, 'error' => 'No se seleccionó ningún archivo.'];
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return ['ok' => false, 'error' => 'El archivo pesa más de lo que permite el servidor.'];
            default:
                return ['ok' => false, 'error' => 'No se pudo subir el archivo.'];
        }
        if ($archivo['size'] > self::MAX_BYTES) {
            return ['ok' => false, 'error' => 'El archivo pesa más de 8 MB.'];
        }
        if (!is_uploaded_file($archivo['tmp_name'])) {
            return ['ok' => false, 'error' => 'Origen del archivo no válido.'];
        }

        // El tipo se determina por el contenido, nunca por el nombre ni por el
        // encabezado que manda el navegador.
        $info = @getimagesize($archivo['tmp_name']);
        if ($info === false || !isset(self::$permitidos[$info['mime']])) {
            return ['ok' => false, 'error' => 'Solo se aceptan imágenes JPG, PNG, WebP o GIF.'];
        }

        $origen = self::abrir($archivo['tmp_name'], $info['mime']);
        if (!$origen) {
            return ['ok' => false, 'error' => 'No se pudo leer la imagen.'];
        }

        $ancho = imagesx($origen);
        $alto  = imagesy($origen);
        if ($ancho > self::MAX_ANCHO) {
            $nuevoAlto = (int) round($alto * (self::MAX_ANCHO / $ancho));
            $destino = imagecreatetruecolor(self::MAX_ANCHO, $nuevoAlto);
            imagealphablending($destino, false);
            imagesavealpha($destino, true);
            imagecopyresampled($destino, $origen, 0, 0, 0, 0, self::MAX_ANCHO, $nuevoAlto, $ancho, $alto);
            imagedestroy($origen);
            $origen = $destino;
            $ancho  = self::MAX_ANCHO;
            $alto   = $nuevoAlto;
        }

        $carpetaRel = '/uploads/' . date('Y') . '/' . date('m');
        $carpetaAbs = PUBLIC_PATH . $carpetaRel;
        if (!is_dir($carpetaAbs) && !@mkdir($carpetaAbs, 0755, true)) {
            imagedestroy($origen);
            return ['ok' => false, 'error' => 'No se pudo crear la carpeta de destino. Revisá permisos de public/uploads.'];
        }

        $base = \slugify(pathinfo($archivo['name'], PATHINFO_FILENAME));
        if ($base === '') {
            $base = 'imagen';
        }
        $base = substr($base, 0, 60) . '-' . substr(bin2hex(random_bytes(4)), 0, 6);

        if (self::soportaWebp()) {
            $nombre = $base . '.webp';
            $ok = imagewebp($origen, $carpetaAbs . '/' . $nombre, 82);
            $mime = 'image/webp';
        } else {
            $nombre = $base . '.jpg';
            $fondo = imagecreatetruecolor($ancho, $alto);
            $blanco = imagecolorallocate($fondo, 255, 255, 255);
            imagefilledrectangle($fondo, 0, 0, $ancho, $alto, $blanco);
            imagecopy($fondo, $origen, 0, 0, 0, 0, $ancho, $alto);
            $ok = imagejpeg($fondo, $carpetaAbs . '/' . $nombre, 86);
            imagedestroy($fondo);
            $mime = 'image/jpeg';
        }
        imagedestroy($origen);

        if (!$ok) {
            return ['ok' => false, 'error' => 'No se pudo guardar la imagen procesada.'];
        }

        $rutaRel = $carpetaRel . '/' . $nombre;
        $id = Database::insert('media', [
            'filename'   => $nombre,
            'path'       => $rutaRel,
            'alt'        => mb_substr($alt, 0, 220),
            'mime'       => $mime,
            'width'      => $ancho,
            'height'     => $alto,
            'filesize'   => filesize($carpetaAbs . '/' . $nombre),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return ['ok' => true, 'error' => '', 'ruta' => $rutaRel, 'id' => $id];
    }

    private static function abrir($ruta, $mime)
    {
        switch ($mime) {
            case 'image/jpeg':
                return @imagecreatefromjpeg($ruta);
            case 'image/png':
                $im = @imagecreatefrompng($ruta);
                if ($im) {
                    imagepalettetotruecolor($im);
                    imagealphablending($im, true);
                    imagesavealpha($im, true);
                }
                return $im;
            case 'image/webp':
                return function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($ruta) : false;
            case 'image/gif':
                return @imagecreatefromgif($ruta);
        }
        return false;
    }

    public static function eliminar($id)
    {
        $media = Database::first('SELECT * FROM media WHERE id = ?', [$id]);
        if (!$media) {
            return false;
        }
        $archivo = PUBLIC_PATH . $media['path'];
        if (is_file($archivo) && strpos(realpath($archivo), realpath(PUBLIC_PATH . '/uploads')) === 0) {
            @unlink($archivo);
        }
        Database::delete('media', 'id = ?', [$id]);
        return true;
    }
}
