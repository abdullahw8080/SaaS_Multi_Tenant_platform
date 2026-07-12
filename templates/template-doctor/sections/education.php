<?php
use App\Services\BilingualHelper;
?>
<div class="timeline">
    <?php if (empty($data['education'])): ?>
        <p style="color: var(--text-muted);"><?= $lang === 'en' ? 'No academic qualification records added yet.' : 'لا يوجد مؤهلات أكاديمية مسجلة بعد.' ?></p>
    <?php else: ?>
        <?php foreach ($data['education'] as $edu): ?>
            <div class="timeline-item">
                <div class="timeline-date"><?= htmlspecialchars($edu['year']) ?></div>
                <h3 class="timeline-title"><?= htmlspecialchars(BilingualHelper::get($edu, 'degree', $lang)) ?></h3>
                <div class="timeline-subtitle"><?= htmlspecialchars(BilingualHelper::get($edu, 'institution', $lang)) ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
