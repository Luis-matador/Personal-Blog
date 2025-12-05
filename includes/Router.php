<?php
// Sistema de enrutamiento
class Router
{
    private $routes = [];

    // Añadir ruta
    public function add($method, $pattern, $callback)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'callback' => $callback
        ];
    }

    // Ejecutar ruta según URL
    public function dispatch($requestUri, $requestMethod)
    {
        $uri = parse_url($requestUri, PHP_URL_PATH);

        $scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if ($scriptName !== '/' && strpos($uri, $scriptName) === 0) {
            $uri = substr($uri, strlen($scriptName));
            if ($uri === false || $uri === '') {
                $uri = '/';
            }
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($requestMethod)) {
                continue;
            }

            $pattern = "@^" . preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route['pattern']) . "$@D";

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return call_user_func_array($route['callback'], $params);
            }
        }

    http_response_code(404);
    require_once __DIR__ . '/../views/errors/404.php';
    }
}
