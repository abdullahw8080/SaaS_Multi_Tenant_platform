<?php
use App\Services\BilingualHelper;
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(BilingualHelper::get($project, 'title', $lang)) ?> - <?= htmlspecialchars(BilingualHelper::get($site, 'full_name', $lang)) ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .detail-wrapper {
            max-width: 900px;
            margin: 60px auto;
            padding: 0 24px;
        }
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 30px;
            transition: var(--transition);
        }
        .back-btn:hover {
            color: var(--primary);
        }
        .detail-header {
            margin-bottom: 40px;
        }
        .project-type-badge {
            background: var(--primary-glow);
            color: var(--primary);
            border: 1px solid rgba(99, 102, 241, 0.2);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 16px;
        }
        .detail-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
        }
        .project-meta-links {
            display: flex;
            gap: 16px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .meta-btn {
            width: auto;
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        .cover-image-container {
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--border-color);
            margin-bottom: 40px;
            max-height: 480px;
        }
        .cover-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .detail-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-main);
            margin-bottom: 50px;
        }
        .detail-body p {
            margin-bottom: 20px;
        }
        .gallery-section h2, .docs-section h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 24px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-color);
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }
        .gallery-card {
            border-radius: var(--radius-md);
            overflow: hidden;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: var(--transition);
            background: var(--bg-card);
        }
        .gallery-card:hover {
            transform: scale(1.03);
            border-color: var(--primary);
        }
        .gallery-card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            display: block;
        }
        .gallery-caption {
            padding: 10px;
            font-size: 0.8rem;
            color: var(--text-muted);
            text-align: center;
        }
        .doc-item {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 16px 20px;
            border-radius: var(--radius-md);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            transition: var(--transition);
        }
        .doc-item:hover {
            border-color: var(--danger);
            background: rgba(239, 68, 68, 0.05);
        }
        .doc-name {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            color: var(--text-main);
        }
        
        /* Simple Lightbox */
        .lightbox {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 10000;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .lightbox img {
            max-width: 100%;
            max-height: 90vh;
            border-radius: var(--radius-md);
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
            animation: zoomIn 0.3s ease-out;
        }
        @keyframes zoomIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .lightbox-close {
            position: absolute;
            top: 24px; right: 24px;
            color: white;
            font-size: 2rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
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
        <div class="detail-header">
            <span class="project-type-badge">
                <?php
                    $type = $project['type'];
                    if ($lang === 'en') {
                        echo $type === 'research' ? 'Research Publication' : ($type === 'case_study' ? 'Case Study' : 'Project Portfolio');
                    } else {
                        echo $type === 'research' ? 'بحث علمي منشور' : ($type === 'case_study' ? 'دراسة حالة' : 'مشروع / عمل');
                    }
                ?>
            </span>
            <h1 class="detail-title"><?= htmlspecialchars(BilingualHelper::get($project, 'title', $lang)) ?></h1>
            <p style="color: var(--text-muted); font-size: 1.15rem;">
                <?= htmlspecialchars(BilingualHelper::get($project, 'summary', $lang)) ?>
            </p>

            <div class="project-meta-links">
                <?php if (!empty($project['link'])): ?>
                    <a href="<?= htmlspecialchars($project['link']) ?>" target="_blank" class="btn btn-primary meta-btn">
                        <i class="fa-solid fa-external-link"></i>
                        <?= $lang === 'en' ? 'Live Demo' : 'عرض المشروع المباشر' ?>
                    </a>
                <?php endif; ?>
                <?php if (!empty($project['github_link'])): ?>
                    <a href="<?= htmlspecialchars($project['github_link']) ?>" target="_blank" class="btn btn-secondary meta-btn">
                        <i class="fa-brands fa-github"></i>
                        <?= $lang === 'en' ? 'GitHub Repository' : 'مستودع الكود' ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Cover Image -->
        <?php if (!empty($project['cover_image'])): ?>
            <div class="cover-image-container">
                <img src="<?= BASE_URL . htmlspecialchars($project['cover_image']) ?>.jpg" alt="Cover Image">
            </div>
        <?php endif; ?>

        <!-- Detailed Body -->
        <div class="detail-body">
            <?= nl2br(htmlspecialchars(BilingualHelper::get($project, 'body', $lang))) ?>
        </div>

        <!-- Media Gallery (Images) -->
        <?php
            $images = array_filter($project['media'], fn($m) => $m['file_type'] === 'image');
            $pdfs = array_filter($project['media'], fn($m) => $m['file_type'] === 'pdf');
        ?>
        <?php if (!empty($images)): ?>
            <div class="gallery-section">
                <h2><?= $lang === 'en' ? 'Media Gallery' : 'معرض الصور والوسائط' ?></h2>
                <div class="gallery-grid">
                    <?php foreach ($images as $img): ?>
                        <div class="gallery-card" onclick="openLightbox('<?= BASE_URL . htmlspecialchars($img['file_path']) ?>.jpg')">
                            <img src="<?= BASE_URL . htmlspecialchars($img['file_path']) ?>.jpg" alt="Gallery Media">
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
                <h2><?= $lang === 'en' ? 'Attached Documents (PDF)' : 'الملفات والوثائق المرفقة (PDF)' ?></h2>
                <div>
                    <?php foreach ($pdfs as $pdf): ?>
                        <div class="doc-item">
                            <div class="doc-name">
                                <i class="fa-solid fa-file-pdf" style="color:#ef4444; font-size:1.4rem;"></i>
                                <span><?= htmlspecialchars(BilingualHelper::get($pdf, 'caption', $lang) ?: ($lang === 'en' ? 'Document Attachment' : 'ملف وثيقة مرفق')) ?></span>
                            </div>
                            <a href="<?= BASE_URL . htmlspecialchars($pdf['file_path']) ?>" target="_blank" class="btn btn-secondary" style="width:auto; padding: 6px 16px; font-size:0.8rem;">
                                <i class="fa-solid fa-download"></i> <?= $lang === 'en' ? 'Download PDF' : 'تحميل الملف' ?>
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
        // Escape key to close
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeLightbox();
            }
        });
    </script>
</body>
</html>
