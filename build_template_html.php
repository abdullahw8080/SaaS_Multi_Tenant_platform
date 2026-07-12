<?php
$baseDir = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\templates\\template-developer\\';

// 1. REWRITE INDEX.PHP
$indexContent = '<?php
use App\Services\BilingualHelper;
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'full_name\', $lang)) ?> | <?= htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'title\', $lang) ?: \'Sash\') ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <!-- Icons & Animations -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/templates/template-developer/style.css?v=<?= time() ?>">
</head>
<body>

    <!-- Animated Shapes Background -->
    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="nav-content">
            <a href="#" class="logo"><?= htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'full_name\', $lang)) ?></a>
            <div class="nav-links" id="navLinks">
                <a href="#objective"><?= $lang === \'en\' ? \'Home\' : \'الرئيسية\' ?></a>
                <?php
                    // Display links based on availability
                    $available = [];
                    foreach ($data[\'sections\'] as $s) {
                        if ($s[\'is_visible\']) $available[$s[\'type_key\']] = BilingualHelper::get($s, \'title\', $lang);
                    }
                ?>
                <?php if(isset($available[\'education\'])): ?><a href="#education"><?= htmlspecialchars($available[\'education\']) ?></a><?php endif; ?>
                <?php if(isset($available[\'certificates\'])): ?><a href="#certificates"><?= htmlspecialchars($available[\'certificates\']) ?></a><?php endif; ?>
                <?php if(isset($available[\'skills\'])): ?><a href="#skills"><?= htmlspecialchars($available[\'skills\']) ?></a><?php endif; ?>
                <?php if(isset($available[\'projects\'])): ?><a href="#projects"><?= htmlspecialchars($available[\'projects\']) ?></a><?php endif; ?>
                <?php if(isset($available[\'experiences\'])): ?><a href="#experiences"><?= htmlspecialchars($available[\'experiences\']) ?></a><?php endif; ?>
                <a href="#contact"><?= $lang === \'en\' ? \'Contact\' : \'تواصل\' ?></a>
            </div>
            
            <div style="display:flex; align-items:center; gap:10px;">
                <button id="themeToggleBtn" class="theme-btn" aria-label="Toggle Theme">
                    <i class="fa-solid fa-moon"></i>
                </button>
                <?php if ($data[\'site\'][\'is_bilingual\']): ?>
                    <a href="?lang=<?= BilingualHelper::opposite($lang) ?>" class="lang-btn">
                        <?= $lang === \'en\' ? \'AR\' : \'EN\' ?>
                    </a>
                <?php endif; ?>
                <div class="menu-btn" id="menuBtn">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Header / Hero -->
        <header class="header" id="objective">
            <div class="header-card" data-aos="fade-up">
                <div class="header-content hero-mobile-reverse">
                    <!-- Right Side: Text -->
                    <div class="hero-text-content">
                        <div class="hero-welcome-badge"><?= $lang === \'en\' ? \'Welcome\' : \'مرحباً\' ?></div>
                        <h2><?= $lang === \'en\' ? \'I am\' : \'أنا\' ?> <span class="highlight-text"><?= htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'full_name\', $lang)) ?></span></h2>

                        <div class="job-title-wrapper">
                            <span class="job-title"><?= htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'title\', $lang)) ?></span>
                        </div>

                        <div class="hero-socials">
                            <?php foreach ($data[\'social_links\'] as $sl): ?>
                                <a href="<?= htmlspecialchars($sl[\'url\']) ?>" target="_blank" title="<?= htmlspecialchars($sl[\'platform\']) ?>">
                                    <?php
                                        switch ($sl[\'platform\']) {
                                            case \'linkedin\': echo \'<i class="fab fa-linkedin-in"></i>\'; break;
                                            case \'github\': echo \'<i class="fab fa-github"></i>\'; break;
                                            case \'twitter\': echo \'<i class="fab fa-twitter"></i>\'; break;
                                            case \'whatsapp\': echo \'<i class="fab fa-whatsapp"></i>\'; break;
                                            case \'email\': echo \'<i class="fas fa-envelope"></i>\'; break;
                                            default: echo \'<i class="fa-solid fa-link"></i>\';
                                        }
                                    ?>
                                </a>
                            <?php endforeach; ?>
                        </div>

                        <p class="bio-text">
                            <?= nl2br(htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'bio\', $lang))) ?>
                        </p>

                        <div class="hero-buttons">
                            <a href="#contact" class="hero-btn btn-primary"><?= $lang === \'en\' ? \'Get In Touch\' : \'تواصل معي\' ?></a>
                            <?php if (!empty($data[\'profile\'][\'cv_url\'])): ?>
                                <a href="<?= BASE_URL . htmlspecialchars($data[\'profile\'][\'cv_url\']) ?>" download class="hero-btn btn-secondary">
                                    <i class="fas fa-file-download"></i> <?= $lang === \'en\' ? \'Download CV\' : \'تحميل السيرة الذاتية\' ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Left Side: Image with Glow -->
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
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- Explicit Rendering of Sections in precise order -->
        <?php 
            $secData = [];
            foreach ($data[\'sections\'] as $s) {
                $secData[$s[\'type_key\']] = $s;
            }
            
            function renderSection($type, $secData, $lang, $data, $tenant) {
                if(isset($secData[$type]) && $secData[$type][\'is_visible\']) {
                    $title = htmlspecialchars(BilingualHelper::get($secData[$type], \'title\', $lang));
                    $icons = [
                        \'education\' => \'fa-graduation-cap\',
                        \'certificates\' => \'fa-certificate\',
                        \'skills\' => \'fa-laptop-code\',
                        \'projects\' => \'fa-folder-open\',
                        \'experiences\' => \'fa-briefcase\',
                        \'languages\' => \'fa-language\'
                    ];
                    $icon = $icons[$type] ?? \'fa-star\';
                    
                    echo \'<section class="section" id="\'.$type.\'" data-aos="fade-up">\';
                    echo \'<div class="section-title"><i class="fas \'.$icon.\'"></i><h2>\'.$title.\'</h2></div>\';
                    include __DIR__ . "/sections/{$type}.php";
                    echo \'</section>\';
                }
            }
        ?>

        <!-- 1. Education -->
        <?php renderSection(\'education\', $secData, $lang, $data, $tenant); ?>

        <!-- 2. Certificates -->
        <?php renderSection(\'certificates\', $secData, $lang, $data, $tenant); ?>

        <!-- 3. Skills -->
        <?php renderSection(\'skills\', $secData, $lang, $data, $tenant); ?>

        <!-- 4. Projects -->
        <?php renderSection(\'projects\', $secData, $lang, $data, $tenant); ?>

        <!-- 5. Experiences -->
        <?php renderSection(\'experiences\', $secData, $lang, $data, $tenant); ?>

        <!-- 6. Personal Skills -->
        <?php if (!empty($data[\'personal_skills\'])): ?>
            <section class="section" id="personal-skills" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-user-check"></i>
                    <h2><?= $lang === \'en\' ? \'Personal Skills\' : \'المهارات الشخصية\' ?></h2>
                </div>
                <div class="skills-cards-grid">
                    <?php foreach ($data[\'personal_skills\'] as $pskill): ?>
                        <div class="skill-modern-card">
                            <h3 class="skill-title"><i class="fas fa-star"></i> <?= htmlspecialchars(BilingualHelper::get($pskill, \'name\', $lang)) ?></h3>
                            <?php if (!empty(BilingualHelper::get($pskill, \'description\', $lang))): ?>
                                <p class="skill-desc"><?= htmlspecialchars(BilingualHelper::get($pskill, \'description\', $lang)) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- 7. Languages -->
        <?php renderSection(\'languages\', $secData, $lang, $data, $tenant); ?>

        <!-- References -->
        <?php if (!empty($data[\'profile\'][\'references_text\'])): ?>
            <section class="section" id="references" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-users"></i>
                    <h2><?= $lang === \'en\' ? \'References\' : \'المراجع\' ?></h2>
                </div>
                <div class="reference-card">
                    <i class="fas fa-quote-right quote-icon"></i>
                    <p><?= nl2br(htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'references_text\', $lang))) ?></p>
                </div>
            </section>
        <?php endif; ?>

        <!-- Footer -->
        <footer class="footer" id="contact">
            <h2 class="footer-name"><?= htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'full_name\', $lang)) ?></h2>
            <div class="social-links">
                <?php foreach ($data[\'social_links\'] as $sl): ?>
                    <a href="<?= htmlspecialchars($sl[\'url\']) ?>" target="_blank"><i class="fab fa-<?= htmlspecialchars($sl[\'platform\']) ?>"></i></a>
                <?php endforeach; ?>
            </div>
            <p class="copyright">&copy; <?= date(\'Y\') ?> <?= $lang === \'en\' ? \'All rights reserved\' : \'جميع الحقوق محفوظة\' ?></p>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="<?= BASE_URL ?>/templates/template-developer/script.js?v=<?= time() ?>"></script>
</body>
</html>';
file_put_contents($baseDir . 'index.php', $indexContent);

// 2. REWRITE EDUCATION
$education = '<?php use App\Services\BilingualHelper; if (!empty($data[\'education\'])): ?>
    <div class="edu-grid">
        <?php foreach ($data[\'education\'] as $edu): ?>
            <div class="edu-card">
                <div class="edu-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="edu-details">
                    <h3 class="edu-degree"><?= htmlspecialchars(BilingualHelper::get($edu, \'degree\', $lang)) ?></h3>
                    <h4 class="edu-inst"><?= htmlspecialchars(BilingualHelper::get($edu, \'institution\', $lang)) ?></h4>
                </div>
                <?php if (!empty($edu[\'year\'])): ?>
                    <div class="edu-year"><i class="far fa-calendar"></i> <?= htmlspecialchars($edu[\'year\']) ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'sections\\education.php', $education);

// 3. REWRITE CERTIFICATES
$certificates = '<?php use App\Services\BilingualHelper; if (!empty($data[\'certificates\'])): ?>
    <div class="cert-modern-grid">
        <?php foreach ($data[\'certificates\'] as $cert): ?>
            <div class="cert-modern-card">
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
file_put_contents($baseDir . 'sections\\certificates.php', $certificates);

// 4. REWRITE SKILLS (Technical)
$skills = '<?php use App\Services\BilingualHelper; if (!empty($data[\'skills\'])): ?>
    <div class="skills-cards-grid">
        <?php foreach ($data[\'skills\'] as $skill): ?>
            <div class="skill-modern-card">
                <h3 class="skill-title"><i class="fas fa-laptop-code"></i> <?= htmlspecialchars(BilingualHelper::get($skill, \'name\', $lang)) ?></h3>
                <?php if (!empty(BilingualHelper::get($skill, \'description\', $lang))): ?>
                    <p class="skill-desc"><?= htmlspecialchars(BilingualHelper::get($skill, \'description\', $lang)) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'sections\\skills.php', $skills);

// 5. REWRITE PROJECTS (Hide links, show Image + Summary + Details Btn)
$projects = '<?php use App\Services\BilingualHelper; if (!empty($data[\'projects\'])): ?>
    <div class="projects-modern-grid">
        <?php foreach ($data[\'projects\'] as $proj): ?>
            <div class="project-modern-card">
                <?php if (!empty($proj[\'cover_image\'])): ?>
                    <div class="proj-img-wrapper">
                        <img src="<?= BASE_URL . htmlspecialchars($proj[\'cover_image\']) ?>" alt="Project Cover" loading="lazy">
                        <div class="proj-overlay">
                            <?php if (!empty($proj[\'slug\'])): ?>
                                <a href="<?= BASE_URL ?>/<?= htmlspecialchars($data[\'site\'][\'domain_prefix\']) ?>/projects/<?= htmlspecialchars($proj[\'slug\']) ?><?= $lang === \'en\' ? \'?lang=en\' : \'\' ?>" class="proj-view-btn">
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
file_put_contents($baseDir . 'sections\\projects.php', $projects);

// 6. REWRITE EXPERIENCES
$experiences = '<?php use App\Services\BilingualHelper; if (!empty($data[\'experiences\'])): ?>
    <div class="exp-modern-grid">
        <?php foreach ($data[\'experiences\'] as $exp): ?>
            <div class="exp-modern-card">
                <div class="exp-header">
                    <h3 class="exp-position"><?= htmlspecialchars(BilingualHelper::get($exp, \'position\', $lang)) ?></h3>
                    <?php if (!empty($exp[\'start_date\']) || !empty($exp[\'end_date\'])): ?>
                        <span class="exp-date"><?= htmlspecialchars($exp[\'start_date\'] ?? \'\') ?> <?= (!empty($exp[\'start_date\']) && !empty($exp[\'end_date\'])) ? \'-\' : \'\' ?> <?= htmlspecialchars($exp[\'end_date\'] ?? \'\') ?></span>
                    <?php endif; ?>
                </div>
                <h4 class="exp-company"><i class="fas fa-building"></i> <?= htmlspecialchars(BilingualHelper::get($exp, \'company\', $lang)) ?></h4>
                <?php if (!empty(BilingualHelper::get($exp, \'description\', $lang))): ?>
                    <p class="exp-desc"><?= nl2br(htmlspecialchars(BilingualHelper::get($exp, \'description\', $lang))) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'sections\\experiences.php', $experiences);

// 7. REWRITE LANGUAGES
$languages = '<?php use App\Services\BilingualHelper; if (!empty($data[\'languages\'])): ?>
    <div class="skills-cards-grid">
        <?php foreach ($data[\'languages\'] as $langObj): ?>
            <div class="skill-modern-card">
                <h3 class="skill-title"><i class="fas fa-language"></i> <?= htmlspecialchars(BilingualHelper::get($langObj, \'name\', $lang)) ?></h3>
                <p class="skill-desc" style="font-weight: bold; color: var(--accent-glow);"><?= htmlspecialchars(BilingualHelper::get($langObj, \'level\', $lang)) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'sections\\languages.php', $languages);

echo "All PHP template files successfully generated.";
?>
