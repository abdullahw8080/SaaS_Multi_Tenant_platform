<?php

namespace App\Models;

use App\Core\BaseModel;

class Profile extends BaseModel {
    protected string $table = 'profiles';

    /**
     * Get profile by site ID.
     */
    public function getBySiteId(int $siteId) {
        return $this->findOneBy('site_id', $siteId);
    }

    /**
     * Save profile (insert or update).
     */
    public function saveProfile(int $siteId, array $data): bool {
        $existing = $this->getBySiteId($siteId);
        
        $fields = [
            'full_name'    => $data['full_name'] ?? '',
            'full_name_en' => $data['full_name_en'] ?? null,
            'photo'        => $data['photo'] ?? null,
            'bio'          => $data['bio'] ?? null,
            'bio_en'       => $data['bio_en'] ?? null,
            'title'        => $data['title'] ?? null,
            'title_en'     => $data['title_en'] ?? null,
            'cv_url'       => $data['cv_url'] ?? null,
            'references_text' => $data['references_text'] ?? null,
            'references_text_en' => $data['references_text_en'] ?? null,
        ];

        // Keep existing photo if not overwritten
        if ($existing && empty($fields['photo'])) {
            $fields['photo'] = $existing['photo'];
        }

        // Keep existing CV if not overwritten
        if ($existing && empty($fields['cv_url'])) {
            $fields['cv_url'] = $existing['cv_url'];
        }

        if ($existing) {
            return $this->update($existing['id'], $fields);
        } else {
            $fields['site_id'] = $siteId;
            return $this->create($fields) !== false;
        }
    }
}

// ✅ CHECKPOINT: Profile.php — COMPLETE (المرحلة 5 من 8)
// التالي: app/Models/Skill.php
