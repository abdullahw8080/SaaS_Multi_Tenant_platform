<?php

namespace App\Middleware;

use App\Core\Auth;

class RoleMiddleware {
    /**
     * Verify user role based on request path.
     */
    public function handle(array $params = []): bool {
        Auth::startSession();
        $role = Auth::role();
        
        $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

        // Strip BASE_URL prefix if defined (for subdirectory support on XAMPP)
        if (defined('BASE_URL') && !empty(BASE_URL) && str_starts_with($requestUri, BASE_URL)) {
            $requestUri = substr($requestUri, strlen(BASE_URL));
        }

        // Enforce admin privileges for /admin routes
        if (str_starts_with($requestUri, '/admin')) {
            if ($role !== 'admin') {
                header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
                echo "<h1>403 Forbidden</h1><p>Access denied. Admin credentials required.</p>";
                return false;
            }
        }

        // Enforce client privileges for /dashboard routes
        if (str_starts_with($requestUri, '/dashboard')) {
            if ($role !== 'client') {
                header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
                echo "<h1>403 Forbidden</h1><p>Access denied. Client credentials required.</p>";
                return false;
            }
        }

        return true;
    }
}

// ✅ CHECKPOINT: RoleMiddleware.php — COMPLETE (المرحلة 3 من 8)
// التالي: app/Middleware/SiteOwnershipMiddleware.php
