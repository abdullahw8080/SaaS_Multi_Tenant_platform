<?php
use App\Services\BilingualHelper;

// Locate the services section in the site data
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
        <p style="color: var(--text-muted); grid-column: span 3;"><?= $lang === 'en' ? 'No specialized services listed yet.' : 'لا يوجد خدمات تخصصية مضافة بعد.' ?></p>
    <?php else: ?>
        <?php foreach ($servicesSection['items'] as $item): ?>
            <div class="card">
                <div style="font-size: 1.8rem; color: var(--primary); margin-bottom: 12px;">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 8px; color: var(--accent);">
                    <?= htmlspecialchars(BilingualHelper::get($item, 'field_key', $lang)) ?>
                </h3>
                <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.5;">
                    <?= htmlspecialchars(BilingualHelper::get($item, 'field_value', $lang)) ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
