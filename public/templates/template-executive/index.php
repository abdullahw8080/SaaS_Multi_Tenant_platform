<?php
/**
 * Executive Prestige Template — index.php
 * Template: template-executive
 * Platform: SaaS Multi-Tenant Portfolio
 *
 * Variables provided by TemplateRenderer:
 *   $data  — full site data array
 *   $lang  — current language ('ar' | 'en')
 *   $dir   — text direction ('rtl' | 'ltr')
 */

// ── Safety Check ──
if (!isset($data) || empty($data)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo '<h1>404 Not Found</h1><p>Site data not found.</p>';
    exit;
}

use App\Services\BilingualHelper;

// ── Language & Direction ──
$lang = $_GET['lang'] ?? $data['site']['default_lang'] ?? 'ar';
if (!in_array($lang, ['ar', 'en'], true)) $lang = 'ar';
$dir  = ($lang === 'ar') ? 'rtl' : 'ltr';

// ── Computed Profile Data ──
$fullName    = htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8');
$fullNameEn  = htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', 'en'), ENT_QUOTES, 'UTF-8');
$title       = htmlspecialchars(BilingualHelper::get($data['profile'], 'title', $lang), ENT_QUOTES, 'UTF-8');
$titleEn     = htmlspecialchars(BilingualHelper::get($data['profile'], 'title', 'en'), ENT_QUOTES, 'UTF-8');
$bio         = BilingualHelper::get($data['profile'], 'bio', $lang);
$bioShort    = htmlspecialchars(substr(strip_tags($bio), 0, 160), ENT_QUOTES, 'UTF-8');
$slug        = htmlspecialchars($data['site']['slug'] ?? '', ENT_QUOTES, 'UTF-8');
$photoUrl    = !empty($data['profile']['photo'])
               ? htmlspecialchars(BASE_URL . '/' . ltrim($data['profile']['photo'], '/'), ENT_QUOTES, 'UTF-8')
               : '';
$cvUrl       = !empty($data['profile']['cv_pdf'])
               ? htmlspecialchars(BASE_URL . '/' . ltrim($data['profile']['cv_pdf'], '/'), ENT_QUOTES, 'UTF-8')
               : '';
$firstLetter = mb_strtoupper(mb_substr(trim(strip_tags($fullName)), 0, 1, 'UTF-8'), 'UTF-8');
$baseUrl     = htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8');

// ── Hero Statistics — Computed from $data ──
$yearsExp = 0;
if (!empty($data['experiences'])) {
    $dates    = array_filter(array_column($data['experiences'], 'start_date'));
    $earliest = !empty($dates) ? min($dates) : null;
    $yearsExp = $earliest ? max(0, (int)date('Y') - (int)substr($earliest, 0, 4)) : 0;
}
$certCount      = count($data['certificates'] ?? []);
$companiesCount = count($data['experiences'] ?? []);
$projectsCount  = count($data['projects'] ?? []);

// ── SVG Icon Helper — Expertise Areas ──
if (!function_exists('getExecExpertiseIcon')) {
    function getExecExpertiseIcon(int $index): string {
        $icons = [
            // 0: Compass — Strategy
            '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>',
            // 1: Trending Up — Finance / Growth
            '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>',
            // 2: Users — Leadership / Teams
            '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            // 3: Handshake / Layers — M&A
            '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>',
            // 4: Cpu — Digital Transformation
            '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/></svg>',
            // 5: Target — Marketing / Sales
            '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
            // 6: Settings — Operations
            '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>',
            // 7: Share2 — Relations / Network
            '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>',
        ];
        return $icons[$index % count($icons)];
    }
}

// ── SVG Icon Helper — Social Links ──
if (!function_exists('getExecSocialIcon')) {
    function getExecSocialIcon(string $platform): string {
        $p = strtolower(trim($platform));
        switch ($p) {
            case 'linkedin':
                return '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>';
            case 'email':
            case 'mail':
                return '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>';
            case 'phone':
            case 'tel':
                return '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M6.62 10.79a15.15 15.15 0 0 0 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>';
            case 'twitter':
            case 'x':
                return '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>';
            case 'whatsapp':
                return '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
            case 'instagram':
                return '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>';
            case 'youtube':
                return '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-2.47 4.92 4.92 0 00-4.91 0A4.83 4.83 0 017.14 6.7H3a1 1 0 00-1 1v9a1 1 0 001 1h18a1 1 0 001-1v-9a1 1 0 00-1-1zM10 15V9l5 3z"/></svg>';
            default: // website, generic
                return '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>';
        }
    }
}

