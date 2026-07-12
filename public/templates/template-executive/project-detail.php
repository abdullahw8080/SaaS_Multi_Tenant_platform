<?php
/**
 * Executive Prestige Template — project-detail.php
 * Template: template-executive
 *
 * Variables provided by platform:
 *   $data    — full site data array
 *   $project — the matched project (by slug + site_id)
 *   $lang    — current language ('ar' | 'en')
 *   $dir     — direction ('rtl' | 'ltr')
 */

// ── Safety Check ──
if (!isset($data) || empty($data)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit('<h1>404</h1>');
}

use App\Services\BilingualHelper;

$lang = $_GET['lang'] ?? $data['site']['default_lang'] ?? 'ar';
if (!in_array($lang, ['ar', 'en'], true)) $lang = 'ar';
$dir  = ($lang === 'ar') ? 'rtl' : 'ltr';

// ── Resolve Project from slug if not already provided ──
if (!isset($project) || empty($project)) {
    $projectSlug = $_GET['project'] ?? '';
    $project = null;
    if (!empty($data['projects'])) {
        foreach ($data['projects'] as $p) {
            if (($p['slug'] ?? '') === $projectSlug) {
                $project = $p;
                break;
            }
        }
    }
}

// ── Authorization Check — must belong to this site ──
if (empty($project) || (isset($project['site_id']) && isset($data['site']['id']) && $project['site_id'] !== $data['site']['id'])) {
    http_response_code(404);
    exit('<h1>404 — الصفحة غير موجودة / Page Not Found</h1>');
}

// ── Profile Helpers ──
$fullName    = htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8');
$firstLetter = mb_strtoupper(mb_substr(trim(strip_tags($fullName)), 0, 1, 'UTF-8'), 'UTF-8');
$slug        = htmlspecialchars($data['site']['slug'] ?? '', ENT_QUOTES, 'UTF-8');
$baseUrl     = htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8');
$backUrl     = $baseUrl . '/' . $slug . ($lang === 'en' ? '?lang=en' : '');

// ── Project Helpers ──
$projTitle   = htmlspecialchars(BilingualHelper::get($project, 'title', $lang), ENT_QUOTES, 'UTF-8');
$projBody    = BilingualHelper::get($project, 'body', $lang);   // raw HTML — sanitized on input
$projType    = ($project['type'] ?? 'project') === 'case_study'
               ? ($lang === 'ar' ? 'دراسة حالة' : 'Case Study')
               : ($lang === 'ar' ? 'إنجاز استراتيجي' : 'Strategic Project');
$coverUrl    = !empty($project['cover_image'])
               ? htmlspecialchars(BASE_URL . '/' . ltrim($project['cover_image'], '/'), ENT_QUOTES, 'UTF-8')
               : '';
$projLink    = !empty($project['link']) ? htmlspecialchars($project['link'], ENT_QUOTES, 'UTF-8') : '';

$hasMetrics = !empty($project['metric_1_value']);
$hasMedia   = !empty($project['media']) && is_array($project['media']);

// ── Social Icon Helper (shared) ──
if (!function_exists('getExecSocialIcon')) {
    function getExecSocialIcon(string $platform): string {
        $p = strtolower(trim($platform));
        switch ($p) {
            case 'linkedin': return '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>';
            case 'email': case 'mail': return '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>';
            default: return '<svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>';
        }
    }
}

?><!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?= $projTitle ?> | <?= $fullName ?></title>
  <meta name="description" content="<?= htmlspecialchars(substr(strip_tags($projBody), 0, 160), ENT_QUOTES, 'UTF-8') ?>">
  <meta name="robots" content="index, follow">

  <!-- Open Graph -->
  <meta property="og:type"        content="article">
  <meta property="og:title"       content="<?= $projTitle ?> — <?= $fullName ?>">
  <meta property="og:description" content="<?= htmlspecialchars(substr(strip_tags($projBody), 0, 200), ENT_QUOTES, 'UTF-8') ?>">
  <?php if ($coverUrl): ?>
  <meta property="og:image"       content="<?= $coverUrl ?>">
  <?php endif; ?>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Playfair+Display:wght@400;700;900&family=Cairo:wght@300;400;600;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- JSON-LD -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": "<?= $projTitle ?>",
    "author": {"@type": "Person", "name": "<?= $fullName ?>"},
    "url": "<?= $baseUrl ?>/<?= $slug ?>/projects/<?= htmlspecialchars($project['slug'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
    <?php if ($coverUrl): ?>,"image": "<?= $coverUrl ?>"<?php endif; ?>
  }
  </script>

  <link rel="stylesheet" href="style.css">
