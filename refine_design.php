<?php
$baseDir = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\';

// 1. REWRITE INDEX.PHP (updating Hero Profile Image to circular & adding rotating arcs)
$indexContent = file_get_contents($baseDir . 'templates\\template-developer\\index.php');

// Replace Image Section
$oldImageSection = '<!-- Left Side: Image with Glow -->
                    <?php if (!empty($data[\'profile\'][\'photo\'])): ?>
                        <div class="profile-image-container">
                            <div class="profile-image-glow-wrapper">
                                <?php 
                                    $photoUrl = BASE_URL . htmlspecialchars($data[\'profile\'][\'photo\']);
                                    $photoExt = strtolower(pathinfo($photoUrl, PATHINFO_EXTENSION));
                                    if (!in_array($photoExt, [\'jpg\', \'jpeg\', \'png\', \'webp\', \'gif\'])) {
                                        $photoUrl .= \'.jpg\';
                                    }
                                ?>
                                <img src="<?= $photoUrl ?>" alt="<?= htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'full_name\', $lang)) ?>" class="glowing-image">
                                <div class="glow-effect"></div>
                            </div>
                        </div>
                    <?php endif; ?>';

$newImageSection = '<!-- Left Side: Image with Glowing Rotating Arcs -->
                    <?php if (!empty($data[\'profile\'][\'photo\'])): ?>
                        <div class="profile-image-container">
                            <div class="profile-image-glow-wrapper">
                                <div class="rotating-arc arc-1"></div>
                                <div class="rotating-arc arc-2"></div>
                                <?php 
                                    $photoUrl = BASE_URL . htmlspecialchars($data[\'profile\'][\'photo\']);
                                    $photoExt = strtolower(pathinfo($photoUrl, PATHINFO_EXTENSION));
                                    if (!in_array($photoExt, [\'jpg\', \'jpeg\', \'png\', \'webp\', \'gif\'])) {
                                        $photoUrl .= \'.jpg\';
                                    }
                                ?>
                                <img src="<?= $photoUrl ?>" alt="<?= htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'full_name\', $lang)) ?>" class="glowing-image">
                                <div class="glow-effect"></div>
                            </div>
                        </div>
                    <?php endif; ?>';

$indexContent = str_replace($oldImageSection, $newImageSection, $indexContent);

// Update References Card class in index.php
$indexContent = str_replace('<div class="reference-card">', '<div class="reference-card glass-card">', $indexContent);

// Update Personal Skills cards to use glass-card class
$indexContent = str_replace('<div class="skill-modern-card">', '<div class="skill-modern-card glass-card">', $indexContent);

file_put_contents($baseDir . 'templates\\template-developer\\index.php', $indexContent);


// 2. REWRITE CERTIFICATES SECTION
$certificates = '<?php use App\Services\BilingualHelper; if (!empty($data[\'certificates\'])): ?>
    <div class="cert-modern-grid">
        <?php foreach ($data[\'certificates\'] as $cert): ?>
            <div class="cert-modern-card glass-card">
                <div class="cert-content">
                    <h3 class="cert-title"><?= htmlspecialchars(BilingualHelper::get($cert, \'title\', $lang)) ?></h3>
                    <p class="cert-issuer"><?= htmlspecialchars(BilingualHelper::get($cert, \'issuer\', $lang)) ?></p>
                    <?php if (!empty($cert[\'year\'])): ?>
                        <p class="cert-year"><?= htmlspecialchars($cert[\'year\']) ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="cert-buttons">
                    <?php if (!empty($cert[\'file\'])): ?>
                        <a href="<?= BASE_URL . htmlspecialchars($cert[\'file\']) ?>" target="_blank" class="btn-cert primary">
                            <i class="fas fa-image"></i> <?= $lang === \'en\' ? \'Certificate Image\' : \'صورة الشهادة\' ?>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($cert[\'link\'])): ?>
                        <a href="<?= htmlspecialchars($cert[\'link\']) ?>" target="_blank" class="btn-cert secondary">
                            <i class="fas fa-link"></i> <?= $lang === \'en\' ? \'Verify Link\' : \'رابط التحقق\' ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'templates\\template-developer\\sections\\certificates.php', $certificates);


// 3. REWRITE PROJECTS SECTION (smaller, glass-card)
$projects = '<?php use App\Services\BilingualHelper; if (!empty($data[\'projects\'])): ?>
    <div class="projects-modern-grid">
        <?php foreach ($data[\'projects\'] as $proj): ?>
            <div class="project-modern-card glass-card">
                <?php if (!empty($proj[\'cover_image\'])): ?>
                    <div class="proj-img-wrapper">
                        <img src="<?= BASE_URL . htmlspecialchars($proj[\'cover_image\']) ?>" alt="Project Cover" loading="lazy">
                        <div class="proj-overlay">
                            <?php if (!empty($proj[\'slug\'])): ?>
                                <a href="<?= BASE_URL ?>/<?= htmlspecialchars($data[\'site\'][\'slug\']) ?>/projects/<?= htmlspecialchars($proj[\'slug\']) ?><?= $lang === \'en\' ? \'?lang=en\' : \'\' ?>" class="proj-view-btn">
                                    <?= $lang === \'en\' ? \'View Details\' : \'عرض التفاصيل\' ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="proj-content">
                    <h3 class="proj-title"><?= htmlspecialchars(BilingualHelper::get($proj, \'title\', $lang)) ?></h3>
                    <?php if (!empty(BilingualHelper::get($proj, \'summary\', $lang))): ?>
                        <p class="proj-summary"><?= htmlspecialchars(BilingualHelper::get($proj, \'summary\', $lang)) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'templates\\template-developer\\sections\\projects.php', $projects);


// 4. REWRITE SKILLS SECTION
$skills = '<?php use App\Services\BilingualHelper; if (!empty($data[\'skills\'])): ?>
    <div class="skills-cards-grid">
        <?php foreach ($data[\'skills\'] as $skill): ?>
            <div class="skill-modern-card glass-card">
                <h3 class="skill-title"><i class="fas fa-laptop-code"></i> <?= htmlspecialchars(BilingualHelper::get($skill, \'name\', $lang)) ?></h3>
                <?php if (!empty(BilingualHelper::get($skill, \'description\', $lang))): ?>
                    <p class="skill-desc"><?= htmlspecialchars(BilingualHelper::get($skill, \'description\', $lang)) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'templates\\template-developer\\sections\\skills.php', $skills);


// 5. REWRITE LANGUAGES SECTION (with progress bar)
$languages = '<?php use App\Services\BilingualHelper; if (!empty($data[\'languages\'])): ?>
    <div class="languages-grid">
        <?php foreach ($data[\'languages\'] as $langObj): ?>
            <div class="lang-modern-card glass-card">
                <div class="lang-info-header">
                    <h3 class="lang-title"><i class="fas fa-language"></i> <?= htmlspecialchars(BilingualHelper::get($langObj, \'name\', $lang)) ?></h3>
                    <span class="lang-level"><?= htmlspecialchars(BilingualHelper::get($langObj, \'level\', $lang)) ?></span>
                </div>
                <div class="lang-bar-wrapper">
                    <?php 
                        $lvl = strtolower(BilingualHelper::get($langObj, \'level\', $lang));
                        $pct = 80;
                        if (str_contains($lvl, \'native\') || str_contains($lvl, \'أم\') || str_contains($lvl, \'ممتاز\') || str_contains($lvl, \'excellent\')) $pct = 100;
                        elseif (str_contains($lvl, \'fluent\') || str_contains($lvl, \'طليق\') || str_contains($lvl, \'very good\')) $pct = 90;
                        elseif (str_contains($lvl, \'good\') || str_contains($lvl, \'جيد\')) $pct = 75;
                        elseif (str_contains($lvl, \'intermediate\') || str_contains($lvl, \'متوسط\')) $pct = 60;
                        elseif (str_contains($lvl, \'basic\') || str_contains($lvl, \'مبتدئ\')) $pct = 40;
                    ?>
                    <div class="lang-bar-fill" style="width: <?= $pct ?>%;"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'templates\\template-developer\\sections\\languages.php', $languages);


// 6. UPDATE STYLE.CSS FOR GLASSMORPHISM, SCALING, ROTATING ARCS AND LANG BAR
$cssContent = file_get_contents($baseDir . 'templates\\template-developer\\style.css');

// We will replace parts or append the refined css rules.
$refinedCss = '
/* --- Refined CSS OVERRIDES (Smaller sizes, Glassmorphism, Arcs) --- */

/* Glassmorphism utility class */
.glass-card {
    background: rgba(255, 255, 255, 0.02) !important;
    backdrop-filter: blur(15px) !important;
    -webkit-backdrop-filter: blur(15px) !important;
    border: 1px solid rgba(255, 255, 255, 0.06) !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
    border-radius: 14px !important;
    padding: 20px !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
}
.glass-card:hover {
    background: rgba(139, 92, 246, 0.04) !important;
    border-color: rgba(139, 92, 246, 0.25) !important;
    transform: translateY(-3px) !important;
    box-shadow: 0 15px 30px rgba(139, 92, 246, 0.1) !important;
}

/* Compact layout sizes */
.navbar {
    background: rgba(15, 23, 42, 0.9);
}
.nav-content {
    padding: 10px 20px;
}
.logo {
    font-size: 1.25rem;
}
.nav-links a {
    margin: 0 10px;
    font-size: 0.9rem;
}
.header {
    padding-top: 100px;
    padding-bottom: 40px;
    min-height: 80vh;
}
.header-card {
    padding: 35px;
    border-radius: 20px;
}
.hero-text-content h2 {
    font-size: 2.2rem;
}
.job-title {
    font-size: 1.1rem;
    margin-bottom: 15px;
}
.bio-text {
    font-size: 0.95rem;
    margin-bottom: 20px;
}
.section {
    padding: 50px 0 25px;
}
.section-title {
    margin-bottom: 25px;
}
.section-title h2 {
    font-size: 1.5rem;
}
.section-title i {
    font-size: 1.5rem;
}

/* Circular glowing profile photo with rotating arcs */
.profile-image-glow-wrapper {
    position: relative;
    width: 250px;
    height: 250px;
    border-radius: 50%;
}
.glowing-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid var(--bg-secondary);
}
.glow-effect {
    position: absolute;
    inset: -5px;
    background: linear-gradient(45deg, var(--accent-glow), var(--accent-glow-secondary));
    border-radius: 50%;
    z-index: -1;
    filter: blur(15px);
    opacity: 0.5;
}

/* Rotating Arcs around image */
.rotating-arc {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}
.arc-1 {
    inset: -12px;
    border: 2px dashed rgba(139, 92, 246, 0.4);
    animation: rotateClockwise 12s linear infinite;
}
.arc-2 {
    inset: -22px;
    border: 2px dotted rgba(59, 130, 246, 0.3);
    animation: rotateCounter 18s linear infinite;
}

@keyframes rotateClockwise {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
@keyframes rotateCounter {
    0% { transform: rotate(360deg); }
    100% { transform: rotate(0deg); }
}

/* Certificates */
.cert-modern-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}
.cert-title {
    font-size: 1.15rem;
}
.cert-issuer {
    font-size: 0.9rem;
}

/* Projects grid size adjustments */
.projects-modern-grid {
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
}
.proj-img-wrapper {
    height: 170px;
    border-radius: 10px;
    overflow: hidden;
}
.proj-content {
    padding: 15px 0 0 0;
}
.proj-title {
    font-size: 1.15rem;
}
.proj-summary {
    font-size: 0.9rem;
}

/* Languages Grid & Progress Bar */
.languages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
}
.lang-modern-card {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.lang-info-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.lang-title {
    font-size: 1.05rem;
    font-weight: 700;
}
.lang-level {
    font-size: 0.85rem;
    font-weight: bold;
    color: var(--accent-glow);
}
.lang-bar-wrapper {
    width: 100%;
    height: 6px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    overflow: hidden;
}
.lang-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--accent-glow), var(--accent-glow-secondary));
    border-radius: 10px;
}

/* Reference Card */
.reference-card {
    text-align: center;
    position: relative;
}
.quote-icon {
    font-size: 1.5rem;
    color: var(--accent-glow);
    margin-bottom: 10px;
}

@media (max-width: 992px) {
    .profile-image-container {
        flex: 0 0 250px;
    }
}
';

$cssContent .= $refinedCss;
file_put_contents($baseDir . 'templates\\template-developer\\style.css', $cssContent);

echo "Redesign modifications successfully generated.";
?>
