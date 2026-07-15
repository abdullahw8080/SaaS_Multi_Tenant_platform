<?php
use App\Services\BilingualHelper;

$hasStructuredRefs = !empty($data['references']);
$hasGeneralText = !empty(BilingualHelper::get($data['profile'], 'references_text', $lang));

if ($hasStructuredRefs):
?>
<div class="references-grid">
    <?php foreach ($data['references'] as $ref): ?>
        <div class="ref-glass-card" data-aos="fade-up">
            <div class="ref-avatar-wrapper">
                <?php if (!empty($ref['photo'])): ?>
                    <?php 
                    $refPhoto = BASE_URL . '/' . ltrim(htmlspecialchars($ref['photo']), '/');
                    $photoExt = strtolower(pathinfo($refPhoto, PATHINFO_EXTENSION));
                    if (!in_array($photoExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                        $refPhoto .= '.jpg';
                    }
                    ?>
                    <img src="<?= $refPhoto ?>" alt="<?= htmlspecialchars(BilingualHelper::get($ref, 'name', $lang)) ?>" class="ref-avatar" onerror="this.parentElement.innerHTML='<div class=\'ref-avatar-placeholder\'><i class=\'fa-solid fa-user\'></i></div>'">
                <?php else: ?>
                    <div class="ref-avatar-placeholder">
                        <i class="fa-solid fa-user"></i>
                    </div>
                <?php endif; ?>
            </div>

            <div class="ref-body">
                <h3 class="ref-name"><?= htmlspecialchars(BilingualHelper::get($ref, 'name', $lang)) ?></h3>

                <?php if (!empty(BilingualHelper::get($ref, 'description', $lang))): ?>
                    <p class="ref-desc"><?= htmlspecialchars(BilingualHelper::get($ref, 'description', $lang)) ?></p>
                <?php endif; ?>

                <?php if (!empty($ref['phone']) || !empty($ref['email'])): ?>
                    <div class="ref-actions">
                        <?php if (!empty($ref['phone'])): ?>
                            <a href="tel:<?= htmlspecialchars($ref['phone']) ?>" class="ref-btn phone" title="<?= $lang === 'en' ? 'Call' : 'اتصال' ?>">
                                <i class="fa-solid fa-phone"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($ref['email'])): ?>
                            <a href="mailto:<?= htmlspecialchars($ref['email']) ?>" class="ref-btn email" title="<?= $lang === 'en' ? 'Email' : 'البريد الإلكتروني' ?>">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php elseif ($hasGeneralText): ?>
    <div class="reference-card glass-card">
        <i class="fas fa-quote-right quote-icon"></i>
        <p><?= nl2br(htmlspecialchars(BilingualHelper::get($data['profile'], 'references_text', $lang))) ?></p>
    </div>
<?php else: ?>
    <p style="text-align: center; color: var(--text-muted); font-style: italic;">
        <?= $lang === 'en' ? 'No references available.' : 'لا تتوفر مراجع حالياً.' ?>
    </p>
<?php endif; ?>
