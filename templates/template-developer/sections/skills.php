<?php use App\Services\BilingualHelper; if (!empty($data['skills'])): ?>
    <div class="skills-cards-grid">
        <?php foreach ($data['skills'] as $skill): ?>
            <div class="skill-modern-card glass-card">
                <h3 class="skill-title"><i class="fas fa-laptop-code"></i> <?= htmlspecialchars(BilingualHelper::get($skill, 'name', $lang)) ?></h3>
                <?php if (!empty(BilingualHelper::get($skill, 'description', $lang))): ?>
                    <p class="skill-desc"><?= htmlspecialchars(BilingualHelper::get($skill, 'description', $lang)) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>