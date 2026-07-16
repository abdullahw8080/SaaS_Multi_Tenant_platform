<?php
if (!isset($data) || empty($data)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo "<h1>404 Not Found</h1><p>المستند غير موجود.</p>";
    exit;
}

use App\Services\BilingualHelper;

$lang = $_GET['lang'] ?? $data['site']['default_lang'] ?? 'ar';
$dir  = ($lang === 'ar') ? 'rtl' : 'ltr';

$profession = $data['site']['profession_type'] ?? 'developer';
require_once __DIR__ . '/../../app/Config/ProfessionConfig.php';
$labels       = ProfessionConfig::getLabels($profession, $lang);
$cssVars      = ProfessionConfig::getCssVariables($profession);
$extraCss     = ProfessionConfig::getExtraCss($profession);

$secData = [];
foreach ($data['sections'] as $s) {
    $secData[$s['type_key']] = $s;
}

$skillsTitle = isset($secData['skills']) ? BilingualHelper::get($secData['skills'], 'title', $lang) : ($labels['skills'] ?? ($lang === 'ar' ? 'التخصصات والخدمات الطبية' : 'Medical Specializations'));
$expTitle = isset($secData['experiences']) ? BilingualHelper::get($secData['experiences'], 'title', $lang) : ($labels['experiences'] ?? ($lang === 'ar' ? 'المسيرة والخبرات المهنية' : 'Professional Journey'));
$eduTitle = isset($secData['education']) ? BilingualHelper::get($secData['education'], 'title', $lang) : ($labels['education'] ?? ($lang === 'ar' ? 'المؤهلات العلمية والتعليم' : 'Education & Credentials'));
$certTitle = isset($secData['certificates']) ? BilingualHelper::get($secData['certificates'], 'title', $lang) : ($labels['certificates'] ?? ($lang === 'ar' ? 'الزمالات والاعتمادات المهنية' : 'Fellowships & Certifications'));
$projTitle = isset($secData['projects']) ? BilingualHelper::get($secData['projects'], 'title', $lang) : ($labels['projects'] ?? ($lang === 'ar' ? 'الأبحاث والمشاريع' : 'Research & Projects'));
$langTitle = isset($secData['languages']) ? BilingualHelper::get($secData['languages'], 'title', $lang) : ($labels['languages'] ?? ($lang === 'ar' ? 'اللغات' : 'Languages'));
$refTitle = isset($secData['references']) ? BilingualHelper::get($secData['references'], 'title', $lang) : ($labels['references'] ?? ($lang === 'ar' ? 'المراجع' : 'References'));

// دالة لجلب الفولت أيقون المناسب للشبكات الاجتماعية
if (!function_exists('getSocialIconSvg')) {
    function getSocialIconSvg($platform) {
        $platform = strtolower(trim($platform));
        switch ($platform) {
            case 'linkedin':
                return '<svg viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>';
            case 'twitter':
            case 'x':
                return '<svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>';
            case 'email':
            case 'mail':
                return '<svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>';
            case 'phone':
            case 'tel':
                return '<svg viewBox="0 0 24 24"><path d="M6.62 10.79a15.15 15.15 0 0 0 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>';
            case 'whatsapp':
                return '<svg viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zm.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23-1.45 0-2.88-.38-4.13-1.11l-.3-.18-3.07.81.82-2.99-.19-.31a8.176 8.176 0 0 1-1.25-4.38c-.01-4.54 3.69-8.23 8.23-8.23zm-1.89 3.09c-.11-.24-.22-.25-.33-.25h-.28c-.1 0-.25.04-.39.18-.14.14-.53.52-.53 1.27s.54 1.47.62 1.57c.07.1 1.07 1.64 2.6 2.3.36.16.65.25.87.32.36.11.69.1 1 .05.34-.05 1.05-.43 1.2-1 .15-.58.15-1.07.1-1.18-.04-.1-.18-.16-.39-.26-.2-.1-1.2-.59-1.38-.66-.19-.07-.32-.1-.46.1-.14.2-.53.66-.65.8-.12.14-.24.16-.45.06-.2-.1-.87-.32-1.65-1.02-.61-.54-1.02-1.2-1.14-1.4-.12-.2-.01-.31.09-.41.09-.09.2-.23.3-.35.1-.12.13-.2.2-.33.07-.14.03-.26-.02-.36-.05-.1-.46-1.12-.63-1.52z"/></svg>';
            default:
                return '<svg viewBox="0 0 24 24"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>';
        }
    }
}

