<?php
use App\Services\BilingualHelper;

// Load profession configurations
$profession = $site['profession_type'] ?? 'developer';
if (file_exists(dirname(__DIR__, 3) . '/app/Config/ProfessionConfig.php')) {
    require_once dirname(__DIR__, 3) . '/app/Config/ProfessionConfig.php';
} else {
    require_once dirname(__DIR__, 4) . '/app/Config/ProfessionConfig.php';
}
$cssVars      = ProfessionConfig::getCssVariables($profession);
$labels       = ProfessionConfig::getLabels($profession, $lang);
$extraCss     = ProfessionConfig::getExtraCss($profession);

// Singular badge label logic
$type = $project['type'] ?? 'project';
$badgeLabel = '';
if ($type === 'research') {
    $badgeLabel = ($lang === 'en') ? 'Research / Publication' : 'بحث علمي / منشور';
} elseif ($type === 'case_study') {
    $badgeLabel = ($lang === 'en') ? 'Case Study' : 'دراسة حالة';
} else {
    switch ($profession) {
        case 'doctor':
        case 'pharmacist':
        case 'teacher':
            $badgeLabel = ($lang === 'en') ? 'Research / Publication' : 'بحث علمي / منشور';
            break;
        case 'lawyer':
            $badgeLabel = ($lang === 'en') ? 'Case / Achievement' : 'قضية / إنجاز قانوني';
            break;
        case 'executive':
            $badgeLabel = ($lang === 'en') ? 'Key Achievement' : 'إنجاز رئيسي';
            break;
        default:
            $badgeLabel = ($lang === 'en') ? 'Project' : 'مشروع';
            break;
    }
}

// Detail Title
switch ($profession) {
    case 'doctor':
    case 'pharmacist':
    case 'teacher':
        $detailsTitle = ($lang === 'en') ? 'Research Details' : 'تفاصيل البحث العلمي';
        break;
    case 'lawyer':
        $detailsTitle = ($lang === 'en') ? 'Case Details' : 'تفاصيل القضية';
        break;
    case 'executive':
        $detailsTitle = ($lang === 'en') ? 'Achievement Details' : 'تفاصيل الإنجاز';
        break;
    default:
        $detailsTitle = ($lang === 'en') ? 'Project Details' : 'تفاصيل المشروع';
        break;
}

// Adapt text & card styles for dark/light themes dynamically
$lightTextPrim = ($profession === 'doctor') ? '#0D1F3C' : '#1E293B';
$lightTextSec  = ($profession === 'doctor') ? '#4A6FA5' : '#475569';
$lightCardBg   = '#FFFFFF';
$lightCardBorder = ($profession === 'doctor') ? 'rgba(0, 102, 204, 0.1)' : 'rgba(0, 0, 0, 0.08)';
$lightDocCardBg = '#F8FAFC';

