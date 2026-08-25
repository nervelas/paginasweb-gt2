<?php

use App\Core\Settings;
use App\Core\View;

if (!function_exists('e')) {
    /** Escapa para HTML. */
    function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('config')) {
    function config(string $key, $default = null)
    {
        static $config = null;
        if ($config === null) {
            $config = $GLOBALS['__app_config'] ?? [];
        }
        $parts = explode('.', $key);
        $value = $config;
        foreach ($parts as $p) {
            if (!is_array($value) || !array_key_exists($p, $value)) {
                return $default;
            }
            $value = $value[$p];
        }
        return $value;
    }
}

if (!function_exists('base_url')) {
    function base_url(string $path = ''): string
    {
        $base = rtrim((string) config('base_url', ''), '/');
        if ($path === '') {
            return $base . '/';
        }
        return $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    /** URL absoluta canónica del sitio. */
    function url(string $path = '/'): string
    {
        return base_url($path);
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        $rel  = '/assets/' . ltrim($path, '/');
        $file = dirname(__DIR__) . '/public' . $rel;
        $v    = is_file($file) ? substr((string) filemtime($file), -6) : '1';
        return $rel . '?v=' . $v;
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string
    {
        $text = trim($text);
        $map = ['á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u','ü'=>'u','ñ'=>'n','Á'=>'a','É'=>'e','Í'=>'i','Ó'=>'o','Ú'=>'u','Ü'=>'u','Ñ'=>'n'];
        $text = strtr($text, $map);
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim((string) $text, '-');
    }
}

if (!function_exists('excerpt')) {
    function excerpt(string $html, int $length = 160): string
    {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags($html)));
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        $cut = mb_substr($text, 0, $length);
        $sp  = mb_strrpos($cut, ' ');
        return rtrim(mb_substr($cut, 0, $sp ?: $length), '.,;: ') . '…';
    }
}

if (!function_exists('word_count_html')) {
    function word_count_html(string $html): int
    {
        return str_word_count(strip_tags($html), 0, 'áéíóúüñÁÉÍÓÚÜÑ');
    }
}

if (!function_exists('money')) {
    /** Formato de precio en quetzales: Q1,250 */
    function money($amount): string
    {
        if ($amount === null || $amount === '') {
            return '';
        }
        if (!is_numeric($amount)) {
            return (string) $amount;
        }
        $n = (float) $amount;
        $decimals = (floor($n) == $n) ? 0 : 2;
        return 'Q' . number_format($n, $decimals, '.', ',');
    }
}

if (!function_exists('fecha_es')) {
    function fecha_es(?string $date): string
    {
        if (!$date) {
            return '';
        }
        $meses = [1=>'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        $ts = strtotime($date);
        return (int) date('j', $ts) . ' de ' . $meses[(int) date('n', $ts)] . ' de ' . date('Y', $ts);
    }
}

if (!function_exists('telefono_html')) {
    /**
     * Devuelve el teléfono con espacios y guiones que no se parten,
     * para que el número nunca quede cortado entre dos líneas.
     */
    function telefono_html(?string $numero): string
    {
        $limpio = e((string) $numero);
        return str_replace([' ', '-'], ['&nbsp;', '&#8209;'], $limpio);
    }
}

if (!function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        return Settings::get($key, $default);
    }
}

if (!function_exists('view')) {
    function view(string $name, array $data = [], ?string $layout = 'layouts/main'): string
    {
        return View::render($name, $data, $layout);
    }
}

if (!function_exists('partial')) {
    function partial(string $name, array $data = []): string
    {
        return View::partial($name, $data);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $to, int $code = 302): void
    {
        header('Location: ' . $to, true, $code);
        exit;
    }
}

if (!function_exists('old')) {
    function old(string $key, $default = '')
    {
        return $_SESSION['_old'][$key] ?? $default;
    }
}

