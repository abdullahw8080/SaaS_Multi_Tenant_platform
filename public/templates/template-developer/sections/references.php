<?php
use App\Services\BilingualHelper;

$hasStructuredRefs = !empty($data['references']);
$hasGeneralText = !empty(BilingualHelper::get($data['profile'], 'references_text', $lang));

if ($hasStructuredRefs):
?>
<div class="references-grid">
    <?php foreach ($data['references'] as $ref): ?>
        <div class="ref-glass-card glass-card" data-aos="zoom-in">
            <div class="ref-avatar-wrapper">
                <?php if (!empty($ref['photo'])): ?>
                    <?php 
                    $refPhoto = BASE_URL . '/' . ltrim(htmlspecialchars($ref['photo']), '/');
                    $photoExt = strtolower(pathinfo($refPhoto, PATHINFO_EXTENSION));
                    if (!in_array($photoExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                        $refPhoto .= '.jpg';
                    }
                    ?>
                    <img src="<?= $refPhoto ?>" alt="<?= htmlspecialchars(BilingualHelper::get($ref, 'name', $lang)) ?>" class="ref-avatar" onerror="this.parentElement.innerHTML='<div class=&quot;ref-avatar-placeholder&quot;><i class=&quot;fa-solid fa-user&quot;></i></div>'">
                <?php else: ?>
                    <div class="ref-avatar-placeholder">
                        <i class="fa-solid fa-user"></i>
                    </div>
                <?php endif; ?>
            </div>
            
            <h3 class="ref-name"><?= htmlspecialchars(BilingualHelper::get($ref, 'name', $lang)) ?></h3>
            
            <?php if (!empty(BilingualHelper::get($ref, 'description', $lang))): ?>
                <p class="ref-desc"><?= htmlspecialchars(BilingualHelper::get($ref, 'description', $lang)) ?></p>
            <?php endif; ?>

            <?php if (!empty($ref['phone']) || !empty($ref['email'])): ?>
                <div class="ref-actions">
                    <?php if (!empty($ref['phone'])): ?>
                        <a href="tel:<?= htmlspecialchars($ref['phone']) ?>" class="ref-btn phone" title="<?= $lang === 'en' ? 'Call' : chr(0xd8).chr(0xa7).chr(0xd8).chr(0xaa).chr(0xd8).chr(0xb5).chr(0xd8).chr(0xa7).chr(0xd9).chr(0x84) ?>">
                            <i class="fa-solid fa-phone"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($ref['email'])): ?>
                        <a href="mailto:<?= htmlspecialchars($ref['email']) ?>" class="ref-btn email" title="Email">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
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
        <?= $lang === 'en' ? 'No references available.' : chr(0xd9).chr(0x84).chr(0xd8).chr(0xa7).' '.chr(0xd8).chr(0xaa).chr(0xd8).chr(0xaa).chr(0xd9).chr(0x88).chr(0xd9).chr(0x81).chr(0xd8).chr(0xb1).' '.chr(0xd9).chr(0x85).chr(0xd8).chr(0xb1).chr(0xd8).chr(0xa7).chr(0xd8).chr(0xac).chr(0xd8).chr(0xb9).' '.chr(0xd8).chr(0xad).chr(0xd8).chr(0xa7).chr(0xd9).chr(0x84).chr(0xd9).chr(0x8a).chr(0xd8).chr(0xa7).'.' ?>
    </p>
<?php endif; ?>