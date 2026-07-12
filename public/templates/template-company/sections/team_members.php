<?php
use App\Services\BilingualHelper;

$teamSection = null;
foreach ($data['sections'] as $sec) {
    if ($sec['type_key'] === 'team_members') {
        $teamSection = $sec;
        break;
    }
}
?>
<div class="grid grid-3">
    <?php if (!$teamSection || empty($teamSection['items'])): ?>
        <p style="color: var(--text-muted); grid-column: span 3; text-align:center;"><?= $lang === 'en' ? 'No team members added yet.' : 'لا يوجد أعضاء في فريق العمل حالياً.' ?></p>
    <?php else: ?>
        <?php foreach ($teamSection['items'] as $item): ?>
            <div class="card" style="text-align: center;">
                <div style="width: 100px; height: 100px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; border: 2px solid var(--border-color); font-size: 2.5rem; color: var(--text-muted);">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 700; color: var(--accent); margin-bottom: 4px;">
                    <?= htmlspecialchars(BilingualHelper::get($item, 'field_key', $lang)) ?>
                </h3>
                <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">
                    <?= htmlspecialchars(BilingualHelper::get($item, 'field_value', $lang)) ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