// دالة لتوليد أيقونة طبية بناء على الترتيب
if (!function_exists('getMedicalIconSvg')) {
    function getMedicalIconSvg($index) {
        $icons = [
            // 0. القلب
            '<svg viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>',
            // 1. الدماغ
            '<svg viewBox="0 0 24 24"><path d="M12 3c-4.97 0-9 4.03-9 9 0 2.12.74 4.07 1.97 5.61L4.35 19.4c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0l1.9-1.9C9.22 19.64 10.57 20 12 20c4.97 0 9-4.03 9-9s-4.03-9-9-9zm0 15c-3.31 0-6-2.69-6-6s2.69-6 6-6 6 2.69 6 6-2.69 6-6 6z"/></svg>',
            // 2. DNA
            '<svg viewBox="0 0 24 24"><path d="M19.07 4.93a10 10 0 0 0-14.14 0 1 1 0 0 0 1.41 1.41 8 8 0 1 1 11.32 11.32 1 1 0 0 0 1.41 1.41 10 10 0 0 0 0-14.14zM12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z"/></svg>',
            // 3. عين
            '<svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>',
            // 4. عظمة / صحة
            '<svg viewBox="0 0 24 24"><path d="M19 10.5c-.83 0-1.5-.67-1.5-1.5V5c0-1.66-1.34-3-3-3H9.5c-1.66 0-3 1.34-3 3v4c0 .83-.67 1.5-1.5 1.5-1.38 0-2.5 1.12-2.5 2.5s1.12 2.5 2.5 2.5c.83 0 1.5.67 1.5 1.5v4c0 1.66 1.34 3 3 3H14.5c1.66 0 3-1.34 3-3v-4c0-.83.67-1.5 1.5-1.5 1.38 0 2.5-1.12 2.5-2.5s-1.12-2.5-2.5-2.5z"/></svg>',
            // 5. مجهر / تحاليل
            '<svg viewBox="0 0 24 24"><path d="M19 7h-1V5.5c0-1.38-1.12-2.5-2.5-2.5h-7C7.12 3 6 4.12 6 5.5V7H5c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2zm-6-2.5c0-.28.22-.5.5-.5s.5.22.5.5V7h-1V4.5zm-5 1c0-.28.22-.5.5-.5h2c.28 0 .5.22.5.5V7H8V5.5zM18 19H6V9h12v10z"/></svg>'
        ];
        return $icons[$index % count($icons)];
    }
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>" dir="<?= htmlspecialchars($dir, ENT_QUOTES, 'UTF-8') ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars(substr(BilingualHelper::get($data['profile'], 'bio', $lang), 0, 160), ENT_QUOTES, 'UTF-8') ?>">
  
  <!-- Open Graph -->
  <meta property="og:title" content="<?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?> | <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'title', $lang), ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars(substr(BilingualHelper::get($data['profile'], 'bio', $lang), 0, 200), ENT_QUOTES, 'UTF-8') ?>">
  <?php if (!empty($data['profile']['photo'])): ?>
    <meta property="og:image" content="<?= htmlspecialchars(BASE_URL . '/' . ltrim($data['profile']['photo'], '/'), ENT_QUOTES, 'UTF-8') ?>">
  <?php endif; ?>
  <meta property="og:type" content="profile">
  
  <title><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?> | <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'title', $lang), ENT_QUOTES, 'UTF-8') ?></title>
  
  <!-- Preconnect Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  
  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>/templates/template-doctor/style.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <!-- [PROFESSION COLORS] — CSS Variable Override per Profession -->
  <style>:root { <?= $cssVars ?> } <?= $extraCss ?></style>

  <!-- JSON-LD Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Physician",
    "name": "<?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?>",
    "medicalSpecialty": "<?= htmlspecialchars(BilingualHelper::get($data['profile'], 'title', $lang), ENT_QUOTES, 'UTF-8') ?>",
    "description": "<?= htmlspecialchars(BilingualHelper::get($data['profile'], 'bio', $lang), ENT_QUOTES, 'UTF-8') ?>",
    <?php if(!empty($data['profile']['photo'])): ?>
    "image": "<?= htmlspecialchars(BASE_URL . '/' . ltrim($data['profile']['photo'], '/'), ENT_QUOTES, 'UTF-8') ?>",
    <?php endif; ?>
    "url": "<?= htmlspecialchars(BASE_URL . '/' . $data['site']['slug'], ENT_QUOTES, 'UTF-8') ?>"
  }
  </script>
