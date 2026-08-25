<?php
/**
 * Compatibilidad con PHP 7.4.
 * El proyecto corre en PHP 7.4 o superior (probado también en 8.1, 8.2, 8.3 y 8.4).
 * Estas funciones existen desde PHP 8.0; acá se definen para hosting con 7.4.
 */

if (PHP_VERSION_ID < 70400) {
    http_response_code(500);
    exit('Este sitio requiere PHP 7.4 o superior. Versión detectada: ' . PHP_VERSION);
}

if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle)
    {
        return $needle === '' || strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

if (!function_exists('str_ends_with')) {
    function str_ends_with($haystack, $needle)
    {
        if ($needle === '') {
            return true;
        }
        $len = strlen($needle);
        return $len <= strlen($haystack) && substr_compare($haystack, $needle, -$len) === 0;
    }
}

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle)
    {
        return $needle === '' || strpos($haystack, $needle) !== false;
    }
}

if (!function_exists('array_is_list')) {
    function array_is_list(array $array)
    {
        return $array === [] || array_keys($array) === range(0, count($array) - 1);
    }
}
