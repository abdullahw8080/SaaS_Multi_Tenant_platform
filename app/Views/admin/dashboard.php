<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بورتفوليو Hub - الإدارة العامة</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-dark: #0b0f19;
            --bg-card: #131826;
            --bg-input: #1a2030;
            --border-color: rgba(255, 255, 255, 0.08);
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --accent: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --radius-md: 8px;
            --radius-sm: 6px;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 0.9rem;
        }

        /* Top Navbar instead of Sidebar */
        .topbar {
            background: rgba(19, 24, 38, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Outfit', 'Cairo', sans-serif;
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 6px 14px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }
        .btn-logout:hover {
            background: var(--danger);
            color: #fff;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 30px;
        }

        /* Header & Tabs */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 16px;
        }

        .page-title h1 {
            font-size: 1.5rem;
            margin: 0 0 4px 0;
            font-weight: 700;
        }

        .page-title p {
            color: var(--text-muted);
            margin: 0;
            font-size: 0.85rem;
        }

        .tabs {
            display: flex;
            gap: 8px;
        }

        .tab-btn {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid transparent;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            font-family: inherit;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .tab-btn:hover {
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-main);
        }

        .tab-btn.active {
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            border-color: rgba(99, 102, 241, 0.3);
        }

        /* Alerts */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .alert-success { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .alert-danger { background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }

        /* Tab Content */
        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease;
        }
        .tab-content.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Compact Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .stat-icon.primary { color: #818cf8; background: rgba(99, 102, 241, 0.15); }
        .stat-icon.warning { color: #fbbf24; background: rgba(245, 158, 11, 0.15); }
        .stat-icon.success { color: #34d399; background: rgba(16, 185, 129, 0.15); }

        .stat-info h3 {
            font-size: 1.3rem;
            margin: 0;
            line-height: 1.2;
            color: var(--text-main);
        }

        .stat-info p {
            margin: 2px 0 0 0;
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        /* Compact Table */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px;
        }

        .table-wrapper {
            overflow-x: auto;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
            font-size: 0.85rem;
        }

        th {
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-muted);
            padding: 12px 16px;
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .td-user strong { color: var(--text-main); font-size: 0.85rem; }
        .td-user span { color: var(--text-muted); font-size: 0.8rem; }
        .td-user a { color: #818cf8; text-decoration: none; font-size: 0.8rem; }
        .td-user a:hover { text-decoration: underline; }

        /* Compact Badges */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .badge-approved { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); }
        .badge-under_review { background: rgba(99, 102, 241, 0.15); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.2); }
        .badge-pending { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.2); }
        .badge-rejected { background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }

        /* Form Inputs */
        .form-card-wrapper {
            max-width: 500px;
            margin: 0 auto;
        }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; margin-bottom: 6px; font-size: 0.85rem; color: var(--text-muted); }
        .form-input {
            width: 100%; padding: 10px 12px; border-radius: var(--radius-sm);
            border: 1px solid var(--border-color); background: var(--bg-input);
            color: var(--text-main); font-size: 0.85rem; font-family: inherit;
            box-sizing: border-box; transition: 0.2s;
        }
        .form-input:focus { border-color: var(--primary); outline: none; }
        .ltr { direction: ltr; text-align: left; }

        /* Buttons */
        .action-flex {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .action-btn {
            padding: 6px 10px; border-radius: 4px; font-size: 0.8rem;
            border: 1px solid transparent; cursor: pointer; font-family: inherit;
            display: inline-flex; align-items: center; gap: 4px; text-decoration: none;
            color: #fff; transition: 0.2s;
        }
        .action-approve { background: rgba(16, 185, 129, 0.15); color: #34d399; border-color: rgba(16, 185, 129, 0.3); }
        .action-approve:hover { background: var(--accent); color: #fff; }
        .action-reject { background: rgba(239, 68, 68, 0.15); color: #f87171; border-color: rgba(239, 68, 68, 0.3); }
        .action-reject:hover { background: var(--danger); color: #fff; }
        .action-edit { background: rgba(99, 102, 241, 0.15); color: #818cf8; border-color: rgba(99, 102, 241, 0.3); }
        .action-edit:hover { background: var(--primary); color: #fff; }
        .action-delete { background: rgba(239, 68, 68, 0.15); color: #f87171; border-color: rgba(239, 68, 68, 0.3); }
        .action-delete:hover { background: var(--danger); color: #fff; }
        
        .action-toggle { background: transparent; border-color: var(--border-color); color: var(--text-main); }
        .action-toggle:hover { background: rgba(255, 255, 255, 0.05); }

        .btn-submit {
            background: var(--primary); color: #fff; border: none; padding: 10px 20px;
            border-radius: var(--radius-sm); font-size: 0.9rem; font-weight: 600;
            width: 100%; cursor: pointer; transition: 0.2s; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { background: var(--primary-hover); }

        .select-mini {
            padding: 6px 10px; background: var(--bg-input); border: 1px solid var(--border-color);
            color: var(--text-main); border-radius: 4px; font-size: 0.8rem; font-family: inherit; cursor: pointer;
        }
        .select-mini option, .form-input option {
            background: #1a2030 !important;
            color: #f8fafc !important;
        }

        /* Modal */
        .modal {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(4px);
            align-items: center; justify-content: center; z-index: 100;
        }
        .modal-content {
            background: var(--bg-card); border: 1px solid var(--border-color);
            border-radius: var(--radius-md); padding: 24px; width: 100%; max-width: 400px;
        }
        .modal-title { font-size: 1rem; color: var(--danger); margin-bottom: 16px; font-weight: 700; display: flex; align-items: center; gap: 8px;}

        @media (max-width: 768px) {
            .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
            .tabs { width: 100%; overflow-x: auto; padding-bottom: 4px; }
            .tab-btn { white-space: nowrap; }
        }
    </style>
</head>
<body>

    <!-- Top Navbar instead of Sidebar -->
    <div class="topbar">
        <div class="topbar-logo">
            <i class="fa-solid fa-chart-pie"></i>
            بورتفوليو Hub
        </div>
        <a href="<?= BASE_URL ?>/logout" class="btn-logout">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> خروج
        </a>
    </div>

    <div class="container">
        
        <!-- Header & Tabs -->
        <div class="page-header">
            <div class="page-title">
                <h1>الإدارة العامة</h1>
                <p>مرحباً بك، يمكنك إدارة العملاء أو إنشاء حسابات جديدة من هنا.</p>
            </div>
            <div class="tabs">
                <button class="tab-btn active" onclick="switchTab('tab-manage', this)">
                    <i class="fa-solid fa-list-check"></i> إدارة المواقع
                </button>
                <button class="tab-btn" onclick="switchTab('tab-create', this)">
                    <i class="fa-solid fa-user-plus"></i> إنشاء حساب جديد
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
            </div>
        <?php endif; ?>

        <!-- Tab 1: Manage Sites -->
        <div id="tab-manage" class="tab-content active">
            <!-- Stats -->
            <?php
                $totalSites = count($sites);
                $pendingApprovals = count(array_filter($sites, fn($s) => $s['approval_status'] === 'under_review'));
                $approvedSites = count(array_filter($sites, fn($s) => $s['approval_status'] === 'approved'));
            ?>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon primary"><i class="fa-solid fa-globe"></i></div>
                    <div class="stat-info">
                        <h3><?= $totalSites ?></h3>
                        <p>إجمالي الحسابات</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon warning"><i class="fa-solid fa-clock"></i></div>
                    <div class="stat-info">
                        <h3><?= $pendingApprovals ?></h3>
                        <p>بانتظار المراجعة</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon success"><i class="fa-solid fa-check-double"></i></div>
                    <div class="stat-info">
                        <h3><?= $approvedSites ?></h3>
                        <p>مواقع نشطة</p>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>العميل والموقع</th>
                                <th>القالب المختار</th>
                                <th>حالة المراجعة</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($sites)): ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">لا يوجد عملاء مسجلين.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($sites as $s): ?>
                                    <tr>
                                        <td class="td-user">
                                            <strong><?= htmlspecialchars($s['full_name'] ?: 'غير محدد') ?></strong><br>
                                            <span><?= htmlspecialchars($s['email']) ?></span><br>
                                            <a href="<?= BASE_URL ?>/<?= htmlspecialchars($s['slug']) ?>" target="_blank">
                                                /<?= htmlspecialchars($s['slug']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <form action="<?= BASE_URL ?>/admin/assign-template/<?= $s['id'] ?>" method="POST" style="margin:0;">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                                                <select name="template_id" class="select-mini" onchange="this.form.submit()">
                                                    <?php foreach ($templates as $t): ?>
                                                        <option value="<?= $t['id'] ?>" <?= $s['template_id'] == $t['id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($t['name']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </form>
                                            <!-- Profession Type — تغيير مستقل -->
                                            <form action="<?= BASE_URL ?>/admin/assign-profession/<?= $s['id'] ?>" method="POST" style="margin:4px 0 0;">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                                                <select name="profession_type" class="select-mini" onchange="this.form.submit()" style="border-color: rgba(201,169,78,0.4); background: rgba(201,169,78,0.05); max-width: 100%;">
                                                    <?php
                                                    require_once dirname(__DIR__, 2) . '/Config/ProfessionConfig.php';
                                                    $professions = ProfessionConfig::getAvailableProfessions('ar');
                                                    foreach ($professions as $key => $name): ?>
                                                        <option value="<?= $key ?>" <?= ($s['profession_type'] ?? 'developer') === $key ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($name) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= $s['approval_status'] ?>">
                                                <?php
                                                    switch ($s['approval_status']) {
                                                        case 'approved': echo 'تم القبول'; break;
                                                        case 'under_review': echo 'قيد المراجعة'; break;
                                                        case 'rejected': echo 'مرفوض'; break;
                                                        case 'pending': echo 'بانتظار الإدخال'; break;
                                                        default: echo 'مسودة';
                                                    }
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?= BASE_URL ?>/admin/toggle-status/<?= $s['user_id'] ?>" class="action-btn action-toggle" title="تفعيل / تعطيل">
                                                <?= $s['user_status'] === 'active' ? '<i class="fa-solid fa-unlock" style="color:#34d399;"></i>' : '<i class="fa-solid fa-lock" style="color:#f87171;"></i>' ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="action-flex">
                                                <a href="<?= BASE_URL ?>/admin/impersonate/<?= $s['user_id'] ?>" class="action-btn action-edit" title="دخول وتعديل">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <button type="button" class="action-btn action-delete" onclick="confirmDeleteUser(<?= $s['user_id'] ?>, '<?= htmlspecialchars($s['email'], ENT_QUOTES, 'UTF-8') ?>')" title="حذف المستخدم نهائياً">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <?php if ($s['approval_status'] !== 'approved'): ?>
                                                    <a href="<?= BASE_URL ?>/admin/approve/<?= $s['id'] ?>" class="action-btn action-approve" title="موافقة">
                                                        <i class="fa-solid fa-check"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($s['approval_status'] === 'under_review' || $s['approval_status'] === 'approved'): ?>
                                                    <button class="action-btn action-reject" onclick="openRejectModal(<?= $s['id'] ?>)" title="رفض">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab 2: Create Account -->
        <div id="tab-create" class="tab-content">
            <div class="form-card-wrapper">
                <div class="card">
                    <form action="<?= BASE_URL ?>/admin/create-client" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                        
                        <div class="form-group">
                            <label class="form-label">الاسم الكامل للعميل</label>
                            <input type="text" name="full_name" class="form-input" placeholder="محمد أحمد" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-input ltr" placeholder="client@example.com" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">كلمة المرور المؤقتة</label>
                            <input type="text" name="password" class="form-input ltr" placeholder="password123" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">اختر القالب الافتراضي</label>
                            <select name="template_id" class="form-input">
                                <?php foreach ($templates as $template): ?>
                                    <option value="<?= $template['id'] ?>"><?= htmlspecialchars($template['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">المهنة الافتراضية (مستقلة عن القالب)</label>
                            <select name="profession_type" class="form-input">
                                <?php
                                $professions = ProfessionConfig::getAvailableProfessions('ar');
                                foreach ($professions as $key => $name): ?>
                                    <option value="<?= $key ?>"><?= htmlspecialchars($name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fa-solid fa-plus"></i> إنشاء الحساب وتفعيل الموقع
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <div class="modal-title">
                <i class="fa-solid fa-triangle-exclamation"></i>
                رفض طلب النشر
            </div>
            <form id="rejectForm" action="" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <div class="form-group">
                    <label class="form-label">سبب الرفض (سيظهر للعميل للتعديل):</label>
                    <textarea name="rejection_reason" class="form-input" style="min-height: 90px; resize: vertical;" placeholder="يرجى تعديل..." required></textarea>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 15px;">
                    <button type="submit" class="action-btn action-reject" style="flex:1; justify-content:center; padding:8px;">تأكيد الرفض</button>
                    <button type="button" class="action-btn" style="flex:1; justify-content:center; background:var(--bg-input); color:var(--text-main); border:1px solid var(--border-color);" onclick="closeRejectModal()">إلغاء</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-title" style="color: var(--danger);">
                <i class="fa-solid fa-trash-can"></i>
                تأكيد حذف المستخدم
            </div>
            <p style="color: var(--text-muted); margin-bottom: 20px;">
                هل أنت متأكد من رغبتك في حذف المستخدم <strong id="deleteUserEmail" style="color: var(--text-main);"></strong> نهائياً؟ 
                <br><br>
                <span style="color: var(--danger); font-size: 0.85rem; font-weight: 600;">تحذير: سيتم حذف جميع مواقع هذا المستخدم وسيرته الذاتية وكافة البيانات المرتبطة به نهائياً ولا يمكن التراجع عن هذا الإجراء!</span>
            </p>
            <form id="deleteForm" action="" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                <div style="display: flex; gap: 10px; margin-top: 15px;">
                    <button type="submit" class="action-btn" style="flex:1; justify-content:center; padding:8px; background-color: var(--danger); border-color: var(--danger); color: white;">تأكيد الحذف النهائي</button>
                    <button type="button" class="action-btn" style="flex:1; justify-content:center; background:var(--bg-input); color:var(--text-main); border:1px solid var(--border-color);" onclick="closeDeleteModal()">إلغاء</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function switchTab(tabId, btn) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            // Remove active from all buttons
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabId).classList.add('active');
            btn.classList.add('active');
        }

        function openRejectModal(siteId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = '<?= BASE_URL ?>/admin/reject/' + siteId;
            modal.style.display = 'flex';
        }
        
        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }

        function confirmDeleteUser(userId, email) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            document.getElementById('deleteUserEmail').textContent = email;
            form.action = '<?= BASE_URL ?>/admin/delete-user/' + userId;
            modal.style.display = 'flex';
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const rejectModal = document.getElementById('rejectModal');
            const deleteModal = document.getElementById('deleteModal');
            if (event.target == rejectModal) {
                rejectModal.style.display = "none";
            }
            if (event.target == deleteModal) {
                deleteModal.style.display = "none";
            }
        }
    </script>
</body>
</html>
