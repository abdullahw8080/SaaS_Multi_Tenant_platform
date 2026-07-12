<?php
use App\Services\BilingualHelper;
?>
<div class="grid grid-3">
    <?php if (empty($data['projects'])): ?>
        <p style="color: var(--text-muted); grid-column: span 3; text-align:center;"><?= $lang === 'en' ? 'No case studies added yet.' : 'لا يوجد أعمال مضافة بعد.' ?></p>
    <?php else: ?>
        <?php foreach ($data['projects'] as $proj): ?>
            <div class="card project-card" style="display:flex; flex-direction:column;">
                <?php if (!empty($proj['cover_image'])): ?>
                    <img src="<?= BASE_URL . htmlspecialchars($proj['cover_image']) ?>.jpg" alt="Case Study Cover" class="project-cover">
                <?php endif; ?>
                
                <h3 class="project-title" style="color: var(--accent); margin-bottom: 8px;"><?= htmlspecialchars(BilingualHelper::get($proj, 'title', $lang)) ?></h3>
                <p class="project-summary" style="font-size:0.9rem; line-height:1.5; color: var(--text-muted); margin-bottom:20px; flex:1;"><?= htmlspecialchars(BilingualHelper::get($proj, 'summary', $lang)) ?></p>
                
                <div class="project-links" style="margin-top:auto;">
                    <a href="<?= BASE_URL ?>/<?= htmlspecialchars($data['site']['slug']) ?>/projects/<?= htmlspecialchars($proj['slug']) ?>" class="btn btn-secondary" style="padding: 6px 14px; font-size:0.8rem; border-color:var(--primary); color:var(--primary); background:transparent; width:auto;">
                        <?= $lang === 'en' ? 'Read Case Study' : 'دراسة الحالة تفصيلياً' ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
