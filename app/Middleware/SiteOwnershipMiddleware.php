<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Database;

class SiteOwnershipMiddleware {
    /**
     * Verify that the client owns the site or the specific resource they are attempting to modify.
     */
    public function handle(array $params = []): bool {
        Auth::startSession();
        
        $userRole = Auth::role();
        $userSiteId = Auth::siteId();

        // Admins bypass ownership checks
        if ($userRole === 'admin') {
            return true;
        }

        // If client has no site assigned yet, deny operations on resources
        if (!$userSiteId) {
            header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
            echo "<h1>403 Forbidden</h1><p>You do not have a site assigned yet. Please contact the administrator.</p>";
            return false;
        }

        // 1. Check if site_id is directly passed in route parameters
        if (isset($params['site_id']) && (int)$params['site_id'] !== $userSiteId) {
            header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
            echo "<h1>403 Forbidden</h1><p>Tenant segregation violation: You do not own this site.</p>";
            return false;
        }

        // 2. Check if a generic {id} parameter is passed, and find if the resource belongs to this site
        if (isset($params['id'])) {
            $resourceId = (int)$params['id'];
            $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

            // Determine table based on the URI path
            $table = null;
            if (str_contains($requestUri, '/dashboard/projects/')) {
                $table = 'projects';
            } elseif (str_contains($requestUri, '/dashboard/skills/')) {
                $table = 'skills';
            } elseif (str_contains($requestUri, '/dashboard/experiences/')) {
                $table = 'experiences';
            } elseif (str_contains($requestUri, '/dashboard/education/')) {
                $table = 'education';
            } elseif (str_contains($requestUri, '/dashboard/certificates/')) {
                $table = 'certificates';
            }

            if ($table) {
                $db = Database::getInstance()->getConnection();
                $stmt = $db->prepare("SELECT `site_id` FROM `{$table}` WHERE `id` = :id LIMIT 1");
                $stmt->execute(['id' => $resourceId]);
                $resource = $stmt->fetch();

                if (!$resource || (int)$resource['site_id'] !== $userSiteId) {
                    header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
                    echo "<h1>403 Forbidden</h1><p>Unauthorized access to this resource.</p>";
                    return false;
                }
            }
        }

        return true;
    }
}

// ✅ CHECKPOINT: SiteOwnershipMiddleware.php — COMPLETE (المرحلة 3 من 8)
// التالي: app/Services/ImageCompressor.php
