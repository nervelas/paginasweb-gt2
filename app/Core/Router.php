<?php
namespace App\Core;

/**
 * Router mínimo con soporte de parámetros {slug} y barra final obligatoria.
 */
class Router
{
    private array $routes = ['GET' => [], 'POST' => []];
    private $fallback = null;

    public function get(string $pattern, callable $handler): void
    {
        $this->routes['GET'][$pattern] = $handler;
    }

    public function post(string $pattern, callable $handler): void
    {
        $this->routes['POST'][$pattern] = $handler;
    }

    public function any(string $pattern, callable $handler): void
    {
        $this->get($pattern, $handler);
        $this->post($pattern, $handler);
    }

    public function fallback(callable $handler): void
    {
        $this->fallback = $handler;
    }

    public function dispatch(string $method, string $path)
    {
        $method = strtoupper($method) === 'POST' ? 'POST' : 'GET';

        foreach ($this->routes[$method] as $pattern => $handler) {
            $regex = $this->toRegex($pattern);
            if (preg_match($regex, $path, $m)) {
                $params = array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY);
                return $handler($params);
            }
        }

        if ($this->fallback) {
            return ($this->fallback)([]);
        }
        http_response_code(404);
        echo 'No encontrado';
        return null;
    }

    private function toRegex(string $pattern): string
    {
        $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[a-zA-Z0-9\-_%\.]+)', $pattern);
        return '#^' . $regex . '$#u';
    }
}
