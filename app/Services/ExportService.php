<?php

namespace App\Services;

use App\Core\Database;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ExportService {
    /**
     * Export a site to a static HTML ZIP archive.
     * 
     * @param int $siteId The ID of the site to export.
     * @param string $renderedHtml The fully rendered HTML content of the site.
     * @param string $templateFolder The template directory name (e.g. 'template-developer').
     * @return string|null The relative path to the generated ZIP file, or null on failure.
     */
    public function export(int $siteId, string $renderedHtml, string $templateFolder): ?string {
        $db = Database::getInstance()->getConnection();
        
        // 1. Fetch site details
        $stmt = $db->prepare("SELECT * FROM `sites` WHERE `id` = :id LIMIT 1");
        $stmt->execute(['id' => $siteId]);
        $site = $stmt->fetch();
        if (!$site) {
            return null;
        }
        
        $slug = $site['slug'];
        $baseDir = dirname(__DIR__, 2);
        
        $exportDir = $baseDir . '/exports/site_' . $siteId;
        $zipFile = $baseDir . '/public/exports/' . $slug . '-static.zip';

        // Ensure exports directory exists in public so it can be downloaded
        $publicExportsDir = $baseDir . '/public/exports';
        if (!is_dir($publicExportsDir)) {
            mkdir($publicExportsDir, 0755, true);
        }

        // Clean up previous structures
        if (file_exists($zipFile)) {
            @unlink($zipFile);
        }
        $this->deleteDirectory($exportDir);

        // Create clean export directory structure
        mkdir($exportDir, 0755, true);
        mkdir($exportDir . '/assets', 0755, true);
        mkdir($exportDir . '/uploads', 0755, true);

        // 2. Copy Template assets (CSS/JS/images inside the template folder)
        $templateSourceDir = $baseDir . '/templates/' . $templateFolder;
        if (is_dir($templateSourceDir)) {
            $this->copyAssets($templateSourceDir, $exportDir . '/assets');
        }

        // 3. Copy user uploaded assets for this site
        $userUploadsSourceDir = $baseDir . '/public/uploads/sites/' . $siteId;
        if (is_dir($userUploadsSourceDir)) {
            $this->copyUserUploads($userUploadsSourceDir, $exportDir . '/uploads');
        }

        // 4. Rewrite URLs in HTML
        // Remove BASE_URL prefix from all URLs to make them relative
        $processedHtml = str_replace(BASE_URL, '', $renderedHtml);

        // Rewrite template assets to local assets/ folder
        // Matches "/templates/template-developer/style.css" or "/public/templates/template-developer/style.css"
        // and strips query parameters (like ?v=178330) for clean offline links
        $processedHtml = preg_replace(
            '#/(?:templates|public/templates)/' . preg_quote($templateFolder, '#') . '/([^"\'\?]+)(?:\?[^"\']*)?#',
            'assets/$1',
            $processedHtml
        );

        // Rewrite user uploaded document paths to 'uploads/docs/'
        $processedHtml = preg_replace(
            '#/uploads/sites/' . $siteId . '/docs/([^"\'\?]+)(?:\?[^"\']*)?#',
            'uploads/docs/$1',
            $processedHtml
        );

        // Rewrite user uploaded general paths to 'uploads/'
        $processedHtml = preg_replace(
            '#/uploads/sites/' . $siteId . '/([^"\'\?]+)(?:\?[^"\']*)?#',
            'uploads/$1',
            $processedHtml
        );

        // Rewrite project detail links on the main page to point to local projects folder
        $processedHtml = preg_replace(
            '#/[a-zA-Z0-9_\-]+/projects/([a-zA-Z0-9_\-]+)/?#',
            'projects/$1.html',
            $processedHtml
        );

        // 5. Generate and export static Project Detail pages
        $lang = \App\Services\BilingualHelper::getCurrentLanguage($site['default_lang']);
        if (!$site['is_bilingual']) {
            $lang = $site['default_lang'];
        }
        $dir = \App\Services\BilingualHelper::direction($lang);

        // Fetch profile to populate full_name in project detail header
        $stmtProf = $db->prepare("SELECT * FROM `profiles` WHERE `site_id` = :site_id LIMIT 1");
        $stmtProf->execute(['site_id' => $siteId]);
        $profile = $stmtProf->fetch();
        if ($profile) {
            $site['full_name'] = $profile['full_name'];
            $site['full_name_en'] = $profile['full_name_en'];
        }

        // Fetch all projects
        $stmtProj = $db->prepare("SELECT * FROM `projects` WHERE `site_id` = :site_id ORDER BY `sort_order` ASC");
        $stmtProj->execute(['site_id' => $siteId]);
        $projects = $stmtProj->fetchAll();

        if (!empty($projects)) {
            mkdir($exportDir . '/projects', 0755, true);
            $detailTemplate = $baseDir . "/templates/{$templateFolder}/sections/project_detail.php";
            
            foreach ($projects as $project) {
                // Fetch media
                $stmtMedia = $db->prepare("SELECT * FROM `project_media` WHERE `project_id` = :project_id ORDER BY `sort_order` ASC");
                $stmtMedia->execute(['project_id' => $project['id']]);
                $project['media'] = $stmtMedia->fetchAll();

                $projectHtml = '';
                if (file_exists($detailTemplate)) {
                    ob_start();
                    $data = [
                        'site'    => $site,
                        'project' => $project,
                        'lang'    => $lang,
                        'dir'     => $dir
                    ];
                    extract($data);
                    include $detailTemplate;
                    $projectHtml = ob_get_clean();
                } else {
                    $projectHtml = "<h1>" . htmlspecialchars($project['title']) . "</h1>";
                }

                // Process URLs in project detail page to make them relative
                $processedProjHtml = str_replace(BASE_URL, '', $projectHtml);

                // Rewrite template assets to local assets/ folder (../assets/ from projects/)
                $processedProjHtml = preg_replace(
                    '#/(?:templates|public/templates)/' . preg_quote($templateFolder, '#') . '/([^"\'\?]+)(?:\?[^"\']*)?#',
                    '../assets/$1',
                    $processedProjHtml
                );

                // Rewrite user uploaded document paths to 'uploads/docs/'
                $processedProjHtml = preg_replace(
                    '#/uploads/sites/' . $siteId . '/docs/([^"\'\?]+)(?:\?[^"\']*)?#',
                    '../uploads/docs/$1',
                    $processedProjHtml
                );

                // Rewrite user uploaded general paths to 'uploads/'
                $processedProjHtml = preg_replace(
                    '#/uploads/sites/' . $siteId . '/([^"\'\?]+)(?:\?[^"\']*)?#',
                    '../uploads/$1',
                    $processedProjHtml
                );

                // Rewrite home link back to index.html
                $processedProjHtml = preg_replace(
                    '#href=["\']/' . preg_quote($slug, '#') . '/?["\']#',
                    'href="../index.html"',
                    $processedProjHtml
                );

                // Rewrite links to other projects
                $processedProjHtml = preg_replace(
                    '#/[a-zA-Z0-9_\-]+/projects/([a-zA-Z0-9_\-]+)/?#',
                    '$1.html',
                    $processedProjHtml
                );

                // Save static page
                $projectSlug = $project['slug'];
                file_put_contents($exportDir . '/projects/' . $projectSlug . '.html', $processedProjHtml);
            }
        }

        // 6. Save the modified HTML as index.html in the root of the export folder
        file_put_contents($exportDir . '/index.html', $processedHtml);

        // 6. Zip the directory
        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($exportDir),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    // Get relative path for the zip file (stripping the root export directory path)
                    $relativePath = substr($filePath, strlen($exportDir) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
        } else {
            return null;
        }

        // 7. Clean up temporary directory
        $this->deleteDirectory($exportDir);

        // Return relative path for download
        return '/exports/' . $slug . '-static.zip';
    }

    /**
     * Recursively copy files from one folder to another.
     */
    private function copyAssets(string $src, string $dst): void {
        $dir = opendir($src);
        @mkdir($dst, 0755, true);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..') && ($file != 'sections')) {
                if (is_dir($src . '/' . $file)) {
                    $this->copyAssets($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /**
     * Copy user uploaded files, including nested docs folder if it exists.
     */
    private function copyUserUploads(string $src, string $dst): void {
        if (!is_dir($src)) {
            return;
        }
        $dir = opendir($src);
        @mkdir($dst, 0755, true);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->copyUserUploads($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /**
     * Recursively delete a directory.
     */
    private function deleteDirectory(string $dir): bool {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }
}

// ✅ CHECKPOINT: ExportService.php — COMPLETE (المرحلة 4 من 8)
// التالي: app/Models/User.php
