<?php use App\Services\BilingualHelper; if (!empty($data['projects'])): ?>
    <div class="projects-modern-grid">
        <?php foreach ($data['projects'] as $proj): ?>
            <div class="project-modern-card glass-card">
                <?php if (!empty($proj['cover_image'])): ?>
                    <div class="proj-img-wrapper">
                        <?php 
                            $coverUrl = BASE_URL . '/' . ltrim(htmlspecialchars($proj['cover_image']), '/');
                            $coverExt = strtolower(pathinfo($coverUrl, PATHINFO_EXTENSION));
                            if (!in_array($coverExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                                $coverUrl .= '.jpg';
                            }
                        ?>
                        <img src="<?= $coverUrl ?>" alt="Project Cover" loading="lazy">
                        <div class="proj-overlay">
                            <?php if (!empty($proj['slug'])): ?>
                                <a href="<?= BASE_URL ?>/<?= htmlspecialchars($data['site']['slug']) ?>/projects/<?= htmlspecialchars($proj['slug']) ?><?= $lang === 'en' ? '?lang=en' : '' ?>" class="proj-view-btn">
                                    <?= $lang === 'en' ? 'View Details' : 'عرض التفاصيل' ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="proj-content">
                    <h3 class="proj-title"><?= htmlspecialchars(BilingualHelper::get($proj, 'title', $lang)) ?></h3>
                    <?php if (!empty(BilingualHelper::get($proj, 'summary', $lang))): ?>
                        <p class="proj-summary"><?= htmlspecialchars(BilingualHelper::get($proj, 'summary', $lang)) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>