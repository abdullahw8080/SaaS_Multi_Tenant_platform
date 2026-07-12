<?php

namespace App\Models;

use App\Core\BaseModel;

class Skill extends BaseModel {
    protected string $table = 'skills';

    public function sync(int $siteId, array $skills, string $type = 'technical'): void {
        $this->deleteWhere(['site_id' => $siteId, 'type' => $type]);

        foreach ($skills as $index => $skill) {
            if (empty($skill['name'])) {
                continue;
            }

            $this->create([
                'site_id'        => $siteId,
                'name'           => $skill['name'],
                'name_en'        => !empty($skill['name_en']) ? $skill['name_en'] : null,
                'level'          => isset($skill['level']) ? (int)$skill['level'] : 100,
                'description'    => !empty($skill['description']) ? $skill['description'] : null,
                'description_en' => !empty($skill['description_en']) ? $skill['description_en'] : null,
                'type'           => $type,
                'sort_order'     => $index
            ]);
        }
    }
}

// ✅ CHECKPOINT: Skill.php — COMPLETE (المرحلة 5 من 8)
// التالي: app/Models/Project.php
