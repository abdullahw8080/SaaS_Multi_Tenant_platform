<?php
$file = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\app\\Views\\client\\dashboard.php';
$content = file_get_contents($file);

// 1. Replace CSS block
$cssPattern = '/<style>.*?<\/style>/s';
$newCss = '<style>
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
            font-family: \'Outfit\', \'Cairo\', sans-serif;
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
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.4);
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
    </style>';

$content = preg_replace($cssPattern, $newCss, $content);

// 2. Replace HTML Layout: from <body> to <div class="main-content">
$layoutPattern = '/<body>.*?<div class="main-content">/s';
$newLayout = '<body>
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
        <button class="tab-btn active" onclick="showTab(\'tab-profile\', this)">
            <i class="fa-solid fa-user"></i> الشخصية
        </button>
        <button class="tab-btn" onclick="showTab(\'tab-sections\', this)">
            <i class="fa-solid fa-shapes"></i> الأقسام
        </button>
        <button class="tab-btn" onclick="showTab(\'tab-social\', this)">
            <i class="fa-solid fa-share-nodes"></i> التواصل
        </button>
        <button class="tab-btn" onclick="showTab(\'tab-skills\', this)">
            <i class="fa-solid fa-code"></i> المهارات
        </button>
        <button class="tab-btn" onclick="showTab(\'tab-experiences\', this)">
            <i class="fa-solid fa-history"></i> الخبرات
        </button>
        <button class="tab-btn" onclick="showTab(\'tab-education\', this)">
            <i class="fa-solid fa-graduation-cap"></i> التعليم
        </button>
        <button class="tab-btn" onclick="showTab(\'tab-certificates\', this)">
            <i class="fa-solid fa-certificate"></i> الشهادات
        </button>
        <button class="tab-btn" onclick="showTab(\'tab-projects\', this)">
            <i class="fa-solid fa-briefcase"></i> المشاريع
        </button>
        <button class="tab-btn" onclick="showTab(\'tab-languages\', this)">
            <i class="fa-solid fa-language"></i> اللغات
        </button>
    </div>

    <div class="main-content">';

$content = preg_replace($layoutPattern, $newLayout, $content);

// 3. Update the closing divs and JS. Since we removed <div class="dashboard-container"> and <div class="sidebar">, we have 1 less closing div at the end before script.
// Wait, the original end was:
//         </div> <!-- end main-content -->
//     </div> <!-- end dashboard-container -->
//     <!-- JS ...
// Our new structure has only <div class="main-content"> to close.
$endPattern = '/<\/div>\s*<\/div>\s*<!-- JS/s';
$newEnd = '</div>
    <!-- JS';
$content = preg_replace($endPattern, $newEnd, $content);

// 4. Fix JS `showTab` function to use new button logic
$jsPattern = '/function showTab\(tabId\) \{.*?\}\s*function switchLangTab/s';
$newJs = 'function showTab(tabId, btnElement = null) {
            const contents = document.querySelectorAll(\'.tab-content\');
            contents.forEach(content => content.classList.remove(\'active\'));
            
            const target = document.getElementById(tabId);
            if (target) {
                target.classList.add(\'active\');
            }
            
            const buttons = document.querySelectorAll(\'.mobile-tabs-container .tab-btn\');
            buttons.forEach(btn => btn.classList.remove(\'active\'));
            
            if (btnElement) {
                btnElement.classList.add(\'active\');
            } else {
                buttons.forEach(btn => {
                    if(btn.getAttribute(\'onclick\').includes(tabId)) {
                        btn.classList.add(\'active\');
                    }
                });
            }
        }

        function switchLangTab';
$content = preg_replace($jsPattern, $newJs, $content);

file_put_contents($file, $content);
echo "Successfully rewrote the client dashboard.";
?>
