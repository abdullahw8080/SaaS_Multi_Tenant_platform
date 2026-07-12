<?php

namespace App\Models;

use App\Core\BaseModel;

class Language extends BaseModel {
    protected string $table = 'languages';

    /**
     * Fetch languages by site ID.
     */
    public function getBySiteId(int $siteId): array {
        return $this->findAllBy('site_id', $siteId, 'sort_order ASC');
    }

    /**
     * Sync languages for a site (Delete & Re-insert).
     */
    public function sync(int $siteId, array $languages): void {
        $this->deleteWhere(['site_id' => $siteId]);

        foreach ($languages as $index => $lang) {
            if (empty($lang['name'])) {
                continue;
            }

            $this->create([
                'site_id'    => $siteId,
                'name'       => $lang['name'],
                'name_en'    => !empty($lang['name_en']) ? $lang['name_en'] : null,
                'level'      => $lang['level'] ?? '',
                'level_en'   => !empty($lang['level_en']) ? $lang['level_en'] : null,
                'percentage' => isset($lang['percentage']) ? (int)$lang['percentage'] : 100,
                'sort_order' => $index
            ]);
        }
    }
}