</head>
<body class="exec-body project-detail-body">

<!-- Static Navbar with Back Link -->
<nav class="navbar exec-navbar--static" role="navigation" aria-label="Page navigation">
  <a href="<?= $backUrl ?>" class="btn btn--ghost" id="back-to-profile-btn" style="color: var(--color-gold); padding-inline-start: 0;">
    <?php if ($dir === 'rtl'): ?>
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
    <?php else: ?>
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
    <?php endif; ?>
    <?= $lang === 'ar' ? 'العودة للملف الشخصي' : 'Back to Profile' ?>
  </a>

  <div class="navbar__logo-mark" aria-hidden="true"><?= $firstLetter ?></div>
</nav>

<!-- Hero — Project Header -->
<header class="detail-hero" role="banner">
  <?php if ($coverUrl): ?>
    <div class="detail-hero__bg" aria-hidden="true">
      <img src="<?= $coverUrl ?>" alt="">
    </div>
  <?php endif; ?>

  <div class="detail-hero__content container">
    <span class="detail-hero__badge"><?= htmlspecialchars($projType, ENT_QUOTES, 'UTF-8') ?></span>
    <h1 class="detail-hero__title"><?= $projTitle ?></h1>
    <p class="detail-hero__author">
      <?= $fullName ?>
      <?php if (!empty($project['year'])): ?>
        &nbsp;&middot;&nbsp;<?= htmlspecialchars($project['year'], ENT_QUOTES, 'UTF-8') ?>
      <?php endif; ?>
    </p>
  </div>
</header>

