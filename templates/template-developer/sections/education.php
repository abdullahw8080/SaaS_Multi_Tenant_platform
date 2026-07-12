<?php use App\Services\BilingualHelper; if (!empty($data['education'])): ?>
    <div class="edu-grid">
        <?php foreach ($data['education'] as $edu): ?>
            <div class="edu-card glass-card">
                <div class="edu-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="edu-details">
                    <h3 class="edu-degree"><?= htmlspecialchars(BilingualHelper::get($edu, 'degree', $lang)) ?></h3>
                    <h4 class="edu-inst"><?= htmlspecialchars(BilingualHelper::get($edu, 'institution', $lang)) ?></h4>
                </div>
                <?php if (!empty($edu['year'])): ?>
                    <div class="edu-year"><i class="far fa-calendar"></i> <?= htmlspecialchars($edu['year']) ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>