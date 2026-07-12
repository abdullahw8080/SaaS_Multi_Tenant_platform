<?php

namespace App\Models;

use App\Core\BaseModel;

class Experience extends BaseModel {
    protected string $table = 'experiences';

    /**
     * Sync experiences using Delete & Re-insert.
     */
    public function sync(int $siteId, array $experiences): void {
        $this->deleteWhere(['site_id' => $siteId]);

        foreach ($experiences as $index => $exp) {
            if (empty($exp['position']) || empty($exp['company'])) {
                continue;
            }

            $this->create([
                'site_id'        => $siteId,
                'position'       => $exp['position'],
                'position_en'    => !empty($exp['position_en']) ? $exp['position_en'] : null,
                'company'        => $exp['company'],
                'company_en'     => !empty($exp['company_en']) ? $exp['company_en'] : null,
                'start_date'     => $exp['start_date'] ?? null,
                'end_date'       => $exp['end_date'] ?? null,
                'description'    => $exp['description'] ?? null,
                'description_en' => !empty($exp['description_en']) ? $exp['description_en'] : null,
                'sort_order'     => $index
            ]);
        }
    }
}

// ✅ CHECKPOINT: Experience.php — COMPLETE (المرحلة 5 من 8)
// التالي: app/Models/Education.php