$darkTextPrim  = '#F8FAFC';
$darkTextSec   = '#94A3B8';
$darkCardBg    = ($profession === 'doctor') ? '#101f42' : ProfessionConfig::get($profession)['colors']['bg_secondary'];
$darkCardBorder = ($profession === 'doctor') ? 'rgba(0, 212, 255, 0.15)' : ProfessionConfig::get($profession)['colors']['border_color'];
$darkDocCardBg = ($profession === 'doctor') ? 'rgba(255, 255, 255, 0.03)' : ProfessionConfig::get($profession)['colors']['bg_primary'];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(BilingualHelper::get($project, 'title', $lang)) ?> - <?= htmlspecialchars(BilingualHelper::get($site, 'full_name', $lang)) ?></title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/templates/template-developer/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        // Apply theme immediately to prevent FOUC
        const savedTheme = localStorage.getItem('dev_cv_theme') || 'dark';
        if (savedTheme === 'light') {
            document.documentElement.classList.add('light-theme');
        }
    </script>
    <style>
        :root { <?= $cssVars ?> }
        <?= $extraCss ?>

        /* Dynamic Theme Adaptivity (Corrected colors for light/dark modes) */
        body:not(.light-theme) {
            --pd-bg-card: <?= $darkCardBg ?>;
            --pd-border-card: <?= $darkCardBorder ?>;
            --pd-text-title: <?= $darkTextPrim ?>;
            --pd-text-primary: <?= $darkTextPrim ?>;
            --pd-text-secondary: <?= $darkTextSec ?>;
            --pd-doc-card-bg: <?= $darkDocCardBg ?>;
        }

        body.light-theme {
            --pd-bg-card: <?= $lightCardBg ?>;
            --pd-border-card: <?= $lightCardBorder ?>;
            --pd-text-title: <?= $lightTextPrim ?>;
            --pd-text-primary: <?= $lightTextPrim ?>;
            --pd-text-secondary: <?= $lightTextSec ?>;
            --pd-doc-card-bg: <?= $lightDocCardBg ?>;
        }
        /* ===== PAGE WRAPPER ===== */
        .pd-wrapper {
            max-width: 1200px;
            margin: 100px auto 80px auto;
            padding: 0 24px;
        }

        /* ===== BACK BUTTON ===== */
        .pd-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 32px;
            padding: 10px 20px;
            border-radius: 50px;
            border: 1px solid var(--border-color);
            background: rgba(30, 41, 59, 0.3);
            backdrop-filter: blur(10px);
            font-size: 0.92rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .pd-back-btn:hover {
            color: #fff;
            border-color: var(--accent-glow);
            background: rgba(139, 92, 246, 0.1);
        }
        .pd-back-btn i {
            transition: transform 0.3s;
        }
        .pd-back-btn:hover i {
            transform: translateX(-4px);
        }
        [dir="rtl"] .pd-back-btn:hover i {
            transform: translateX(4px);
        }

        /* ===== HERO IMAGE SLIDER ===== */
        .pd-slider-section {
            position: relative;
            width: 100%;
            border-radius: 28px;
            overflow: hidden;
            margin-bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid var(--border-color);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
        }

        .pd-slider-viewport {
            position: relative;
            width: 100%;
            height: 520px;
            overflow: hidden;
            /* Force LTR so the flex track always flows left→right regardless of page dir */
            direction: ltr;
        }

        @media (max-width: 768px) {
            .pd-slider-viewport {
                height: 260px;
            }
        }

        .pd-slider-track {
            display: flex;
            height: 100%;
            width: 100%;
            /* Force LTR so translateX(-N*100%) always works correctly in RTL pages */
            direction: ltr;
            transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .pd-slide {
            min-width: 100%;
            width: 100%;
            height: 100%;
            position: relative;
            flex-shrink: 0;
            overflow: hidden;
        }

        .pd-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            /* Ensure image fills slide in all directions */
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        /* gradient overlay on slide */
        .pd-slide::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 50%;
            background: linear-gradient(to top, rgba(10, 15, 30, 0.85) 0%, transparent 100%);
            pointer-events: none;
        }

        /* single cover fallback */
        .pd-single-cover {
            width: 100%;
            height: 520px;
            object-fit: cover;
            display: block;
        }

        /* === Slider Navigation Arrows === */
        .pd-slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 20;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(255,255,255,0.15);
            color: #fff;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 8px 24px rgba(0,0,0,0.35);
            user-select: none;
        }
        .pd-slider-arrow:hover {
            background: var(--accent-glow);
            border-color: var(--accent-glow);
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 12px 28px rgba(139, 92, 246, 0.45);
        }
        .pd-slider-arrow.prev {
            left: 20px;
        }
        .pd-slider-arrow.next {
            right: 20px;
        }
        [dir="rtl"] .pd-slider-arrow.prev {
            left: auto;
            right: 20px;
        }
        [dir="rtl"] .pd-slider-arrow.next {
            right: auto;
            left: 20px;
        }

        /* === Slide counter badge === */
        .pd-slide-counter {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 20;
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.75);
            font-weight: 600;
            font-variant-numeric: tabular-nums;
        }
        [dir="rtl"] .pd-slide-counter {
            right: auto;
            left: 20px;
        }

        /* === Thumbnail Strip === */
        .pd-thumbnails {
            display: flex;
            gap: 10px;
            padding: 16px 20px;
            background: rgba(10, 15, 30, 0.7);
            backdrop-filter: blur(10px);
            overflow-x: auto;
            scrollbar-width: none;
            border-top: 1px solid rgba(255,255,255,0.06);
            justify-content: center;
        }
        .pd-thumbnails::-webkit-scrollbar { display: none; }

        .pd-thumb {
            width: 72px;
            height: 50px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            opacity: 0.55;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .pd-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s;
        }
        .pd-thumb:hover {
            opacity: 0.85;
            transform: translateY(-2px);
        }
        .pd-thumb.active {
            border-color: var(--accent-glow);
            opacity: 1;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
        }

        /* ===== GLASSMORPHIC INFO CARD ===== */
        .pd-info-card {
            margin-top: 28px;
            background: var(--pd-bg-card);
            border: 1px solid var(--pd-border-card);
            border-radius: 28px;
            padding: 44px 48px;
            backdrop-filter: blur(20px);
            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.35),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
            position: relative;
            overflow: hidden;
        }

        /* Decorative glow blob */
        .pd-info-card::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 280px;
            height: 280px;
            background: radial-gradient(circle, var(--pd-border-card) 0%, transparent 65%);
            pointer-events: none;
        }
        [dir="rtl"] .pd-info-card::before {
            right: auto;
            left: -80px;
        }

        .pd-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .pd-badge {
            background: rgba(255, 255, 255, 0.05);
            color: var(--accent-glow);
            border: 1px solid var(--accent-glow);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }
        .pd-badge i {
            font-size: 0.78rem;
        }

        .pd-title {
            font-size: 2.4rem;
            font-weight: 900;
            line-height: 1.2;
            color: var(--pd-text-title);
            margin-bottom: 18px;
        }
        /* Gradient background text overlay ONLY in dark theme */
        body:not(.light-theme) .pd-title {
            background: linear-gradient(135deg, #ffffff 0%, rgba(180, 200, 255, 0.7) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .pd-summary {
            font-size: 1.05rem;
            line-height: 1.8;
            color: var(--pd-text-secondary);
            margin-bottom: 32px;
            max-width: 820px;
        }

        /* Action Buttons Row */
        .pd-action-btns {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            align-items: center;
        }

        .pd-btn {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 13px 26px;
            border-radius: 14px;
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            border: none;
            white-space: nowrap;
        }
        .pd-btn-primary {
            background: linear-gradient(135deg, var(--accent-glow) 0%, var(--accent-glow-secondary) 100%);
            color: #fff;
            box-shadow: 0 8px 24px rgba(139, 92, 246, 0.3);
        }
        .pd-btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 14px 32px rgba(139, 92, 246, 0.5);
        }
        .pd-btn-secondary {
            background: var(--pd-doc-card-bg);
            color: var(--pd-text-primary);
            border: 1px solid var(--pd-border-card);
        }
        .pd-btn-secondary:hover {
            background: var(--pd-border-card);
            border-color: var(--pd-text-secondary);
            transform: translateY(-2px);
        }
        .pd-btn-pdf {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .pd-btn-pdf:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #ef4444;
            transform: translateY(-2px);
        }

        /* ===== DIVIDER ===== */
        .pd-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.1), transparent);
            margin: 40px 0;
        }

        /* ===== DESCRIPTION SECTION ===== */
        .pd-description-section {
            background: var(--pd-bg-card);
            border: 1px solid var(--pd-border-card);
            border-radius: 24px;
            padding: 44px 48px;
            backdrop-filter: blur(16px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            margin-bottom: 32px;
            margin-top: 40px; /* Space between title card and description card */
        }

        .pd-section-heading {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--pd-text-primary);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--pd-border-card);
        }
        .pd-section-heading .pd-heading-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--pd-border-card);
            border: 1px solid var(--pd-border-card);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.9rem;
            color: var(--accent-glow);
        }

        .pd-body-text {
            font-size: 1.05rem;
            line-height: 1.9;
            color: var(--pd-text-secondary);
            white-space: pre-wrap;
        }

        /* ===== PDF SECTION ===== */
        .pd-docs-section {
            background: var(--pd-bg-card);
            border: 1px solid var(--pd-border-card);
            border-radius: 24px;
            padding: 40px 48px;
            backdrop-filter: blur(16px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            margin-bottom: 32px;
        }

        .pd-docs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 16px;
        }

        .pd-doc-card {
            background: var(--pd-doc-card-bg);
            border: 1px solid var(--pd-border-card);
            border-radius: 16px;
            padding: 20px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
        }
        .pd-doc-card:hover {
            border-color: rgba(239, 68, 68, 0.4);
            background: rgba(239, 68, 68, 0.06);
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(239, 68, 68, 0.12);
        }
        .pd-doc-info {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }
        .pd-doc-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.2rem;
            color: #f87171;
        }
        .pd-doc-name {
            font-weight: 700;
            color: var(--pd-text-primary);
            font-size: 0.95rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .pd-doc-download {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(239, 68, 68, 0.12);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s;
            flex-shrink: 0;
        }
        .pd-doc-download:hover {
            background: #ef4444;
            color: #fff;
            border-color: #ef4444;
        }

        /* ===== LIGHTBOX ===== */
        .pd-lightbox {
            position: fixed;
            inset: 0;
            background: rgba(8, 12, 24, 0.97);
            backdrop-filter: blur(14px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            animation: pd-lb-fadein 0.25s ease;
        }
        @keyframes pd-lb-fadein {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .pd-lightbox.active {
            display: flex;
        }
        .pd-lightbox img {
            max-width: 92vw;
            max-height: 88vh;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 30px 80px rgba(0,0,0,0.6);
            animation: pd-lb-zoom 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes pd-lb-zoom {
            from { transform: scale(0.92); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .pd-lightbox-close {
            position: absolute;
            top: 24px;
            right: 24px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            color: #fff;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .pd-lightbox-close:hover {
            background: rgba(139, 92, 246, 0.25);
            border-color: var(--accent-glow);
            transform: rotate(90deg);
        }
        [dir="rtl"] .pd-lightbox-close {
            right: auto;
            left: 24px;
        }
        .pd-lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255,255,255,0.12);
            color: #fff;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .pd-lightbox-nav:hover {
            background: var(--accent-glow);
            border-color: var(--accent-glow);
        }
        .pd-lightbox-nav.prev { left: 24px; }
        .pd-lightbox-nav.next { right: 24px; }
        [dir="rtl"] .pd-lightbox-nav.prev { left: auto; right: 24px; }
        [dir="rtl"] .pd-lightbox-nav.next { right: auto; left: 24px; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .pd-title { font-size: 2rem; }
            .pd-info-card { padding: 32px 30px; }
            .pd-description-section { padding: 30px; }
            .pd-docs-section { padding: 30px; }
        }
        @media (max-width: 768px) {
            .pd-wrapper { margin-top: 80px; }
            .pd-title { font-size: 1.7rem; }
            .pd-info-card { padding: 26px 22px; }
            .pd-description-section { padding: 24px 20px; }
            .pd-docs-section { padding: 24px 20px; }
            .pd-docs-grid { grid-template-columns: 1fr; }
            .pd-slider-section { border-radius: 18px; }
            .pd-info-card { border-radius: 18px; }
            .pd-thumb { width: 56px; height: 40px; }
        }
    </style>
</head>
<body class="<?php echo isset($_COOKIE['dev_cv_theme']) && $_COOKIE['dev_cv_theme'] === 'light' ? 'light-theme' : ''; ?>">
    <script>
        if (localStorage.getItem('dev_cv_theme') === 'light') {
            document.body.classList.add('light-theme');
        }
    </script>

    <!-- Header Navbar -->
    <header class="navbar">
        <div class="nav-content">
            <a href="<?= BASE_URL ?>/<?= htmlspecialchars($site['slug']) ?>" class="logo"><?= htmlspecialchars(BilingualHelper::get($site, 'full_name', $lang)) ?></a>
            <div class="nav-links" style="display:flex; align-items:center; gap:12px;">
                <button id="themeToggleBtn" class="theme-btn" aria-label="Toggle Theme" style="border: 1px solid var(--border-color); background: rgba(255,255,255,0.05); color: var(--text-primary); cursor: pointer; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; transition: all 0.3s;">
                    <i class="fa-solid fa-moon"></i>
                </button>
                <a href="<?= BASE_URL ?>/<?= htmlspecialchars($site['slug']) ?>" class="lang-btn">
                    <?= $lang === 'en' ? 'Back to Site' : 'العودة للموقع' ?>
                </a>
            </div>
        </div>
    </header>

    <div class="pd-wrapper">

        <?php
            // Separate images and PDFs
            $images = array_values(array_filter($project['media'], fn($m) => $m['file_type'] === 'image'));
            $pdfs   = array_values(array_filter($project['media'], fn($m) => $m['file_type'] === 'pdf'));

            // Build all slide sources: start with cover image if present, then gallery images
            $allSlides = [];
            if (!empty($project['cover_image'])) {
                $covPath = BASE_URL . '/' . ltrim($project['cover_image'], '/');
                $covExt  = strtolower(pathinfo($covPath, PATHINFO_EXTENSION));
                if (!in_array($covExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) { $covPath .= '.jpg'; }
                $allSlides[] = ['url' => $covPath, 'caption' => ''];
            }
            foreach ($images as $img) {
                $imgUrl = BASE_URL . '/' . ltrim(htmlspecialchars($img['file_path']), '/');
                $imgExt = strtolower(pathinfo($imgUrl, PATHINFO_EXTENSION));
                if (!in_array($imgExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) { $imgUrl .= '.jpg'; }
                $allSlides[] = ['url' => $imgUrl, 'caption' => BilingualHelper::get($img, 'caption', $lang)];
            }
        ?>

        <!-- ===== HERO IMAGE SLIDER ===== -->
        <?php if (!empty($allSlides)): ?>
        <div class="pd-slider-section" id="pdSliderSection">

            <!-- Slide Viewport -->
            <div class="pd-slider-viewport" id="pdSliderViewport">
                <div class="pd-slider-track" id="pdSliderTrack">
                    <?php foreach ($allSlides as $slide): ?>
                    <div class="pd-slide">
                        <img src="<?= htmlspecialchars($slide['url']) ?>" alt="<?= htmlspecialchars($slide['caption']) ?>" loading="lazy">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Arrows (only show if more than 1 slide) -->
            <?php if (count($allSlides) > 1): ?>
            <button class="pd-slider-arrow prev" id="pdPrev" aria-label="Previous">
                <?= $dir === 'rtl' ? '<i class="fa-solid fa-chevron-right"></i>' : '<i class="fa-solid fa-chevron-left"></i>' ?>
            </button>
            <button class="pd-slider-arrow next" id="pdNext" aria-label="Next">
                <?= $dir === 'rtl' ? '<i class="fa-solid fa-chevron-left"></i>' : '<i class="fa-solid fa-chevron-right"></i>' ?>
            </button>

            <!-- Slide Counter -->
            <div class="pd-slide-counter" id="pdCounter">1 / <?= count($allSlides) ?></div>

            <!-- Thumbnail Strip -->
            <div class="pd-thumbnails" id="pdThumbnails">
                <?php foreach ($allSlides as $idx => $slide): ?>
                <div class="pd-thumb <?= $idx === 0 ? 'active' : '' ?>" data-idx="<?= $idx ?>" onclick="pdGoTo(<?= $idx ?>)">
                    <img src="<?= htmlspecialchars($slide['url']) ?>" alt="thumb" loading="lazy">
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
        <?php endif; ?>

        <!-- ===== GLASSMORPHIC INFO CARD ===== -->
        <div class="pd-info-card">
            <div class="pd-card-top">
                <span class="pd-badge">
                    <i class="fa-solid fa-layer-group"></i> <?= htmlspecialchars($badgeLabel) ?>
                </span>
            </div>

            <h1 class="pd-title"><?= htmlspecialchars(BilingualHelper::get($project, 'title', $lang)) ?></h1>

            <?php $summary = BilingualHelper::get($project, 'summary', $lang); if (!empty($summary)): ?>
            <p class="pd-summary"><?= htmlspecialchars($summary) ?></p>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="pd-action-btns">
                <?php if (!empty($project['link'])): ?>
                <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank" class="pd-btn pd-btn-primary">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <?= $lang === 'en' ? 'Live Demo' : 'معاينة مباشرة' ?>
                </a>
                <?php endif; ?>

                <?php if (!empty($project['github_link'])): ?>
                <a href="<?= htmlspecialchars($project['github_link']) ?>" target="_blank" class="pd-btn pd-btn-secondary">
                    <i class="fa-brands fa-github"></i>
                    <?= $lang === 'en' ? 'GitHub Repository' : 'مستودع الكود' ?>
                </a>
                <?php endif; ?>

                <?php if (!empty($pdfs)): ?>
                <a href="<?= BASE_URL . '/' . ltrim(htmlspecialchars($pdfs[0]['file_path']), '/') ?>" target="_blank" class="pd-btn pd-btn-pdf">
                    <i class="fa-solid fa-file-pdf"></i>
                    <?= $lang === 'en' ? 'View PDF' : 'عرض الملف' ?>
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- ===== PROJECT DESCRIPTION ===== -->
        <?php $body = BilingualHelper::get($project, 'body', $lang); if (!empty($body)): ?>
        <div class="pd-description-section">
            <h2 class="pd-section-heading">
                <span class="pd-heading-icon"><i class="fa-solid fa-align-left"></i></span>
                <?= htmlspecialchars($detailsTitle) ?>
            </h2>
            <div class="pd-body-text" style="direction: <?= $dir ?>; text-align: <?= $dir === 'rtl' ? 'right' : 'left' ?>;">
                <?= nl2br(htmlspecialchars($body)) ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- ===== PDF DOCUMENTS ===== -->
        <?php if (!empty($pdfs)): ?>
        <div class="pd-docs-section">
            <h2 class="pd-section-heading">
                <span class="pd-heading-icon" style="background: rgba(239,68,68,0.12); border-color: rgba(239,68,68,0.25); color: #f87171;">
                    <i class="fa-solid fa-paperclip"></i>
                </span>
                <?= $lang === 'en' ? 'Attached Documents' : 'الملفات المرفقة' ?>
            </h2>
            <div class="pd-docs-grid">
                <?php foreach ($pdfs as $pdf): ?>
                <?php $pdfUrl = BASE_URL . '/' . ltrim(htmlspecialchars($pdf['file_path']), '/'); ?>
                <div class="pd-doc-card">
                    <div class="pd-doc-info">
                        <div class="pd-doc-icon"><i class="fa-solid fa-file-pdf"></i></div>
                        <span class="pd-doc-name" style="direction: <?= $dir ?>;">
                            <?= htmlspecialchars(BilingualHelper::get($pdf, 'caption', $lang) ?: ($lang === 'en' ? 'Document Attachment' : 'وثيقة مرفقة')) ?>
                        </span>
                    </div>
                    <a href="<?= $pdfUrl ?>" target="_blank" class="pd-doc-download">
                        <i class="fa-solid fa-eye"></i>
                        <?= $lang === 'en' ? 'View' : 'عرض' ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div><!-- end pd-wrapper -->


    <!-- ===== LIGHTBOX ===== -->
    <div class="pd-lightbox" id="pdLightbox" onclick="pdCloseLightbox()">
        <button class="pd-lightbox-close" onclick="pdCloseLightbox()"><i class="fa-solid fa-xmark"></i></button>
        <button class="pd-lightbox-nav prev" id="pdLbPrev" onclick="event.stopPropagation(); pdLightboxNav(-1)">
            <?= $dir === 'rtl' ? '<i class="fa-solid fa-chevron-right"></i>' : '<i class="fa-solid fa-chevron-left"></i>' ?>
        </button>
        <img id="pdLightboxImg" src="" alt="" onclick="event.stopPropagation()">
        <button class="pd-lightbox-nav next" id="pdLbNext" onclick="event.stopPropagation(); pdLightboxNav(1)">
            <?= $dir === 'rtl' ? '<i class="fa-solid fa-chevron-left"></i>' : '<i class="fa-solid fa-chevron-right"></i>' ?>
        </button>
    </div>

    <script>
    (function() {

        /* ======= SLIDER ======= */
        const slides = <?= json_encode(array_values(array_map(fn($s) => $s['url'], $allSlides))) ?>;
        const totalSlides = slides.length;
        let currentIdx = 0;
        let autoTimer = null;

        const track   = document.getElementById('pdSliderTrack');
        const counter = document.getElementById('pdCounter');
        const thumbs  = document.querySelectorAll('.pd-thumb');

        function pdGoTo(idx) {
            if (totalSlides === 0) return;
            currentIdx = (idx + totalSlides) % totalSlides;
            if (track) track.style.transform = `translateX(-${currentIdx * 100}%)`;
            if (counter) counter.textContent = `${currentIdx + 1} / ${totalSlides}`;
            thumbs.forEach((t, i) => t.classList.toggle('active', i === currentIdx));
            // Scroll the active thumb into view
            if (thumbs[currentIdx]) {
                thumbs[currentIdx].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }

        // Expose globally for onclick
        window.pdGoTo = pdGoTo;

        const prevBtn = document.getElementById('pdPrev');
        const nextBtn = document.getElementById('pdNext');
        if (prevBtn) prevBtn.addEventListener('click', () => { pdGoTo(currentIdx - 1); resetAuto(); });
        if (nextBtn) nextBtn.addEventListener('click', () => { pdGoTo(currentIdx + 1); resetAuto(); });

        // Auto-slide
        function startAuto() {
            if (totalSlides <= 1) return;
            autoTimer = setInterval(() => pdGoTo(currentIdx + 1), 3000);
        }
        function resetAuto() {
            clearInterval(autoTimer);
            startAuto();
        }
        startAuto();

        // Pause on hover
        const section = document.getElementById('pdSliderSection');
        if (section) {
            section.addEventListener('mouseenter', () => clearInterval(autoTimer));
            section.addEventListener('mouseleave', startAuto);
        }

        // Keyboard navigation
        document.addEventListener('keydown', e => {
            if (e.key === 'ArrowLeft')  pdGoTo(currentIdx - 1);
            if (e.key === 'ArrowRight') pdGoTo(currentIdx + 1);
        });

        // Touch swipe support
        let touchStartX = 0;
        const viewport = document.getElementById('pdSliderViewport');
        if (viewport) {
            viewport.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; }, { passive: true });
            viewport.addEventListener('touchend', e => {
                const dx = e.changedTouches[0].clientX - touchStartX;
                if (Math.abs(dx) > 50) {
                    dx < 0 ? pdGoTo(currentIdx + 1) : pdGoTo(currentIdx - 1);
                    resetAuto();
                }
            });
        }

        /* ======= LIGHTBOX ======= */
        let lbIdx = 0;
        const lightbox = document.getElementById('pdLightbox');
        const lbImg    = document.getElementById('pdLightboxImg');

        // Open lightbox when clicking a slide image
        document.querySelectorAll('.pd-slide img').forEach((img, i) => {
            img.style.cursor = 'zoom-in';
            img.addEventListener('click', () => {
                lbIdx = i;
                pdOpenLightbox(slides[i]);
            });
        });

        function pdOpenLightbox(src) {
            if (lbImg) lbImg.src = src;
            if (lightbox) lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function pdCloseLightbox() {
            if (lightbox) lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }
        window.pdCloseLightbox = pdCloseLightbox;

        function pdLightboxNav(dir) {
            if (slides.length === 0) return;
            lbIdx = (lbIdx + dir + slides.length) % slides.length;
            if (lbImg) {
                lbImg.style.animation = 'none';
                lbImg.offsetHeight; // reflow
                lbImg.style.animation = '';
                lbImg.src = slides[lbIdx];
            }
        }
        window.pdLightboxNav = pdLightboxNav;

        // Also show nav in lightbox only if multiple images
        const lbPrev = document.getElementById('pdLbPrev');
        const lbNext = document.getElementById('pdLbNext');
        if (slides.length <= 1) {
            if (lbPrev) lbPrev.style.display = 'none';
            if (lbNext) lbNext.style.display = 'none';
        }

        document.addEventListener('keydown', e => {
            if (!lightbox || !lightbox.classList.contains('active')) return;
            if (e.key === 'Escape')      pdCloseLightbox();
            if (e.key === 'ArrowLeft')   pdLightboxNav(-1);
            if (e.key === 'ArrowRight')  pdLightboxNav(1);
        });

        // Theme switch support
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        if (themeToggleBtn) {
            const savedTheme = localStorage.getItem('dev_cv_theme') || 'dark';
            if (savedTheme === 'light') {
                themeToggleBtn.querySelector('i').className = 'fa-solid fa-sun';
            } else {
                themeToggleBtn.querySelector('i').className = 'fa-solid fa-moon';
            }

            themeToggleBtn.addEventListener('click', () => {
                document.body.classList.toggle('light-theme');
                const icon = themeToggleBtn.querySelector('i');
                if (document.body.classList.contains('light-theme')) {
                    icon.className = 'fa-solid fa-sun';
                    localStorage.setItem('dev_cv_theme', 'light');
                } else {
                    icon.className = 'fa-solid fa-moon';
                    localStorage.setItem('dev_cv_theme', 'dark');
                }
            });
        }

    })();
    </script>

</body>
</html>