// ── Language level → CSS class helper ──
if (!function_exists('getLangPillClass')) {
    function getLangPillClass(string $levelAr, string $levelEn): string {
        $combined = strtolower($levelAr . $levelEn);
        if (str_contains($combined, 'native') || str_contains($combined, 'أم') ||
            str_contains($combined, 'ممتاز') || str_contains($combined, 'excellent') ||
            str_contains($combined, 'fluent') || str_contains($combined, 'طليق')) {
            return 'lang-pill--native';
        }
        if (str_contains($combined, 'advanced') || str_contains($combined, 'متقدم')) {
            return 'lang-pill--advanced';
        }
        if (str_contains($combined, 'intermediate') || str_contains($combined, 'متوسط')) {
            return 'lang-pill--intermediate';
        }
        return 'lang-pill--basic';
    }
}

// ── Project type label helper ──
if (!function_exists('getProjectTypeLabel')) {
    function getProjectTypeLabel(string $type, string $lang): string {
        if ($lang === 'ar') {
            return $type === 'case_study' ? 'دراسة حالة' : 'مشروع استراتيجي';
        }
        return $type === 'case_study' ? 'Case Study' : 'Strategic Project';
    }
}

// ── Tagline rotating texts ──
$taglineTexts = json_encode($lang === 'ar'
    ? ['رئيس تنفيذي', 'قائد أعمال', 'رائد مؤسس', 'صانع قرار', 'ملهم فرق']
    : ['CEO', 'BUSINESS LEADER', 'FOUNDER', 'VISIONARY', 'STRATEGIST']
);

?><!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- SEO -->
  <title><?= $fullName ?> | <?= $title ?></title>
  <meta name="description" content="<?= $bioShort ?>">
  <meta name="robots" content="index, follow">

  <!-- Open Graph -->
  <meta property="og:type"        content="profile">
  <meta property="og:title"       content="<?= $fullName ?> — <?= $title ?>">
  <meta property="og:description" content="<?= $bioShort ?>">
  <?php if ($photoUrl): ?>
  <meta property="og:image"       content="<?= $photoUrl ?>">
  <?php endif; ?>
  <meta property="og:url"         content="<?= $baseUrl ?>/<?= $slug ?>">
  <meta property="og:locale"      content="<?= $lang === 'ar' ? 'ar_SA' : 'en_US' ?>">

  <!-- Twitter Card -->
  <meta name="twitter:card"        content="summary_large_image">
  <meta name="twitter:title"       content="<?= $fullName ?>">
  <meta name="twitter:description" content="<?= $bioShort ?>">
  <?php if ($photoUrl): ?>
  <meta name="twitter:image"       content="<?= $photoUrl ?>">
  <?php endif; ?>

  <!-- Fonts — Preconnect + Load -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Playfair+Display:wght@400;700;900&family=Cairo:wght@300;400;600;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- JSON-LD Schema -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "<?= $fullNameEn ?>",
    "jobTitle": "<?= $titleEn ?>",
    "description": "<?= htmlspecialchars(substr(strip_tags(BilingualHelper::get($data['profile'], 'bio', 'en')), 0, 200), ENT_QUOTES, 'UTF-8') ?>",
    "url": "<?= $baseUrl ?>/<?= $slug ?>"
    <?php if ($photoUrl): ?>,"image": "<?= $photoUrl ?>"<?php endif; ?>
    <?php if (!empty($data['social_links'])): ?>
    ,"sameAs": [<?= implode(',', array_map(fn($sl) => '"' . htmlspecialchars($sl['url'], ENT_QUOTES, 'UTF-8') . '"', array_filter($data['social_links'], fn($sl) => !empty($sl['url'])))) ?>]
    <?php endif; ?>
  }
  </script>

  <link rel="stylesheet" href="style.css">
