<?php

namespace App\Models;

use App\Core\BaseModel;

class SiteSection extends BaseModel {
    protected string $table = 'site_sections';

    /**
     * Get sections for a site.
     */
    public function getBySiteId(int $siteId): array {
        $sql = "SELECT ss.*, st.key as type_key 
                FROM `{$this->table}` ss 
                JOIN `section_types` st ON ss.section_type_id = st.id 
                WHERE ss.site_id = :site_id 
                ORDER BY ss.sort_order ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['site_id' => $siteId]);
        return $stmt->fetchAll();
    }

    /**
     * Initialize default sections for a site based on template default sections JSON.
     */
    public function initializeDefaultSections(int $siteId, int $templateId): void {
        // 1. Fetch template default sections
        $stmtTpl = $this->db->prepare("SELECT `default_sections` FROM `templates` WHERE `id` = :template_id LIMIT 1");
        $stmtTpl->execute(['template_id' => $templateId]);
        $defaultSectionsJson = $stmtTpl->fetchColumn();

        if (!$defaultSectionsJson) {
            return;
        }

        $defaultSections = json_decode($defaultSectionsJson, true);
        if (empty($defaultSections)) {
            return;
        }

        // 2. Delete existing sections (and cascade delete section_items)
        $this->deleteWhere(['site_id' => $siteId]);

        // 3. Create default sections
        foreach ($defaultSections as $index => $key) {
            $stmtType = $this->db->prepare("SELECT * FROM `section_types` WHERE `key` = :key LIMIT 1");
            $stmtType->execute(['key' => $key]);
            $type = $stmtType->fetch();

            if ($type) {
                $this->create([
                    'site_id'         => $siteId,
                    'section_type_id' => $type['id'],
                    'title'           => $type['name'], // Arabic name from seed data
                    'title_en'        => ucwords(str_replace('_', ' ', $key)),
                    'sort_order'      => $index,
                    'is_visible'      => 1
                ]);
            }
        }
    }
}

// ✅ CHECKPOINT: SiteSection.php — COMPLETE (المرحلة 5 من 8)
// التالي: app/Models/SectionItem.php
