<?php

namespace App\Models;

use App\Core\BaseModel;

class Education extends BaseModel {
    protected string $table = 'education';

    /**
     * Sync education using Delete & Re-insert.
     */
    public function sync(int $siteId, array $educations): void {
        $this->deleteWhere(['site_id' => $siteId]);

        foreach ($educations as $index => $edu) {
            if (empty($edu['degree']) || empty($edu['institution'])) {
                continue;
            }

            $this->create([
                'site_id'        => $siteId,
                'degree'         => $edu['degree'],
                'degree_en'      => !empty($edu['degree_en']) ? $edu['degree_en'] : null,
                'institution'    => $edu['institution'],
                'institution_en' => !empty($edu['institution_en']) ? $edu['institution_en'] : null,
                'year'           => $edu['year'] ?? null,
                'sort_order'     => $index
            ]);
        }
    }
}

// ✅ CHECKPOINT: Education.php — COMPLETE (المرحلة 5 من 8)
// التالي: app/Models/Certificate.php
