<?php

namespace App\Controllers;

use App\Models\Site;
use App\Models\Project;
use App\Services\BilingualHelper;
use Templates\TemplateRenderer;

class SiteController extends BaseController {
    /**
     * Serve the main SaaS landing page.
     */
    public function showHome(): void {
        // Beautiful welcome page introducing the platform
        $this->view('public/home');
    }

    /**
     * Show a client's public portfolio website.
     * Integrates bilingual caching.
     */
    public function showSite(array $params): void {
        $slug = trim($params['slug'] ?? '');
        
        $siteModel = new Site();
        $site = $siteModel->getSiteBySlug($slug);

        // 1. Validate site exists, user account is active, and site is approved/published
        if (!$site || $site['user_status'] !== 'active' || !$site['is_published'] || $site['approval_status'] !== 'approved') {
            $this->showNotFound("الموقع غير موجود، أو غير منشور حالياً، أو تم تعطيله من قبل الإدارة.");
            return;
        }

        // 2. Detect language
        $lang = BilingualHelper::getCurrentLanguage($site['default_lang']);
        
        // Ensure language is set for bilingual support
        if (!$site['is_bilingual']) {
            $lang = $site['default_lang'];
        }

        // 3. Check Caching Layer
        $cacheFile = dirname(__DIR__, 2) . '/cache/' . $slug . '_' . $lang . '.html';
        
        if (file_exists($cacheFile)) {
            // Read and output static cache file
            readfile($cacheFile);
            exit;
        }

        // 4. Cache Miss - Render using TemplateRenderer
        require_once dirname(__DIR__, 2) . '/templates/TemplateRenderer.php';
        $renderer = new \Templates\TemplateRenderer();

        try {
            $html = $renderer->render($site['id'], $lang);

            // 5. Store in cache folder (Ensure cache folder exists)
            $cacheDir = dirname(__DIR__, 2) . '/cache';
            if (!is_dir($cacheDir)) {
                mkdir($cacheDir, 0755, true);
            }
            file_put_contents($cacheFile, $html);

            // Output HTML
            echo $html;
        } catch (\Exception $e) {
            header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
            echo "<h1>500 Internal Server Error</h1><p>حدث خطأ أثناء عرض الموقع.</p>";
            if (defined('DEBUG') && DEBUG) {
                echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
    }

    /**
     * Show project detail page.
     * Displays a full description, image slider, PDF attachments, etc.
     */
    public function showProjectDetail(array $params): void {
        $slug = trim($params['slug'] ?? '');
        $projectSlug = trim($params['project_slug'] ?? '');

        $siteModel = new Site();
        $site = $siteModel->getSiteBySlug($slug);

        if (!$site || $site['user_status'] !== 'active' || !$site['is_published'] || $site['approval_status'] !== 'approved') {
            $this->showNotFound();
            return;
        }

        // Fetch project
        $projectModel = new Project();
        $project = $projectModel->getBySlug($site['id'], $projectSlug);

        if (!$project) {
            $this->showNotFound("المشروع غير موجود.");
            return;
        }

        // Fetch project media
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmtMedia = $db->prepare("SELECT * FROM `project_media` WHERE `project_id` = :project_id ORDER BY `sort_order` ASC");
        $stmtMedia->execute(['project_id' => $project['id']]);
        $project['media'] = $stmtMedia->fetchAll();

        // Get language settings
        $lang = BilingualHelper::getCurrentLanguage($site['default_lang']);
        if (!$site['is_bilingual']) {
            $lang = $site['default_lang'];
        }

        // Render project detail using the template's details file
        $templateFolder = $site['template_folder'];
        $detailTemplate = dirname(__DIR__, 2) . "/templates/{$templateFolder}/sections/project_detail.php";

        if (file_exists($detailTemplate)) {
            // Package standard parameters
            $data = [
                'site'    => $site,
                'project' => $project,
                'lang'    => $lang,
                'dir'     => BilingualHelper::direction($lang)
            ];
            
            extract($data);
            include $detailTemplate;
        } else {
            // Fallback generic detail view if template doesn't specify one
            $this->view('public/project_detail', [
                'site'    => $site,
                'project' => $project,
                'lang'    => $lang,
                'dir'     => BilingualHelper::direction($lang)
            ]);
        }
    }

    /**
     * Render a clean 404 page.
     */
    private function showNotFound(string $message = 'الصفحة المطلوبة غير موجودة.'): void {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        $this->view('public/404', ['message' => $message]);
    }
}

// ✅ CHECKPOINT: SiteController.php — COMPLETE (المرحلة 6 من 8)
// التالي: Phase 6 Views (public/home.php, public/404.php, public/project_detail.php)
