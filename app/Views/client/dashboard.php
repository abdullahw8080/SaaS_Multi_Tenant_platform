<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - تعديل بورتفوليو الخاص بك</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <style>
        /* Mobile-First Responsive Dark Theme */
        :root {
            --bg-dark: #0b0f19;
            --bg-card: #131826;
            --bg-input: #1a2030;
            --border-color: rgba(255, 255, 255, 0.08);
            --primary: #6366f1;
            --accent: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --transition: all 0.2s ease-in-out;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            margin: 0;
            font-family: 'Outfit', 'Cairo', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Navbar */
        .top-navbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .top-navbar .auth-logo {
            font-size: 1.5rem;
            margin: 0;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            text-decoration: none;
        }
        .nav-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .nav-actions .btn {
            padding: 8px 16px;
            font-size: 0.85rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition);
        }
        .btn-export { background: rgba(16, 185, 129, 0.1); color: var(--accent); }
        .btn-export:hover { background: var(--accent); color: white; }
        .btn-logout { background: transparent; border: 1px solid var(--border-color); color: var(--text-muted); }
        .btn-logout:hover { background: rgba(239, 68, 68, 0.1); color: var(--danger); border-color: rgba(239, 68, 68, 0.2); }
        .btn-save { background: rgba(99, 102, 241, 0.2); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); }
        .btn-save:hover { background: var(--primary); color: white; border-color: var(--primary); }

        /* Horizontal Scrollable Tabs */
        .mobile-tabs-container {
            background: rgba(11, 15, 25, 0.95);
            backdrop-filter: blur(10px);
            padding: 12px 24px;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 65px;
            z-index: 90;
            overflow-x: auto;
            white-space: nowrap;
            display: flex;
            gap: 8px;
            scrollbar-width: none;
        }
        .mobile-tabs-container::-webkit-scrollbar { display: none; }
        
        .tab-btn {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            padding: 8px 16px;
            font-family: inherit;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            border-radius: 20px;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .tab-btn:hover {
            color: var(--text-main);
            background: var(--bg-input);
        }
        .tab-btn.active {
            color: #fff;
            background: var(--primary);
            border: 1px solid var(--primary);
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
            font-weight: 700;
        }

        /* Main Content Container */
        .main-content {
            padding: 24px 16px;
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
        }

        /* Components */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
            gap: 16px;
            flex-wrap: wrap;
        }
        .dashboard-title-area h1 {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .dashboard-title-area p {
            color: var(--text-muted);
            margin-top: 0;
            font-size: 0.85rem;
        }
        
        .tab-content { display: none; animation: fadeIn 0.3s ease-out; }
        .tab-content.active { display: block; }
        
        .section-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
        }
        
        /* Form Inputs */
        .form-group { margin-bottom: 16px; }
        .form-label {
            font-size: 0.8rem;
            margin-bottom: 6px;
            color: var(--text-muted);
            display: block;
        }
        .form-input {
            width: 100%;
            padding: 10px 14px;
            font-size: 0.9rem;
            border-radius: 8px;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            color: var(--text-main);
            font-family: inherit;
            transition: var(--transition);
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }
        
        /* Dynamic Row Layouts */
        .dynamic-row {
            background: rgba(26, 32, 48, 0.4);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 16px;
            position: relative;
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .remove-row-btn {
            position: absolute;
            top: 16px; left: 16px;
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
            width: 32px; height: 32px;
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.85rem;
        }
        .remove-row-btn:hover { background: var(--danger); color: white; }
        
        .add-row-btn {
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent);
            border: 1px dashed rgba(16, 185, 129, 0.3);
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            margin-top: 10px;
            font-size: 0.9rem;
            width: 100%;
            justify-content: center;
        }
        .add-row-btn:hover { background: rgba(16, 185, 129, 0.2); border-color: var(--accent); }
        
        /* Language Tabs */
        .lang-tabs {
            display: flex;
            gap: 4px;
            margin-bottom: 16px;
            background: rgba(0,0,0,0.2);
            padding: 4px;
            border-radius: 8px;
            width: fit-content;
        }
        .lang-tab-btn {
            border: none;
            background: transparent;
            color: var(--text-muted);
            padding: 8px 16px;
            font-size: 0.85rem;
            cursor: pointer;
            font-weight: 600;
            border-radius: 6px;
        }
        .lang-tab-btn.active {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }
        .lang-field-group { display: none; }
        .lang-field-group.active { display: block; }
        
        /* Status Banner */
        .status-banner {
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            font-size: 0.85rem;
            flex-wrap: wrap;
        }
        .status-banner strong { font-size: 0.9rem; }
        .status-banner-approved { background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: var(--accent); }
        .status-banner-under_review { background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.2); color: var(--primary); }
        .status-banner-rejected { background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: var(--danger); }
        .status-banner-draft { background: rgba(55, 65, 81, 0.2); border: 1px solid var(--border-color); color: var(--text-muted); }
        
        /* Media Queries for Mobile Responsiveness */
        @media (max-width: 768px) {
            .grid-2, .grid-3 { grid-template-columns: 1fr !important; }
            .section-card { padding: 16px; }
            .dynamic-row { padding: 16px 12px; }
            .top-navbar { padding: 12px 16px; flex-wrap: wrap; gap: 12px;}
            .mobile-tabs-container { top: auto; position: relative; padding: 12px 16px;}
            .impersonation-banner { flex-direction: column; align-items: flex-start; gap: 10px; }
            .status-banner { flex-direction: column; align-items: flex-start; }
            .nav-actions { width: 100%; justify-content: space-between; }
        }
        
        .impersonation-banner {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            padding: 12px 20px;
            font-weight: 600;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(245, 158, 11, 0.3);
            font-size: 0.85rem;
        }
        .impersonation-banner a.btn {
            background: #f59e0b;
            color: #0b0f19;
            padding: 8px 16px;
            font-size: 0.8rem;
            font-weight: 700;
            border: none;
            border-radius: 6px;
            text-decoration: none;
        }
    
        /* Required / Optional Badges using Modern CSS :has() */
        .form-group:has(input[required], select[required], textarea[required]) .form-label::after {
            content: " (إجباري)";
            color: var(--danger);
            font-size: 0.75rem;
            margin-right: 6px;
            font-weight: 600;
        }
        .form-group:not(:has(input[required], select[required], textarea[required])) .form-label:not(.no-badge)::after {
            content: " (اختياري)";
            color: var(--text-muted);
            font-size: 0.75rem;
            margin-right: 6px;
            font-weight: normal;
        }
        
        /* English Labels */
        .form-group:has(input[required], select[required], textarea[required]) .form-label.ltr::after {
            content: " (Required)";
            margin-right: 0;
            margin-left: 6px;
        }
        .form-group:not(:has(input[required], select[required], textarea[required])) .form-label.ltr:not(.no-badge)::after {
            content: " (Optional)";
            margin-right: 0;
            margin-left: 6px;
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <div class="top-navbar">
        <a href="<?= BASE_URL ?>/dashboard" class="auth-logo">بورتفوليو Hub</a>
        <div class="nav-actions">
            <button type="submit" form="dashboardForm" class="btn btn-save" style="cursor: pointer; font-family: inherit;">
                <i class="fa-solid fa-floppy-disk"></i> <span>حفظ</span>
            </button>
            <?php if (\App\Core\Auth::role() === 'admin' || !empty($_SESSION['admin_user_id'])): ?>
                <a href="<?= BASE_URL ?>/dashboard/export" class="btn btn-export">
                    <i class="fa-solid fa-file-zipper"></i> <span class="hide-mobile">تصدير ZIP</span>
                </a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/logout" class="btn btn-logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> <span class="hide-mobile">خروج</span>
            </a>
        </div>
    </div>

    <!-- Horizontal Scrollable Tabs Menu -->
    <?php
    $sectionVisible = [];
    $sectionTitles = [];
    foreach ($siteData['sections'] as $sec) {
        $sectionVisible[$sec['type_key']] = (bool)$sec['is_visible'];
        $sectionTitles[$sec['type_key']] = $sec['title'];
    }
    ?>
    <div class="mobile-tabs-container">
        <button class="tab-btn active" onclick="showTab('tab-profile', this)">
            <i class="fa-solid fa-user"></i> الشخصية
        </button>
        <button class="tab-btn" onclick="showTab('tab-sections', this)">
            <i class="fa-solid fa-shapes"></i> الأقسام
        </button>
        <button class="tab-btn" onclick="showTab('tab-social', this)">
            <i class="fa-solid fa-share-nodes"></i> التواصل
        </button>
        <?php if ($sectionVisible['skills'] ?? true): ?>
            <button class="tab-btn" onclick="showTab('tab-skills', this)">
                <i class="fa-solid fa-code"></i> <?= htmlspecialchars($sectionTitles['skills'] ?? 'المهارات') ?>
            </button>
        <?php endif; ?>
        <?php if ($sectionVisible['experiences'] ?? true): ?>
            <button class="tab-btn" onclick="showTab('tab-experiences', this)">
                <i class="fa-solid fa-history"></i> <?= htmlspecialchars($sectionTitles['experiences'] ?? 'الخبرات') ?>
            </button>
        <?php endif; ?>
        <?php if ($sectionVisible['education'] ?? true): ?>
            <button class="tab-btn" onclick="showTab('tab-education', this)">
                <i class="fa-solid fa-graduation-cap"></i> <?= htmlspecialchars($sectionTitles['education'] ?? 'التعليم') ?>
            </button>
        <?php endif; ?>
        <?php if ($sectionVisible['certificates'] ?? true): ?>
            <button class="tab-btn" onclick="showTab('tab-certificates', this)">
                <i class="fa-solid fa-certificate"></i> <?= htmlspecialchars($sectionTitles['certificates'] ?? 'الشهادات') ?>
            </button>
        <?php endif; ?>
        <?php if ($sectionVisible['projects'] ?? true): ?>
            <button class="tab-btn" onclick="showTab('tab-projects', this)">
                <i class="fa-solid fa-briefcase"></i> <?= htmlspecialchars($sectionTitles['projects'] ?? 'المشاريع') ?>
            </button>
        <?php endif; ?>
        <?php if ($sectionVisible['languages'] ?? true): ?>
            <button class="tab-btn" onclick="showTab('tab-languages', this)">
                <i class="fa-solid fa-language"></i> <?= htmlspecialchars($sectionTitles['languages'] ?? 'اللغات') ?>
            </button>
        <?php endif; ?>
        <?php if ($sectionVisible['references'] ?? true): ?>
            <button class="tab-btn" onclick="showTab('tab-references', this)">
                <i class="fa-solid fa-user-check"></i> <?= htmlspecialchars($sectionTitles['references'] ?? 'المراجع') ?>
            </button>
        <?php endif; ?>
    </div>

    <div class="main-content">
            
            <?php if (!empty($_SESSION['admin_user_id'])): ?>
                <div class="impersonation-banner">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <i class="fa-solid fa-user-shield" style="font-size:1.1rem;"></i>
                        <span>أنت تتصفح وتعدل بيانات هذا العميل بصفتك مديراً للمنصة.</span>
                    </div>
                    <a href="<?= BASE_URL ?>/admin/stop-impersonating" class="btn">
                        العودة للإدارة <i class="fa-solid fa-arrow-left-long"></i>
                    </a>
                </div>
            <?php endif; ?>
            
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <div class="dashboard-title-area">
                    <h1>تعديل محتوى موقعك</h1>
                    <p>رابط موقعك الحالي: 
                        <a href="<?= BASE_URL ?>/<?= htmlspecialchars($siteData['site']['slug']) ?>" target="_blank" style="color: var(--primary); font-weight: 600; text-decoration: none;">
                            /<?= htmlspecialchars($siteData['site']['slug']) ?> <i class="fa-solid fa-external-link" style="font-size:0.8rem"></i>
                        </a>
                    </p>
                </div>
                <div>
                    <a href="<?= BASE_URL ?>/<?= htmlspecialchars($siteData['site']['slug']) ?>" target="_blank" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.875rem;">
                        <i class="fa-solid fa-eye"></i> عرض المعاينة
                    </a>
                </div>
            </div>

            <!-- Approval Status Banner -->
            <?php
                $status = $siteData['site']['approval_status'];
                $bannerClass = 'status-banner-' . $status;
                $statusText = '';
                switch ($status) {
                    case 'approved': $statusText = 'موقعك منشور للعامة ونشط حالياً.'; break;
                    case 'under_review': $statusText = 'موقعك قيد المراجعة حالياً من قبل الإدارة. التغييرات الجديدة ستبقى مخفية حتى إقرارها.'; break;
                    case 'rejected': $statusText = 'تم رفض موقعك. يرجى مراجعة الملاحظات وتعديلها وإرسالها للمراجعة مجدداً.'; break;
                    case 'pending': $statusText = 'حسابك مسجل. يرجى إدخال بياناتك بالكامل ثم إرسال الموقع للموافقة عليه.'; break;
                    default: $statusText = 'موقعك مسودة حالياً وغير مرئي للعامة.';
                }
            ?>
            <div class="status-banner <?= $bannerClass ?>">
                <div>
                    <strong><i class="fa-solid fa-circle-info"></i> حالة الموقع:</strong> <?= $statusText ?>
                    <?php if ($status === 'rejected' && !empty($siteData['site']['rejection_reason'])): ?>
                        <div style="margin-top: 10px; font-size: 0.9rem; background: rgba(0,0,0,0.2); padding: 12px; border-radius: var(--radius-sm);">
                            <strong>سبب الرفض:</strong> <?= htmlspecialchars($siteData['site']['rejection_reason']) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (in_array($status, ['draft', 'pending', 'rejected'])): ?>
                    <form action="<?= BASE_URL ?>/dashboard/submit-review" method="POST" class="inline-form">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                        <button type="submit" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.875rem; background-color: var(--accent);">
                            إرسال للمراجعة والنشر <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Flash Messages -->
            <?php if (!empty($_SESSION['flash_success'])): ?>
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></span>
                </div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['flash_error'])): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></span>
                </div>
            <?php endif; ?>

            <!-- Global Form -->
            <form id="dashboardForm" action="<?= BASE_URL ?>/dashboard/save" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <input type="hidden" name="approval_status" value="<?= htmlspecialchars($status) ?>">

                <!-- TAB: Personal Information -->
                <div id="tab-profile" class="tab-content active section-card">
                    <div class="section-title"><i class="fa-solid fa-user" style="color:var(--primary)"></i> المعلومات الشخصية</div>
                    
                    <div class="lang-tabs">
                        <button type="button" class="lang-tab-btn active" onclick="switchLangTab(this, 'profile-ar')">العربية</button>
                        <button type="button" class="lang-tab-btn" onclick="switchLangTab(this, 'profile-en')">English</button>
                    </div>

                    <!-- Arabic Fields -->
                    <div id="profile-ar" class="lang-field-group active">
                        <div class="form-group">
                            <label class="form-label">الاسم الكامل (سيظهر كعنوان رئيسي وشخصي في موقعك)</label>
                            <input type="text" name="profile[full_name]" class="form-input" value="<?= htmlspecialchars($siteData['profile']['full_name'] ?? '') ?>" placeholder="مثال: د. باسم علي الشريف، م. أحمد الحربي" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">المسمى المهني / الاختصاص الدقيق</label>
                            <input type="text" name="profile[title]" class="form-input" value="<?= htmlspecialchars($siteData['profile']['title'] ?? '') ?>" placeholder="مثال: استشاري جراحة العظام، مهندس مدني، مطور تطبيقات ويب، مستشار قانوني">
                            <small style="color: var(--text-muted); display: block; margin-top: 4px; font-size: 0.8rem;">يحدد تخصصك الفرعي أو لقبك المهني بدقة ليظهر تحت اسمك مباشرة.</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">نبذة تعريفية شاملة (Bio)</label>
                            <textarea name="profile[bio]" class="form-input" rows="4" placeholder="اكتب نبذة مهنية تلخص مسيرتك وخبراتك وتناسب تخصصك..."><?= htmlspecialchars($siteData['profile']['bio'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- English Fields -->
                    <div id="profile-en" class="lang-field-group">
                        <div class="form-group">
                            <label class="form-label ltr">Full Name (English)</label>
                            <input type="text" name="profile[full_name_en]" class="form-input ltr" value="<?= htmlspecialchars($siteData['profile']['full_name_en'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Job Title / Specialty (English)</label>
                            <input type="text" name="profile[title_en]" class="form-input ltr" value="<?= htmlspecialchars($siteData['profile']['title_en'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Bio (English)</label>
                            <textarea name="profile[bio_en]" class="form-input ltr"><?= htmlspecialchars($siteData['profile']['bio_en'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label no-badge">الصورة الشخصية</label>
                            <?php if (!empty($siteData['profile']['photo'])): ?>
                                <?php $profilePhotoSrc = BASE_URL . '/' . ltrim(htmlspecialchars($siteData['profile']['photo']), '/') . '.jpg'; ?>
                                <input type="hidden" name="profile[existing_photo]" id="existing_profile_photo" value="<?= htmlspecialchars($siteData['profile']['photo']) ?>">
                                <!-- Current photo preview -->
                                <div id="profile-photo-preview-box" style="margin-top: 10px; display: flex; align-items: center; gap: 14px; background: rgba(0,0,0,0.2); padding: 12px; border-radius: 10px; border: 1px solid var(--border-color);">
                                    <img id="profile-photo-img" src="<?= $profilePhotoSrc ?>" style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary); flex-shrink:0;" onerror="this.src='<?= BASE_URL . '/' . ltrim(htmlspecialchars($siteData['profile']['photo']), '/') ?>.webp'; this.onerror=null;">
                                    <div style="display:flex; flex-direction:column; gap:8px;">
                                        <span style="font-size:0.85rem; font-weight:600; color:var(--text-main)"><i class="fa-solid fa-circle-check" style="color:var(--accent)"></i> الصورة الشخصية الحالية</span>
                                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                            <label for="profile_photo" style="font-size:0.75rem; color:var(--primary); cursor:pointer; background:rgba(99,102,241,0.1); padding:5px 12px; border-radius:5px; border:1px solid rgba(99,102,241,0.3); display:inline-flex; align-items:center; gap:5px;">
                                                <i class="fa-solid fa-cloud-arrow-up"></i> تبديل الصورة
                                            </label>
                                            <button type="button" onclick="deleteProfilePhoto()" style="font-size:0.75rem; color:var(--danger); cursor:pointer; background:rgba(239,68,68,0.1); padding:5px 12px; border-radius:5px; border:1px solid rgba(239,68,68,0.3); display:inline-flex; align-items:center; gap:5px;">
                                                <i class="fa-solid fa-trash"></i> حذف الصورة
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <input type="file" id="profile_photo" name="profile_photo" class="form-input" accept="image/*" style="height: auto; margin-top: 8px; display:none;" onchange="previewProfilePhoto(this)">
                            <?php else: ?>
                                <!-- No photo yet -->
                                <div style="margin-top:10px;">
                                    <label for="profile_photo" style="display:flex; flex-direction:column; align-items:center; gap:10px; background:rgba(99,102,241,0.05); border:2px dashed rgba(99,102,241,0.3); border-radius:10px; padding:20px; cursor:pointer; text-align:center;" id="profile-photo-dropzone">
                                        <div id="profile-photo-preview-icon" style="width:72px; height:72px; border-radius:50%; background:rgba(99,102,241,0.1); display:flex; align-items:center; justify-content:center; font-size:2rem; color:var(--primary);">
                                            <i class="fa-solid fa-user-circle"></i>
                                        </div>
                                        <span style="font-size:0.85rem; color:var(--text-muted)"><i class="fa-solid fa-cloud-arrow-up" style="color:var(--primary)"></i> انقر لاختيار صورة شخصية</span>
                                        <span style="font-size:0.75rem; color:var(--text-muted)">JPG, PNG, WEBP — بحد أقصى 10 ميجابايت</span>
                                    </label>
                                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display:none;" onchange="previewProfilePhoto(this)">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label class="form-label no-badge">إعدادات اللغة للموقع</label>
                            <div style="display: flex; gap: 20px; align-items: center; margin-top: 12px;">
                                <label style="display: flex; align-items: center; gap: 8px;">
                                    <input type="radio" name="default_lang" value="ar" <?= $siteData['site']['default_lang'] === 'ar' ? 'checked' : '' ?>> العربية كلغة افتراضية
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px;">
                                    <input type="radio" name="default_lang" value="en" <?= $siteData['site']['default_lang'] === 'en' ? 'checked' : '' ?>> English by default
                                </label>
                            </div>
                            <div style="margin-top: 15px;">
                                <label style="display: flex; align-items: center; gap: 8px;">
                                    <input type="checkbox" name="is_bilingual" value="1" <?= $siteData['site']['is_bilingual'] ? 'checked' : '' ?>> تفعيل الموقع باللغتين معاً (Arabic & English)
                                </label>
                            </div>
                        </div>
                    </div>

                        <div class="form-group" style="margin-top: 15px;">
                            <label class="form-label">ملف السيرة الذاتية (PDF)</label>
                            <input type="file" name="profile_cv" class="form-input" accept=".pdf" style="height: auto;">
                            <?php if (!empty($siteData['profile']['cv_url'])): ?>
                                <input type="hidden" name="profile[existing_cv]" value="<?= htmlspecialchars($siteData['profile']['cv_url']) ?>">
                                <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
                                    <a href="<?= BASE_URL . htmlspecialchars($siteData['profile']['cv_url']) ?>" target="_blank" style="color:var(--primary); font-weight:700; text-decoration:none;">
                                        <i class="fa-solid fa-file-pdf"></i> عرض السيرة الذاتية الحالية (PDF)
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                </div>

                <!-- TAB: Section configuration -->
                <div id="tab-sections" class="tab-content section-card">
                    <div class="section-title"><i class="fa-solid fa-shapes" style="color:var(--primary)"></i> تهيئة وإخفاء الأقسام</div>
                    <p style="color:var(--text-muted); margin-bottom: 20px; font-size: 0.9rem;">
                        يمكنك هنا تعديل عناوين الأقسام الرئيسية في قالب موقعك وتحديد الأقسام التي تريد عرضها أو إخفائها للزوار.
                    </p>
                    <?php foreach ($siteData['sections'] as $sec): ?>
                        <div class="dynamic-row" style="padding: 16px 24px; display: flex; align-items: center; gap: 20px;">
                            <div style="flex: 0 0 40px; font-size: 1.5rem; color: var(--primary); text-align: center;">
                                <i class="fa-solid <?= htmlspecialchars($sec['icon'] ?? 'fa-circle') ?>"></i>
                            </div>
                            <div class="grid grid-2" style="flex: 1; gap: 12px;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <input type="text" name="sections[<?= $sec['id'] ?>][title]" class="form-input" value="<?= htmlspecialchars($sec['title']) ?>" placeholder="العنوان بالعربية" required>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <input type="text" name="sections[<?= $sec['id'] ?>][title_en]" class="form-input ltr" value="<?= htmlspecialchars($sec['title_en']) ?>" placeholder="Title in English">
                                </div>
                            </div>
                            <div style="flex: 0 0 120px; display: flex; justify-content: flex-end;">
                                <label style="display: flex; align-items: center; gap: 8px; font-weight: 600; cursor: pointer;">
                                    <input type="checkbox" name="sections[<?= $sec['id'] ?>][is_visible]" value="1" <?= $sec['is_visible'] ? 'checked' : '' ?> onchange="toggleSectionTab('<?= $sec['type_key'] ?>', this.checked)"> مرئي بالصفحة
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- TAB: Social links -->
                <div id="tab-social" class="tab-content section-card">
                    <div class="section-title"><i class="fa-solid fa-share-nodes" style="color:var(--primary)"></i> روابط شبكات التواصل الاجتماعي</div>
                    <?php
                        $socials = [];
                        foreach ($siteData['social_links'] as $sl) {
                            $socials[$sl['platform']] = $sl['url'];
                        }
                    ?>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label ltr">LinkedIn URL</label>
                            <input type="url" name="social[linkedin]" class="form-input ltr" value="<?= htmlspecialchars($socials['linkedin'] ?? '') ?>" placeholder="https://linkedin.com/in/username">
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">GitHub URL</label>
                            <input type="url" name="social[github]" class="form-input ltr" value="<?= htmlspecialchars($socials['github'] ?? '') ?>" placeholder="https://github.com/username">
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Twitter / X URL</label>
                            <input type="url" name="social[twitter]" class="form-input ltr" value="<?= htmlspecialchars($socials['twitter'] ?? '') ?>" placeholder="https://twitter.com/username">
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Facebook URL</label>
                            <input type="url" name="social[facebook]" class="form-input ltr" value="<?= htmlspecialchars($socials['facebook'] ?? '') ?>" placeholder="https://facebook.com/username">
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">YouTube URL</label>
                            <input type="url" name="social[youtube]" class="form-input ltr" value="<?= htmlspecialchars($socials['youtube'] ?? '') ?>" placeholder="https://youtube.com/@channel">
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Instagram URL</label>
                            <input type="url" name="social[instagram]" class="form-input ltr" value="<?= htmlspecialchars($socials['instagram'] ?? '') ?>" placeholder="https://instagram.com/username">
                        </div>
                        <div class="form-group">
                            <label class="form-label">البريد الإلكتروني للتواصل (Email Link)</label>
                            <input type="email" name="social[email]" class="form-input ltr" value="<?= htmlspecialchars($socials['email'] ?? '') ?>" placeholder="yourname@domain.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">رقم الهاتف للتواصل (WhatsApp / Phone)</label>
                            <input type="text" name="social[phone]" class="form-input ltr" value="<?= htmlspecialchars($socials['phone'] ?? '') ?>" placeholder="+96655555555">
                        </div>
                    </div>
                </div>

                <!-- TAB: Skills -->
                <div id="tab-skills" class="tab-content section-card">
                    <div class="section-title"><i class="fa-solid fa-code" style="color:var(--primary)"></i> <?= htmlspecialchars($sectionTitles['skills'] ?? 'إدارة المهارات والاهتمامات المهنية') ?></div>
                    <p style="color:var(--text-muted); margin-bottom: 20px; font-size: 0.9rem;">
                        أدخل مهاراتك الفنية والتخصصية التي تميزك في مجالك (مثال: لغات البرمجة للمطورين، التخصصات الإكلينيكية للأطباء، البرمجيات الهندسية للمهندسين، إلخ).
                    </p>
                    <div id="skills-container">
                        <?php foreach ($siteData['skills'] as $i => $skill): ?>
                            <div class="dynamic-row skill-row">
                                <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label class="form-label">اسم المهارة بالعربية</label>
                                        <input type="text" name="skills[<?= $i ?>][name]" class="form-input" value="<?= htmlspecialchars($skill['name']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Skill Name (English)</label>
                                        <input type="text" name="skills[<?= $i ?>][name_en]" class="form-input ltr" value="<?= htmlspecialchars($skill['name_en'] ?? '') ?>">
                                    </div>
                                    
                                </div>
                                <div class="grid grid-2" style="margin-top: 10px;">
                                    <div class="form-group">
                                        <label class="form-label">وصف بسيط للمهارة بالعربية</label>
                                        <input type="text" name="skills[<?= $i ?>][description]" class="form-input" value="<?= htmlspecialchars($skill['description'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Simple Description (English)</label>
                                        <input type="text" name="skills[<?= $i ?>][description_en]" class="form-input ltr" value="<?= htmlspecialchars($skill['description_en'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="add-row-btn" onclick="addSkillRow()" style="margin-bottom: 40px;">
                        <i class="fa-solid fa-plus"></i> إضافة مهارة تقنية جديدة
                    </button>

                    <div class="section-title" style="margin-top: 40px; border-top: 1px solid var(--border-color); padding-top: 30px;"><i class="fa-solid fa-user-check" style="color:var(--primary)"></i> إدارة المهارات الشخصية (مثل التواصل، العمل الجماعي، إلخ)</div>
                    <div id="personal-skills-container">
                        <?php foreach ($siteData['personal_skills'] as $i => $pskill): ?>
                            <div class="dynamic-row personal-skill-row">
                                <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label class="form-label">اسم المهارة الشخصية بالعربية</label>
                                        <input type="text" name="personal_skills[<?= $i ?>][name]" class="form-input" value="<?= htmlspecialchars($pskill['name']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Skill Name (English)</label>
                                        <input type="text" name="personal_skills[<?= $i ?>][name_en]" class="form-input ltr" value="<?= htmlspecialchars($pskill['name_en'] ?? '') ?>">
                                    </div>
                                    
                                </div>
                                <div class="grid grid-2" style="margin-top: 10px;">
                                    <div class="form-group">
                                        <label class="form-label">وصف بسيط للمهارة الشخصية بالعربية</label>
                                        <input type="text" name="personal_skills[<?= $i ?>][description]" class="form-input" value="<?= htmlspecialchars($pskill['description'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Simple Description (English)</label>
                                        <input type="text" name="personal_skills[<?= $i ?>][description_en]" class="form-input ltr" value="<?= htmlspecialchars($pskill['description_en'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="add-row-btn" onclick="addPersonalSkillRow()">
                        <i class="fa-solid fa-plus"></i> إضافة مهارة شخصية جديدة
                    </button>
                </div>

                <!-- TAB: Experiences -->
                <div id="tab-experiences" class="tab-content section-card">
                    <div class="section-title"><i class="fa-solid fa-history" style="color:var(--primary)"></i> <?= htmlspecialchars($sectionTitles['experiences'] ?? 'مسيرتك المهنية والخبرات العملانية') ?></div>
                    <p style="color:var(--text-muted); margin-bottom: 20px; font-size: 0.9rem;">
                        أضف هنا تاريخك الوظيفي وأماكن عملك السابقة (مثال: مستشفيات أو عيادات للأطباء، شركات هندسية للمهندسين، مدارس للمعلمين، إلخ).
                    </p>
                    <div id="experiences-container">
                        <?php foreach ($siteData['experiences'] as $i => $exp): ?>
                            <div class="dynamic-row exp-row">
                                <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                                <div class="lang-tabs">
                                    <button type="button" class="lang-tab-btn active" onclick="switchRowLang(this, 'ar')">العربية</button>
                                    <button type="button" class="lang-tab-btn" onclick="switchRowLang(this, 'en')">English</button>
                                </div>
                                <div class="row-lang-ar active">
                                    <div class="grid grid-2">
                                        <div class="form-group">
                                            <label class="form-label">المسمى الوظيفي</label>
                                            <input type="text" name="experiences[<?= $i ?>][position]" class="form-input" value="<?= htmlspecialchars($exp['position']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">اسم الشركة / المؤسسة</label>
                                            <input type="text" name="experiences[<?= $i ?>][company]" class="form-input" value="<?= htmlspecialchars($exp['company']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">الوصف والمهام الوظيفية</label>
                                        <textarea name="experiences[<?= $i ?>][description]" class="form-input"><?= htmlspecialchars($exp['description']) ?></textarea>
                                    </div>
                                </div>
                                <div class="row-lang-en" style="display:none">
                                    <div class="grid grid-2">
                                        <div class="form-group">
                                            <label class="form-label ltr">Job Position (EN)</label>
                                            <input type="text" name="experiences[<?= $i ?>][position_en]" class="form-input ltr" value="<?= htmlspecialchars($exp['position_en'] ?? '') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label ltr">Company Name (EN)</label>
                                            <input type="text" name="experiences[<?= $i ?>][company_en]" class="form-input ltr" value="<?= htmlspecialchars($exp['company_en'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Job Description (EN)</label>
                                        <textarea name="experiences[<?= $i ?>][description_en]" class="form-input ltr"><?= htmlspecialchars($exp['description_en'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label class="form-label">تاريخ البدء</label>
                                        <input type="text" name="experiences[<?= $i ?>][start_date]" class="form-input" value="<?= htmlspecialchars($exp['start_date']) ?>" placeholder="مثال: يناير 2022">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">تاريخ الانتهاء</label>
                                        <input type="text" name="experiences[<?= $i ?>][end_date]" class="form-input" value="<?= htmlspecialchars($exp['end_date']) ?>" placeholder="مثال: الحالي، أو ديسمبر 2023">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="add-row-btn" onclick="addExperienceRow()">
                        <i class="fa-solid fa-plus"></i> إضافة خبرة جديدة
                    </button>
                </div>

                <!-- TAB: Education -->
                <div id="tab-education" class="tab-content section-card">
                    <div class="section-title"><i class="fa-solid fa-graduation-cap" style="color:var(--primary)"></i> <?= htmlspecialchars($sectionTitles['education'] ?? 'التعليم والمؤهلات الأكاديمية') ?></div>
                    <p style="color:var(--text-muted); margin-bottom: 20px; font-size: 0.9rem;">
                        أضف مؤهلاتك الدراسية، درجاتك العلمية، أو زمالاتك وتدريبك الأكاديمي (بكالوريوس، ماجستير، زمالة طبية، شهادة فنية، إلخ).
                    </p>
                    <div id="education-container">
                        <?php foreach ($siteData['education'] as $i => $edu): ?>
                            <div class="dynamic-row edu-row">
                                <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                                <div class="lang-tabs">
                                    <button type="button" class="lang-tab-btn active" onclick="switchRowLang(this, 'ar')">العربية</button>
                                    <button type="button" class="lang-tab-btn" onclick="switchRowLang(this, 'en')">English</button>
                                </div>
                                <div class="row-lang-ar active">
                                    <div class="grid grid-2">
                                        <div class="form-group">
                                            <label class="form-label">المؤهل الدراسي / الشهادة</label>
                                            <input type="text" name="education[<?= $i ?>][degree]" class="form-input" value="<?= htmlspecialchars($edu['degree']) ?>" placeholder="مثال: بكالوريوس هندسة برمجيات" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">المؤسسة التعليمية / الجامعة</label>
                                            <input type="text" name="education[<?= $i ?>][institution]" class="form-input" value="<?= htmlspecialchars($edu['institution']) ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-lang-en" style="display:none">
                                    <div class="grid grid-2">
                                        <div class="form-group">
                                            <label class="form-label ltr">Degree / Major (EN)</label>
                                            <input type="text" name="education[<?= $i ?>][degree_en]" class="form-input ltr" value="<?= htmlspecialchars($edu['degree_en'] ?? '') ?>" placeholder="e.g. Bachelor of Software Engineering">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label ltr">Institution / University (EN)</label>
                                            <input type="text" name="education[<?= $i ?>][institution_en]" class="form-input ltr" value="<?= htmlspecialchars($edu['institution_en'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="max-width: 300px;">
                                    <label class="form-label">السنة</label>
                                    <input type="text" name="education[<?= $i ?>][year]" class="form-input" value="<?= htmlspecialchars($edu['year']) ?>" placeholder="مثال: 2021">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="add-row-btn" onclick="addEducationRow()">
                        <i class="fa-solid fa-plus"></i> إضافة شهادة تعليمية
                    </button>
                </div>

                <!-- TAB: Certificates -->
                <div id="tab-certificates" class="tab-content section-card">
                    <div class="section-title"><i class="fa-solid fa-certificate" style="color:var(--primary)"></i> <?= htmlspecialchars($sectionTitles['certificates'] ?? 'الشهادات المهنية، الرخص والاعتمادات') ?></div>
                    <p style="color:var(--text-muted); margin-bottom: 20px; font-size: 0.9rem;">
                        أضف تراخيصك المهنية، شهادات الاعتماد والتدريب البارزة (مثل رخصة مزاولة المهنة للأطباء، رخصة هيئة المهندسين للمهندسين، شهادة PMP لمدراء المشاريع، إلخ).
                    </p>
                    <div id="certificates-container">
                        <?php foreach ($siteData['certificates'] as $i => $cert): ?>
                            <div class="dynamic-row cert-row">
                                <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label class="form-label">عنوان الشهادة</label>
                                        <input type="text" name="certificates[<?= $i ?>][title]" class="form-input" value="<?= htmlspecialchars($cert['title']) ?>" placeholder="مثال: شهادة إدارة المشاريع PMP" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Certificate Title (EN)</label>
                                        <input type="text" name="certificates[<?= $i ?>][title_en]" class="form-input ltr" value="<?= htmlspecialchars($cert['title_en'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">الجهة المانحة</label>
                                        <input type="text" name="certificates[<?= $i ?>][issuer]" class="form-input" value="<?= htmlspecialchars($cert['issuer']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Issuer Organization (EN)</label>
                                        <input type="text" name="certificates[<?= $i ?>][issuer_en]" class="form-input ltr" value="<?= htmlspecialchars($cert['issuer_en'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">رابط الشهادة (URL)</label>
                                        <input type="url" name="certificates[<?= $i ?>][link]" class="form-input ltr" placeholder="https://..." value="<?= htmlspecialchars($cert['link'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">السنة</label>
                                        <input type="text" name="certificates[<?= $i ?>][year]" class="form-input" value="<?= htmlspecialchars($cert['year']) ?>" placeholder="مثال: 2023">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">ملف الشهادة PDF (إرفاق ملف)</label>
                                        <input type="file" name="certificate_file_<?= $i ?>" class="form-input" style="height: auto;">
                                        <?php if (!empty($cert['file_url'])): ?>
                                            <input type="hidden" name="certificates[<?= $i ?>][existing_file]" value="<?= htmlspecialchars($cert['file_url']) ?>">
                                            <div style="margin-top: 10px;">
                                                <a href="<?= BASE_URL . htmlspecialchars($cert['file_url']) ?>" target="_blank" style="color: var(--accent); font-weight: 600; font-size: 0.85rem;">
                                                    <i class="fa-solid fa-file-pdf"></i> عرض ملف الشهادة الحالي
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="add-row-btn" onclick="addCertificateRow()">
                        <i class="fa-solid fa-plus"></i> إضافة شهادة مهنية
                    </button>
                </div>

                <!-- TAB: Projects & Research -->
                <div id="tab-projects" class="tab-content section-card">
                    <div class="section-title"><i class="fa-solid fa-briefcase" style="color:var(--primary)"></i> <?= htmlspecialchars($sectionTitles['projects'] ?? 'المشاريع، الإنجازات، والأبحاث والمنشورات العلمية') ?></div>
                    <p style="color:var(--text-muted); margin-bottom: 20px; font-size: 0.9rem;">
                        أدخل أعمالك البارزة هنا. بالنسبة للأطباء والباحثين، يمكن أن تكون أبحاثاً طبية منشورة أو حالات سريرية معقدة. للمطورين والمهندسين، مشاريع برمجية أو إنشائية. للمحامين، قضايا ودراسات حالة ناجحة.
                    </p>
                    <div id="projects-container">
                        <?php foreach ($siteData['projects'] as $i => $proj): ?>
                            <div class="dynamic-row proj-row" data-index="<?= $i ?>">
                                <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                                
                                <div class="lang-tabs">
                                    <button type="button" class="lang-tab-btn active" onclick="switchRowLang(this, 'ar')">العربية</button>
                                    <button type="button" class="lang-tab-btn" onclick="switchRowLang(this, 'en')">English</button>
                                </div>

                                <div class="row-lang-ar active">
                                    <div class="form-group">
                                        <label class="form-label">عنوان المشروع / البحث</label>
                                        <input type="text" name="projects[<?= $i ?>][title]" class="form-input" value="<?= htmlspecialchars($proj['title']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">وصف مختصر للبطاقة (ملخص 2-3 أسطر)</label>
                                        <textarea name="projects[<?= $i ?>][summary]" class="form-input" rows="2"><?= htmlspecialchars($proj['summary']) ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">المحتوى التفصيلي للمشروع (يدعم HTML بسيط أو فقرات كاملة)</label>
                                        <textarea name="projects[<?= $i ?>][body]" class="form-input" style="min-height: 150px;"><?= htmlspecialchars($proj['body']) ?></textarea>
                                    </div>
                                </div>

                                <div class="row-lang-en" style="display:none">
                                    <div class="form-group">
                                        <label class="form-label ltr">Project Title (EN)</label>
                                        <input type="text" name="projects[<?= $i ?>][title_en]" class="form-input ltr" value="<?= htmlspecialchars($proj['title_en'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Brief Summary (EN)</label>
                                        <textarea name="projects[<?= $i ?>][summary_en]" class="form-input ltr" rows="2"><?= htmlspecialchars($proj['summary_en'] ?? '') ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Detailed Body Content (EN)</label>
                                        <textarea name="projects[<?= $i ?>][body_en]" class="form-input ltr" style="min-height: 150px;"><?= htmlspecialchars($proj['body_en'] ?? '') ?></textarea>
                                    </div>
                                </div>

                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label class="form-label">التصنيف</label>
                                        <select name="projects[<?= $i ?>][type]" class="form-input" style="height:auto">
                                            <option value="project" <?= $proj['type'] === 'project' ? 'selected' : '' ?>>مشروع / Portfolio</option>
                                            <option value="research" <?= $proj['type'] === 'research' ? 'selected' : '' ?>>بحث علمي / Publication</option>
                                            <option value="case_study" <?= $proj['type'] === 'case_study' ? 'selected' : '' ?>>دراسة حالة / Case Study</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Live Demo URL</label>
                                        <input type="url" name="projects[<?= $i ?>][link]" class="form-input ltr" value="<?= htmlspecialchars($proj['link'] ?? '') ?>" placeholder="https://example.com">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">GitHub/Source URL</label>
                                        <input type="url" name="projects[<?= $i ?>][github_link]" class="form-input ltr" value="<?= htmlspecialchars($proj['github_link'] ?? '') ?>" placeholder="https://github.com/...">
                                    </div>
                                </div>

                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label class="form-label">صورة الغلاف للمشروع (Cover Image)</label>
                                        <input type="file" name="project_cover_<?= $i ?>" class="form-input" style="height:auto" accept="image/*">
                                        <?php if (!empty($proj['cover_image'])): ?>
                                            <?php $coverSrc = BASE_URL . '/' . ltrim(htmlspecialchars($proj['cover_image']), '/') . '.jpg'; ?>
                                            <input type="hidden" name="projects[<?= $i ?>][existing_cover]" value="<?= htmlspecialchars($proj['cover_image']) ?>">
                                            <div style="margin-top:10px; display:flex; align-items:center; gap:10px; background:rgba(0,0,0,0.2); padding:8px; border-radius:8px; border:1px solid var(--border-color);">
                                                <img src="<?= $coverSrc ?>" style="width: 90px; height: 60px; object-fit: cover; border-radius: 6px; border:1px solid var(--border-color);" onerror="this.src='<?= BASE_URL . '/' . ltrim(htmlspecialchars($proj['cover_image']), '/') ?>.webp'; this.onerror=null;">
                                                <div style="display:flex; flex-direction:column; gap:4px;">
                                                    <span style="font-size:0.85rem; color:var(--text-muted)"><i class="fa-solid fa-image" style="color:var(--accent)"></i> صورة الغلاف الحالية</span>
                                                    <span style="font-size:0.75rem; color:var(--text-muted)">ارفع صورة جديدة للاستبدال</span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">الرابط الفرعي للصفحة التفصيلية (Project Slug)</label>
                                        <input type="text" name="projects[<?= $i ?>][slug]" class="form-input ltr" value="<?= htmlspecialchars($proj['slug']) ?>" placeholder="project-slug-name" required>
                                    </div>
                                </div>

                                <!-- Project Gallery Media Section -->
                                <div style="margin-top: 20px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                                    <label class="form-label no-badge" style="font-weight:700;"><i class="fa-solid fa-images"></i> معرض وسائط المشروع (صور أو ملفات PDF إضافية للبحث)</label>
                                    <div class="media-gallery-container" id="media-gallery-<?= $i ?>">
                                        <?php if (!empty($proj['media'])): ?>
                                            <?php foreach ($proj['media'] as $j => $media): ?>
                                                <div class="gallery-item" style="position:relative; background:rgba(0,0,0,0.2); border:1px solid var(--border-color); border-radius:8px; padding:12px; margin-bottom:10px;">
                                                    <input type="hidden" name="projects[<?= $i ?>][media][<?= $j ?>][existing_file]" value="<?= htmlspecialchars($media['file_path']) ?>">
                                                    <div style="display:flex; flex-direction:column; gap:10px; width:100%;">
                                                        <!-- Preview row -->
                                                        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                                                            <?php if ($media['file_type'] === 'image'): ?>
                                                                <?php $mediaSrc = BASE_URL . '/' . ltrim(htmlspecialchars($media['file_path']), '/') . '.jpg'; ?>
                                                                <img src="<?= $mediaSrc ?>" style="width:70px; height:55px; object-fit:cover; border-radius:6px; border:1px solid var(--border-color); flex-shrink:0;" onerror="this.src='<?= BASE_URL . '/' . ltrim(htmlspecialchars($media['file_path']), '/') ?>.webp'; this.onerror=null;">
                                                            <?php else: ?>
                                                                <div style="width:70px; height:55px; display:flex; align-items:center; justify-content:center; background:#ef4444; border-radius:6px; font-size:1.5rem; color:white; flex-shrink:0;"><i class="fa-solid fa-file-pdf"></i></div>
                                                            <?php endif; ?>
                                                            <div style="flex:1; min-width:0;">
                                                                <div style="font-size:0.8rem; color:var(--text-muted); margin-bottom:6px;">
                                                                    <i class="fa-solid <?= $media['file_type'] === 'image' ? 'fa-image' : 'fa-file-pdf' ?>" style="color:var(--accent)"></i>
                                                                    <?= $media['file_type'] === 'image' ? 'صورة مرفقة' : 'ملف PDF مرفق' ?>
                                                                </div>
                                                                <!-- Replace + Delete buttons -->
                                                                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                                                    <label for="replace_media_<?= $i ?>_<?= $j ?>" style="font-size:0.75rem; color:var(--accent); cursor:pointer; background:rgba(16,185,129,0.1); padding:4px 10px; border-radius:4px; border:1px solid rgba(16,185,129,0.3); display:inline-flex; align-items:center; gap:4px;">
                                                                        <i class="fa-solid fa-cloud-arrow-up"></i> تبديل الملف
                                                                    </label>
                                                                    <input type="file" id="replace_media_<?= $i ?>_<?= $j ?>" name="project_media_file_<?= $i ?>_<?= $j ?>" accept="image/*,.pdf" style="display:none;" onchange="updateReplaceLabel(this, 'replace_media_<?= $i ?>_<?= $j ?>')">
                                                                    <button type="button" onclick="this.closest('.gallery-item').remove()" style="font-size:0.75rem; color:var(--danger); cursor:pointer; background:rgba(239,68,68,0.1); padding:4px 10px; border-radius:4px; border:1px solid rgba(239,68,68,0.3); display:inline-flex; align-items:center; gap:4px;">
                                                                        <i class="fa-solid fa-trash"></i> حذف
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Caption inputs -->
                                                        <div class="grid grid-2" style="gap:10px;">
                                                            <input type="text" name="projects[<?= $i ?>][media][<?= $j ?>][caption]" class="form-input" style="padding:6px; font-size:0.8rem;" value="<?= htmlspecialchars($media['caption'] ?? '') ?>" placeholder="تعليق الصورة بالعربية">
                                                            <input type="text" name="projects[<?= $i ?>][media][<?= $j ?>][caption_en]" class="form-input ltr" style="padding:6px; font-size:0.8rem;" value="<?= htmlspecialchars($media['caption_en'] ?? '') ?>" placeholder="English Caption">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <button type="button" class="add-row-btn" style="padding: 6px 12px; font-size:0.8rem; border-color:var(--primary); color:var(--primary); background:transparent;" onclick="addGalleryMediaItem(<?= $i ?>)">
                                        <i class="fa-solid fa-plus"></i> إضافة صورة/ملف للمعرض
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="add-row-btn" onclick="addProjectRow()">
                        <i class="fa-solid fa-plus"></i> إضافة مشروع أو بحث جديد
                    </button>
                </div>

                <!-- TAB: Languages -->
                <div id="tab-languages" class="tab-content section-card">
                    <div class="section-title"><i class="fa-solid fa-language" style="color:var(--primary)"></i> <?= htmlspecialchars($sectionTitles['languages'] ?? 'إدارة اللغات المتقنة') ?></div>
                    <p style="color:var(--text-muted); margin-bottom: 20px; font-size: 0.9rem;">
                        أدخل اللغات التي تجيد التحدث أو الكتابة بها ومستوى إتقانك لكل لغة.
                    </p>
                    <div id="languages-container">
                        <?php foreach ($siteData['languages'] as $i => $langObj): ?>
                            <div class="dynamic-row lang-row">
                                <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label class="form-label">اللغة بالعربية</label>
                                        <input type="text" name="languages[<?= $i ?>][name]" class="form-input" value="<?= htmlspecialchars($langObj['name']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Language Name (English)</label>
                                        <input type="text" name="languages[<?= $i ?>][name_en]" class="form-input ltr" value="<?= htmlspecialchars($langObj['name_en'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">مستوى التحدث/الكتابة بالعربية</label>
                                        <input type="text" name="languages[<?= $i ?>][level]" class="form-input" value="<?= htmlspecialchars($langObj['level']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label ltr">Proficiency Level (English)</label>
                                        <input type="text" name="languages[<?= $i ?>][level_en]" class="form-input ltr" value="<?= htmlspecialchars($langObj['level_en'] ?? '') ?>">
                                    </div>
                                    <div class="form-group" style="grid-column: span 2;">
                                        <label class="form-label">النسبة المئوية للمستوى (1 - 100)</label>
                                        <input type="number" name="languages[<?= $i ?>][percentage]" class="form-input" min="1" max="100" value="<?= (int)$langObj['percentage'] ?>" required>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="add-row-btn" onclick="addLanguageRow()">
                        <i class="fa-solid fa-plus"></i> إضافة لغة جديدة
                    </button>
                </div>

                <!-- TAB: References -->
                <div id="tab-references" class="tab-content section-card">
                    <div class="section-title"><i class="fa-solid fa-user-check" style="color:var(--primary)"></i> <?= htmlspecialchars($sectionTitles['references'] ?? 'إدارة المراجع والتوصيات') ?></div>
                    <p style="color:var(--text-muted); margin-bottom: 20px; font-size: 0.9rem;">
                        أضف المراجع من أشخاص عملت معهم سابقاً، أو اكتب نصاً عاماً (مثل: المراجع متوفرة عند الطلب) في حال عدم رغبتك بإضافة مراجع فردية.
                    </p>

                    <!-- Text area for general references fallback -->
                    <div class="form-group" style="background: rgba(0,0,0,0.1); padding: 15px; border-radius: 8px; border: 1px dashed var(--border-color); margin-bottom: 25px;">
                        <label class="form-label" style="font-weight: 700; color: var(--accent);">نص المراجع العام (اختياري / بديل للمراجع الفردية)</label>
                        <div class="lang-tabs" style="margin-top: 5px;">
                            <button type="button" class="lang-tab-btn active" onclick="switchLangTab(this, 'ref-ar-tab')">العربية</button>
                            <button type="button" class="lang-tab-btn" onclick="switchLangTab(this, 'ref-en-tab')">English</button>
                        </div>
                        <div id="ref-ar-tab" class="lang-field-group active" style="margin-top: 10px;">
                            <textarea name="profile[references_text]" class="form-input" style="height: 80px;" placeholder="مثال: جميع المراجع متوفرة عند الطلب..."><?= htmlspecialchars($siteData['profile']['references_text'] ?? '') ?></textarea>
                        </div>
                        <div id="ref-en-tab" class="lang-field-group" style="margin-top: 10px;">
                            <textarea name="profile[references_text_en]" class="form-input ltr" style="height: 80px;" placeholder="Example: References available upon request..."><?= htmlspecialchars($siteData['profile']['references_text_en'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- List of Structured References -->
                    <div id="references-container">
                        <?php if (!empty($siteData['references'])): ?>
                            <?php foreach ($siteData['references'] as $i => $ref): ?>
                                <div class="dynamic-row ref-row">
                                    <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                                    <input type="hidden" name="references[<?= $i ?>][existing_photo]" value="<?= htmlspecialchars($ref['photo'] ?? '') ?>">
                                    <div class="grid grid-2">
                                        <div class="form-group">
                                            <label class="form-label">الاسم بالكامل بالعربية</label>
                                            <input type="text" name="references[<?= $i ?>][name]" class="form-input" value="<?= htmlspecialchars($ref['name']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label ltr">Full Name (English)</label>
                                            <input type="text" name="references[<?= $i ?>][name_en]" class="form-input ltr" value="<?= htmlspecialchars($ref['name_en'] ?? '') ?>">
                                        </div>
                                        <div class="form-group" style="grid-column: span 2;">
                                            <label class="form-label">نبذة أو وصف مختصر بالعربية (مثال: مدير مشروع في شركة س - اختياري)</label>
                                            <input type="text" name="references[<?= $i ?>][description]" class="form-input" value="<?= htmlspecialchars($ref['description'] ?? '') ?>">
                                        </div>
                                        <div class="form-group" style="grid-column: span 2;">
                                            <label class="form-label ltr">Description (English - Optional)</label>
                                            <input type="text" name="references[<?= $i ?>][description_en]" class="form-input ltr" value="<?= htmlspecialchars($ref['description_en'] ?? '') ?>">
                                        </div>
                                        <div class="form-group" style="grid-column: span 2;">
                                            <label class="form-label">صورة المرجع (اختياري)</label>
                                            <input type="file" name="reference_photo_<?= $i ?>" class="form-input" accept="image/*" style="height:auto;">
                                            <?php if (!empty($ref['photo'])): ?>
                                                <?php $refPhotoUrl = BASE_URL . '/' . ltrim(htmlspecialchars($ref['photo']), '/') . '.jpg'; ?>
                                                <div class="photo-preview-box" style="margin-top:10px; display:flex; align-items:center; gap:12px; background: rgba(0,0,0,0.1); padding: 10px; border-radius: 8px; border: 1px dashed var(--border-color);">
                                                    <img src="<?= $refPhotoUrl ?>" style="width:48px; height:48px; border-radius:50%; object-fit:cover; border: 2px solid var(--primary);" onerror="this.src='<?= BASE_URL . '/' . ltrim(htmlspecialchars($ref['photo']), '/') ?>.webp'; this.onerror=null;">
                                                    <div style="display:flex; flex-direction:column; gap:6px;">
                                                        <span style="font-size:0.85rem; font-weight:600; color:var(--text-main)"><i class="fa-solid fa-circle-check" style="color:var(--accent)"></i> صورة المرجع الحالية</span>
                                                        <div style="display:flex; gap:8px;">
                                                            <button type="button" onclick="this.closest('.ref-row').querySelector('input[type=hidden][name*=\'[existing_photo]\']').value=''; this.closest('.photo-preview-box').remove();" style="font-size:0.75rem; color:var(--danger); cursor:pointer; background:rgba(239,68,68,0.1); padding:4px 10px; border-radius:4px; border:1px solid rgba(239,68,68,0.3); display:inline-flex; align-items:center; gap:4px;">
                                                                <i class="fa-solid fa-trash"></i> حذف الصورة
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">رقم الهاتف (اختياري)</label>
                                            <input type="text" name="references[<?= $i ?>][phone]" class="form-input ltr" value="<?= htmlspecialchars($ref['phone'] ?? '') ?>" placeholder="+966xxxxxxxxx">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">البريد الإلكتروني (اختياري)</label>
                                            <input type="email" name="references[<?= $i ?>][email]" class="form-input ltr" value="<?= htmlspecialchars($ref['email'] ?? '') ?>" placeholder="name@domain.com">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="add-row-btn" onclick="addReferenceRow()">
                        <i class="fa-solid fa-plus"></i> إضافة مرجع جديد
                    </button>
                </div>




            </form>
        </div>
    <!-- JS Form Dynamism Engine -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector('form');
            if (form) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.addEventListener('click', function() {
                        if (!form.checkValidity()) {
                            const invalidElements = form.querySelectorAll(':invalid');
                            let firstInvalid = null;
                            for (let el of invalidElements) {
                                if (el.tagName !== 'FORM') {
                                    firstInvalid = el;
                                    break;
                                }
                            }
                            if (firstInvalid) {
                                const tabContent = firstInvalid.closest('.tab-content');
                                if (tabContent && !tabContent.classList.contains('active')) {
                                    showTab(tabContent.id);
                                }
                                const langGroup = firstInvalid.closest('.lang-field-group');
                                if (langGroup && !langGroup.classList.contains('active')) {
                                    const langTabsContainer = langGroup.parentElement.querySelector('.lang-tabs');
                                    if (langTabsContainer) {
                                        const btn = langTabsContainer.querySelector(`[onclick*="${langGroup.id}"]`);
                                        if (btn) btn.click();
                                    }
                                }
                                setTimeout(() => firstInvalid.focus(), 100);
                            }
                        }
                    });
                }
            }
        });

        // Tab system
        function showTab(tabId, btnElement = null) {
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.remove('active'));
            
            const target = document.getElementById(tabId);
            if (target) {
                target.classList.add('active');
            }
            
            // Highlight active horizontal tab button
            const tabButtons = document.querySelectorAll('.mobile-tabs-container .tab-btn');
            tabButtons.forEach(btn => btn.classList.remove('active'));
            
            if (btnElement) {
                btnElement.classList.add('active');
            } else {
                tabButtons.forEach(btn => {
                    if (btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(tabId)) {
                        btn.classList.add('active');
                        // Ensure the button is scrolled into view in the horizontal menu
                        btn.scrollIntoView({ behavior: "smooth", block: "nearest", inline: "center" });
                    }
                });
            }
        }

        // Language toggle tabs
        function switchLangTab(btn, tabId) {
            const container = btn.parentElement.parentElement;
            const groups = container.querySelectorAll('.lang-field-group');
            groups.forEach(group => group.classList.remove('active'));
            
            const btns = btn.parentElement.querySelectorAll('.lang-tab-btn');
            btns.forEach(b => b.classList.remove('active'));
            
            document.getElementById(tabId).classList.add('active');
            btn.classList.add('active');
        }

        // Profile photo: live preview on file select
        function previewProfilePhoto(input) {
            if (!input.files || !input.files[0]) return;
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                // If existing preview box exists, update its image
                const imgEl = document.getElementById('profile-photo-img');
                if (imgEl) {
                    imgEl.src = e.target.result;
                } else {
                    // If it was empty (no photo), replace dropzone with a preview box
                    const dropzone = document.getElementById('profile-photo-dropzone');
                    if (dropzone) {
                        const previewBox = document.createElement('div');
                        previewBox.id = 'profile-photo-preview-box';
                        previewBox.style.cssText = 'margin-top:10px; display:flex; align-items:center; gap:14px; background:rgba(0,0,0,0.2); padding:12px; border-radius:10px; border:1px solid var(--border-color);';
                        previewBox.innerHTML = `
                            <img id="profile-photo-img" src="${e.target.result}" style="width:72px; height:72px; border-radius:50%; object-fit:cover; border:3px solid var(--primary); flex-shrink:0;">
                            <div style="display:flex; flex-direction:column; gap:6px;">
                                <span style="font-size:0.85rem; font-weight:600; color:var(--text-main)"><i class="fa-solid fa-circle-check" style="color:var(--accent)"></i> ${file.name.substring(0,25)}...</span>
                                <span style="font-size:0.75rem; color:var(--text-muted)">ستُرفع الصورة عند الحفظ</span>
                            </div>
                        `;
                        dropzone.parentElement.insertBefore(previewBox, dropzone);
                        dropzone.style.display = 'none';
                    }
                }
                // Show the file input if it was hidden (for replace flow)
                input.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }

        // Profile photo: delete (clear hidden input + remove preview)
        function deleteProfilePhoto() {
            if (!confirm('هل أنت متأكد من حذف الصورة الشخصية الحالية؟')) return;
            // Clear the existing_photo hidden input so it won't be kept on save
            const existingInput = document.getElementById('existing_profile_photo');
            if (existingInput) existingInput.value = '';
            // Remove preview box
            const previewBox = document.getElementById('profile-photo-preview-box');
            if (previewBox) previewBox.remove();
            // Show an empty dropzone instead
            const fileInput = document.getElementById('profile_photo');
            if (fileInput) {
                fileInput.style.display = 'block';
                fileInput.style.marginTop = '8px';
            }
        }

        // Inner row language toggler
        function switchRowLang(btn, lang) {
            const row = btn.parentElement.parentElement;
            const arGroup = row.querySelector('.row-lang-ar');
            const enGroup = row.querySelector('.row-lang-en');
            const btns = btn.parentElement.querySelectorAll('.lang-tab-btn');
            
            btns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            if (lang === 'ar') {
                arGroup.style.display = 'block';
                enGroup.style.display = 'none';
            } else {
                arGroup.style.display = 'none';
                enGroup.style.display = 'block';
            }
        }

        // Counters for array index generation in newly added elements
        let skillCounter = Math.floor(Date.now() / 1000);
        let personalSkillCounter = Math.floor(Date.now() / 1000) + 1;
        let langCounter = Math.floor(Date.now() / 1000) + 2;
        let expCounter = Math.floor(Date.now() / 1000) + 3;
        let eduCounter = Math.floor(Date.now() / 1000) + 4;
        let certCounter = Math.floor(Date.now() / 1000) + 5;
        let projCounter = Math.floor(Date.now() / 1000) + 6;
        let refCounter = Math.floor(Date.now() / 1000) + 7;

        function addReferenceRow() {
            const container = document.getElementById('references-container');
            const html = `
                <div class="dynamic-row ref-row">
                    <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">الاسم بالكامل بالعربية</label>
                            <input type="text" name="references[${refCounter}][name]" class="form-input" placeholder="اسم صاحب المرجع" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Full Name (English)</label>
                            <input type="text" name="references[${refCounter}][name_en]" class="form-input ltr" placeholder="Reference Full Name">
                        </div>
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">نبذة أو وصف مختصر بالعربية (مثال: مدير مشروع في شركة س - اختياري)</label>
                            <input type="text" name="references[${refCounter}][description]" class="form-input">
                        </div>
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label ltr">Description (English - Optional)</label>
                            <input type="text" name="references[${refCounter}][description_en]" class="form-input ltr">
                        </div>
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">صورة المرجع (اختياري)</label>
                            <input type="file" name="reference_photo_${refCounter}" class="form-input" accept="image/*" style="height:auto;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">رقم الهاتف (اختياري)</label>
                            <input type="text" name="references[${refCounter}][phone]" class="form-input ltr" placeholder="+966xxxxxxxxx">
                        </div>
                        <div class="form-group">
                            <label class="form-label">البريد الإلكتروني (اختياري)</label>
                            <input type="email" name="references[${refCounter}][email]" class="form-input ltr" placeholder="name@domain.com">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            refCounter++;
        }


        function addSkillRow() {
            const container = document.getElementById('skills-container');
            const html = `
                <div class="dynamic-row skill-row">
                    <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">اسم المهارة بالعربية</label>
                            <input type="text" name="skills[${skillCounter}][name]" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Skill Name (English)</label>
                            <input type="text" name="skills[${skillCounter}][name_en]" class="form-input ltr">
                        </div>
                        
                    </div>
                    <div class="grid grid-2" style="margin-top: 10px;">
                        <div class="form-group">
                            <label class="form-label">وصف بسيط للمهارة بالعربية</label>
                            <input type="text" name="skills[${skillCounter}][description]" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Simple Description (English)</label>
                            <input type="text" name="skills[${skillCounter}][description_en]" class="form-input ltr">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            skillCounter++;
        }

        function addPersonalSkillRow() {
            const container = document.getElementById('personal-skills-container');
            const html = `
                <div class="dynamic-row personal-skill-row">
                    <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">اسم المهارة الشخصية بالعربية</label>
                            <input type="text" name="personal_skills[${personalSkillCounter}][name]" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Skill Name (English)</label>
                            <input type="text" name="personal_skills[${personalSkillCounter}][name_en]" class="form-input ltr">
                        </div>
                        
                    </div>
                    <div class="grid grid-2" style="margin-top: 10px;">
                        <div class="form-group">
                            <label class="form-label">وصف بسيط للمهارة الشخصية بالعربية</label>
                            <input type="text" name="personal_skills[${personalSkillCounter}][description]" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Simple Description (English)</label>
                            <input type="text" name="personal_skills[${personalSkillCounter}][description_en]" class="form-input ltr">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            personalSkillCounter++;
        }

        function addLanguageRow() {
            const container = document.getElementById('languages-container');
            const html = `
                <div class="dynamic-row lang-row">
                    <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">اللغة بالعربية</label>
                            <input type="text" name="languages[${langCounter}][name]" class="form-input" placeholder="مثال: العربية" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Language Name (English)</label>
                            <input type="text" name="languages[${langCounter}][name_en]" class="form-input ltr" placeholder="e.g. English">
                        </div>
                        <div class="form-group">
                            <label class="form-label">مستوى التحدث/الكتابة بالعربية</label>
                            <input type="text" name="languages[${langCounter}][level]" class="form-input" placeholder="مثال: اللغة الأم، ممتاز" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Proficiency Level (English)</label>
                            <input type="text" name="languages[${langCounter}][level_en]" class="form-input ltr" placeholder="e.g. Native speaker, Fluent">
                        </div>
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">النسبة المئوية للمستوى (1 - 100)</label>
                            <input type="number" name="languages[${langCounter}][percentage]" class="form-input" min="1" max="100" value="80" required>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            langCounter++;
        }

        function addExperienceRow() {
            const container = document.getElementById('experiences-container');
            const html = `
                <div class="dynamic-row exp-row">
                    <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                    <div class="lang-tabs">
                        <button type="button" class="lang-tab-btn active" onclick="switchRowLang(this, 'ar')">العربية</button>
                        <button type="button" class="lang-tab-btn" onclick="switchRowLang(this, 'en')">English</button>
                    </div>
                    <div class="row-lang-ar active">
                        <div class="grid grid-2">
                            <div class="form-group">
                                <label class="form-label">المسمى الوظيفي</label>
                                <input type="text" name="experiences[${expCounter}][position]" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">اسم الشركة / المؤسسة</label>
                                <input type="text" name="experiences[${expCounter}][company]" class="form-input" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">الوصف والمهام الوظيفية</label>
                            <textarea name="experiences[${expCounter}][description]" class="form-input"></textarea>
                        </div>
                    </div>
                    <div class="row-lang-en" style="display:none">
                        <div class="grid grid-2">
                            <div class="form-group">
                                <label class="form-label ltr">Job Position (EN)</label>
                                <input type="text" name="experiences[${expCounter}][position_en]" class="form-input ltr">
                            </div>
                            <div class="form-group">
                                <label class="form-label ltr">Company Name (EN)</label>
                                <input type="text" name="experiences[${expCounter}][company_en]" class="form-input ltr">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Job Description (EN)</label>
                            <textarea name="experiences[${expCounter}][description_en]" class="form-input ltr"></textarea>
                        </div>
                    </div>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">تاريخ البدء</label>
                            <input type="text" name="experiences[${expCounter}][start_date]" class="form-input" placeholder="يناير 2022">
                        </div>
                        <div class="form-group">
                            <label class="form-label">تاريخ الانتهاء</label>
                            <input type="text" name="experiences[${expCounter}][end_date]" class="form-input" placeholder="ديسمبر 2023 أو الحالي">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            expCounter++;
        }

        function addEducationRow() {
            const container = document.getElementById('education-container');
            const html = `
                <div class="dynamic-row edu-row">
                    <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                    <div class="lang-tabs">
                        <button type="button" class="lang-tab-btn active" onclick="switchRowLang(this, 'ar')">العربية</button>
                        <button type="button" class="lang-tab-btn" onclick="switchRowLang(this, 'en')">English</button>
                    </div>
                    <div class="row-lang-ar active">
                        <div class="grid grid-2">
                            <div class="form-group">
                                <label class="form-label">المؤهل الدراسي / الشهادة</label>
                                <input type="text" name="education[${eduCounter}][degree]" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">المؤسسة التعليمية / الجامعة</label>
                                <input type="text" name="education[${eduCounter}][institution]" class="form-input" required>
                            </div>
                        </div>
                    </div>
                    <div class="row-lang-en" style="display:none">
                        <div class="grid grid-2">
                            <div class="form-group">
                                <label class="form-label ltr">Degree / Major (EN)</label>
                                <input type="text" name="education[${eduCounter}][degree_en]" class="form-input ltr">
                            </div>
                            <div class="form-group">
                                <label class="form-label ltr">Institution / University (EN)</label>
                                <input type="text" name="education[${eduCounter}][institution_en]" class="form-input ltr">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="max-width: 300px;">
                        <label class="form-label">السنة</label>
                        <input type="text" name="education[${eduCounter}][year]" class="form-input" placeholder="2022">
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            eduCounter++;
        }

        function addCertificateRow() {
            const container = document.getElementById('certificates-container');
            const html = `
                <div class="dynamic-row cert-row">
                    <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">عنوان الشهادة</label>
                            <input type="text" name="certificates[${certCounter}][title]" class="form-input" placeholder="PMP" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Certificate Title (EN)</label>
                            <input type="text" name="certificates[${certCounter}][title_en]" class="form-input ltr">
                        </div>
                        <div class="form-group">
                            <label class="form-label">الجهة المانحة</label>
                            <input type="text" name="certificates[${certCounter}][issuer]" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Issuer Organization (EN)</label>
                            <input type="text" name="certificates[${certCounter}][issuer_en]" class="form-input ltr">
                        </div>
                        <div class="form-group">
                            <label class="form-label">رابط الشهادة (URL)</label>
                            <input type="url" name="certificates[${certCounter}][link]" class="form-input ltr" placeholder="https://...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">السنة</label>
                            <input type="text" name="certificates[${certCounter}][year]" class="form-input" placeholder="2023">
                        </div>
                        <div class="form-group">
                            <label class="form-label">ملف الشهادة PDF (إرفاق ملف)</label>
                            <input type="file" name="certificate_file_${certCounter}" class="form-input" style="height: auto;">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            certCounter++;
        }

        function addProjectRow() {
            const container = document.getElementById('projects-container');
            const i = projCounter;
            const html = `
                <div class="dynamic-row proj-row" data-index="${i}">
                    <span class="remove-row-btn" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                    <div class="lang-tabs">
                        <button type="button" class="lang-tab-btn active" onclick="switchRowLang(this, 'ar')">العربية</button>
                        <button type="button" class="lang-tab-btn" onclick="switchRowLang(this, 'en')">English</button>
                    </div>
                    <div class="row-lang-ar active">
                        <div class="form-group">
                            <label class="form-label">عنوان المشروع / البحث</label>
                            <input type="text" name="projects[${i}][title]" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">وصف مختصر للبطاقة (ملخص 2-3 أسطر)</label>
                            <textarea name="projects[${i}][summary]" class="form-input" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">المحتوى التفصيلي للمشروع</label>
                            <textarea name="projects[${i}][body]" class="form-input" style="min-height: 150px;"></textarea>
                        </div>
                    </div>
                    <div class="row-lang-en" style="display:none">
                        <div class="form-group">
                            <label class="form-label ltr">Project Title (EN)</label>
                            <input type="text" name="projects[${i}][title_en]" class="form-input ltr">
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Brief Summary (EN)</label>
                            <textarea name="projects[${i}][summary_en]" class="form-input ltr" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Detailed Body Content (EN)</label>
                            <textarea name="projects[${i}][body_en]" class="form-input ltr" style="min-height: 150px;"></textarea>
                        </div>
                    </div>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">التصنيف</label>
                            <select name="projects[${i}][type]" class="form-input" style="height:auto">
                                <option value="project">مشروع / Portfolio</option>
                                <option value="research">بحث علمي / Publication</option>
                                <option value="case_study">دراسة حالة / Case Study</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">Live Demo URL</label>
                            <input type="url" name="projects[${i}][link]" class="form-input ltr" placeholder="https://example.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label ltr">GitHub/Source URL</label>
                            <input type="url" name="projects[${i}][github_link]" class="form-input ltr" placeholder="https://github.com/...">
                        </div>
                    </div>
                    <div class="grid grid-2">
                        <div class="form-group">
                            <label class="form-label">صورة الغلاف للمشروع (Cover Image)</label>
                            <input type="file" name="project_cover_${i}" class="form-input" style="height:auto" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">الرابط الفرعي للصفحة التفصيلية (Project Slug)</label>
                            <input type="text" name="projects[${i}][slug]" class="form-input ltr" placeholder="project-slug-name">
                        </div>
                    </div>
                    <div style="margin-top: 20px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                        <label class="form-label no-badge" style="font-weight:700;"><i class="fa-solid fa-images"></i> معرض وسائط المشروع (صور أو ملفات PDF إضافية)</label>
                        <div class="media-gallery-container" id="media-gallery-${i}"></div>
                        <button type="button" class="add-row-btn" style="padding: 6px 12px; font-size:0.8rem; border-color:var(--primary); color:var(--primary); background:transparent;" onclick="addGalleryMediaItem(${i})">
                            <i class="fa-solid fa-plus"></i> إضافة صورة/ملف للمعرض
                        </button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            projCounter++;
        }

        // Helper: update replace label text after file chosen
        function updateReplaceLabel(input, labelId) {
            const label = document.querySelector('label[for="' + labelId + '"]');
            if (label && input.files.length > 0) {
                label.innerHTML = '<i class="fa-solid fa-check"></i> تم اختيار: ' + input.files[0].name.substring(0, 20);
                label.style.color = 'var(--accent)';
                label.style.borderColor = 'var(--accent)';
            }
        }

        // Dynamic project gallery media items
        function addGalleryMediaItem(projectIndex) {
            const container = document.getElementById('media-gallery-' + projectIndex);
            // Count current items inside this container
            const mediaIndex = container.querySelectorAll('.gallery-item').length;
            
            const html = `
                <div class="gallery-item" style="position:relative; background:rgba(0,0,0,0.2); border:1px solid var(--border-color); border-radius:8px; padding:12px; margin-bottom:10px;">
                    <div style="display:flex; flex-direction:column; gap:10px; width:100%;">
                        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                            <div id="preview-${projectIndex}-${mediaIndex}" style="width:70px; height:55px; background:rgba(99,102,241,0.1); border-radius:6px; border:2px dashed var(--primary); display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1.5rem; color:var(--primary);"><i class="fa-solid fa-image"></i></div>
                            <div style="flex:1;">
                                <div style="font-size:0.8rem; color:var(--text-muted); margin-bottom:6px;">اختر صورة أو PDF للإضافة</div>
                                <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                                    <label style="font-size:0.75rem; color:var(--primary); cursor:pointer; background:rgba(99,102,241,0.1); padding:5px 12px; border-radius:4px; border:1px solid rgba(99,102,241,0.3); display:inline-flex; align-items:center; gap:4px;">
                                        <i class="fa-solid fa-cloud-arrow-up"></i> اختيار ملف
                                        <input type="file" name="project_media_file_${projectIndex}_${mediaIndex}" accept="image/*,.pdf" style="display:none;" required onchange="previewNewMedia(this, '${projectIndex}', '${mediaIndex}')">
                                    </label>
                                    <button type="button" onclick="this.closest('.gallery-item').remove()" style="font-size:0.75rem; color:var(--danger); cursor:pointer; background:rgba(239,68,68,0.1); padding:5px 12px; border-radius:4px; border:1px solid rgba(239,68,68,0.3); display:inline-flex; align-items:center; gap:4px;">
                                        <i class="fa-solid fa-trash"></i> حذف
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-2" style="gap:10px;">
                            <input type="text" name="projects[${projectIndex}][media][${mediaIndex}][caption]" class="form-input" style="padding:6px; font-size:0.8rem;" placeholder="تعليق الصورة بالعربية">
                            <input type="text" name="projects[${projectIndex}][media][${mediaIndex}][caption_en]" class="form-input ltr" style="padding:6px; font-size:0.8rem;" placeholder="English Caption">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        // Preview newly selected media file before upload
        function previewNewMedia(input, projIdx, mediaIdx) {
            const previewEl = document.getElementById('preview-' + projIdx + '-' + mediaIdx);
            if (!previewEl) return;
            const file = input.files[0];
            if (!file) return;
            if (file.type === 'application/pdf') {
                previewEl.innerHTML = '<i class="fa-solid fa-file-pdf" style="color:#ef4444; font-size:1.8rem;"></i>';
                previewEl.style.background = 'rgba(239,68,68,0.1)';
                previewEl.style.border = '2px solid rgba(239,68,68,0.3)';
            } else {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewEl.innerHTML = '<img src="' + e.target.result + '" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">';
                    previewEl.style.border = '2px solid var(--accent)';
                };
                reader.readAsDataURL(file);
            }
            // Update label
            const label = input.parentElement;
            label.innerHTML = '<i class="fa-solid fa-check"></i> ' + file.name.substring(0,18) + '...';
            label.style.color = 'var(--accent)';
            label.style.borderColor = 'var(--accent)';
            label.style.background = 'rgba(16,185,129,0.1)';
            // Re-append the file input (since we replaced innerHTML)
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'project_media_file_' + projIdx + '_' + mediaIdx;
            newInput.accept = 'image/*,.pdf';
            newInput.required = true;
            newInput.style.display = 'none';
            newInput.onchange = function() { previewNewMedia(this, projIdx, mediaIdx); };
            label.appendChild(newInput);
            // Transfer the file to the new input (not possible directly, so just keep original input hidden inside)
        }

        // AJAX Form Submission (Prevent page reloads and retain inputs)
        const dashboardForm = document.getElementById('dashboardForm') || document.querySelector('form');
        if (dashboardForm) {
            dashboardForm.addEventListener('submit', function (e) {
                e.preventDefault();
                
                // Show loading state
                const submitBtn = document.querySelector('button[type="submit"][form="' + dashboardForm.id + '"]') || dashboardForm.querySelector('button[type="submit"]');
                let originalHtml = '';
                if (submitBtn) {
                    originalHtml = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'جاري الحفظ... <i class="fa-solid fa-spinner fa-spin"></i>';
                }
                
                const formData = new FormData(dashboardForm);
                
                // Clear any existing alerts
                document.querySelectorAll('.alert').forEach(a => a.remove());
                
                fetch(dashboardForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(res => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHtml;
                    }
                    
                    if (res.status === 200 && res.body.success) {
                        const alertHtml = `
                            <div class="alert alert-success" id="ajax-save-alert" style="margin-bottom: 25px;">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>${res.body.message}</span>
                            </div>
                        `;
                        dashboardForm.insertAdjacentHTML('beforebegin', alertHtml);
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                        
                        // Automatically clear success toast after 5s
                        setTimeout(() => {
                            const alert = document.getElementById('ajax-save-alert');
                            if (alert) alert.remove();
                        }, 5000);
                    } else {
                        const errorMsg = res.body.error || 'حدث خطأ أثناء حفظ البيانات.';
                        const alertHtml = `
                            <div class="alert alert-danger" style="margin-bottom: 25px;">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>${errorMsg}</span>
                            </div>
                        `;
                        dashboardForm.insertAdjacentHTML('beforebegin', alertHtml);
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                })
                .catch(err => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHtml;
                    }
                    
                    const alertHtml = `
                        <div class="alert alert-danger" style="margin-bottom: 25px;">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>تعذر الاتصال بالخادم. يرجى التحقق من اتصالك والمحاولة لاحقاً.</span>
                        </div>
                    `;
                    dashboardForm.insertAdjacentHTML('beforebegin', alertHtml);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            });
        }
    
        // Smart Form Validation for Hidden Tabs (Catching HTML5 Invalid Event)
        let isHandlingInvalid = false;
        document.addEventListener("invalid", function(e) {
            e.preventDefault(); // Prevent default browser tooltip which breaks on hidden tabs
            
            if (isHandlingInvalid) return;
            isHandlingInvalid = true; // Debounce so we only handle the first invalid element
            
            const firstInvalid = e.target;
            const parentTab = firstInvalid.closest(".tab-content");
            
            if (parentTab) {
                const tabId = parentTab.id;
                const tabBtn = document.querySelector(`.mobile-tabs-container .tab-btn[onclick*="${tabId}"]`);
                if(tabBtn) {
                    showTab(tabId, tabBtn);
                } else {
                    showTab(tabId);
                }
                
                // Slight delay to allow CSS display:block to render before scrolling
                setTimeout(() => {
                    firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
                    firstInvalid.focus();
                    
                    const originalShadow = firstInvalid.style.boxShadow;
                    firstInvalid.style.boxShadow = "0 0 0 3px rgba(239, 68, 68, 0.6)";
                    firstInvalid.style.borderColor = "var(--danger)";
                    setTimeout(() => { 
                        firstInvalid.style.boxShadow = originalShadow; 
                        firstInvalid.style.borderColor = "";
                    }, 2500);
                }, 150);
            }
            
            setTimeout(() => { isHandlingInvalid = false; }, 1000);
        }, true); // Use capture phase to intercept the event before it bubbles

        // Define all potential tab IDs
        const allTabs = [
            'tab-profile',
            'tab-sections',
            'tab-social',
            'tab-skills',
            'tab-experiences',
            'tab-education',
            'tab-certificates',
            'tab-projects',
            'tab-languages',
            'tab-references'
        ];

        let tabOrder = [];
        function updateTabOrder() {
            tabOrder = allTabs.filter(tabId => {
                if (['tab-profile', 'tab-sections', 'tab-social'].includes(tabId)) return true;
                const btn = document.querySelector(`.mobile-tabs-container .tab-btn[onclick*="${tabId}"]`);
                return btn !== null;
            });
        }

        function nextTab() {
            updateTabOrder();
            const activeTab = document.querySelector('.tab-content.active');
            if (activeTab) {
                const currentIndex = tabOrder.indexOf(activeTab.id);
                if (currentIndex !== -1 && currentIndex < tabOrder.length - 1) {
                    const nextTabId = tabOrder[currentIndex + 1];
                    const nextBtn = document.querySelector(`.mobile-tabs-container .tab-btn[onclick*="${nextTabId}"]`);
                    showTab(nextTabId, nextBtn);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        }

        function prevTab() {
            updateTabOrder();
            const activeTab = document.querySelector('.tab-content.active');
            if (activeTab) {
                const currentIndex = tabOrder.indexOf(activeTab.id);
                if (currentIndex > 0) {
                    const prevTabId = tabOrder[currentIndex - 1];
                    const prevBtn = document.querySelector(`.mobile-tabs-container .tab-btn[onclick*="${prevTabId}"]`);
                    showTab(prevTabId, prevBtn);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        }

        // Inject navigation buttons and style the save footer on load
        document.addEventListener('DOMContentLoaded', function() {
            updateTabOrder();
            
            // 1. Move the sticky footer buttons to the last active tab and make it non-sticky
            const stickyFooter = document.querySelector('div[style*="position: sticky"]');
            const lastTabId = tabOrder[tabOrder.length - 1];
            const lastTab = document.getElementById(lastTabId);
            if (stickyFooter && lastTab) {
                // Style footer to be a standard card bottom panel
                stickyFooter.removeAttribute('style');
                stickyFooter.style.marginTop = '30px';
                stickyFooter.style.borderTop = '1px solid var(--border-color)';
                stickyFooter.style.paddingTop = '20px';
                stickyFooter.style.display = 'flex';
                stickyFooter.style.gap = '15px';
                stickyFooter.style.justifyContent = 'flex-end';
                
                // Extract inner container div and inject a back button
                const buttonsContainer = stickyFooter.querySelector('div');
                if (buttonsContainer) {
                    buttonsContainer.removeAttribute('style');
                    buttonsContainer.style.display = 'flex';
                    buttonsContainer.style.gap = '15px';
                    buttonsContainer.style.justifyContent = 'flex-end';
                    buttonsContainer.style.width = '100%';
                    buttonsContainer.style.flexWrap = 'wrap';
                    
                    // Create prev button for the last active tab
                    const prevBtn = document.createElement('button');
                    prevBtn.type = 'button';
                    prevBtn.className = 'btn btn-secondary';
                    prevBtn.innerHTML = '⬅ السابق';
                    prevBtn.style.width = 'auto';
                    prevBtn.style.padding = '12px 24px';
                    prevBtn.onclick = prevTab;
                    
                    buttonsContainer.insertBefore(prevBtn, buttonsContainer.firstChild);
                }
                
                // Append the stickyFooter to the last active tab
                lastTab.appendChild(stickyFooter);
            }

            // 2. Inject Next/Prev buttons in all active tabs except the last one
            tabOrder.forEach((tabId, idx) => {
                if (tabId === lastTabId) return; // Skip last active tab
                
                const tabEl = document.getElementById(tabId);
                if (tabEl) {
                    const navContainer = document.createElement('div');
                    navContainer.style.display = 'flex';
                    navContainer.style.gap = '15px';
                    navContainer.style.justifyContent = 'flex-end';
                    navContainer.style.marginTop = '30px';
                    navContainer.style.borderTop = '1px solid var(--border-color)';
                    navContainer.style.paddingTop = '20px';
                    
                    // If not the first tab, add a prev button
                    if (idx > 0) {
                        const prevBtn = document.createElement('button');
                        prevBtn.type = 'button';
                        prevBtn.className = 'btn btn-secondary';
                        prevBtn.innerHTML = '⬅ السابق';
                        prevBtn.style.width = 'auto';
                        prevBtn.style.padding = '10px 24px';
                        prevBtn.onclick = prevTab;
                        navContainer.appendChild(prevBtn);
                    }
                    
                    // Add next button
                    const nextBtn = document.createElement('button');
                    nextBtn.type = 'button';
                    nextBtn.className = 'btn btn-primary';
                    nextBtn.innerHTML = 'التالي ➔';
                    nextBtn.style.width = 'auto';
                    nextBtn.style.padding = '10px 28px';
                    nextBtn.style.fontWeight = '600';
                    nextBtn.onclick = nextTab;
                    navContainer.appendChild(nextBtn);
                    
                    tabEl.appendChild(navContainer);
                }
            });
        });
    </script>
</body>
</html>
