<?php
use App\Services\BilingualHelper;

$servicesSection = null;
foreach ($data['sections'] as $sec) {
    if ($sec['type_key'] === 'services') {
        $servicesSection = $sec;
        break;
    }
}
?>
<div class="grid grid-3">
    <?php if (!$servicesSection || empty($servicesSection['items'])): ?>
        <p style="color: var(--text-muted); grid-column: span 3; text-align:center;"><?= $lang === 'en' ? 'No services added yet.' : 'لا يوجد خدمات مضافة بعد.' ?></p>
    <?php else: ?>
        <?php foreach ($servicesSection['items'] as $item): ?>
            <div class="card">
                <div style="font-size: 2rem; color: var(--primary); margin-bottom: 16px;">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 12px; color: var(--accent);">
                    <?= htmlspecialchars(BilingualHelper::get($item, 'field_key', $lang)) ?>
                </h3>
                <p style="font-size: 0.95rem; color: var(--text-muted); line-height: 1.6;">
                    <?= htmlspecialchars(BilingualHelper::get($item, 'field_value', $lang)) ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
