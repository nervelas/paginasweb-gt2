<?php
namespace App\Core;

/** Renderizado de vistas PHP con layout. */
class View
{
    private static string $basePath = '';
    private static array $shared = [];

    public static function setBasePath(string $path): void
    {
        self::$basePath = rtrim($path, '/');
    }

    public static function share(string $key, $value): void
    {
        self::$shared[$key] = $value;
    }

    public static function shared(): array
    {
        return self::$shared;
    }

    public static function render(string $view, array $data = [], ?string $layout = 'layouts/main'): string
    {
        $content = self::partial($view, $data);
        if ($layout === null) {
            return $content;
        }
        return self::partial($layout, array_merge($data, ['content' => $content]));
    }

    public static function partial(string $view, array $data = []): string
    {
        // Solo se aceptan nombres de vista con letras, números, guiones y
        // separadores simples: así ninguna plantilla puede salirse de app/Views/
        // por más que el nombre venga de la base de datos.
        if (!preg_match('#^[A-Za-z0-9_\-]+([./][A-Za-z0-9_\-]+)*$#', $view)) {
            throw new \RuntimeException('Nombre de vista no válido: ' . $view);
        }
        $file = self::$basePath . '/' . str_replace('.', '/', $view) . '.php';
        if (!is_file($file)) {
            throw new \RuntimeException('Vista no encontrada: ' . $view);
        }
        extract(array_merge(self::$shared, $data), EXTR_SKIP);
        ob_start();
        include $file;
        return (string) ob_get_clean();
    }
}
