<?php

namespace App\Core;

class Router {
    private array $routes = [];

    /**
     * Add a GET route.
     */
    public function get(string $path, string $handler, array $middlewares = []): void {
        $this->addRoute('GET', $path, $handler, $middlewares);
    }

    /**
     * Add a POST route.
     */
    public function post(string $path, string $handler, array $middlewares = []): void {
        $this->addRoute('POST', $path, $handler, $middlewares);
    }

    /**
     * Internal method to store routes.
     */
    private function addRoute(string $method, string $path, string $handler, array $middlewares): void {
        // Convert path placeholders {param} to regex groups
        // e.g. "/admin/edit-client/{id}" -> "#^/admin/edit-client/([^/]+)$#D"
        $regex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $regex = '#^' . $regex . '$#D';

        $this->routes[] = [
            'method'      => $method,
            'path'        => $path,
            'regex'       => $regex,
            'handler'     => $handler,
            'middlewares' => $middlewares
        ];
    }

    /**
     * Dispatch the current request.
     */
    public function dispatch(): void {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $requestUri    = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

        // 1. Automatically detect and strip subdirectory prefix (for XAMPP local testing)
        // e.g. Script name: /SaaS_Multi_Tenant_platform/public/index.php
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = dirname(dirname($scriptName)); // returns "/SaaS_Multi_Tenant_platform"
        $basePath = str_replace('\\', '/', $basePath);
        $basePath = rtrim($basePath, '/');

        if (!empty($basePath) && str_starts_with($requestUri, $basePath)) {
            $requestUri = substr($requestUri, strlen($basePath));
        }

        // 2. Strip /public if present in request path
        if (str_starts_with($requestUri, '/public')) {
            $requestUri = substr($requestUri, 7);
        }

        // 3. Ensure the URI is normalized
        if (empty($requestUri)) {
            $requestUri = '/';
        }

        // Normalize URL (strip trailing slash if it is not just "/")
        if ($requestUri !== '/' && str_ends_with($requestUri, '/')) {
            $requestUri = rtrim($requestUri, '/');
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            if (preg_match($route['regex'], $requestUri, $matches)) {
                // Extract named parameters from regex matches
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Run middlewares
                foreach ($route['middlewares'] as $middlewareClass) {
                    $middleware = new $middlewareClass();
                    // If middleware handle returns false, we abort routing execution
                    if ($middleware->handle($params) === false) {
                        return;
                    }
                }

                // Dispatch to Controller
                list($controllerClass, $method) = explode('@', $route['handler']);
                $fullControllerClass = "App\\Controllers\\" . $controllerClass;

                if (class_exists($fullControllerClass)) {
                    $controller = new $fullControllerClass();
                    if (method_exists($controller, $method)) {
                        // Call the method and pass request parameters
                        call_user_func_array([$controller, $method], [$params]);
                        return;
                    }
                }

                $this->sendNotFound("Method '{$method}' not found in controller '{$fullControllerClass}'.");
                return;
            }
        }

        $this->sendNotFound("No route matched: [{$requestMethod}] {$requestUri}");
    }

    /**
     * Send 404 Response.
     */
    private function sendNotFound(string $debugMessage = ''): void {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        echo "<h1>404 Not Found</h1>";
        if (defined('DEBUG') && DEBUG) {
            echo "<p>" . htmlspecialchars($debugMessage) . "</p>";
        }
    }
}

// ✅ CHECKPOINT: Router.php — COMPLETE (المرحلة 2 من 8)
// التالي: app/Core/Auth.php
