<?php

namespace App\Models;

use App\Core\BaseModel;
use PDO;

class Site extends BaseModel {
    protected string $table = 'sites';

    /**
     * Find a site by slug with template and user data.
     */
    public function getSiteBySlug(string $slug) {
        $sql = "SELECT s.*, t.folder_name as template_folder, t.name as template_name, u.email as user_email, u.status as user_status 
                FROM `{$this->table}` s 
                JOIN `templates` t ON s.template_id = t.id 
                JOIN `users` u ON s.user_id = u.id 
                WHERE s.slug = :slug LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Get site by user ID.
     */
    public function getSiteByUserId(int $userId) {
        return $this->findOneBy('user_id', $userId);
    }

    /**
     * Check if slug exists, optionally ignoring a specific site ID.
     */
    public function slugExists(string $slug, ?int $excludeSiteId = null): bool {
        $reserved = ['admin', 'dashboard', 'login', 'register', 'logout', 'assets', 'public', 'uploads', 'cache', 'api'];
        if (in_array(strtolower(trim($slug)), $reserved, true)) {
            return true;
        }

        $sql = "SELECT COUNT(*) FROM `{$this->table}` WHERE `slug` = :slug";
        $params = ['slug' => $slug];
        
        if ($excludeSiteId !== null) {
            $sql .= " AND `id` != :exclude_id";
            $params['exclude_id'] = $excludeSiteId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }

    /**
     * Fetch complete site data (profile, sections, items, experiences, etc.)
     * returns consolidated array for templating.
     */
    public function getFullSiteData(int $siteId): ?array {
        // 1. Fetch site and template folder
        $sql = "SELECT s.*, t.folder_name as template_folder, t.name as template_name
                FROM `{$this->table}` s 
                JOIN `templates` t ON s.template_id = t.id 
                WHERE s.id = :site_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['site_id' => $siteId]);
        $site = $stmt->fetch();
        
        if (!$site) {
            return null;
        }

        // 2. Fetch Profile
        $stmtProf = $this->db->prepare("SELECT * FROM `profiles` WHERE `site_id` = :site_id LIMIT 1");
        $stmtProf->execute(['site_id' => $siteId]);
        $profile = $stmtProf->fetch() ?: [
            'full_name' => '', 'full_name_en' => '',
            'photo' => '', 'bio' => '', 'bio_en' => '',
            'title' => '', 'title_en' => '',
            'cv_url' => '', 'references_text' => '', 'references_text_en' => ''
        ];

        // 3. Fetch Social Links
        $stmtSocial = $this->db->prepare("SELECT * FROM `social_links` WHERE `site_id` = :site_id ORDER BY `sort_order` ASC");
        $stmtSocial->execute(['site_id' => $siteId]);
        $socialLinks = $stmtSocial->fetchAll();

        // 4. Fetch Technical Skills
        $stmtSkills = $this->db->prepare("SELECT * FROM `skills` WHERE `site_id` = :site_id AND `type` = 'technical' ORDER BY `sort_order` ASC");
        $stmtSkills->execute(['site_id' => $siteId]);
        $skills = $stmtSkills->fetchAll();

        // 4b. Fetch Personal Skills
        $stmtPersSkills = $this->db->prepare("SELECT * FROM `skills` WHERE `site_id` = :site_id AND `type` = 'personal' ORDER BY `sort_order` ASC");
        $stmtPersSkills->execute(['site_id' => $siteId]);
        $personalSkills = $stmtPersSkills->fetchAll();

        // 5. Fetch Experiences
        $stmtExp = $this->db->prepare("SELECT * FROM `experiences` WHERE `site_id` = :site_id ORDER BY `sort_order` ASC, `start_date` DESC");
        $stmtExp->execute(['site_id' => $siteId]);
        $experiences = $stmtExp->fetchAll();

        // 6. Fetch Education
        $stmtEd = $this->db->prepare("SELECT * FROM `education` WHERE `site_id` = :site_id ORDER BY `sort_order` ASC");
        $stmtEd->execute(['site_id' => $siteId]);
        $education = $stmtEd->fetchAll();

        // 7. Fetch Certificates
        $stmtCert = $this->db->prepare("SELECT * FROM `certificates` WHERE `site_id` = :site_id ORDER BY `sort_order` ASC");
        $stmtCert->execute(['site_id' => $siteId]);
        $certificates = $stmtCert->fetchAll();

        // 7b. Fetch Languages
        $stmtLang = $this->db->prepare("SELECT * FROM `languages` WHERE `site_id` = :site_id ORDER BY `sort_order` ASC");
        $stmtLang->execute(['site_id' => $siteId]);
        $languages = $stmtLang->fetchAll();

        // 8. Fetch Projects and their media
        $stmtProj = $this->db->prepare("SELECT * FROM `projects` WHERE `site_id` = :site_id ORDER BY `sort_order` ASC");
        $stmtProj->execute(['site_id' => $siteId]);
        $projects = $stmtProj->fetchAll();

        foreach ($projects as &$project) {
            $stmtMedia = $this->db->prepare("SELECT * FROM `project_media` WHERE `project_id` = :project_id ORDER BY `sort_order` ASC");
            $stmtMedia->execute(['project_id' => $project['id']]);
            $project['media'] = $stmtMedia->fetchAll();
        }

        // 9b. Fetch Structured References
        $stmtRefs = $this->db->prepare("SELECT * FROM `site_references` WHERE `site_id` = :site_id ORDER BY `sort_order` ASC");
        $stmtRefs->execute(['site_id' => $siteId]);
        $references = $stmtRefs->fetchAll();

        // 9. Fetch dynamic sections and items
        $stmtSections = $this->db->prepare("
            SELECT ss.*, st.key as type_key 
            FROM `site_sections` ss 
            JOIN `section_types` st ON ss.section_type_id = st.id 
            WHERE ss.site_id = :site_id 
            ORDER BY ss.sort_order ASC
        ");
        $stmtSections->execute(['site_id' => $siteId]);
        $sections = $stmtSections->fetchAll();

        foreach ($sections as &$section) {
            $stmtItems = $this->db->prepare("SELECT * FROM `section_items` WHERE `section_id` = :section_id ORDER BY `sort_order` ASC");
            $stmtItems->execute(['section_id' => $section['id']]);
            $section['items'] = $stmtItems->fetchAll();
        }

        return [
            'site'            => $site,
            'profile'         => $profile,
            'social_links'    => $socialLinks,
            'skills'          => $skills,
            'personal_skills' => $personalSkills,
            'languages'       => $languages,
            'experiences'     => $experiences,
            'education'       => $education,
            'certificates'    => $certificates,
            'projects'        => $projects,
            'sections'        => $sections,
            'references'      => $references,
        ];
    }
}

// ✅ CHECKPOINT: Site.php — COMPLETE (المرحلة 5 من 8)
// التالي: app/Models/Profile.php
