<?php

namespace Templates;

use App\Models\Site;
use App\Services\BilingualHelper;

class TemplateRenderer {
    /**
     * Render the site using the configured template.
     * 
     * @param int $siteId The ID of the site.
     * @param string|null $lang Force language ('ar' or 'en'), otherwise detects current.
     * @return string The fully rendered HTML of the portfolio page.
     */
    public function render(int $siteId, ?string $lang = null): string {
        $siteModel = new Site();
        $data = $siteModel->getFullSiteData($siteId);

        if (!$data) {
            throw new \Exception("Site data not found.");
        }

        // Determine language
        if ($lang === null) {
            $lang = BilingualHelper::getCurrentLanguage($data['site']['default_lang']);
        }
        
        // Force default language if bilingual is disabled
        if (!$data['site']['is_bilingual']) {
            $lang = $data['site']['default_lang'];
        }

        $dir = BilingualHelper::direction($lang);

        // Store active templates directory path
        $templateFolder = $data['site']['template_folder'];
        $templateIndexFile = dirname(__DIR__) . "/templates/{$templateFolder}/index.php";

        if (!file_exists($templateIndexFile)) {
            throw new \Exception("Template index file not found under 'templates/{$templateFolder}/index.php'");
        }

        // Capture template output
        ob_start();
        
        // Expose helper variables to the template
        // $data holds everything: site, profile, social_links, skills, experiences, education, certificates, projects, sections
        // $lang is the active language string ('ar' or 'en')
        // $dir is direction ('rtl' or 'ltr')
        include $templateIndexFile;
        
        return ob_get_clean();
    }
}

// ✅ CHECKPOINT: TemplateRenderer.php — COMPLETE (المرحلة 7 من 8)
// التالي: templates/template-developer/index.php
