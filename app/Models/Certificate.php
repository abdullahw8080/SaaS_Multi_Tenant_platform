<?php

namespace App\Models;

use App\Core\BaseModel;

class Certificate extends BaseModel {
    protected string $table = 'certificates';

    /**
     * Sync certificates using Delete & Re-insert.
     */
    public function sync(int $siteId, array $certificates): void {
        $this->deleteWhere(['site_id' => $siteId]);

        foreach ($certificates as $index => $cert) {
            if (empty($cert['title'])) {
                continue;
            }

            $this->create([
                'site_id'    => $siteId,
                'title'      => $cert['title'],
                'title_en'   => !empty($cert['title_en']) ? $cert['title_en'] : null,
                'issuer'     => $cert['issuer'] ?? '',
                'issuer_en'  => !empty($cert['issuer_en']) ? $cert['issuer_en'] : null,
                'file_url'   => $cert['file_url'] ?? null,
                'link'       => !empty($cert['link']) ? $cert['link'] : null,
                'year'       => $cert['year'] ?? null,
                'sort_order' => $index
            ]);
        }
    }
}

// ✅ CHECKPOINT: Certificate.php — COMPLETE (المرحلة 5 من 8)
// التالي: app/Models/SiteSection.php
