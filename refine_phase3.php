<?php
$baseDir = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\';

// 1. REWRITE templates/template-developer/index.php (Helper for icons + using it)
$indexContent = '<?php
use App\Services\BilingualHelper;

// Helper function to map platforms to correct Font Awesome icons
if (!function_exists(\'getSocialIconClass\')) {
    function getSocialIconClass($platform) {
        $platform = strtolower(trim($platform));
        switch ($platform) {
            case \'linkedin\': return \'fab fa-linkedin-in\';
            case \'github\': return \'fab fa-github\';
            case \'twitter\': return \'fab fa-twitter\';
            case \'whatsapp\': return \'fab fa-whatsapp\';
            case \'facebook\': return \'fab fa-facebook-f\';
            case \'instagram\': return \'fab fa-instagram\';
            case \'youtube\': return \'fab fa-youtube\';
            case \'email\':
            case \'mail\': return \'fas fa-envelope\';
            case \'phone\': return \'fas fa-phone\';
            default: return \'fas fa-link\';
        }
    }
}
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
                                    <i class="<?= getSocialIconClass($sl[\'platform\']) ?>"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>

                        <p class="bio-text">
                            <?= nl2br(htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'bio\', $lang))) ?>
                        </p>

                        <div class="hero-buttons">
                            <a href="#contact" class="hero-btn btn-primary"><?= $lang === \'en\' ? \'Get In Touch\' : \'تواصل معي\' ?></a>
                            <?php if (!empty($data[\'profile\'][\'cv_url\'])): ?>
                                <a href="<?= BASE_URL ?>/<?= htmlspecialchars(ltrim($data[\'profile\'][\'cv_url\'], \'/\')) ?>" download class="hero-btn btn-secondary">
                                    <i class="fas fa-file-download"></i> <?= $lang === \'en\' ? \'Download CV\' : \'تحميل السيرة الذاتية\' ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Left Side: Image with Glowing Rotating Arcs -->
                    <?php if (!empty($data[\'profile\'][\'photo\'])): ?>
                        <div class="profile-image-container">
                            <div class="profile-image-glow-wrapper">
                                <div class="rotating-arc arc-1"></div>
                                <div class="rotating-arc arc-2"></div>
                                <?php 
                                    $photoUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($data[\'profile\'][\'photo\']), \'/\');
                                ?>
                                <img src="<?= $photoUrl ?>" alt="<?= htmlspecialchars(BilingualHelper::get($data[\'profile\'], \'full_name\', $lang)) ?>" class="glowing-image">
                                <div class="glow-effect"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <!-- 1. Education -->
        <?php if(isset($secData[\'education\']) && $secData[\'education\'][\'is_visible\']): ?>
            <section class="section" id="education" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-graduation-cap"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData[\'education\'], \'title\', $lang)) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/education.php"; ?>
            </section>
        <?php endif; ?>

        <!-- 2. Certificates -->
        <?php if(isset($secData[\'certificates\']) && $secData[\'certificates\'][\'is_visible\']): ?>
            <section class="section" id="certificates" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-certificate"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData[\'certificates\'], \'title\', $lang)) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/certificates.php"; ?>
            </section>
        <?php endif; ?>

        <!-- 3. Skills -->
        <?php if(isset($secData[\'skills\']) && $secData[\'skills\'][\'is_visible\']): ?>
            <section class="section" id="skills" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-laptop-code"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData[\'skills\'], \'title\', $lang)) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/skills.php"; ?>
            </section>
        <?php endif; ?>

        <!-- 4. Projects -->
        <?php if(isset($secData[\'projects\']) && $secData[\'projects\'][\'is_visible\']): ?>
            <section class="section" id="projects" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-folder-open"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData[\'projects\'], \'title\', $lang)) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/projects.php"; ?>
            </section>
        <?php endif; ?>

        <!-- 5. Experiences -->
        <?php if(isset($secData[\'experiences\']) && $secData[\'experiences\'][\'is_visible\']): ?>
            <section class="section" id="experiences" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-briefcase"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData[\'experiences\'], \'title\', $lang)) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/experiences.php"; ?>
            </section>
        <?php endif; ?>

        <!-- 6. Personal Skills -->
        <?php if (!empty($data[\'personal_skills\'])): ?>
            <section class="section" id="personal-skills" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-user-check"></i>
                    <h2><?= $lang === \'en\' ? \'Personal Skills\' : \'المهارات الشخصية\' ?></h2>
                </div>
                <div class="skills-cards-grid">
                    <?php foreach ($data[\'personal_skills\'] as $pskill): ?>
                        <div class="skill-modern-card glass-card">
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
        <?php if(isset($secData[\'languages\']) && $secData[\'languages\'][\'is_visible\']): ?>
            <section class="section" id="languages" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-language"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData[\'languages\'], \'title\', $lang)) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/languages.php"; ?>
            </section>
        <?php endif; ?>

        <!-- References -->
        <?php if (!empty($data[\'profile\'][\'references_text\'])): ?>
            <section class="section" id="references" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-users"></i>
                    <h2><?= $lang === \'en\' ? \'References\' : \'المراجع\' ?></h2>
                </div>
                <div class="reference-card glass-card">
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
                    <a href="<?= htmlspecialchars($sl[\'url\']) ?>" target="_blank"><i class="<?= getSocialIconClass($sl[\'platform\']) ?>"></i></a>
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
file_put_contents($baseDir . 'templates\\template-developer\\index.php', $indexContent);


// 2. REWRITE EDUCATION SECTION (glass-card)
$education = '<?php use App\Services\BilingualHelper; if (!empty($data[\'education\'])): ?>
    <div class="edu-grid">
        <?php foreach ($data[\'education\'] as $edu): ?>
            <div class="edu-card glass-card">
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
file_put_contents($baseDir . 'templates\\template-developer\\sections\\education.php', $education);


// 3. REWRITE CERTIFICATES SECTION (smaller, conditional buttons, glass-card)
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
                        <a href="<?= BASE_URL ?>/<?= ltrim(htmlspecialchars($cert[\'file\']), \'/\') ?>" target="_blank" class="btn-cert primary">
                            <i class="fas fa-image"></i> <?= $lang === \'en\' ? \'View\' : \'عرض\' ?>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($cert[\'link\'])): ?>
                        <a href="<?= htmlspecialchars($cert[\'link\']) ?>" target="_blank" class="btn-cert secondary">
                            <i class="fas fa-link"></i> <?= $lang === \'en\' ? \'Link\' : \'رابط\' ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'templates\\template-developer\\sections\\certificates.php', $certificates);


// 4. REWRITE PROJECTS SECTION (correct image URL rendering)
$projects = '<?php use App\Services\BilingualHelper; if (!empty($data[\'projects\'])): ?>
    <div class="projects-modern-grid">
        <?php foreach ($data[\'projects\'] as $proj): ?>
            <div class="project-modern-card glass-card">
                <?php if (!empty($proj[\'cover_image\'])): ?>
                    <div class="proj-img-wrapper">
                        <?php 
                            $coverUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($proj[\'cover_image\']), \'/\');
                        ?>
                        <img src="<?= $coverUrl ?>" alt="Project Cover" loading="lazy">
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


// 5. REWRITE templates/template-developer/sections/project_detail.php (fully secure, styled, glassy page)
$projectDetail = '<?php
use App\Services\BilingualHelper;
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(BilingualHelper::get($project, \'title\', $lang)) ?> - <?= htmlspecialchars(BilingualHelper::get($site, \'full_name\', $lang)) ?></title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/templates/template-developer/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .detail-wrapper {
            max-width: 900px;
            margin: 100px auto 60px auto;
            padding: 0 20px;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 25px;
            transition: 0.3s;
            border: 1px solid var(--border-color);
            padding: 8px 16px;
            border-radius: 8px;
            background: rgba(255,255,255,0.02);
        }
        .back-btn:hover {
            color: var(--accent-glow);
            border-color: var(--accent-glow);
        }
        .detail-header {
            margin-bottom: 30px;
        }
        .project-type-badge {
            background: rgba(139, 92, 246, 0.15);
            color: var(--accent-glow);
            border: 1px solid rgba(139, 92, 246, 0.3);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 15px;
        }
        .detail-title {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 12px;
            color: #fff;
        }
        .project-meta-links {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .meta-btn {
            padding: 10px 20px;
            font-size: 0.9rem;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
            transition: 0.3s;
        }
        .meta-btn.primary {
            background: linear-gradient(90deg, var(--accent-glow), var(--accent-glow-secondary));
            color: #fff;
        }
        .meta-btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 92, 246, 0.3);
        }
        .meta-btn.secondary {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }
        .meta-btn.secondary:hover {
            border-color: #fff;
        }
        .cover-image-container {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            margin-bottom: 30px;
            max-height: 400px;
        }
        .cover-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .detail-body {
            font-size: 1rem;
            line-height: 1.8;
            color: var(--text-secondary);
            margin-bottom: 40px;
        }
        .gallery-section h2, .docs-section h2 {
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: #fff;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 45px;
        }
        .gallery-card {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: 0.3s;
            background: var(--bg-secondary);
        }
        .gallery-card:hover {
            transform: translateY(-3px);
            border-color: var(--accent-glow);
        }
        .gallery-card img {
            width: 100%;
            height: 130px;
            object-fit: cover;
            display: block;
        }
        .gallery-caption {
            padding: 8px;
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-align: center;
        }
        .doc-item {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            padding: 14px 18px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            transition: 0.3s;
        }
        .doc-item:hover {
            border-color: var(--accent-glow);
        }
        .doc-name {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: var(--text-primary);
        }
    </style>
</head>
<body>

    <!-- Header Navbar -->
    <header class="navbar">
        <div class="nav-content">
            <a href="<?= BASE_URL ?>/<?= htmlspecialchars($site[\'slug\']) ?>" class="logo"><?= htmlspecialchars(BilingualHelper::get($site, \'full_name\', $lang)) ?></a>
            <div class="nav-links">
                <a href="<?= BASE_URL ?>/<?= htmlspecialchars($site[\'slug\']) ?>" class="lang-btn">
                    <?= $lang === \'en\' ? \'Back\' : \'العودة للموقع\' ?>
                </a>
            </div>
        </div>
    </header>

    <div class="detail-wrapper">
        <!-- Return Link -->
        <a href="<?= BASE_URL ?>/<?= htmlspecialchars($site[\'slug\']) ?>" class="back-btn">
            <?php if ($lang === \'en\'): ?>
                <i class="fa-solid fa-arrow-left"></i> Back to Portfolio
            <?php else: ?>
                <i class="fa-solid fa-arrow-right"></i> العودة للموقع الشخصي
            <?php endif; ?>
        </a>

        <!-- Header -->
        <div class="detail-header glass-card">
            <span class="project-type-badge">
                <?php
                    $type = $project[\'type\'];
                    if ($lang === \'en\') {
                        echo $type === \'research\' ? \'Research\' : ($type === \'case_study\' ? \'Case Study\' : \'Project\');
                    } else {
                        echo $type === \'research\' ? \'بحث علمي\' : ($type === \'case_study\' ? \'دراسة حالة\' : \'مشروع\');
                    }
                ?>
            </span>
            <h1 class="detail-title"><?= htmlspecialchars(BilingualHelper::get($project, \'title\', $lang)) ?></h1>
            <p style="color: var(--text-secondary); font-size: 1rem; line-height: 1.6; margin-bottom: 20px;">
                <?= htmlspecialchars(BilingualHelper::get($project, \'summary\', $lang)) ?>
            </p>

            <div class="project-meta-links">
                <?php if (!empty($project[\'link\'])): ?>
                    <a href="<?= htmlspecialchars($project[\'link\']) ?>" target="_blank" class="meta-btn primary">
                        <i class="fa-solid fa-external-link"></i>
                        <?= $lang === \'en\' ? \'Live Demo\' : \'معاينة مباشرة\' ?>
                    </a>
                <?php endif; ?>
                <?php if (!empty($project[\'github_link\'])): ?>
                    <a href="<?= htmlspecialchars($project[\'github_link\']) ?>" target="_blank" class="meta-btn secondary">
                        <i class="fa-brands fa-github"></i>
                        <?= $lang === \'en\' ? \'GitHub Repository\' : \'مستودع الكود\' ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Cover Image -->
        <?php if (!empty($project[\'cover_image\'])): ?>
            <div class="cover-image-container">
                <?php 
                    $coverUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($project[\'cover_image\']), \'/\');
                ?>
                <img src="<?= $coverUrl ?>" alt="Cover Image">
            </div>
        <?php endif; ?>

        <!-- Detailed Body -->
        <div class="detail-body glass-card">
            <?= nl2br(htmlspecialchars(BilingualHelper::get($project, \'body\', $lang))) ?>
        </div>

        <!-- Media Gallery (Images) -->
        <?php
            $images = array_filter($project[\'media\'], fn($m) => $m[\'file_type\'] === \'image\');
            $pdfs = array_filter($project[\'media\'], fn($m) => $m[\'file_type\'] === \'pdf\');
        ?>
        <?php if (!empty($images)): ?>
            <div class="gallery-section">
                <h2><?= $lang === \'en\' ? \'Media Gallery\' : \'معرض الصور\' ?></h2>
                <div class="gallery-grid">
                    <?php foreach ($images as $img): ?>
                        <?php 
                            $imgUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($img[\'file_path\']), \'/\');
                        ?>
                        <div class="gallery-card" onclick="openLightbox(\'<?= $imgUrl ?>\')">
                            <img src="<?= $imgUrl ?>" alt="Gallery Media">
                            <?php if (!empty(BilingualHelper::get($img, \'caption\', $lang))): ?>
                                <div class="gallery-caption">
                                    <?= htmlspecialchars(BilingualHelper::get($img, \'caption\', $lang)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- PDF Documents -->
        <?php if (!empty($pdfs)): ?>
            <div class="docs-section" style="margin-top: 40px;">
                <h2><?= $lang === \'en\' ? \'Attached Documents (PDF)\' : \'الملفات المرفقة (PDF)\' ?></h2>
                <div>
                    <?php foreach ($pdfs as $pdf): ?>
                        <?php 
                            $pdfUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($pdf[\'file_path\']), \'/\');
                        ?>
                        <div class="doc-item">
                            <div class="doc-name">
                                <i class="fa-solid fa-file-pdf" style="color:#ef4444; font-size:1.4rem;"></i>
                                <span><?= htmlspecialchars(BilingualHelper::get($pdf, \'caption\', $lang) ?: ($lang === \'en\' ? \'Document Attachment\' : \'ملف وثيقة مرفق\')) ?></span>
                            </div>
                            <a href="<?= $pdfUrl ?>" target="_blank" class="meta-btn secondary" style="padding: 6px 16px; font-size:0.8rem;">
                                <i class="fa-solid fa-download"></i> <?= $lang === \'en\' ? \'Download\' : \'تحميل\' ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Lightbox Modal -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <img id="lightbox-img" src="" alt="Lightbox View" onclick="event.stopPropagation()">
    </div>

    <script>
        function openLightbox(src) {
            const lightbox = document.getElementById(\'lightbox\');
            const img = document.getElementById(\'lightbox-img\');
            img.src = src;
            lightbox.style.display = \'flex\';
        }
        function closeLightbox() {
            document.getElementById(\'lightbox\').style.display = \'none\';
        }
        document.addEventListener(\'keydown\', function(event) {
            if (event.key === "Escape") {
                closeLightbox();
            }
        });
    </script>
</body>
</html>';
file_put_contents($baseDir . 'templates\\template-developer\\sections\\project_detail.php', $projectDetail);

echo "Redesign phase 3 complete.";
?>