</head>
<body class="exec-body">

<!-- ① Language Toggle -->
<?php if (!empty($data['site']['is_bilingual'])): ?>
  <a href="?lang=<?= $lang === 'ar' ? 'en' : 'ar' ?>" class="lang-toggle" id="lang-toggle-btn" aria-label="Switch to <?= $lang === 'ar' ? 'English' : 'Arabic' ?>">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <circle cx="12" cy="12" r="10"/>
      <line x1="2" y1="12" x2="22" y2="12"/>
      <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
    </svg>
    <span><?= $lang === 'ar' ? 'EN' : 'ع' ?></span>
  </a>
<?php endif; ?>

<!-- ② Navbar -->
<nav class="navbar" id="navbar" role="navigation" aria-label="Main navigation">
  <div class="navbar__logo">
    <div class="navbar__logo-mark" aria-hidden="true"><?= $firstLetter ?></div>
  </div>

  <div class="navbar__links" id="mobile-menu" role="menu">
    <?php if (!empty(BilingualHelper::get($data['profile'], 'bio', $lang))): ?>
      <a href="#about" role="menuitem"><?= $lang === 'ar' ? 'عن المدير' : 'About' ?></a>
    <?php endif; ?>
    <?php if (!empty($data['skills'])): ?>
      <a href="#expertise" role="menuitem"><?= $lang === 'ar' ? 'الخبرات' : 'Expertise' ?></a>
    <?php endif; ?>
    <?php if (!empty($data['projects'])): ?>
      <a href="#achievements" role="menuitem"><?= $lang === 'ar' ? 'الإنجازات' : 'Achievements' ?></a>
    <?php endif; ?>
    <?php if (!empty($data['experiences'])): ?>
      <a href="#journey" role="menuitem"><?= $lang === 'ar' ? 'المسيرة' : 'Journey' ?></a>
    <?php endif; ?>
    <?php if (!empty($data['education'])): ?>
      <a href="#education" role="menuitem"><?= $lang === 'ar' ? 'التعليم' : 'Education' ?></a>
    <?php endif; ?>
    <a href="#contact" class="btn btn--gold-outline btn--sm" role="menuitem" id="nav-contact-btn">
      <?= $lang === 'ar' ? 'تواصل معي' : 'Contact Me' ?>
    </a>
  </div>

  <button class="hamburger" id="hamburger-btn" aria-expanded="false" aria-controls="mobile-menu" aria-label="Toggle navigation menu">
    <span></span>
    <span></span>
    <span></span>
  </button>
</nav>

