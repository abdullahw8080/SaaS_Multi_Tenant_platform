<?php use App\Services\BilingualHelper; if (!empty($data['languages'])): ?>
    <div class="languages-grid">
        <?php foreach ($data['languages'] as $langObj): ?>
            <div class="lang-modern-card glass-card">
                <div class="lang-info-header">
                    <h3 class="lang-title"><i class="fas fa-language"></i> <?= htmlspecialchars(BilingualHelper::get($langObj, 'name', $lang)) ?></h3>
                    <span class="lang-level"><?= htmlspecialchars(BilingualHelper::get($langObj, 'level', $lang)) ?></span>
                </div>
                <div class="lang-bar-wrapper">
                    <?php 
                        $lvl = strtolower(BilingualHelper::get($langObj, 'level', $lang));
                        $pct = 80;
                        if (str_contains($lvl, 'native') || str_contains($lvl, 'أم') || str_contains($lvl, 'ممتاز') || str_contains($lvl, 'excellent')) $pct = 100;
                        elseif (str_contains($lvl, 'fluent') || str_contains($lvl, 'طليق') || str_contains($lvl, 'very good')) $pct = 90;
                        elseif (str_contains($lvl, 'good') || str_contains($lvl, 'جيد')) $pct = 75;
                        elseif (str_contains($lvl, 'intermediate') || str_contains($lvl, 'متوسط')) $pct = 60;
                        elseif (str_contains($lvl, 'basic') || str_contains($lvl, 'مبتدئ')) $pct = 40;
                    ?>
                    <div class="lang-bar-fill" style="width: <?= $pct ?>%;"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>