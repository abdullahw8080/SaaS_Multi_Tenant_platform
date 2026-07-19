<?php use App\Services\BilingualHelper; if (!empty($data['certificates'])): ?>
    <div class="cert-modern-grid">
        <?php foreach ($data['certificates'] as $cert): ?>
            <div class="cert-modern-card glass-card">
                <div class="cert-content">
                    <h3 class="cert-title"><?= htmlspecialchars(BilingualHelper::get($cert, 'title', $lang)) ?></h3>
                    <p class="cert-issuer"><?= htmlspecialchars(BilingualHelper::get($cert, 'issuer', $lang)) ?></p>
                    <?php if (!empty($cert['year'])): ?>
                        <p class="cert-year"><?= htmlspecialchars($cert['year']) ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="cert-buttons">
                    <?php
                    // Support both 'file' and 'file_url' keys for backwards compatibility
                    $certFile = $cert['file_url'] ?? $cert['file'] ?? '';
                    ?>
                    <?php if (!empty($certFile)): ?>
                        <a href="<?= BASE_URL ?>/<?= ltrim(htmlspecialchars($certFile), '/') ?>" target="_blank" class="btn-cert primary">
                            <i class="fas fa-image"></i> <?= $lang === 'en' ? 'View' : 'عرض' ?>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($cert['link'])): ?>
                        <a href="<?= htmlspecialchars($cert['link']) ?>" target="_blank" class="btn-cert secondary">
                            <i class="fas fa-link"></i> <?= $lang === 'en' ? 'Link' : 'رابط' ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>