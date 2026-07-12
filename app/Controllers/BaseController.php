<?php

namespace App\Controllers;

use App\Core\Auth;

abstract class BaseController {
    /**
     * Render an HTML view.
     * 
     * @param string $path Path to view file relative to app/Views/ (e.g. 'auth/login')
     * @param array $data Variables to extract and make available in the view.
     */
    protected function view(string $path, array $data = []): void {
        extract($data);
        
        $viewFile = dirname(__DIR__) . '/Views/' . $path . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
            echo "<h1>500 Internal Server Error</h1><p>View file '{$path}' not found.</p>";
        }
    }

    /**
     * Send a JSON response.
     */
    protected function json(array $data, int $statusCode = 200): void {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    /**
     * Redirect to a specific URL.
     */
    protected function redirect(string $url): void {
        // Automatically prefix with BASE_URL if it is a root-relative path
        if (str_starts_with($url, '/') && defined('BASE_URL')) {
            // Ensure we don't double-prefix if BASE_URL is already present
            if (empty(BASE_URL) || !str_starts_with($url, BASE_URL)) {
                $url = BASE_URL . $url;
            }
        }
        header("Location: " . $url);
        exit;
    }

    /**
     * Generate or fetch CSRF token.
     */
    protected function csrfToken(): string {
        return Auth::csrfToken();
    }

    /**
     * Verify CSRF token from post request.
     */
    protected function verifyCsrf(): void {
        $token = $_POST['csrf_token'] ?? null;
        if (!Auth::verifyCsrfToken($token)) {
            header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
            echo "<h1>400 Bad Request</h1><p>CSRF verification failed.</p>";
            exit;
        }
    }
}

// ✅ CHECKPOINT: BaseController.php — COMPLETE (المرحلة 6 من 8)
// التالي: app/Controllers/AuthController.php
