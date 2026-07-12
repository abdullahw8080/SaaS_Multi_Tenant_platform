<?php
if (!isset($project) || empty($project) || !isset($data) || $project['site_id'] != $data['site']['id']) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    echo "<h1>404 Not Found</h1><p>المشروع غير موجود أو غير تابع لهذا الطبيب.</p>";
    exit;
}

use App\Services\BilingualHelper;

$lang = $_GET['lang'] ?? $data['site']['default_lang'] ?? 'ar';
$dir  = ($lang === 'ar') ? 'rtl' : 'ltr';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') ?>" dir="<?= htmlspecialchars($dir, ENT_QUOTES, 'UTF-8') ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars(substr(BilingualHelper::get($project, 'summary', $lang), 0, 160), ENT_QUOTES, 'UTF-8') ?>">
  
  <!-- Open Graph -->
  <meta property="og:title" content="<?= htmlspecialchars(BilingualHelper::get($project, 'title', $lang), ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?>">
  <meta property="og:description" content="<?= htmlspecialchars(substr(BilingualHelper::get($project, 'summary', $lang), 0, 200), ENT_QUOTES, 'UTF-8') ?>">
  <?php if (!empty($project['cover_image'])): ?>
    <meta property="og:image" content="<?= htmlspecialchars(BASE_URL . '/' . ltrim($project['cover_image'], '/'), ENT_QUOTES, 'UTF-8') ?>">
  <?php endif; ?>
  <meta property="og:type" content="article">
  
  <title><?= htmlspecialchars(BilingualHelper::get($project, 'title', $lang), ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?></title>
  
  <!-- Preconnect Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
  
  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>/templates/template-doctor/style.css?v=<?= time() ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    .detail-wrapper {
      max-width: 900px;
      margin: 120px auto 60px auto;
      padding: 0 var(--space-md);
    }
    
    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: var(--space-sm);
      color: var(--color-primary);
      text-decoration: none;
      font-weight: 700;
      margin-bottom: var(--space-xl);
      transition: all var(--transition-fast);
      border: 1px solid var(--color-primary);
      padding: 10px 20px;
      border-radius: var(--radius-full);
      background: rgba(0, 212, 255, 0.03);
    }
    
    .back-btn:hover {
      background: rgba(0, 212, 255, 0.1);
      box-shadow: var(--glow-primary);
      transform: translateY(-2px);
    }
    
    .detail-hero {
      position: relative;
      border-radius: var(--radius-lg);
      overflow: hidden;
      margin-bottom: var(--space-2xl);
      min-height: 280px;
      display: flex;
      align-items: flex-end;
      padding: var(--space-xl);
      border: 1px solid var(--glass-border);
      background-size: cover;
      background-position: center;
    }
    
    .detail-hero__overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(5, 8, 15, 0.95) 20%, rgba(5, 8, 15, 0.4) 100%);
      z-index: 1;
    }
    
    .detail-hero__content {
      position: relative;
      z-index: 2;
      width: 100%;
    }
    
    .detail-hero__badge {
      display: inline-block;
      padding: 6px 14px;
      border-radius: var(--radius-full);
      font-size: 0.8rem;
      font-weight: 700;
      margin-bottom: var(--space-md);
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    
    .detail-hero__badge--research {
      background: var(--color-accent);
      color: var(--color-bg-deep);
    }
    
    .detail-hero__badge--case_study {
      background: var(--color-gold);
      color: var(--color-bg-deep);
    }
    
    .detail-hero__badge--project {
      background: var(--color-primary);
      color: var(--color-bg-deep);
    }
    
    .detail-hero__title {
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      font-weight: 800;
      line-height: 1.3;
      margin-bottom: var(--space-sm);
      color: #fff;
      font-family: var(--font-heading);
      letter-spacing: -1px;
    }
    
    .detail-hero__meta {
      font-size: 0.95rem;
      color: var(--color-text-muted);
      font-weight: 600;
    }
    
    .detail-body {
      padding: var(--space-2xl);
      font-size: 1.05rem;
      line-height: 1.8;
      color: var(--color-text-base);
      margin-bottom: var(--space-2xl);
    }
    
    .detail-body p {
      margin-bottom: var(--space-md);
    }
    
    /* Gallery Styling */
    .detail-gallery {
      margin-bottom: var(--space-2xl);
    }
    
    .detail-gallery h2, .detail-links h2 {
      font-size: 1.4rem;
      font-weight: 800;
      margin-bottom: var(--space-lg);
      font-family: var(--font-heading);
      color: #fff;
    }
    
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: var(--space-md);
    }
    
    .gallery-item {
      border-radius: var(--radius-md);
      overflow: hidden;
      border: 1px solid var(--glass-border);
      cursor: pointer;
      transition: all var(--transition-base);
      background: var(--color-bg-surface);
      position: relative;
    }
    
    .gallery-item:hover {
      transform: translateY(-4px);
      border-color: var(--color-primary);
      box-shadow: var(--glow-primary);
    }
    
    .gallery-item img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      display: block;
    }
    
    .gallery-caption {
      padding: var(--space-sm);
      font-size: 0.8rem;
      color: var(--color-text-muted);
      text-align: center;
      border-top: 1px solid var(--border-color);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .detail-links {
      display: flex;
      flex-direction: column;
      gap: var(--space-md);
      margin-top: var(--space-2xl);
    }
    
    .detail-links__buttons {
      display: flex;
      gap: var(--space-md);
      flex-wrap: wrap;
    }
    
    /* Lightbox Modal */
    .lightbox {
      display: none;
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(5, 8, 15, 0.95);
      z-index: 10000;
      align-items: center;
      justify-content: center;
      padding: var(--space-xl);
    }
    
    .lightbox__close {
      position: absolute;
      top: 30px;
      inset-inline-end: 30px;
      color: #fff;
      font-size: 2.2rem;
      background: transparent;
      border: none;
      cursor: pointer;
      z-index: 10010;
      transition: color var(--transition-fast);
    }
    
    .lightbox__close:hover {
      color: var(--color-primary);
    }
    
    .lightbox img {
      max-width: 90%;
      max-height: 80vh;
      border-radius: var(--radius-md);
      box-shadow: 0 0 30px rgba(0,0,0,0.8);
      border: 1px solid var(--glass-border);
      animation: zoomIn 0.3s ease-out;
    }
    
    @keyframes zoomIn {
      from { transform: scale(0.9); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }
    
    .lightbox__prev, .lightbox__next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(15, 32, 64, 0.5);
      border: 1px solid var(--glass-border);
      color: #fff;
      font-size: 2.5rem;
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      cursor: pointer;
      z-index: 10005;
      transition: all var(--transition-base);
    }
    
    .lightbox__prev:hover, .lightbox__next:hover {
      background: var(--color-primary);
      color: var(--color-bg-deep);
      box-shadow: var(--glow-primary);
      border-color: var(--color-primary);
    }
    
    .lightbox__prev { left: 30px; }
    .lightbox__next { right: 30px; }
    
    .back-link-wrapper {
      margin-top: var(--space-3xl);
      text-align: center;
      border-top: 1px solid var(--glass-border);
      padding-top: var(--space-2xl);
    }
    
    .back-link {
      color: var(--color-text-muted);
      text-decoration: none;
      font-weight: 700;
      transition: color var(--transition-fast);
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    
    .back-link:hover {
      color: var(--color-primary);
    }
  </style>
</head>
<body>

  <!-- Header Navbar -->
  <header class="navbar scrolled">
    <div class="nav-content">
      <a href="<?= htmlspecialchars(BASE_URL . '/' . $data['site']['slug'], ENT_QUOTES, 'UTF-8') ?>" class="navbar__logo">
        <svg width="24" height="24" viewBox="0 0 24 24"><path d="M19 10.5h-5.5V5c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v5.5H5c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5h5.5V19c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5v-5.5H19c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5z"/></svg>
        <span><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?></span>
      </a>
      <div class="navbar__links">
        <a href="<?= htmlspecialchars(BASE_URL . '/' . $data['site']['slug'], ENT_QUOTES, 'UTF-8') ?>" class="navbar__link">
          <?= $lang === 'ar' ? 'العودة للملف' : 'Back to Profile' ?>
        </a>
      </div>
    </div>
  </header>

  <div class="detail-wrapper">
    <!-- Return Button -->
    <a href="<?= htmlspecialchars(BASE_URL . '/' . $data['site']['slug'], ENT_QUOTES, 'UTF-8') ?>" class="back-btn">
      <?php if ($lang === 'en'): ?>
        <i class="fa-solid fa-arrow-left"></i> Back to Profile
      <?php else: ?>
        <i class="fa-solid fa-arrow-right"></i> العودة للملف الشخصي
      <?php endif; ?>
    </a>

    <!-- Small Hero -->
    <?php 
      $bgStyle = '';
      if (!empty($project['cover_image'])) {
          $coverUrl = BASE_URL . '/' . ltrim($project['cover_image'], '/');
          $coverExt = strtolower(pathinfo($coverUrl, PATHINFO_EXTENSION));
          if (!in_array($coverExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
              $coverUrl .= '.jpg';
          }
          $bgStyle = ' style="background-image: url(\'' . htmlspecialchars($coverUrl, ENT_QUOTES, 'UTF-8') . '\');"';
      }
    ?>
    <div class="detail-hero"<?= $bgStyle ?>>
      <div class="detail-hero__overlay"></div>
      <div class="detail-hero__content" data-aos="fade-up">
        <span class="detail-hero__badge detail-hero__badge--<?= htmlspecialchars($project['type'] ?? 'project', ENT_QUOTES, 'UTF-8') ?>">
          <?php
            $type = $project['type'] ?? 'project';
            if ($lang === 'ar') {
                echo $type === 'research' ? 'بحث علمي منشور' : ($type === 'case_study' ? 'دراسة حالة سريرية' : 'مشروع طبي');
            } else {
                echo $type === 'research' ? 'Research Publication' : ($type === 'case_study' ? 'Clinical Case Study' : 'Medical Project');
            }
          ?>
        </span>
        <h1 class="detail-hero__title"><?= htmlspecialchars(BilingualHelper::get($project, 'title', $lang), ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="detail-hero__meta">
          <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?>
          <?= !empty($project['year']) ? ' · ' . htmlspecialchars($project['year'], ENT_QUOTES, 'UTF-8') : '' ?>
        </p>
      </div>
    </div>

    <!-- Detailed Content -->
    <article class="detail-body glass-card fade-in-up">
      <?= BilingualHelper::get($project, 'body', $lang) ?>
    </article>

    <!-- Media Gallery & PDFs -->
    <?php
      $images = [];
      $pdfs = [];
      if (!empty($project['media'])) {
          $images = array_filter($project['media'], fn($m) => ($m['file_type'] ?? '') === 'image');
          $pdfs = array_filter($project['media'], fn($m) => ($m['file_type'] ?? '') === 'pdf');
      }
    ?>

    <?php if (!empty($images)): ?>
      <section class="detail-gallery" data-aos="fade-up">
        <h2><?= $lang === 'ar' ? 'معرض الوسائط التوضيحية' : 'Illustrative Media Gallery' ?></h2>
        <div class="gallery-grid">
          <?php foreach (array_values($images) as $index => $img): ?>
            <?php 
              $imgUrl = BASE_URL . '/' . ltrim($img['file_path'], '/');
              $imgExt = strtolower(pathinfo($imgUrl, PATHINFO_EXTENSION));
              if (!in_array($imgExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                  $imgUrl .= '.jpg';
              }
            ?>
            <div class="gallery-item" data-src="<?= htmlspecialchars($imgUrl, ENT_QUOTES, 'UTF-8') ?>" onclick="openLightbox(<?= (int)$index ?>)">
              <img src="<?= htmlspecialchars($imgUrl, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars(BilingualHelper::get($img, 'caption', $lang), ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
              <?php if (!empty(BilingualHelper::get($img, 'caption', $lang))): ?>
                <div class="gallery-caption">
                  <?= htmlspecialchars(BilingualHelper::get($img, 'caption', $lang), ENT_QUOTES, 'UTF-8') ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

    <!-- PDF Documents -->
    <?php if (!empty($pdfs)): ?>
      <section class="detail-gallery" data-aos="fade-up" style="margin-top: 40px;">
        <h2><?= $lang === 'ar' ? 'المستندات والتقارير الطبية المرفقة (PDF)' : 'Attached Medical Reports & PDFs' ?></h2>
        <div style="display: flex; flex-direction: column; gap: var(--space-sm);">
          <?php foreach ($pdfs as $pdf): ?>
            <?php 
              $pdfUrl = BASE_URL . '/' . ltrim($pdf['file_path'], '/');
            ?>
            <div class="glass-card" style="padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; border-radius: var(--radius-md) !important;">
              <span style="font-weight: 700; display: inline-flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-file-pdf" style="color: #ef4444; font-size: 1.3rem;"></i>
                <?= htmlspecialchars(BilingualHelper::get($pdf, 'caption', $lang) ?: ($lang === 'ar' ? 'مستند طبي مرفق' : 'Attached Report'), ENT_QUOTES, 'UTF-8') ?>
              </span>
              <a href="<?= htmlspecialchars($pdfUrl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn--pdf" style="padding: 8px 16px; font-size: 0.85rem; min-height: 38px;" rel="noopener noreferrer">
                <i class="fa-solid fa-download"></i> <?= $lang === 'ar' ? 'تحميل الملف' : 'Download PDF' ?>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endif; ?>

    <!-- External Links -->
    <?php if (!empty($project['link'])): ?>
      <div class="detail-links" data-aos="fade-up">
        <h2><?= $lang === 'ar' ? 'روابط ومراجع خارجية للبحث' : 'External Research Links & References' ?></h2>
        <div class="detail-links__buttons">
          <a href="<?= htmlspecialchars($project['link'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="btn btn--primary" rel="noopener noreferrer">
            <i class="fa-solid fa-link"></i> <?= $lang === 'ar' ? 'رابط البحث المباشر / DOI' : 'Research Link / DOI' ?>
          </a>
        </div>
      </div>
    <?php endif; ?>

    <div class="back-link-wrapper">
      <a href="<?= htmlspecialchars(BASE_URL . '/' . $data['site']['slug'], ENT_QUOTES, 'UTF-8') ?>" class="back-link">
        <?= $lang === 'ar' ? '← العودة لملف الطبيب الشخصي' : '← Back to Doctor Profile' ?>
      </a>
    </div>
  </div>

  <!-- Lightbox Modal -->
  <div id="lightbox" class="lightbox" role="dialog" aria-modal="true">
    <button class="lightbox__close" aria-label="Close" onclick="closeLightbox()">✕</button>
    <img id="lightbox-img" src="" alt="Lightbox View">
    <button class="lightbox__prev" aria-label="Previous" onclick="prevLightbox()">‹</button>
    <button class="lightbox__next" aria-label="Next" onclick="nextLightbox()">›</button>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <p class="copyright">&copy; <?= date('Y') ?> <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8') ?>. <?= $lang === 'ar' ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' ?></p>
  </footer>

  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    // Inject images list for Lightbox navigation
    const lightboxImages = [
      <?php foreach (array_values($images) as $img): ?>
        "<?= htmlspecialchars(BASE_URL . '/' . ltrim($img['file_path'], '/'), ENT_QUOTES, 'UTF-8') ?>",
      <?php endforeach; ?>
    ];
  </script>
  <script src="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>/templates/template-doctor/script.js?v=<?= time() ?>"></script>
</body>
</html>
<?php
// ✅ CHECKPOINT: template-doctor/project-detail.php — COMPLETE
// المرحلة: قالب الأطباء (Doctor Template)
// التالي: script.js
?>
