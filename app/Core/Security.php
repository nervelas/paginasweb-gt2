<?php
namespace App\Core;

/**
 * Refuerzos de seguridad que no dependen de la configuración de Apache.
 *
 * En hosting compartido no siempre está activo mod_headers, así que las
 * cabeceras de protección se emiten también desde PHP. Si Apache ya las mandó,
 * header() las reemplaza por el mismo valor y no pasa nada.
 */
class Security
{
    /** Máximo de mensajes que acepta el formulario público por IP y por hora. */
    const MAX_MENSAJES_HORA = 5;

    /**
     * Limpia la ruta pedida antes de usarla en enrutado o en cabeceras Location.
     * Quita bytes de control (evita partir la respuesta HTTP), normaliza las
     * barras invertidas y colapsa las barras repetidas para que nunca quede
     * una ruta del tipo "//dominio-ajeno.com".
     */
    public static function rutaSegura($path)
    {
        $path = (string) $path;
        $path = str_replace("\\", '/', $path);
        $path = preg_replace('/[\x00-\x1F\x7F]/', '', $path);
        $path = preg_replace('#/+#', '/', $path);
        if ($path === '' || $path[0] !== '/') {
            $path = '/' . ltrim($path, '/');
        }
        return $path;
    }

    /** Cabeceras de seguridad para las páginas públicas. */
    public static function cabecerasPublicas()
    {
        if (headers_sent()) {
            return;
        }
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: camera=(), microphone=(), geolocation=(), interest-cohort=()');
        header('X-Permitted-Cross-Domain-Policies: none');
        header('Cross-Origin-Opener-Policy: same-origin');
        header_remove('X-Powered-By');
    }

    /** Cabeceras del panel: además, nada de caché ni de indexación. */
    public static function cabecerasPanel()
    {
        self::cabecerasPublicas();
        if (headers_sent()) {
            return;
        }
        header('X-Robots-Tag: noindex, nofollow');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
    }

    /** IP del visitante, sin confiar en cabeceras que cualquiera puede falsificar. */
    public static function ip()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? substr($_SERVER['REMOTE_ADDR'], 0, 45) : '';
    }

    /**
     * Cuenta los mensajes recientes de una IP. Sirve para frenar el envío
     * masivo desde el formulario público sin molestar a un visitante normal.
     */
    public static function mensajesRecientes($ip, $minutos = 60)
    {
        if ($ip === '') {
            return 0;
        }
        $desde = date('Y-m-d H:i:s', time() - ($minutos * 60));
        $fila = Database::first(
            'SELECT COUNT(*) AS total FROM messages WHERE ip = ? AND created_at >= ?',
            [$ip, $desde]
        );
        return $fila ? (int) $fila['total'] : 0;
    }

    /** ¿Esta IP ya pasó el límite de envíos por hora? */
    public static function excedeEnvios($ip)
    {
        return self::mensajesRecientes($ip) >= self::MAX_MENSAJES_HORA;
    }
}
