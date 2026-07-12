<?php
use App\Services\BilingualHelper;
?>
<div class="timeline">
    <?php if (empty($data['experiences'])): ?>
        <p style="color: var(--text-muted);"><?= $lang === 'en' ? 'No medical practice experiences added yet.' : 'لا يوجد خبرات ممارسة مهنية مضافة بعد.' ?></p>
    <?php else: ?>
        <?php foreach ($data['experiences'] as $exp): ?>
            <div class="timeline-item">
                <div class="timeline-date"><?= htmlspecialchars($exp['start_date']) ?> - <?= htmlspecialchars($exp['end_date'] ?: ($lang === 'en' ? 'Present' : 'الحالي')) ?></div>
                <h3 class="timeline-title"><?= htmlspecialchars(BilingualHelper::get($exp, 'position', $lang)) ?></h3>
                <div class="timeline-subtitle"><?= htmlspecialchars(BilingualHelper::get($exp, 'company', $lang)) ?></div>
                <?php if (!empty(BilingualHelper::get($exp, 'description', $lang))): ?>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 6px;">
                        <?= nl2br(htmlspecialchars(BilingualHelper::get($exp, 'description', $lang))) ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