if (!function_exists('flash')) {
    function flash(?string $message = null, string $type = 'ok')
    {
        if ($message === null) {
            $f = $_SESSION['_flash'] ?? null;
            unset($_SESSION['_flash']);
            return $f;
        }
        $_SESSION['_flash'] = ['message' => $message, 'type' => $type];
        return null;
    }
}

if (!function_exists('clean_html')) {
    /**
     * Sanea HTML del editor del panel: permite etiquetas de contenido,
     * elimina scripts, iframes de terceros y atributos peligrosos.
     */
    function clean_html(string $html): string
    {
        // 1. Fuera las etiquetas que pueden ejecutar código o traer contenido ajeno.
        $html = preg_replace('#<(script|style|iframe|object|embed|form|svg|math|template|base|noscript)\b[^>]*>.*?</\1>#is', '', $html);
        $html = preg_replace('#<(script|style|iframe|object|embed|form|link|meta|base|source|track)\b[^>]*/?>#i', '', $html);
        $html = preg_replace('#<!--.*?-->#s', '', $html);

        // 2. Fuera los manejadores de eventos (onclick, onerror, onload...).
        $html = preg_replace('#\son[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)#i', '', $html);

        // 3. Fuera los atributos que sirven para ejecutar o traer cosas raras.
        $html = preg_replace('#\s(formaction|xlink:href|srcdoc|srcset|ping|http-equiv)\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)#i', '', $html);

        // 4. Enlaces e imágenes: solo esquemas sanos. Se permite data: únicamente
        //    para imágenes, que es el único uso legítimo en un texto del blog.
        $esquemaSano = function ($valor) {
            $valor = trim(html_entity_decode($valor, ENT_QUOTES, 'UTF-8'));
            $valor = preg_replace('/[\s\x00-\x1F]/', '', $valor);
            if (preg_match('#^data:image/(png|jpeg|jpg|gif|webp|avif);base64,#i', $valor)) {
                return true;
            }
            return !preg_match('#^(javascript|vbscript|data|blob|file):#i', $valor);
        };
        // Valor entre comillas.
        $html = preg_replace_callback(
            '#(href|src)\s*=\s*(["\'])(.*?)\2#is',
            function ($m) use ($esquemaSano) {
                return $esquemaSano($m[3]) ? $m[0] : $m[1] . '="#"';
            },
            $html
        );
        // Valor sin comillas.
        $html = preg_replace_callback(
            '#(href|src)\s*=\s*([^\s"\'>]+)#i',
            function ($m) use ($esquemaSano) {
                return $esquemaSano($m[2]) ? $m[0] : $m[1] . '="#"';
            },
            $html
        );

        // 5. Nada de estilos que escondan texto: eso es justo lo que Google
        //    castiga y no tiene ningún uso legítimo dentro de un artículo.
        $html = preg_replace_callback(
            '#\sstyle\s*=\s*(["\'])(.*?)\1#is',
            function ($m) {
                $css = strtolower(preg_replace('/\s+/', '', $m[2]));
                $prohibido = [
                    'display:none', 'visibility:hidden', 'opacity:0', 'font-size:0',
                    'text-indent:-', 'position:absolute;left:-', 'clip:rect(0',
                    'height:0', 'width:0', 'expression(', 'url(javascript',
                ];
                foreach ($prohibido as $mal) {
                    if (strpos($css, $mal) !== false) {
                        return '';
                    }
                }
                return $m[0];
            },
            $html
        );

        // 6. Y al final, solo pasan las etiquetas de la lista blanca.
        $allowed = '<p><br><strong><b><em><i><u><ul><ol><li><h2><h3><h4><h5><blockquote><a><img><table><thead><tbody><tr><th><td><figure><figcaption><hr><span><div><small><sup><sub><code><pre>';
        return trim((string) strip_tags($html, $allowed));
    }
}

if (!function_exists('is_active_path')) {
    function is_active_path(string $path): bool
    {
        $current = $GLOBALS['__current_path'] ?? '/';
        if ($path === '/') {
            return $current === '/';
        }
        return str_starts_with($current, rtrim($path, '/'));
    }
}