<!-- Metrics Bar -->
<?php if ($hasMetrics): ?>
  <div class="metrics-bar" aria-label="<?= $lang === 'ar' ? 'مقاييس النجاح' : 'Success Metrics' ?>">
    <div class="gold-card metrics-bar__inner">
      <?php if (!empty($project['metric_1_value'])): ?>
        <div class="metrics-bar__item">
          <span class="metrics-bar__value"><?= htmlspecialchars($project['metric_1_value'], ENT_QUOTES, 'UTF-8') ?></span>
          <span class="metrics-bar__label"><?= htmlspecialchars(BilingualHelper::get($project, 'metric_1_label', $lang), ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      <?php endif; ?>
      <?php if (!empty($project['metric_2_value'])): ?>
        <div class="metrics-bar__item">
          <span class="metrics-bar__value"><?= htmlspecialchars($project['metric_2_value'], ENT_QUOTES, 'UTF-8') ?></span>
          <span class="metrics-bar__label"><?= htmlspecialchars(BilingualHelper::get($project, 'metric_2_label', $lang), ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      <?php endif; ?>
      <?php if (!empty($project['metric_3_value'])): ?>
        <div class="metrics-bar__item">
          <span class="metrics-bar__value"><?= htmlspecialchars($project['metric_3_value'], ENT_QUOTES, 'UTF-8') ?></span>
          <span class="metrics-bar__label"><?= htmlspecialchars(BilingualHelper::get($project, 'metric_3_label', $lang), ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>

<!-- Main Content -->
<main class="container detail-body-wrap" id="main-content">

  <article class="gold-card detail-article" aria-label="<?= $lang === 'ar' ? 'تفاصيل الإنجاز' : 'Achievement Details' ?>">

    <!-- Body HTML Content -->
    <?php if (!empty($projBody)): ?>
      <div class="exec-typography">
        <?= $projBody ?>
      </div>
    <?php endif; ?>

    <!-- Media Gallery -->
    <?php if ($hasMedia): ?>
      <?php
        $imageItems = [];
        $fileItems  = [];
        foreach ($project['media'] as $m) {
            if (empty($m['file_path'])) continue;
            $mUrl = BASE_URL . '/' . ltrim($m['file_path'], '/');
            $ext  = strtolower(pathinfo($mUrl, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'])) {
                $imageItems[] = $m + ['url' => $mUrl];
            } else {
                $fileItems[] = $m + ['url' => $mUrl];
            }
        }
      ?>

      <?php if (!empty($imageItems) || !empty($fileItems)): ?>
        <div class="media-section">
          <h2 class="media-section__title">
            <?= $lang === 'ar' ? 'المرفقات والوسائط' : 'Media & Attachments' ?>
          </h2>

          <!-- Image Grid with Lightbox -->
          <?php if (!empty($imageItems)): ?>
            <div class="media-grid" role="list">
              <?php foreach ($imageItems as $img): ?>
                <?php $safeUrl = htmlspecialchars($img['url'], ENT_QUOTES, 'UTF-8'); ?>
                <?php $captionText = htmlspecialchars(BilingualHelper::get($img, 'caption', $lang) ?: '', ENT_QUOTES, 'UTF-8'); ?>
                <div class="gallery-item"
                     data-src="<?= $safeUrl ?>"
                     role="listitem button"
                     tabindex="0"
                     aria-label="<?= $lang === 'ar' ? 'عرض الصورة: ' . $captionText : 'View image: ' . $captionText ?>">
                  <img src="<?= $safeUrl ?>"
                       alt="<?= $captionText ?>"
                       loading="lazy">
                  <div class="gallery-item__overlay" aria-hidden="true">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                      <path d="M1 1l22 22M17 17H3v-3a4 4 0 0 1 4-4h10M21 21V7a2 2 0 0 0-2-2H8"/>
                    </svg>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <!-- File Downloads -->
          <?php if (!empty($fileItems)): ?>
            <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 1.5rem;" role="list">
              <?php foreach ($fileItems as $file): ?>
                <?php $safeFileUrl = htmlspecialchars($file['url'], ENT_QUOTES, 'UTF-8'); ?>
                <?php $fileCaption = htmlspecialchars(BilingualHelper::get($file, 'caption', $lang) ?: ($lang === 'ar' ? 'تحميل الملف' : 'Download File'), ENT_QUOTES, 'UTF-8'); ?>
                <a href="<?= $safeFileUrl ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="btn btn--royal-outline"
                   role="listitem"
                   aria-label="<?= $fileCaption ?>">
                  <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                  <?= $fileCaption ?>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- External Project Link -->
    <?php if ($projLink): ?>
      <div style="margin-top: 3rem; text-align: center; padding-top: 2rem; border-top: 1px solid rgba(201,169,78,0.12);">
        <a href="<?= $projLink ?>" target="_blank" rel="noopener noreferrer"
           class="btn btn--gold" id="project-external-link">
          <?= $lang === 'ar' ? 'زيارة رابط المشروع ↗' : 'Visit Project Link ↗' ?>
        </a>
      </div>
    <?php endif; ?>

  </article>

  <!-- Back Button -->
  <div style="text-align: center; margin-top: 3rem;">
    <a href="<?= $backUrl ?>" class="btn btn--ghost" id="back-bottom-btn">
      <?php if ($dir === 'rtl'): ?>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
      <?php else: ?>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
      <?php endif; ?>
      <?= $lang === 'ar' ? 'العودة للملف الشخصي' : 'Back to Profile' ?>
    </a>
  </div>

</main>

<!-- Lightbox Modal -->
<div id="lightbox"
     class="lightbox-modal"
     style="display: none;"
     tabindex="-1"
     role="dialog"
     aria-modal="true"
     aria-label="<?= $lang === 'ar' ? 'عرض الصورة' : 'Image Viewer' ?>">
  <button class="lightbox-close" aria-label="<?= $lang === 'ar' ? 'إغلاق' : 'Close' ?>">&times;</button>
  <img id="lightbox-img" src="" alt="<?= $lang === 'ar' ? 'صورة مكبّرة' : 'Full size image' ?>">
</div>

<!-- Footer -->
<footer class="footer" role="contentinfo" style="margin-top: var(--space-3xl);">
  <div class="container">
    <!-- Social Links (if any) -->
    <?php if (!empty($data['social_links'])): ?>
      <nav class="footer__socials" style="margin-bottom: 2rem;"
           aria-label="<?= $lang === 'ar' ? 'روابط التواصل' : 'Social Links' ?>">
        <?php foreach ($data['social_links'] as $sl): ?>
          <?php if (empty($sl['url'])) continue; ?>
          <?php $isExt = !str_starts_with($sl['url'], 'mailto:') && !str_starts_with($sl['url'], 'tel:'); ?>
          <a href="<?= htmlspecialchars($sl['url'], ENT_QUOTES, 'UTF-8') ?>"
             <?= $isExt ? 'target="_blank" rel="noopener noreferrer"' : '' ?>
             class="social-icon"
             aria-label="<?= htmlspecialchars(ucfirst($sl['platform']), ENT_QUOTES, 'UTF-8') ?>">
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
  </div>
</footer>

<script src="script.js"></script>
</body>
</html>
