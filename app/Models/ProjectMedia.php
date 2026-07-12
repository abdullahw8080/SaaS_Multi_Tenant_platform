<?php

namespace App\Models;

use App\Core\BaseModel;

class ProjectMedia extends BaseModel {
    protected string $table = 'project_media';

    /**
     * Get all media for a specific project.
     */
    public function getByProjectId(int $projectId): array {
        return $this->findAll(['project_id' => $projectId], 'sort_order ASC');
    }
}

// ✅ CHECKPOINT: ProjectMedia.php — COMPLETE (المرحلة 5 من 8)
// التالي: app/Models/Experience.php