</head>
<body>

  <!-- (1) زر تبديل اللغة -->
  <?php if ($data['site']['is_bilingual']): ?>
    <a href="?lang=<?= $lang === 'ar' ? 'en' : 'ar' ?>" class="lang-toggle" aria-label="Switch Language">
        <span class="lang-toggle__icon">🌐</span>
        <span><?= $lang === 'ar' ? 'EN' : 'ع' ?></span>
    </a>
  <?php endif; ?>

  <!-- (2) شريط التنقل (Navbar) -->
  <nav class="navbar" id="navbar">
    <div class="nav-content">
      <a href="#" class="navbar__logo">
        <svg width="24" height="24" viewBox="0 0 24 24"><path d="M19 10.5h-5.5V5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v5.5H5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5h5.5V19c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5v-5.5H19c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5z"/></svg>
        <span><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?></span>
      </a>
      
      <div class="navbar__links" id="navbarLinks">
        <a href="#objective" class="navbar__link"><?= $lang === 'ar' ? 'الرئيسية' : 'Home' ?></a>
        <?php if (!empty(BilingualHelper::get($data['profile'], 'bio', $lang))): ?>
          <a href="#about" class="navbar__link"><?= htmlspecialchars($labels['about'] ?? ($lang === 'ar' ? 'عن الطبيب' : 'About')) ?></a>
        <?php endif; ?>
        <?php if (!empty($data['skills']) && (!isset($secData['skills']) || $secData['skills']['is_visible'])): ?>
          <a href="#skills" class="navbar__link"><?= htmlspecialchars($skillsTitle) ?></a>
        <?php endif; ?>
        <?php if (!empty($data['experiences']) && (!isset($secData['experiences']) || $secData['experiences']['is_visible'])): ?>
          <a href="#experience" class="navbar__link"><?= htmlspecialchars($expTitle) ?></a>
        <?php endif; ?>
        <?php if (!empty($data['education']) && (!isset($secData['education']) || $secData['education']['is_visible'])): ?>
          <a href="#education" class="navbar__link"><?= htmlspecialchars($eduTitle) ?></a>
        <?php endif; ?>
        <?php if (!empty($data['certificates']) && (!isset($secData['certificates']) || $secData['certificates']['is_visible'])): ?>
          <a href="#certificates" class="navbar__link"><?= htmlspecialchars($certTitle) ?></a>
        <?php endif; ?>
        <?php if (!empty($data['projects']) && (!isset($secData['projects']) || $secData['projects']['is_visible'])): ?>
          <a href="#projects" class="navbar__link"><?= htmlspecialchars($projTitle) ?></a>
        <?php endif; ?>
        <a href="#contact" class="navbar__link"><?= $lang === 'ar' ? 'تواصل' : 'Contact' ?></a>
      </div>

      <button class="hamburger" id="hamburgerBtn" aria-label="Toggle Menu" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </nav>

  <!-- (3) قسم Hero -->
  <section class="hero" id="objective">
    <canvas id="particles-canvas"></canvas>
    
    <div class="hero__content">
      <div class="hero__photo-wrapper" data-aos="zoom-in">
        <?php if (!empty($data['profile']['photo'])): ?>
          <?php 
            $photoUrl = BASE_URL . '/' . ltrim($data['profile']['photo'], '/');
            $photoExt = strtolower(pathinfo($photoUrl, PATHINFO_EXTENSION));
            if (!in_array($photoExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $photoUrl .= '.jpg';
            }
          ?>
          <img src="<?= htmlspecialchars($photoUrl, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?>" class="hero__photo" fetchpriority="high" loading="eager">
        <?php else: ?>
          <div class="hero__placeholder-icon">
            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
          </div>
        <?php endif; ?>
      </div>

      <div class="hero-welcome-badge" data-aos="fade-up"><?= $lang === 'ar' ? 'مرحباً بك' : 'Welcome' ?></div>
      <h1 class="hero__name" data-aos="fade-up"><span class="highlight-text"><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?></span></h1>
      <p class="hero__title" data-aos="fade-up"><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'title', $lang), ENT_QUOTES, 'UTF-8') ?></p>
      
      <?php if (!empty(BilingualHelper::get($data['profile'], 'bio', $lang))): ?>
        <p class="hero__bio" data-aos="fade-up">
          <?= htmlspecialchars(mb_strimwidth(BilingualHelper::get($data['profile'], 'bio', $lang), 0, 180, '...'), ENT_QUOTES, 'UTF-8') ?>
        </p>
      <?php endif; ?>

      <div class="hero__actions" data-aos="fade-up">
        <a href="#contact" class="btn btn--primary"><?= $lang === 'ar' ? 'تواصل معي' : 'Get In Touch' ?></a>
        <?php if (!empty($data['profile']['cv_pdf'])): ?>
          <a href="<?= htmlspecialchars(BASE_URL . '/' . ltrim($data['profile']['cv_pdf'], '/'), ENT_QUOTES, 'UTF-8') ?>" download class="btn btn--ghost">
            <i class="fas fa-file-download"></i> <?= $lang === 'ar' ? 'تحميل السيرة الذاتية' : 'Download CV' ?>
          </a>
        <?php endif; ?>
      </div>

      <!-- الإحصائيات السريعة -->
      <?php
        $yearsExp = 0;
        if (!empty($data['experiences'])) {
            $dates = array_filter(array_column($data['experiences'], 'start_date'));
            if (!empty($dates)) {
                $earliest = min($dates);
                $yearsExp = (date('Y') - (int)substr($earliest, 0, 4));
            }
        }
        $certCount = count($data['certificates'] ?? []);
        $researchCount = count(array_filter($data['projects'] ?? [], fn($p) => ($p['type'] ?? 'project') === 'research'));
      ?>
      <div class="hero__stats" data-aos="fade-up">
        <?php if ($yearsExp > 0): ?>
          <div class="hero__stat">
            <div class="hero__stat-number" data-target="<?= (int)$yearsExp ?>">0</div>
            <div class="hero__stat-label"><?= $lang === 'ar' ? 'سنوات الخبرة' : 'Years Exp' ?></div>
          </div>
        <?php endif; ?>
        <?php if ($certCount > 0): ?>
          <div class="hero__stat">
            <div class="hero__stat-number" data-target="<?= (int)$certCount ?>">0</div>
            <div class="hero__stat-label"><?= $lang === 'ar' ? 'الشهادات المعتمدة' : 'Certifications' ?></div>
          </div>
        <?php endif; ?>
        <?php if ($researchCount > 0): ?>
          <div class="hero__stat">
            <div class="hero__stat-number" data-target="<?= (int)$researchCount ?>">0</div>
            <div class="hero__stat-label"><?= $lang === 'ar' ? 'الأبحاث والمنشورات' : 'Research Papers' ?></div>
          </div>
        <?php endif; ?>
      </div>
    </div>
    
    <a href="#about" class="scroll-down-indicator" aria-label="Scroll Down">
      <i class="fa-solid fa-chevron-down"></i>
    </a>
  </section>

  <!-- (4) قسم عن الطبيب (About) -->
  <?php if (!empty(BilingualHelper::get($data['profile'], 'bio', $lang))): ?>
    <section class="section container" id="about">
      <div class="section-title" data-aos="fade-up">
        <i class="fa-solid fa-user-doctor"></i>
        <h2><?= htmlspecialchars($labels['about'] ?? ($lang === 'ar' ? 'نبذة تعريفية' : 'About Me')) ?></h2>
      </div>
      <div class="about-card glass-card fade-in-up">
        <p class="about-bio"><?= nl2br(htmlspecialchars(BilingualHelper::get($data['profile'], 'bio', $lang), ENT_QUOTES, 'UTF-8')) ?></p>
        
        <?php if (!empty(BilingualHelper::get($data['profile'], 'references', $lang))): ?>
          <div class="about-references">
            <div class="about-references__title"><?= htmlspecialchars($refTitle) ?></div>
            <div class="about-references__text"><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'references', $lang), ENT_QUOTES, 'UTF-8') ?></div>
          </div>
        <?php endif; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- (5) قسم التخصصات والمهارات -->
  <?php if (!empty($data['skills'])): ?>
    <section class="section container" id="skills">
      <div class="section-title" data-aos="fade-up">
        <i class="fa-solid fa-stethoscope"></i>
        <h2><?= htmlspecialchars($skillsTitle) ?></h2>
      </div>
      <div class="skills-grid">
        <?php foreach ($data['skills'] as $index => $skill): ?>
          <div class="skill-card glass-card fade-in-up">
            <div class="skill-header">
              <div class="skill-icon-box">
                <?= getMedicalIconSvg($index) ?>
              </div>
              <h3 class="skill-name"><?= htmlspecialchars(BilingualHelper::get($skill, 'name', $lang), ENT_QUOTES, 'UTF-8') ?></h3>
            </div>
            
            <?php if (!empty(BilingualHelper::get($skill, 'description', $lang))): ?>
              <p class="skill-desc"><?= htmlspecialchars(BilingualHelper::get($skill, 'description', $lang), ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            
            <?php if (isset($skill['level']) && (int)$skill['level'] > 0): ?>
              <div class="skill-bar-wrapper">
                <div class="skill-bar-header">
                  <span><?= $lang === 'ar' ? 'التمكن السريري' : 'Clinical Expertise' ?></span>
                  <span><?= (int)$skill['level'] ?>%</span>
                </div>
                <div class="skill-bar-track">
                  <div class="skill-bar-fill" data-width="<?= (int)$skill['level'] ?>%"></div>
                </div>
              </div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- (6) قسم المسيرة المهنية (Experience Timeline) -->
  <?php if (!empty($data['experiences'])): ?>
    <section class="section container" id="experience">
      <div class="section-title" data-aos="fade-up">
        <i class="fa-solid fa-hospital"></i>
        <h2><?= htmlspecialchars($expTitle) ?></h2>
      </div>
      
      <div class="timeline">
        <?php foreach ($data['experiences'] as $exp): ?>
          <div class="timeline__item">
            <div class="timeline__dot"></div>
            <div class="timeline-card glass-card">
              <div class="timeline-card__header">
                <h3 class="timeline-card__title"><?= htmlspecialchars(BilingualHelper::get($exp, 'position', $lang), ENT_QUOTES, 'UTF-8') ?></h3>
                <span class="timeline-card__date">
                  <?= htmlspecialchars($exp['start_date'], ENT_QUOTES, 'UTF-8') ?> 
                  → 
                  <?= !empty($exp['end_date']) ? htmlspecialchars($exp['end_date'], ENT_QUOTES, 'UTF-8') : ($lang === 'ar' ? 'حتى الآن' : 'Present') ?>
                </span>
              </div>
              <h4 class="timeline-card__subtitle">
                <i class="fa-solid fa-square-h"></i>
                <?= htmlspecialchars(BilingualHelper::get($exp, 'company', $lang), ENT_QUOTES, 'UTF-8') ?>
              </h4>
              <?php if (!empty(BilingualHelper::get($exp, 'description', $lang))): ?>
                <p class="timeline-card__desc"><?= nl2br(htmlspecialchars(BilingualHelper::get($exp, 'description', $lang), ENT_QUOTES, 'UTF-8')) ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- (7) قسم التعليم والتدريب (Education Timeline) -->
  <?php if (!empty($data['education'])): ?>
    <section class="section container" id="education">
      <div class="section-title" data-aos="fade-up">
        <i class="fa-solid fa-user-graduate"></i>
        <h2><?= htmlspecialchars($eduTitle) ?></h2>
      </div>
      
      <div class="timeline">
        <?php foreach ($data['education'] as $edu): ?>
          <div class="timeline__item">
            <div class="timeline__dot" style="background-color: var(--color-accent); box-shadow: var(--glow-accent);"></div>
            <div class="timeline-card glass-card">
              <div class="timeline-card__header">
                <h3 class="timeline-card__title"><?= htmlspecialchars(BilingualHelper::get($edu, 'degree', $lang), ENT_QUOTES, 'UTF-8') ?></h3>
                <span class="timeline-card__date" style="background: rgba(167, 139, 250, 0.08); border-color: rgba(167, 139, 250, 0.15); color: var(--color-accent);">
                  <?= htmlspecialchars($edu['year'], ENT_QUOTES, 'UTF-8') ?>
                </span>
              </div>
              <h4 class="timeline-card__subtitle" style="color: var(--color-accent);">
                <i class="fa-solid fa-university"></i>
                <?= htmlspecialchars(BilingualHelper::get($edu, 'institution', $lang), ENT_QUOTES, 'UTF-8') ?>
              </h4>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- (8) قسم الشهادات والاعتمادات -->
  <?php if (!empty($data['certificates'])): ?>
    <section class="section container" id="certificates">
      <div class="section-title" data-aos="fade-up">
        <i class="fa-solid fa-award"></i>
        <h2><?= htmlspecialchars($certTitle) ?></h2>
      </div>
      
      <div class="cert-grid">
        <?php foreach ($data['certificates'] as $cert): ?>
          <div class="cert-card glass-card fade-in-up">
            <div class="cert-card__icon">
              <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
            </div>
            <div>
              <h3 class="cert-card__title"><?= htmlspecialchars(BilingualHelper::get($cert, 'title', $lang), ENT_QUOTES, 'UTF-8') ?></h3>
              <p class="cert-card__issuer"><?= htmlspecialchars(BilingualHelper::get($cert, 'issuer', $lang), ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            
            <div class="cert-card__footer">
              <span class="cert-card__year"><?= !empty($cert['year']) ? htmlspecialchars($cert['year'], ENT_QUOTES, 'UTF-8') : '' ?></span>
              <div class="cert-card__actions">
                <?php if (!empty($cert['file_url'])): ?>
                  <a href="<?= htmlspecialchars(BASE_URL . '/' . ltrim($cert['file_url'], '/'), ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn--pdf" rel="noopener noreferrer">
                    <i class="fa-solid fa-file-pdf"></i> <?= $lang === 'ar' ? 'وثيقة' : 'Verify' ?>
                  </a>
                <?php endif; ?>
                <?php if (!empty($cert['credential_url'])): ?>
                  <a href="<?= htmlspecialchars($cert['credential_url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn--ghost" rel="noopener noreferrer">
                    <i class="fa-solid fa-up-right-from-square"></i> <?= $lang === 'ar' ? 'التحقق' : 'Verify' ?>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- (9) قسم الأبحاث والمشاريع -->
  <?php if (!empty($data['projects'])): ?>
    <?php
      $onlyResearch = true;
      foreach ($data['projects'] as $p) {
          if (($p['type'] ?? 'project') !== 'research') {
              $onlyResearch = false;
              break;
          }
      }
      $projectSectionTitle = $onlyResearch 
          ? ($lang === 'ar' ? 'الأبحاث الطبية والمنشورات' : 'Medical Research & Publications')
          : ($lang === 'ar' ? 'الأبحاث والمنجزات السريرية' : 'Research & Clinical Projects');
    ?>
    <section class="section container" id="projects">
      <div class="section-title" data-aos="fade-up">
        <i class="fa-solid fa-book-medical"></i>
        <h2><?= htmlspecialchars($projTitle) ?></h2>
      </div>
      
      <div class="projects-grid">
        <?php foreach ($data['projects'] as $proj): ?>
          <div class="project-card glass-card fade-in-up">
            <div class="project-card__img-wrapper">
              <?php if (!empty($proj['cover_image'])): ?>
                <?php 
                  $coverUrl = BASE_URL . '/' . ltrim($proj['cover_image'], '/');
                  $coverExt = strtolower(pathinfo($coverUrl, PATHINFO_EXTENSION));
                  if (!in_array($coverExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                      $coverUrl .= '.jpg';
                  }
                ?>
                <img src="<?= htmlspecialchars($coverUrl, ENT_QUOTES, 'UTF-8') ?>" alt="Project Cover" class="project-card__img" loading="lazy">
              <?php else: ?>
                <div class="project-card__img-placeholder">
                  <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                </div>
              <?php endif; ?>
              
              <span class="project-card__badge project-card__badge--<?= htmlspecialchars($proj['type'] ?? 'project', ENT_QUOTES, 'UTF-8') ?>">
                <?php
                  $type = $proj['type'] ?? 'project';
                  if ($lang === 'ar') {
                      echo $type === 'research' ? 'بحث طبي' : ($type === 'case_study' ? 'دراسة حالة' : 'عمل سريري');
                  } else {
                      echo $type === 'research' ? 'Research' : ($type === 'case_study' ? 'Case Study' : 'Project');
                  }
                ?>
              </span>
            </div>
            
            <div class="project-card__content">
              <h3 class="project-card__title"><?= htmlspecialchars(BilingualHelper::get($proj, 'title', $lang), ENT_QUOTES, 'UTF-8') ?></h3>
              <?php if (!empty(BilingualHelper::get($proj, 'summary', $lang))): ?>
                <p class="project-card__summary"><?= htmlspecialchars(BilingualHelper::get($proj, 'summary', $lang), ENT_QUOTES, 'UTF-8') ?></p>
              <?php endif; ?>
              
              <div class="project-card__actions">
                <?php if (!empty($proj['body']) || !empty($proj['media'])): ?>
                  <a href="<?= htmlspecialchars(BASE_URL . '/' . $data['site']['slug'] . '/projects/' . $proj['slug'], ENT_QUOTES, 'UTF-8') ?><?= $lang === 'en' ? '?lang=en' : '' ?>" class="btn btn--primary">
                    <i class="fa-solid fa-book-open"></i> <?= $lang === 'ar' ? 'اقرأ كامل التفاصيل' : 'Read Full Details' ?>
                  </a>
                <?php endif; ?>
                <?php if (!empty($proj['link'])): ?>
                  <a href="<?= htmlspecialchars($proj['link'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn--ghost" rel="noopener noreferrer">
                    <i class="fa-solid fa-up-right-from-square"></i> DOI / Link
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- (10) قسم اللغات -->
  <?php if (!empty($data['languages'])): ?>
    <section class="section container" id="languages">
      <div class="section-title" data-aos="fade-up">
        <i class="fa-solid fa-language"></i>
        <h2><?= htmlspecialchars($langTitle) ?></h2>
      </div>
      <div class="languages-list" data-aos="fade-up">
        <?php foreach ($data['languages'] as $langObj): ?>
          <?php
            $lvl = strtolower(BilingualHelper::get($langObj, 'level', $lang));
            $badgeClass = 'lang-badge--intermediate'; // default
            if (str_contains($lvl, 'native') || str_contains($lvl, 'أم') || str_contains($lvl, 'excellent') || str_contains($lvl, 'ممتاز')) {
                $badgeClass = 'lang-badge--native';
            } elseif (str_contains($lvl, 'advanced') || str_contains($lvl, 'متقدم') || str_contains($lvl, 'fluent') || str_contains($lvl, 'طليق')) {
                $badgeClass = 'lang-badge--advanced';
            } elseif (str_contains($lvl, 'beginner') || str_contains($lvl, 'مبتدئ')) {
                $badgeClass = 'lang-badge--beginner';
            }
          ?>
          <div class="lang-badge <?= $badgeClass ?>">
            <span><?= htmlspecialchars(BilingualHelper::get($langObj, 'name', $lang), ENT_QUOTES, 'UTF-8') ?>:</span>
            <span><?= htmlspecialchars(BilingualHelper::get($langObj, 'level', $lang), ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>

  <!-- (11) قسم التواصل (Footer) -->
  <footer class="footer" id="contact">
    <div class="container">
      <h2 class="footer-name"><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?></h2>
      
      <?php if (!empty($data['social_links'])): ?>
        <div class="social-links">
          <?php foreach ($data['social_links'] as $sl): ?>
            <a href="<?= htmlspecialchars($sl['url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" title="<?= htmlspecialchars($sl['platform'], ENT_QUOTES, 'UTF-8') ?>" rel="noopener noreferrer">
              <?= getSocialIconSvg($sl['platform']) ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      
      <p class="copyright">&copy; <?= date('Y') ?> <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?>. <?= $lang === 'ar' ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' ?></p>
      
      <?php if (!empty(BilingualHelper::get($data['profile'], 'references', $lang))): ?>
        <p class="copyright" style="margin-top: 10px; font-size: 0.8rem; opacity: 0.8;">
          <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'references', $lang), ENT_QUOTES, 'UTF-8') ?>
        </p>
      <?php endif; ?>
    </div>
  </footer>

  <!-- Scripts -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script src="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>/templates/template-doctor/script.js?v=<?= time() ?>"></script>
</body>
</html>
<?php
// ✅ CHECKPOINT: template-doctor/index.php — COMPLETE
// المرحلة: قالب الأطباء (Doctor Template)
// التالي: project-detail.php
?>
