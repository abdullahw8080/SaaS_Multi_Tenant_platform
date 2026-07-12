<?php
use App\Services\BilingualHelper;
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(BilingualHelper::get($project, 'title', $lang)) ?> - <?= htmlspecialchars(BilingualHelper::get($site, 'full_name', $lang)) ?></title>
    
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
            <a href="<?= BASE_URL ?>/<?= htmlspecialchars($site['slug']) ?>" class="logo"><?= htmlspecialchars(BilingualHelper::get($site, 'full_name', $lang)) ?></a>
            <div class="nav-links">
                <a href="<?= BASE_URL ?>/<?= htmlspecialchars($site['slug']) ?>" class="lang-btn">
                    <?= $lang === 'en' ? 'Back' : 'العودة للموقع' ?>
                </a>
            </div>
        </div>
    </header>

    <div class="detail-wrapper">
        <!-- Return Link -->
        <a href="<?= BASE_URL ?>/<?= htmlspecialchars($site['slug']) ?>" class="back-btn">
            <?php if ($lang === 'en'): ?>
                <i class="fa-solid fa-arrow-left"></i> Back to Portfolio
            <?php else: ?>
                <i class="fa-solid fa-arrow-right"></i> العودة للموقع الشخصي
            <?php endif; ?>
        </a>

        <!-- Header -->
        <div class="detail-header glass-card">
            <span class="project-type-badge">
                <?php
                    $type = $project['type'];
                    if ($lang === 'en') {
                        echo $type === 'research' ? 'Research' : ($type === 'case_study' ? 'Case Study' : 'Project');
                    } else {
                        echo $type === 'research' ? 'بحث علمي' : ($type === 'case_study' ? 'دراسة حالة' : 'مشروع');
                    }
                ?>
            </span>
            <h1 class="detail-title"><?= htmlspecialchars(BilingualHelper::get($project, 'title', $lang)) ?></h1>
            <p style="color: var(--text-secondary); font-size: 1rem; line-height: 1.6; margin-bottom: 20px;">
                <?= htmlspecialchars(BilingualHelper::get($project, 'summary', $lang)) ?>
            </p>

            <div class="project-meta-links">
                <?php if (!empty($project['link'])): ?>
                    <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank" class="meta-btn primary">
                        <i class="fa-solid fa-external-link"></i>
                        <?= $lang === 'en' ? 'Live Demo' : 'معاينة مباشرة' ?>
                    </a>
                <?php endif; ?>
                <?php if (!empty($project['github_link'])): ?>
                    <a href="<?= htmlspecialchars($project['github_link']) ?>" target="_blank" class="meta-btn secondary">
                        <i class="fa-brands fa-github"></i>
                        <?= $lang === 'en' ? 'GitHub Repository' : 'مستودع الكود' ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Cover Image -->
        <?php if (!empty($project['cover_image'])): ?>
            <div class="cover-image-container">
                <?php 
                    $coverUrl = BASE_URL . '/' . ltrim(htmlspecialchars($project['cover_image']), '/');
                    $coverExt = strtolower(pathinfo($coverUrl, PATHINFO_EXTENSION));
                    if (!in_array($coverExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                        $coverUrl .= '.jpg';
                    }
                ?>
                <img src="<?= $coverUrl ?>" alt="Cover Image">
            </div>
        <?php endif; ?>

        <!-- Detailed Body -->
        <div class="detail-body glass-card">
            <?= nl2br(htmlspecialchars(BilingualHelper::get($project, 'body', $lang))) ?>
        </div>

        <!-- Media Gallery (Images) -->
        <?php
            $images = array_filter($project['media'], fn($m) => $m['file_type'] === 'image');
            $pdfs = array_filter($project['media'], fn($m) => $m['file_type'] === 'pdf');
        ?>
        <?php if (!empty($images)): ?>
            <div class="gallery-section">
                <h2><?= $lang === 'en' ? 'Media Gallery' : 'معرض الصور' ?></h2>
                <div class="gallery-grid">
                    <?php foreach ($images as $img): ?>
                        <?php 
                            $imgUrl = BASE_URL . '/' . ltrim(htmlspecialchars($img['file_path']), '/');
                            $imgExt = strtolower(pathinfo($imgUrl, PATHINFO_EXTENSION));
                            if (!in_array($imgExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                                $imgUrl .= '.jpg';
                            }
                        ?>
                        <div class="gallery-card" onclick="openLightbox('<?= $imgUrl ?>')">
                            <img src="<?= $imgUrl ?>" alt="Gallery Media">
                            <?php if (!empty(BilingualHelper::get($img, 'caption', $lang))): ?>
                                <div class="gallery-caption">
                                    <?= htmlspecialchars(BilingualHelper::get($img, 'caption', $lang)) ?>
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
                <h2><?= $lang === 'en' ? 'Attached Documents (PDF)' : 'الملفات المرفقة (PDF)' ?></h2>
                <div>
                    <?php foreach ($pdfs as $pdf): ?>
                        <?php 
                            $pdfUrl = BASE_URL . '/' . ltrim(htmlspecialchars($pdf['file_path']), '/');
                        ?>
                        <div class="doc-item">
                            <div class="doc-name">
                                <i class="fa-solid fa-file-pdf" style="color:#ef4444; font-size:1.4rem;"></i>
                                <span><?= htmlspecialchars(BilingualHelper::get($pdf, 'caption', $lang) ?: ($lang === 'en' ? 'Document Attachment' : 'ملف وثيقة مرفق')) ?></span>
                            </div>
                            <a href="<?= $pdfUrl ?>" target="_blank" class="meta-btn secondary" style="padding: 6px 16px; font-size:0.8rem;">
                                <i class="fa-solid fa-download"></i> <?= $lang === 'en' ? 'Download' : 'تحميل' ?>
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
            const lightbox = document.getElementById('lightbox');
            const img = document.getElementById('lightbox-img');
            img.src = src;
            lightbox.style.display = 'flex';
        }
        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
        }
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeLightbox();
            }
        });
    </script>
</body>
</html>