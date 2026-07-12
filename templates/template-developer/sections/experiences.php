<?php use App\Services\BilingualHelper; if (!empty($data['experiences'])): ?>
    <div class="exp-modern-grid">
        <?php foreach ($data['experiences'] as $exp): ?>
            <div class="exp-modern-card">
                <div class="exp-header">
                    <h3 class="exp-position"><?= htmlspecialchars(BilingualHelper::get($exp, 'position', $lang)) ?></h3>
                    <?php if (!empty($exp['start_date']) || !empty($exp['end_date'])): ?>
                        <span class="exp-date"><?= htmlspecialchars($exp['start_date'] ?? '') ?> <?= (!empty($exp['start_date']) && !empty($exp['end_date'])) ? '-' : '' ?> <?= htmlspecialchars($exp['end_date'] ?? '') ?></span>
                    <?php endif; ?>
                </div>
                <h4 class="exp-company"><i class="fas fa-building"></i> <?= htmlspecialchars(BilingualHelper::get($exp, 'company', $lang)) ?></h4>
                <?php if (!empty(BilingualHelper::get($exp, 'description', $lang))): ?>
                    <p class="exp-desc"><?= nl2br(htmlspecialchars(BilingualHelper::get($exp, 'description', $lang))) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>