<!-- ③ Hero Section -->
<section class="hero container" id="hero" aria-label="<?= $lang === 'ar' ? 'البيان القيادي' : 'Leadership Statement' ?>">
  <!-- Text Side -->
  <div class="hero__text">
    <!-- Tagline Rotator Badge -->
    <div class="hero__tagline-wrap">
      <div class="hero__tagline-dot" aria-hidden="true"></div>
      <span class="hero__tagline-rotate" data-texts='<?= $taglineTexts ?>' aria-live="polite">
        <?= $lang === 'ar' ? 'رئيس تنفيذي' : 'CEO' ?>
      </span>
    </div>

    <!-- Name -->
    <h1 class="hero__name fade-in-up">
      <?= $fullName ?>
    </h1>

    <!-- Title -->
    <p class="hero__title fade-in-up">
      <?= $title ?>
    </p>

    <!-- Divider -->
    <hr class="gold-divider hero__divider fade-in-up" aria-hidden="true">

    <!-- Stats -->
    <?php
      $statsToShow = [];
      if ($yearsExp > 0) $statsToShow[] = ['count' => $yearsExp, 'label' => $lang === 'ar' ? 'سنة خبرة' : 'Years Experience'];
      if ($companiesCount > 0) $statsToShow[] = ['count' => $companiesCount, 'label' => $lang === 'ar' ? 'جهة عمل' : 'Organizations Led'];
      if ($certCount > 0) $statsToShow[] = ['count' => $certCount, 'label' => $lang === 'ar' ? 'شهادة مهنية' : 'Certifications'];
      if ($projectsCount > 0 && $companiesCount === 0) $statsToShow[] = ['count' => $projectsCount, 'label' => $lang === 'ar' ? 'إنجاز كبير' : 'Key Achievements'];
    ?>
    <?php if (!empty($statsToShow)): ?>
      <div class="hero__stats fade-in-up" role="list" aria-label="<?= $lang === 'ar' ? 'الإنجازات الرئيسية' : 'Key Statistics' ?>">
        <?php foreach ($statsToShow as $stat): ?>
          <div class="hero__stat" data-count="<?= (int)$stat['count'] ?>" role="listitem">
            <span class="hero__stat-number" aria-label="<?= (int)$stat['count'] . ' ' . $stat['label'] ?>">0</span>
            <span class="hero__stat-label"><?= htmlspecialchars($stat['label'], ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- CTAs -->
    <div class="hero__actions fade-in-up">
      <?php if ($cvUrl): ?>
        <a href="<?= $cvUrl ?>" class="btn btn--gold" download id="download-cv-btn"
           aria-label="<?= $lang === 'ar' ? 'تحميل السيرة الذاتية' : 'Download Resume' ?>">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
          </svg>
          <?= $lang === 'ar' ? 'تحميل السيرة الذاتية' : 'Download Resume' ?>
        </a>
      <?php endif; ?>
      <a href="#contact" class="btn btn--royal-outline" id="hero-contact-btn">
        <?= $lang === 'ar' ? 'التواصل المباشر' : 'Direct Contact' ?>
      </a>
    </div>
  </div>

  <!-- Visual Side -->
  <div class="hero__visual fade-in-up">
    <div class="hero__photo-wrapper">
      <div class="hero__photo-frame" aria-hidden="true"></div>
      <?php if ($photoUrl): ?>
        <img class="hero__photo"
             src="<?= $photoUrl ?>"
             alt="<?= $lang === 'ar' ? 'صورة ' . $fullName : 'Photo of ' . $fullName ?>"
             loading="eager">
      <?php else: ?>
        <div class="hero__photo-placeholder" role="img" aria-label="<?= $fullName ?>">
          <span class="hero__photo-initial" aria-hidden="true"><?= $firstLetter ?></span>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Scroll Indicator -->
  <div class="scroll-indicator" aria-hidden="true">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="6 9 12 15 18 9"/>
    </svg>
  </div>
</section>

<!-- ④ About — القصة القيادية -->
<?php if (!empty(BilingualHelper::get($data['profile'], 'bio', $lang))): ?>
<section class="section" id="about" aria-labelledby="about-heading">
  <div class="container">
    <div class="section__header">
      <span class="section__eyebrow fade-in-up"><?= $lang === 'ar' ? 'من أنا' : 'MY STORY' ?></span>
      <h2 class="section__title fade-in-up" id="about-heading">
        <?= $lang === 'ar' ? 'القصة القيادية' : 'Leadership Story' ?>
      </h2>
    </div>

    <div class="gold-card gold-card--accent about-card fade-in-up">
      <div class="about-card__body">
        <?= nl2br(htmlspecialchars(BilingualHelper::get($data['profile'], 'bio', $lang), ENT_QUOTES, 'UTF-8')) ?>
      </div>

      <?php $ref = BilingualHelper::get($data['profile'], 'references', $lang); ?>
      <?php if (!empty($ref)): ?>
        <blockquote class="about-card__quote" aria-label="<?= $lang === 'ar' ? 'المراجع' : 'References' ?>">
          <span class="about-card__quote-icon" aria-hidden="true">"</span>
          <p class="about-card__quote-text"><?= htmlspecialchars($ref, ENT_QUOTES, 'UTF-8') ?></p>
        </blockquote>
      <?php endif; ?>
    </div>
  </div>
</section>
<hr class="gold-divider container" aria-hidden="true">
<?php endif; ?>

<!-- ⑤ Expertise Areas — مجالات الخبرة -->
<?php if (!empty($data['skills'])): ?>
<section class="section" id="expertise" aria-labelledby="expertise-heading">
  <div class="container">
    <div class="section__header">
      <span class="section__eyebrow fade-in-up"><?= $lang === 'ar' ? 'ما أتقنه' : 'WHAT I DO' ?></span>
      <h2 class="section__title fade-in-up" id="expertise-heading">
        <?= $lang === 'ar' ? 'مجالات الخبرة' : 'Areas of Expertise' ?>
      </h2>
    </div>

    <div class="expertise-grid" role="list">
      <?php foreach ($data['skills'] as $idx => $skill): ?>
        <article class="gold-card expertise-card fade-in-up" role="listitem">
          <div class="expertise-card__icon" aria-hidden="true">
            <?= getExecExpertiseIcon($idx) ?>
          </div>
          <h3 class="expertise-card__name">
            <?= htmlspecialchars(BilingualHelper::get($skill, 'name', $lang), ENT_QUOTES, 'UTF-8') ?>
          </h3>
          <?php $desc = BilingualHelper::get($skill, 'description', $lang); ?>
          <?php if (!empty($desc)): ?>
            <p class="expertise-card__desc">
              <?= htmlspecialchars($desc, ENT_QUOTES, 'UTF-8') ?>
            </p>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<hr class="gold-divider container" aria-hidden="true">
<?php endif; ?>

<!-- ⑥ Key Achievements & Case Studies — الإنجازات الكبرى -->
<?php if (!empty($data['projects'])): ?>
<section class="section" id="achievements" aria-labelledby="achievements-heading">
  <div class="container">
    <div class="section__header">
      <span class="section__eyebrow fade-in-up"><?= $lang === 'ar' ? 'أثري' : 'IMPACT' ?></span>
      <h2 class="section__title fade-in-up" id="achievements-heading">
        <?= $lang === 'ar' ? 'الإنجازات والمشاريع الكبرى' : 'Key Achievements & Case Studies' ?>
      </h2>
    </div>

    <div class="achievements-grid" role="list">
      <?php foreach ($data['projects'] as $proj): ?>
        <?php
          $projTitle   = htmlspecialchars(BilingualHelper::get($proj, 'title', $lang), ENT_QUOTES, 'UTF-8');
          $projSummary = htmlspecialchars(BilingualHelper::get($proj, 'summary', $lang), ENT_QUOTES, 'UTF-8');
          $projType    = getProjectTypeLabel($proj['type'] ?? 'project', $lang);
          $coverUrl    = !empty($proj['cover_image'])
                         ? htmlspecialchars(BASE_URL . '/' . ltrim($proj['cover_image'], '/'), ENT_QUOTES, 'UTF-8')
                         : '';
          $hasDetail   = !empty($proj['body']) || !empty($proj['media']);
          $projLink    = !empty($proj['link']) ? htmlspecialchars($proj['link'], ENT_QUOTES, 'UTF-8') : '';
          $detailUrl   = htmlspecialchars(BASE_URL . '/' . $slug . '/projects/' . ($proj['slug'] ?? ''), ENT_QUOTES, 'UTF-8')
                         . ($lang === 'en' ? '?lang=en' : '');
        ?>
        <article class="gold-card achievement-card fade-in-up" role="listitem">
          <!-- Cover Image -->
          <div class="achievement-card__cover">
            <?php if ($coverUrl): ?>
              <img src="<?= $coverUrl ?>" alt="<?= $projTitle ?>" loading="lazy">
              <div class="achievement-card__cover-overlay" aria-hidden="true"></div>
            <?php endif; ?>
            <span class="achievement-card__badge"><?= htmlspecialchars($projType, ENT_QUOTES, 'UTF-8') ?></span>
          </div>

          <!-- Body -->
          <div class="achievement-card__body">
            <h3 class="achievement-card__title"><?= $projTitle ?></h3>
            <?php if (!empty($projSummary)): ?>
              <p class="achievement-card__summary"><?= $projSummary ?></p>
            <?php endif; ?>

            <!-- Metrics -->
            <?php if (!empty($proj['metric_1_value'])): ?>
              <div class="achievement-metrics" aria-label="<?= $lang === 'ar' ? 'مقاييس النجاح' : 'Success Metrics' ?>">
                <div class="metric">
                  <span class="metric__value"><?= htmlspecialchars($proj['metric_1_value'], ENT_QUOTES, 'UTF-8') ?></span>
                  <span class="metric__label"><?= htmlspecialchars(BilingualHelper::get($proj, 'metric_1_label', $lang), ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <?php if (!empty($proj['metric_2_value'])): ?>
                  <div class="metric">
                    <span class="metric__value"><?= htmlspecialchars($proj['metric_2_value'], ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="metric__label"><?= htmlspecialchars(BilingualHelper::get($proj, 'metric_2_label', $lang), ENT_QUOTES, 'UTF-8') ?></span>
                  </div>
                <?php endif; ?>
                <?php if (!empty($proj['metric_3_value'])): ?>
                  <div class="metric">
                    <span class="metric__value"><?= htmlspecialchars($proj['metric_3_value'], ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="metric__label"><?= htmlspecialchars(BilingualHelper::get($proj, 'metric_3_label', $lang), ENT_QUOTES, 'UTF-8') ?></span>
                  </div>
                <?php endif; ?>
              </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="achievement-card__actions">
              <?php if ($hasDetail): ?>
                <a href="<?= $detailUrl ?>" class="btn btn--gold-outline btn--sm" id="achievement-detail-<?= (int)($proj['id'] ?? 0) ?>">
                  <?= $lang === 'ar' ? 'التفاصيل الكاملة' : 'Full Details' ?>
                </a>
              <?php endif; ?>
              <?php if ($projLink): ?>
                <a href="<?= $projLink ?>" target="_blank" rel="noopener noreferrer" class="btn btn--ghost btn--sm">
                  <?= $lang === 'ar' ? 'الرابط المباشر ↗' : 'Direct Link ↗' ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<hr class="gold-divider container" aria-hidden="true">
<?php endif; ?>

<!-- ⑦ Career Journey — المسيرة المهنية -->
<?php if (!empty($data['experiences'])): ?>
<section class="section" id="journey" aria-labelledby="journey-heading">
  <div class="container">
    <div class="section__header">
      <span class="section__eyebrow fade-in-up"><?= $lang === 'ar' ? 'تاريخي المهني' : 'MY PATH' ?></span>
      <h2 class="section__title fade-in-up" id="journey-heading">
        <?= $lang === 'ar' ? 'المسيرة المهنية' : 'Career Journey' ?>
      </h2>
    </div>

    <div class="timeline" role="list">
      <?php foreach ($data['experiences'] as $exp): ?>
        <?php
          $pos     = htmlspecialchars(BilingualHelper::get($exp, 'position', $lang), ENT_QUOTES, 'UTF-8');
          $company = htmlspecialchars(BilingualHelper::get($exp, 'company', $lang), ENT_QUOTES, 'UTF-8');
          $desc    = BilingualHelper::get($exp, 'description', $lang);
          $start   = htmlspecialchars($exp['start_date'] ?? '', ENT_QUOTES, 'UTF-8');
          $end     = !empty($exp['end_date'])
                     ? htmlspecialchars($exp['end_date'], ENT_QUOTES, 'UTF-8')
                     : ($lang === 'ar' ? 'الآن' : 'Present');
        ?>
        <div class="timeline__item" role="listitem">
          <div class="timeline__dot" aria-hidden="true"></div>
          <div class="gold-card timeline__card">
            <div class="timeline__header">
              <div>
                <h3 class="timeline__position"><?= $pos ?></h3>
                <p class="timeline__company"><?= $company ?></p>
              </div>
              <?php if ($start): ?>
                <time class="timeline__period" datetime="<?= $start ?>">
                  <?= $start ?> &mdash; <?= $end ?>
                </time>
              <?php endif; ?>
            </div>
            <?php if (!empty($desc)): ?>
              <p class="timeline__desc">
                <?= nl2br(htmlspecialchars($desc, ENT_QUOTES, 'UTF-8')) ?>
              </p>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<hr class="gold-divider container" aria-hidden="true">
<?php endif; ?>

<!-- ⑧ Education & Executive Programs — التعليم -->
<?php if (!empty($data['education'])): ?>
<section class="section" id="education" aria-labelledby="education-heading">
  <div class="container">
    <div class="section__header">
      <span class="section__eyebrow fade-in-up"><?= $lang === 'ar' ? 'المؤهلات' : 'CREDENTIALS' ?></span>
      <h2 class="section__title fade-in-up" id="education-heading">
        <?= $lang === 'ar' ? 'التعليم والبرامج التنفيذية' : 'Education & Executive Programs' ?>
      </h2>
    </div>

    <div class="timeline timeline--edu" role="list">
      <?php foreach ($data['education'] as $edu): ?>
        <div class="timeline__item" role="listitem">
          <div class="timeline__dot" aria-hidden="true"></div>
          <div class="gold-card timeline__card">
            <div class="timeline__header">
              <div>
                <h3 class="timeline__degree">
                  <?= htmlspecialchars(BilingualHelper::get($edu, 'degree', $lang), ENT_QUOTES, 'UTF-8') ?>
                </h3>
                <p class="timeline__institution">
                  <?= htmlspecialchars(BilingualHelper::get($edu, 'institution', $lang), ENT_QUOTES, 'UTF-8') ?>
                </p>
              </div>
              <?php if (!empty($edu['year'])): ?>
                <span class="timeline__year"><?= htmlspecialchars($edu['year'], ENT_QUOTES, 'UTF-8') ?></span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<hr class="gold-divider container" aria-hidden="true">
<?php endif; ?>

<!-- ⑨ Professional Credentials — الشهادات المهنية -->
<?php if (!empty($data['certificates'])): ?>
<section class="section" id="certificates" aria-labelledby="certificates-heading">
  <div class="container">
    <div class="section__header">
      <span class="section__eyebrow fade-in-up"><?= $lang === 'ar' ? 'الاعتمادات' : 'ACCREDITATIONS' ?></span>
      <h2 class="section__title fade-in-up" id="certificates-heading">
        <?= $lang === 'ar' ? 'الاعتمادات المهنية' : 'Professional Credentials' ?>
      </h2>
    </div>

    <div class="certificates-list" role="list">
      <?php foreach ($data['certificates'] as $cert): ?>
        <?php
          $issuerInitial = mb_strtoupper(
            mb_substr(trim(BilingualHelper::get($cert, 'issuer', 'en') ?: 'C'), 0, 1, 'UTF-8'),
            'UTF-8'
          );
          $certTitle  = htmlspecialchars(BilingualHelper::get($cert, 'title', $lang), ENT_QUOTES, 'UTF-8');
          $certIssuer = htmlspecialchars(BilingualHelper::get($cert, 'issuer', $lang), ENT_QUOTES, 'UTF-8');
          $credUrl    = !empty($cert['credential_url']) ? htmlspecialchars($cert['credential_url'], ENT_QUOTES, 'UTF-8') : '';
          $fileUrl    = !empty($cert['file_url'])
                        ? htmlspecialchars(BASE_URL . '/' . ltrim($cert['file_url'], '/'), ENT_QUOTES, 'UTF-8')
                        : '';
        ?>
        <div class="gold-card cert-card fade-in-up" role="listitem">
          <div class="cert-card__left">
            <div class="cert-card__badge" aria-hidden="true"><?= $issuerInitial ?></div>
            <div>
              <h3 class="cert-card__title"><?= $certTitle ?></h3>
              <p class="cert-card__meta">
                <?= $certIssuer ?>
                <?php if (!empty($cert['year'])): ?>
                  &nbsp;&middot;&nbsp;<?= htmlspecialchars($cert['year'], ENT_QUOTES, 'UTF-8') ?>
                <?php endif; ?>
              </p>
            </div>
          </div>

          <div class="cert-card__actions">
            <?php if ($credUrl): ?>
              <a href="<?= $credUrl ?>" target="_blank" rel="noopener noreferrer"
                 class="btn btn--ghost btn--sm" id="cert-verify-<?= htmlspecialchars(md5($certTitle), ENT_QUOTES, 'UTF-8') ?>">
                <?= $lang === 'ar' ? 'تحقق رقمي ↗' : 'Verify ↗' ?>
              </a>
            <?php endif; ?>
            <?php if ($fileUrl): ?>
              <a href="<?= $fileUrl ?>" target="_blank" rel="noopener noreferrer"
                 class="btn btn--royal-outline btn--sm">
                <?= $lang === 'ar' ? 'عرض الشهادة' : 'View Cert' ?>
              </a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<hr class="gold-divider container" aria-hidden="true">
<?php endif; ?>

<!-- ⑩ Languages — اللغات -->
<?php if (!empty($data['languages'])): ?>
<section class="section" id="languages" aria-labelledby="languages-heading">
  <div class="container">
    <div class="section__header">
      <span class="section__eyebrow fade-in-up"><?= $lang === 'ar' ? 'التواصل' : 'COMMUNICATION' ?></span>
      <h2 class="section__title fade-in-up" id="languages-heading">
        <?= $lang === 'ar' ? 'اللغات' : 'Languages' ?>
      </h2>
    </div>

    <div class="languages-list fade-in-up" role="list">
      <?php foreach ($data['languages'] as $langObj): ?>
        <?php
          $lvlAr   = BilingualHelper::get($langObj, 'level', 'ar');
          $lvlEn   = BilingualHelper::get($langObj, 'level', 'en');
          $pillCls = getLangPillClass($lvlAr, $lvlEn);
          $langName  = htmlspecialchars(BilingualHelper::get($langObj, 'name', $lang), ENT_QUOTES, 'UTF-8');
          $langLevel = htmlspecialchars(BilingualHelper::get($langObj, 'level', $lang), ENT_QUOTES, 'UTF-8');
        ?>
        <div class="lang-pill <?= $pillCls ?>" role="listitem" aria-label="<?= $langName ?> — <?= $langLevel ?>">
          <span><?= $langName ?></span>
          <span class="lang-pill__divider" aria-hidden="true"></span>
          <span class="lang-pill__level"><?= $langLevel ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ⑪ Footer — التواصل والختام -->
<footer class="footer" id="contact" role="contentinfo">
  <div class="container">
    <h2 class="footer__name" id="contact-name"><?= $fullName ?></h2>
    <p class="footer__title"><?= $title ?></p>

    <!-- Social Links -->
    <?php if (!empty($data['social_links'])): ?>
      <nav class="footer__socials" aria-label="<?= $lang === 'ar' ? 'روابط التواصل' : 'Social Links' ?>">
        <?php foreach ($data['social_links'] as $sl): ?>
          <?php if (empty($sl['url'])) continue; ?>
          <?php
            $slUrl      = htmlspecialchars($sl['url'], ENT_QUOTES, 'UTF-8');
            $slPlatform = htmlspecialchars(ucfirst($sl['platform']), ENT_QUOTES, 'UTF-8');
            $isExternal = !str_starts_with($sl['url'], 'mailto:') && !str_starts_with($sl['url'], 'tel:');
          ?>
          <a href="<?= $slUrl ?>"
             <?= $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' ?>
             class="social-icon"
             aria-label="<?= $slPlatform ?>"
             id="social-<?= strtolower(htmlspecialchars($sl['platform'], ENT_QUOTES, 'UTF-8')) ?>-link">
            <?= getExecSocialIcon($sl['platform']) ?>
          </a>
        <?php endforeach; ?>
      </nav>
    <?php endif; ?>

    <hr class="gold-divider footer__divider" aria-hidden="true">

    <p class="footer__copy">
      &copy; <?= date('Y') ?> <?= $fullName ?>.
      <?= $lang === 'ar' ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' ?>
    </p>

    <?php $ref = BilingualHelper::get($data['profile'], 'references', $lang); ?>
    <?php if (!empty($ref)): ?>
      <p class="footer__references">"<?= htmlspecialchars($ref, ENT_QUOTES, 'UTF-8') ?>"</p>
    <?php endif; ?>
  </div>
</footer>

<script src="script.js"></script>
</body>
</html>
