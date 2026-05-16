<?php
/**
 * Clase Router
 * Sistema de enrutamiento simple
 */

class Router {
    private $routes = [];
    private $notFoundCallback;
    
    public function get($path, $callback) {
        $this->addRoute('GET', $path, $callback);
    }
    
    public function post($path, $callback) {
        $this->addRoute('POST', $path, $callback);
    }
    
    private function addRoute($method, $path, $callback) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }
    
    public function notFound($callback) {
        $this->notFoundCallback = $callback;
    }
    
    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
        
        // Remover query string
        $pathWithoutQuery = parse_url($requestUri, PHP_URL_PATH);
        
        // Limpiar la ruta para que funcione en cualquier carpeta
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        $requestPath = substr($pathWithoutQuery, strlen($basePath));
        
        $requestPath = '/' . trim($requestPath, '/');
        if (empty($requestPath)) $requestPath = '/';
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }
            
            $pattern = $this->convertPathToRegex($route['path']);
            
            if (preg_match($pattern, $requestPath, $matches)) {
                array_shift($matches); // Remover match completo
                return call_user_func_array($route['callback'], $matches);
            }
        }
        
        // No se encontró ruta
        if ($this->notFoundCallback) {
            return call_user_func($this->notFoundCallback);
        }
        
        http_response_code(404);
        echo "404 - Página no encontrada";
    }
    
    private function convertPathToRegex($path) {
        // Convertir {param} a expresión regular
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_-]+)', $path);
        return '#^' . $pattern . '$#';
    }
}
