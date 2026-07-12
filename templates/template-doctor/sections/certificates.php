<?php
use App\Services\BilingualHelper;
?>
<div class="grid grid-2">
    <?php if (empty($data['certificates'])): ?>
        <p style="color: var(--text-muted); grid-column: span 2;"><?= $lang === 'en' ? 'No licenses or board certifications added yet.' : 'لا يوجد شهادات أو تراخيص مزاولة مضافة بعد.' ?></p>
    <?php else: ?>
        <?php foreach ($data['certificates'] as $cert): ?>
            <div class="card" style="display:flex; justify-content:space-between; align-items:center; gap:20px;">
                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--accent); margin-bottom: 4px;"><?= htmlspecialchars(BilingualHelper::get($cert, 'title', $lang)) ?></h3>
                    <p style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;"><?= htmlspecialchars(BilingualHelper::get($cert, 'issuer', $lang)) ?> (<?= htmlspecialchars($cert['year']) ?>)</p>
                </div>
                <?php if (!empty($cert['file_url'])): ?>
                    <div>
                        <a href="<?= BASE_URL . htmlspecialchars($cert['file_url']) ?>" target="_blank" class="btn btn-secondary" style="width:auto; padding: 6px 14px; font-size:0.75rem; border-color:var(--primary); color:var(--primary);">
                            <i class="fa-solid fa-file-pdf"></i> <?= $lang === 'en' ? 'View PDF' : 'عرض الترخيص' ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
