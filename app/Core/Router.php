<?php
namespace App\Core;

class Router {
    private array $routes = [];
    private array $errorPages = [];

    public function get(string $uri, string $action) {
        $this->routes['GET'][$this->normalizeUri($uri)] = $action;
    }

    public function post(string $uri, string $action) {
        $this->routes['POST'][$this->normalizeUri($uri)] = $action;
    }

    /**
     * Définir une page d'erreur personnalisée
     */
    public function setErrorPage(int $code, string $action) {
        $this->errorPages[$code] = $action;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = $this->normalizeUri($uri);

        // Supprime le chemin du dossier public ou du projet si présent
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if (strpos($uri, $scriptName) === 0) {
            $uri = substr($uri, strlen($scriptName));
        }

        if ($uri === '' || $uri === '/index.php') $uri = '/';

        if (!isset($this->routes[$method][$uri])) {
            $this->handleError(404);
            return;
        }

        [$controllerName, $methodName] = explode('@', $this->routes[$method][$uri]);
        $controllerClass = "App\\Controllers\\$controllerName";

        if (!class_exists($controllerClass)) {
            $this->handleError(500, "Controller $controllerClass not found.");
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $methodName)) {
            $this->handleError(500, "Method $methodName not found in $controllerClass.");
            return;
        }

        call_user_func([$controller, $methodName]);
    }

    /**
     * Normalise les URIs pour éviter les soucis avec les slashes
     */
    private function normalizeUri(string $uri): string {
        $uri = rtrim($uri, '/');
        return $uri === '' ? '/' : $uri;
    }

    /**
     * Gestion centralisée des erreurs
     */
    private function handleError(int $code, string $message = '') {
        http_response_code($code);
        if (isset($this->errorPages[$code])) {
            [$controllerName, $methodName] = explode('@', $this->errorPages[$code]);
            $controllerClass = "App\\Controllers\\$controllerName";
            if (class_exists($controllerClass) && method_exists($controllerClass, $methodName)) {
                $controller = new $controllerClass();
                call_user_func([$controller, $methodName], $message);
                return;
            }
        }
        // fallback simple
        echo "$code - " . ($message ?: 'Page not found');
        exit;
    }
}