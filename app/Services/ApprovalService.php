<?php

namespace App\Services;

use App\Core\Database;

class ApprovalService {
    /**
     * Submit a site's draft for admin review.
     * Transitions from 'draft' or 'rejected' to 'under_review'.
     */
    public function submitForReview(int $siteId): bool {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("
            UPDATE `sites` 
            SET `approval_status` = 'under_review', `is_published` = 0 
            WHERE `id` = :site_id AND `approval_status` IN ('draft', 'pending', 'rejected')
        ");
        return $stmt->execute(['site_id' => $siteId]);
    }

    /**
     * Approve a site, making it publicly visible.
     * Transitions status to 'approved' and sets is_published = 1.
     * Invalidates the cache for the site's slug.
     */
    public function approve(int $siteId): bool {
        $db = Database::getInstance()->getConnection();

        // 1. Fetch site slug for cache invalidation
        $stmtSlug = $db->prepare("SELECT `slug` FROM `sites` WHERE `id` = :site_id LIMIT 1");
        $stmtSlug->execute(['site_id' => $siteId]);
        $site = $stmtSlug->fetch();
        
        if (!$site) {
            return false;
        }

        // 2. Transition status
        $stmt = $db->prepare("
            UPDATE `sites` 
            SET `approval_status` = 'approved', `is_published` = 1, `rejection_reason` = NULL 
            WHERE `id` = :site_id
        ");
        
        $success = $stmt->execute(['site_id' => $siteId]);

        if ($success) {
            self::invalidateCache($site['slug']);
        }

        return $success;
    }

    /**
     * Reject a site with a specific reason.
     * Transitions status to 'rejected' and sets is_published = 0.
     * Invalidates any existing cache.
     */
    public function reject(int $siteId, string $reason): bool {
        $db = Database::getInstance()->getConnection();

        // 1. Fetch slug
        $stmtSlug = $db->prepare("SELECT `slug` FROM `sites` WHERE `id` = :site_id LIMIT 1");
        $stmtSlug->execute(['site_id' => $siteId]);
        $site = $stmtSlug->fetch();
        
        if (!$site) {
            return false;
        }

        // 2. Transition status and set reason
        $stmt = $db->prepare("
            UPDATE `sites` 
            SET `approval_status` = 'rejected', `is_published` = 0, `rejection_reason` = :reason 
            WHERE `id` = :site_id
        ");
        
        $success = $stmt->execute([
            'site_id' => $siteId,
            'reason'  => $reason
        ]);

        if ($success) {
            self::invalidateCache($site['slug']);
        }

        return $success;
    }

    /**
     * Helper to invalidate (delete) static HTML cache when site status changes.
     */
    public static function invalidateCache(string $slug): void {
        $cacheDir = dirname(__DIR__, 2) . '/cache/';
        if (is_dir($cacheDir)) {
            $files = glob($cacheDir . $slug . '*.html');
            if ($files) {
                foreach ($files as $file) {
                    @unlink($file);
                }
            }
        }
    }
}

// ✅ CHECKPOINT: ApprovalService.php — COMPLETE (المرحلة 4 من 8)
// التالي: app/Services/ExportService.php
