<?php

namespace App\Models;

use App\Core\BaseModel;

class SectionItem extends BaseModel {
    protected string $table = 'section_items';

    /**
     * Fetch all items belonging to a section.
     */
    public function getBySectionId(int $sectionId): array {
        return $this->findAll(['section_id' => $sectionId], 'sort_order ASC');
    }

    /**
     * Sync section items using Delete & Re-insert.
     */
    public function sync(int $sectionId, array $items): void {
        $this->deleteWhere(['section_id' => $sectionId]);

        foreach ($items as $index => $item) {
            if (empty($item['field_key']) || empty($item['field_value'])) {
                continue;
            }

            $this->create([
                'section_id'     => $sectionId,
                'field_key'      => $item['field_key'],
                'field_value'    => $item['field_value'],
                'field_value_en' => !empty($item['field_value_en']) ? $item['field_value_en'] : null,
                'sort_order'     => $index
            ]);
        }
    }
}

// ✅ CHECKPOINT: SectionItem.php — COMPLETE (المرحلة 5 من 8)
// التالي: Phase 6: Controllers والـ Views
