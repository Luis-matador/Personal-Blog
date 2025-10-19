<?php
/**
 * Sistema de enrutamiento básico
 * Permite definir rutas y asociarlas con controladores y acciones
 * Analiza la URL actual y ejecuta el controlador correspondiente
 */

class Router
{
    private $routes = [];

    /**
     * Añade una ruta al router
     * @param string $method Método HTTP (GET, POST, etc.)
     * @param string $pattern Patrón de la ruta (ej: /post/{id})
     * @param callable $callback Controlador y método a ejecutar
     */
    public function add($method, $pattern, $callback)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'pattern' => $pattern,
            'callback' => $callback
        ];
    }

    /**
     * Ejecuta la acción correspondiente según la URL y el método HTTP
     * @param string $requestUri URI de la petición
     * @param string $requestMethod Método HTTP
     */
    public function dispatch($requestUri, $requestMethod)
    {
        $uri = parse_url($requestUri, PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($requestMethod)) {
                continue;
            }

            // Convierte el patrón a una expresión regular
            $pattern = "@^" . preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route['pattern']) . "$@D";

            if (preg_match($pattern, $uri, $matches)) {
                // Extrae los parámetros nombrados de la URL
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return call_user_func_array($route['callback'], $params);
            }
        }

        // Si no se encuentra la ruta, muestra 404
        http_response_code(404);
        echo "Página no encontrada";
    }
}
