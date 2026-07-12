<?php

namespace App\Middleware;

use App\Core\Auth;

class AuthMiddleware {
    /**
     * Handle the middleware validation.
     */
    public function handle(array $params = []): bool {
        Auth::startSession();
        
        if (!Auth::check()) {
            // Redirect to login page (compatible with subdirectories)
            $redirectUrl = defined('BASE_URL') ? BASE_URL . '/login' : '/login';
            header("Location: " . $redirectUrl);
            exit;
        }
        
        return true;
    }
}

// ✅ CHECKPOINT: AuthMiddleware.php — COMPLETE (المرحلة 3 من 8)
// التالي: app/Middleware/RoleMiddleware.php
