<?php
// ══════════════════════════════════════════════════════════
// [PROFESSION ADAPTER] — يقرأ إعدادات المهنة ويُعدّ المتغيرات
// ══════════════════════════════════════════════════════════
if (!isset($data) || empty($data)) { http_response_code(404); exit; }

$lang       = $_GET['lang'] ?? $data['site']['default_lang'] ?? 'ar';
$dir        = ($lang === 'ar') ? 'rtl' : 'ltr';
$profession = $data['site']['profession_type'] ?? 'developer';

require_once __DIR__ . '/../../app/Config/ProfessionConfig.php';
$labels       = ProfessionConfig::getLabels($profession, $lang);
$cssVars      = ProfessionConfig::getCssVariables($profession);
$showLevelBar = ProfessionConfig::showLevelBar($profession);
$heroIcon     = ProfessionConfig::getHeroIcon($profession);
$sectionIcons = ProfessionConfig::getSectionIcons($profession);
$extraCss     = ProfessionConfig::getExtraCss($profession);
// ══════════════════════════════════════════════════════════
// [/PROFESSION ADAPTER]
// ══════════════════════════════════════════════════════════

use App\Services\BilingualHelper;

// Helper function to map platforms to correct Font Awesome icons
if (!function_exists('getSocialIconClass')) {
    function getSocialIconClass($platform) {
        $platform = strtolower(trim($platform));
        switch ($platform) {
            case 'linkedin': return 'fab fa-linkedin-in';
            case 'github': return 'fab fa-github';
            case 'twitter': return 'fab fa-twitter';
            case 'whatsapp': return 'fab fa-whatsapp';
            case 'facebook': return 'fab fa-facebook-f';
            case 'instagram': return 'fab fa-instagram';
            case 'youtube': return 'fab fa-youtube';
            case 'email':
            case 'mail': return 'fas fa-envelope';
            case 'phone': return 'fas fa-phone';
            default: return 'fas fa-link';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang)) ?> | <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'title', $lang) ?: 'Sash') ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <!-- Icons & Animations -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/templates/template-developer/style.css?v=<?= time() ?>">
    <!-- [PROFESSION COLORS] — CSS Variable Override per Profession -->
    <style>:root { <?= $cssVars ?> } <?= $extraCss ?></style>
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
            <a href="#" class="logo"><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang)) ?></a>
            <div class="nav-links" id="navLinks">
                <a href="#objective"><?= $lang === 'en' ? 'Home' : 'الرئيسية' ?></a>
                <?php
                    $available = [];
                    foreach ($data['sections'] as $s) {
                        if ($s['is_visible']) {
                            $available[$s['type_key']] = BilingualHelper::get($s, 'title', $lang) ?: ($labels[$s['type_key']] ?? '');
                        }
                    }
                ?>
                <?php if(isset($available['education'])): ?><a href="#education"><?= htmlspecialchars($available['education']) ?></a><?php endif; ?>
                <?php if(isset($available['certificates'])): ?><a href="#certificates"><?= htmlspecialchars($available['certificates']) ?></a><?php endif; ?>
                <?php if(isset($available['skills'])): ?><a href="#skills"><?= htmlspecialchars($available['skills']) ?></a><?php endif; ?>
                <?php if(isset($available['projects'])): ?><a href="#projects"><?= htmlspecialchars($available['projects']) ?></a><?php endif; ?>
                <?php if(isset($available['experiences'])): ?><a href="#experiences"><?= htmlspecialchars($available['experiences']) ?></a><?php endif; ?>
                <?php if(isset($available['references'])): ?><a href="#references"><?= htmlspecialchars($available['references']) ?></a><?php endif; ?>
                <a href="#contact"><?= $lang === 'en' ? 'Contact' : 'تواصل' ?></a>
            </div>
            
            <div style="display:flex; align-items:center; gap:10px;">
                <button id="themeToggleBtn" class="theme-btn" aria-label="Toggle Theme">
                    <i class="fa-solid fa-moon"></i>
                </button>
                <?php if ($data['site']['is_bilingual']): ?>
                    <a href="?lang=<?= BilingualHelper::opposite($lang) ?>" class="lang-btn">
                        <?= $lang === 'en' ? 'AR' : 'EN' ?>
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
                        <div class="hero-welcome-badge"><?= htmlspecialchars($labels['hero_badge']) ?></div>
                        <h2><?= $lang === 'en' ? 'I am' : 'أنا' ?> <span class="highlight-text"><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang)) ?></span></h2>

                        <div class="job-title-wrapper">
                            <span class="job-title"><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'title', $lang)) ?></span>
                        </div>

                        <div class="hero-socials">
                            <?php foreach ($data['social_links'] as $sl): ?>
                                <a href="<?= htmlspecialchars($sl['url']) ?>" target="_blank" title="<?= htmlspecialchars($sl['platform']) ?>">
                                    <i class="<?= getSocialIconClass($sl['platform']) ?>"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>

                        <p class="bio-text">
                            <?= nl2br(htmlspecialchars(BilingualHelper::get($data['profile'], 'bio', $lang))) ?>
                        </p>

                        <div class="hero-buttons">
                             <?php $doctorBtnStyle = ($profession === 'doctor') ? 'color: #ffffff !important; border: 2px solid #ffffff !important; background: transparent !important; box-shadow: none !important;' : ''; ?>
                             <a href="#contact" class="hero-btn btn-primary" style="<?= $doctorBtnStyle ?>"><?= htmlspecialchars($labels['cta_primary']) ?></a>
                              <?php if (!empty($data['profile']['cv_url'])): ?>
                                  <?php 
                                      $cvUrl = BASE_URL . '/' . ltrim($data['profile']['cv_url'], '/');
                                      $isPdf = (strtolower(pathinfo($cvUrl, PATHINFO_EXTENSION)) === 'pdf');
                                  ?>
                                  <a href="<?= htmlspecialchars($cvUrl, ENT_QUOTES, 'UTF-8') ?>" <?= $isPdf ? 'target="_blank"' : 'download' ?> class="hero-btn btn-secondary" style="<?= $doctorBtnStyle ?>">
                                      <i class="fas <?= $isPdf ? 'fa-file-pdf' : 'fa-file-download' ?>"></i> <?= htmlspecialchars($isPdf ? ($lang === 'ar' ? 'عرض السيرة الذاتية' : 'View CV') : $labels['cta_cv']) ?>
                                  </a>
                              <?php endif; ?>
                        </div>
                    </div>

                    <!-- Left Side: Image with Glowing Rotating Arcs -->
                    <?php if (!empty($data['profile']['photo'])): ?>
                        <div class="profile-image-container">
                            <div class="profile-image-glow-wrapper">
                                <div class="rotating-arc arc-1"></div>
                                <div class="rotating-arc arc-2"></div>
                                <?php 
                                    $photoUrl = BASE_URL . '/' . ltrim(htmlspecialchars($data['profile']['photo']), '/');
                                    $photoExt = strtolower(pathinfo($photoUrl, PATHINFO_EXTENSION));
                                    if (!in_array($photoExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                                        $photoUrl .= '.jpg';
                                    }
                                ?>
                                <img src="<?= $photoUrl ?>" alt="<?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang)) ?>" class="glowing-image">
                                <div class="glow-effect"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>

                <!-- Populate secData for sections rendering -->
        <?php 
            $secData = [];
            foreach ($data['sections'] as $s) {
                $secData[$s['type_key']] = $s;
            }
        ?>

        <!-- 1. Education -->
        <?php if(isset($secData['education']) && $secData['education']['is_visible']): ?>
            <section class="section" id="education" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas <?= $sectionIcons['education'] ?>"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData['education'], 'title', $lang) ?: ($labels['education'] ?? '')) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/education.php"; ?>
            </section>
        <?php endif; ?>

        <!-- 2. Certificates -->
        <?php if(isset($secData['certificates']) && $secData['certificates']['is_visible']): ?>
            <section class="section" id="certificates" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas <?= $sectionIcons['certificates'] ?>"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData['certificates'], 'title', $lang) ?: ($labels['certificates'] ?? '')) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/certificates.php"; ?>
            </section>
        <?php endif; ?>

        <!-- 3. Skills -->
        <?php if(isset($secData['skills']) && $secData['skills']['is_visible']): ?>
            <section class="section" id="skills" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas <?= $sectionIcons['skills'] ?>"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData['skills'], 'title', $lang) ?: ($labels['skills'] ?? '')) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/skills.php"; ?>
            </section>
        <?php endif; ?>

        <!-- 4. Projects -->
        <?php if(isset($secData['projects']) && $secData['projects']['is_visible']): ?>
            <section class="section" id="projects" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas <?= $sectionIcons['projects'] ?>"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData['projects'], 'title', $lang) ?: ($labels['projects'] ?? '')) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/projects.php"; ?>
            </section>
        <?php endif; ?>

        <!-- 5. Experiences -->
        <?php if(isset($secData['experiences']) && $secData['experiences']['is_visible']): ?>
            <section class="section" id="experiences" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas <?= $sectionIcons['experiences'] ?>"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData['experiences'], 'title', $lang) ?: ($labels['experiences'] ?? '')) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/experiences.php"; ?>
            </section>
        <?php endif; ?>

        <!-- 6. Personal Skills -->
        <?php if (!empty($data['personal_skills'])): ?>
            <section class="section" id="personal-skills" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-user-check"></i>
                    <h2><?= $lang === 'en' ? 'Personal Skills' : 'المهارات الشخصية' ?></h2>
                </div>
                <div class="skills-cards-grid">
                    <?php foreach ($data['personal_skills'] as $pskill): ?>
                        <div class="skill-modern-card glass-card">
                            <h3 class="skill-title"><i class="fas fa-star"></i> <?= htmlspecialchars(BilingualHelper::get($pskill, 'name', $lang)) ?></h3>
                            <?php if (!empty(BilingualHelper::get($pskill, 'description', $lang))): ?>
                                <p class="skill-desc"><?= htmlspecialchars(BilingualHelper::get($pskill, 'description', $lang)) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <!-- 7. Languages -->
        <?php if(isset($secData['languages']) && $secData['languages']['is_visible']): ?>
            <section class="section" id="languages" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas <?= $sectionIcons['languages'] ?>"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData['languages'], 'title', $lang) ?: ($labels['languages'] ?? '')) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/languages.php"; ?>
            </section>
        <?php endif; ?>

        <!-- References -->
        <?php if(isset($secData['references']) && $secData['references']['is_visible']): ?>
            <section class="section" id="references" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas <?= $sectionIcons['references'] ?? 'fa-user-check' ?>"></i>
                    <h2><?= htmlspecialchars(BilingualHelper::get($secData['references'], 'title', $lang) ?: ($labels['references'] ?? '')) ?></h2>
                </div>
                <?php include __DIR__ . "/sections/references.php"; ?>
            </section>
        <?php elseif (!empty($data['profile']['references_text'])): ?>
            <section class="section" id="references" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-user-check"></i>
                    <h2><?= $lang === 'en' ? 'References' : 'المراجع' ?></h2>
                </div>
                <div class="reference-card glass-card">
                    <i class="fas fa-quote-right quote-icon"></i>
                    <p><?= nl2br(htmlspecialchars(BilingualHelper::get($data['profile'], 'references_text', $lang))) ?></p>
                </div>
            </section>
        <?php endif; ?>

        <!-- Footer -->
        <footer class="footer" id="contact">
            <h2 class="footer-name"><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang)) ?></h2>
            <div class="social-links">
                <?php foreach ($data['social_links'] as $sl): ?>
                    <a href="<?= htmlspecialchars($sl['url']) ?>" target="_blank"><i class="<?= getSocialIconClass($sl['platform']) ?>"></i></a>
                <?php endforeach; ?>
            </div>
            <p class="copyright">&copy; <?= date('Y') ?> <?= $lang === 'en' ? 'All rights reserved' : 'جميع الحقوق محفوظة' ?></p>
        </footer>

    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="<?= BASE_URL ?>/templates/template-developer/script.js?v=<?= time() ?>"></script>
</body>
</html>