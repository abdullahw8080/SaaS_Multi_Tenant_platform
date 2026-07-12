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
            <a href="<?= BASE_URL ?>/dashboard/export" class="btn btn-export">
                <i class="fa-solid fa-file-zipper"></i> <span class="hide-mobile">تصدير ZIP</span>
            </a>
            <a href="<?= BASE_URL ?>/logout" class="btn btn-logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> <span class="hide-mobile">خروج</span>
            </a>
        </div>
    </div>

    <!-- Horizontal Scrollable Tabs Menu -->
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
        <button class="tab-btn" onclick="showTab('tab-skills', this)">
            <i class="fa-solid fa-code"></i> المهارات
        </button>
        <button class="tab-btn" onclick="showTab('tab-experiences', this)">
            <i class="fa-solid fa-history"></i> الخبرات
        </button>
        <button class="tab-btn" onclick="showTab('tab-education', this)">
            <i class="fa-solid fa-graduation-cap"></i> التعليم
        </button>
        <button class="tab-btn" onclick="showTab('tab-certificates', this)">
            <i class="fa-solid fa-certificate"></i> الشهادات
        </button>
        <button class="tab-btn" onclick="showTab('tab-projects', this)">
            <i class="fa-solid fa-briefcase"></i> المشاريع
        </button>
        <button class="tab-btn" onclick="showTab('tab-languages', this)">
            <i class="fa-solid fa-language"></i> اللغات
        </button>
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
            <form action="<?= BASE_URL ?>/dashboard/save" method="POST" enctype="multipart/form-data">
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
                            <label class="form-label">الاسم الكامل</label>
                            <input type="text" name="profile[full_name]" class="form-input" value="<?= htmlspecialchars($siteData['profile']['full_name'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">المسمى الوظيفي / الاختصاص</label>
                            <input type="text" name="profile[title]" class="form-input" value="<?= htmlspecialchars($siteData['profile']['title'] ?? '') ?>" placeholder="مثال: مطور ويب، أخصائي عظام">
                        </div>
                        <div class="form-group">
                            <label class="form-label">نبذة تعريفية (Bio)</label>
                            <textarea name="profile[bio]" class="form-input"><?= htmlspecialchars($siteData['profile']['bio'] ?? '') ?></textarea>
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
                            <label class="form-label">الصورة الشخصية</label>
                            <input type="file" name="profile_photo" class="form-input" style="height: auto;">
                            <?php if (!empty($siteData['profile']['photo'])): ?>
                                <input type="hidden" name="profile[existing_photo]" value="<?= htmlspecialchars($siteData['profile']['photo']) ?>">
                                <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
                                    <img src="<?= BASE_URL . htmlspecialchars($siteData['profile']['photo']) ?>.jpg" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 1px solid var(--border-color);">
                                    <span style="font-size:0.85rem; color:var(--text-muted)">تم رفع صورة مسبقاً</span>
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
                        <div class="form-group">
                            <label class="form-label no-badge">مهنتك (تُغيّر ألوان ونصوص الموقع)</label>
                            <select name="profession_type" class="form-input" style="margin-top: 12px;">
                                <?php
                                $profOptions = [
                                    'developer'  => 'مطور برمجيات',
                                    'engineer'   => 'مهندس',
                                    'doctor'     => 'طبيب',
                                    'pharmacist' => 'صيدلي',
                                    'lawyer'     => 'محامي',
                                    'teacher'    => 'مدرس / أستاذ',
                                    'executive'  => 'مدير أعمال / تنفيذي',
                                    'accountant' => 'محاسب',
                                    'student'    => 'طالب',
                                    'other'      => 'مهنة أخرى',
                                ];
                                $currentProf = $siteData['site']['profession_type'] ?? 'developer';
                                foreach ($profOptions as $key => $name): ?>
                                    <option value="<?= $key ?>" <?= $currentProf === $key ? 'selected' : '' ?>><?= $name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small style="color: var(--text-muted); display: block; margin-top: 6px; font-size: 0.8rem;">مستقلة عن القالب — تُحدد لون الثيم والنصوص التلقائية</small>
                        </div>
                    </div>

                    <div class="grid grid-2" style="margin-top: 20px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                        <div class="form-group">
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
                        <div class="form-group">
                            <label class="form-label no-badge">المراجع (References)</label>
                            <div class="lang-tabs" style="margin-top: 5px;">
                                <button type="button" class="lang-tab-btn active" onclick="switchLangTab(this, 'ref-ar')">العربية</button>
                                <button type="button" class="lang-tab-btn" onclick="switchLangTab(this, 'ref-en')">English</button>
                            </div>
                            <div id="ref-ar" class="lang-field-group active" style="margin-top: 10px;">
                                <textarea name="profile[references_text]" class="form-input" placeholder="مثال: جميع المراجع متوفرة عند الطلب..."><?= htmlspecialchars($siteData['profile']['references_text'] ?? '') ?></textarea>
                            </div>
                            <div id="ref-en" class="lang-field-group" style="margin-top: 10px;">
                                <textarea name="profile[references_text_en]" class="form-input ltr" placeholder="Example: References available upon request..."><?= htmlspecialchars($siteData['profile']['references_text_en'] ?? '') ?></textarea>
                            </div>
                        </div>
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
                                    <input type="checkbox" name="sections[<?= $sec['id'] ?>][is_visible]" value="1" <?= $sec['is_visible'] ? 'checked' : '' ?>> مرئي بالصفحة
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
                    <div class="section-title"><i class="fa-solid fa-code" style="color:var(--primary)"></i> إدارة المهارات التقنية</div>
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
                    <div class="section-title"><i class="fa-solid fa-history" style="color:var(--primary)"></i> الخبرات المهنية</div>
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
                    <div class="section-title"><i class="fa-solid fa-graduation-cap" style="color:var(--primary)"></i> التعليم والمؤهلات</div>
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
                    <div class="section-title"><i class="fa-solid fa-certificate" style="color:var(--primary)"></i> الشهادات والاعتمادات المهنية</div>
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
                    <div class="section-title"><i class="fa-solid fa-briefcase" style="color:var(--primary)"></i> المشاريع، الأبحاث، ودراسات الحالة</div>
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
                                        <input type="file" name="project_cover_<?= $i ?>" class="form-input" style="height:auto">
                                        <?php if (!empty($proj['cover_image'])): ?>
                                            <input type="hidden" name="projects[<?= $i ?>][existing_cover]" value="<?= htmlspecialchars($proj['cover_image']) ?>">
                                            <div style="margin-top:10px; display:flex; align-items:center; gap:10px;">
                                                <img src="<?= htmlspecialchars($proj['cover_image']) ?>.jpg" style="width: 80px; height: 50px; object-fit: cover; border-radius: var(--radius-sm);">
                                                <span style="font-size:0.85rem; color:var(--text-muted)">صورة الغلاف الحالية</span>
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
                                                <div class="gallery-item">
                                                    <span class="remove-row-btn" style="top:5px; left:5px; width:24px; height:24px; font-size:0.75rem;" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                                                    <input type="hidden" name="projects[<?= $i ?>][media][<?= $j ?>][existing_file]" value="<?= htmlspecialchars($media['file_path']) ?>">
                                                    <div style="display:flex; flex-direction:column; gap:8px; width:100%; padding-left: 20px;">
                                                        <div style="display:flex; align-items:center; gap:10px;">
                                                            <?php if ($media['file_type'] === 'image'): ?>
                                                                <img src="<?= htmlspecialchars($media['file_path']) ?>.jpg" style="width: 40px; height: 40px; object-fit: cover; border-radius: var(--radius-sm);">
                                                            <?php else: ?>
                                                                <div style="width: 40px; height: 40px; display:flex; align-items:center; justify-content:center; background:#ef4444; border-radius:var(--radius-sm); font-size:1.2rem; color:white;"><i class="fa-solid fa-file-pdf"></i></div>
                                                            <?php endif; ?>
                                                            <span style="font-size:0.8rem; color:var(--text-muted);">ملف مرفق جاهز</span>
                                                        </div>
                                                        <div class="grid grid-2" style="gap:10px; margin-top:5px;">
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
                    <div class="section-title"><i class="fa-solid fa-language" style="color:var(--primary)"></i> إدارة اللغات</div>
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

                <!-- Form Submit Sticky Footer -->
                <div class="section-card" style="position: sticky; bottom: 0; margin-bottom: 0; z-index: 10; border-top: 1px solid var(--border-color); box-shadow: 0 -10px 15px -3px rgba(0,0,0,0.3); border-radius: var(--radius-lg) var(--radius-lg) 0 0;">
                    <div style="display: flex; gap: 20px; justify-content: flex-end;">
                        <button type="button" class="btn btn-secondary" style="width: auto; padding: 14px 30px; font-size: 1.1rem; background-color: var(--bg-input); border-color: var(--border-color); color: var(--text-main);" onclick="window.location.reload();">
                            إلغاء التعديلات <i class="fa-solid fa-xmark"></i>
                        </button>
                        <button type="submit" class="btn btn-primary" style="width: auto; padding: 14px 40px; font-size: 1.1rem; background-color: var(--primary);">
                            حفظ جميع التعديلات <i class="fa-solid fa-floppy-disk"></i>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    <!-- JS Form Dynamism Engine -->
    <script>
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
        let skillCounter = <?= count($siteData['skills']) ?>;
        let personalSkillCounter = <?= count($siteData['personal_skills']) ?>;
        let langCounter = <?= count($siteData['languages']) ?>;
        let expCounter = <?= count($siteData['experiences']) ?>;
        let eduCounter = <?= count($siteData['education']) ?>;
        let certCounter = <?= count($siteData['certificates']) ?>;
        let projCounter = <?= count($siteData['projects']) ?>;

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

        // Dynamic project gallery media items
        function addGalleryMediaItem(projectIndex) {
            const container = document.getElementById('media-gallery-' + projectIndex);
            // Count current items inside this container
            const mediaIndex = container.querySelectorAll('.gallery-item').length;
            
            const html = `
                <div class="gallery-item">
                    <span class="remove-row-btn" style="top:5px; left:5px; width:24px; height:24px; font-size:0.75rem;" onclick="this.parentElement.remove()"><i class="fa-solid fa-trash"></i></span>
                    <div style="display:flex; flex-direction:column; gap:8px; width:100%; padding-left: 20px;">
                        <div class="grid grid-2" style="gap:10px;">
                            <div class="form-group" style="margin-bottom:0">
                                <label class="form-label" style="font-size:0.75rem">اختر ملف (صورة أو PDF)</label>
                                <input type="file" name="project_media_file_${projectIndex}_${mediaIndex}" class="form-input" style="padding:6px; font-size:0.8rem; height:auto;" required>
                            </div>
                        </div>
                        <div class="grid grid-2" style="gap:10px; margin-top:5px;">
                            <input type="text" name="projects[${projectIndex}][media][${mediaIndex}][caption]" class="form-input" style="padding:6px; font-size:0.8rem;" placeholder="تعليق الصورة بالعربية">
                            <input type="text" name="projects[${projectIndex}][media][${mediaIndex}][caption_en]" class="form-input ltr" style="padding:6px; font-size:0.8rem;" placeholder="English Caption">
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        // AJAX Form Submission (Prevent page reloads and retain inputs)
        const dashboardForm = document.querySelector('form');
        if (dashboardForm) {
            dashboardForm.addEventListener('submit', function (e) {
                e.preventDefault();
                
                // Show loading state
                const submitBtn = dashboardForm.querySelector('button[type="submit"]');
                const originalHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'جاري حفظ التعديلات... <i class="fa-solid fa-spinner fa-spin"></i>';
                
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
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                    
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
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                    
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
    </script>
</body>
</html>
