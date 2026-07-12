<?php

namespace App\Models;

use App\Core\BaseModel;

class Project extends BaseModel {
    protected string $table = 'projects';

    /**
     * Find a single project by slug and site ID.
     */
    public function getBySlug(int $siteId, string $slug) {
        $sql = "SELECT * FROM `{$this->table}` WHERE `site_id` = :site_id AND `slug` = :slug LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'site_id' => $siteId,
            'slug'    => $slug
        ]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Helper to generate a slug from a title, supporting Arabic unicode characters.
     */
    public static function generateSlug(string $title): string {
        // Match Arabic and alphanumeric characters, replace others with dash
        $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', $title);
        $slug = trim($slug, '-');
        return !empty($slug) ? strtolower($slug) : uniqid('project-', false);
    }

    /**
     * Sync projects for a site using Delete & Re-insert.
     * Takes care of preserving existing cover images and handling nested project media sync.
     */
    public function sync(int $siteId, array $projects): void {
        $mediaModel = new ProjectMedia();

        // 1. Delete all projects for this site (Cascades to project_media)
        $this->deleteWhere(['site_id' => $siteId]);

        // 2. Insert list
        foreach ($projects as $index => $proj) {
            if (empty($proj['title'])) {
                continue;
            }

            $title = $proj['title'];
            $slug = !empty($proj['slug']) ? $proj['slug'] : self::generateSlug($title);

            // De-duplicate slug within the site scope
            $originalSlug = $slug;
            $counter = 1;
            while ($this->getBySlug($siteId, $slug) !== null) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $projectId = $this->create([
                'site_id'     => $siteId,
                'slug'        => $slug,
                'title'       => $title,
                'title_en'    => !empty($proj['title_en']) ? $proj['title_en'] : null,
                'summary'     => $proj['summary'] ?? null,
                'summary_en'  => !empty($proj['summary_en']) ? $proj['summary_en'] : null,
                'body'        => $proj['body'] ?? null,
                'body_en'     => !empty($proj['body_en']) ? $proj['body_en'] : null,
                'cover_image' => $proj['cover_image'] ?? null,
                'link'        => $proj['link'] ?? null,
                'github_link' => $proj['github_link'] ?? null,
                'type'        => !empty($proj['type']) ? $proj['type'] : 'project',
                'sort_order'  => $index
            ]);

            // Sync media gallery for this project if provided
            if ($projectId && !empty($proj['media'])) {
                foreach ($proj['media'] as $mediaIndex => $mediaItem) {
                    if (empty($mediaItem['file_path'])) {
                        continue;
                    }
                    $mediaModel->create([
                        'project_id' => $projectId,
                        'file_path'  => $mediaItem['file_path'],
                        'file_type'  => $mediaItem['file_type'] ?? 'image',
                        'caption'    => $mediaItem['caption'] ?? null,
                        'caption_en' => !empty($mediaItem['caption_en']) ? $mediaItem['caption_en'] : null,
                        'sort_order' => $mediaIndex
                    ]);
                }
            }
        }
    }
}

// ✅ CHECKPOINT: Project.php — COMPLETE (المرحلة 5 من 8)
// التالي: app/Models/ProjectMedia.php
