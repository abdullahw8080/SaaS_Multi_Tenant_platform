<?php

namespace App\Controllers;

use App\Core\Database;
use App\Models\User;
use App\Models\Site;
use App\Models\Profile;
use App\Models\SiteSection;
use App\Services\ApprovalService;

class AdminController extends BaseController {
    /**
     * Show admin dashboard listing all sites/users.
     */
    public function index(): void {
        $db = Database::getInstance()->getConnection();
        
        // Fetch all sites with their owner details and templates
        $sql = "SELECT s.*, u.email, u.phone, u.status as user_status, t.name as template_name, p.full_name 
                FROM `sites` s
                JOIN `users` u ON s.user_id = u.id
                JOIN `templates` t ON s.template_id = t.id
                LEFT JOIN `profiles` p ON s.id = p.site_id
                ORDER BY s.created_at DESC";
        $stmt = $db->query($sql);
        $sites = $stmt->fetchAll();

        // Fetch all available templates
        $stmtTemplates = $db->query("SELECT * FROM `templates` WHERE `is_active` = 1");
        $templates = $stmtTemplates->fetchAll();

        $this->view('admin/dashboard', [
            'sites'      => $sites,
            'templates'  => $templates,
            'csrf_token' => $this->csrfToken()
        ]);
    }

    /**
     * Approve a site, publishing it live.
     */
    public function approve(array $params): void {
        $csrfToken = $_GET['csrf_token'] ?? '';
        if (!\App\Core\Auth::verifyCsrfToken($csrfToken)) {
            header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
            echo "<h1>400 Bad Request</h1><p>CSRF verification failed.</p>";
            exit;
        }
        $siteId = (int)($params['id'] ?? 0);
        
        $approvalService = new ApprovalService();
        if ($approvalService->approve($siteId)) {
            $_SESSION['flash_success'] = "تمت الموافقة على الموقع وتفعيله بنجاح.";
        } else {
            $_SESSION['flash_error'] = "فشلت عملية الموافقة على الموقع.";
        }
        $this->redirect('/admin');
    }

    /**
     * Reject a site and specify a reason.
     */
    public function reject(array $params): void {
        $this->verifyCsrf();
        $siteId = (int)($params['id'] ?? 0);
        $reason = trim($_POST['rejection_reason'] ?? '');

        if (empty($reason)) {
            $_SESSION['flash_error'] = "يجب تحديد سبب الرفض.";
            $this->redirect('/admin');
        }

        $approvalService = new ApprovalService();
        if ($approvalService->reject($siteId, $reason)) {
            $_SESSION['flash_success'] = "تم رفض الموقع وإشعار العميل بالسبب.";
        } else {
            $_SESSION['flash_error'] = "فشلت عملية رفض الموقع.";
        }
        $this->redirect('/admin');
    }

    /**
     * Toggle a user account status (active / inactive).
     */
    public function toggleUserStatus(array $params): void {
        $csrfToken = $_GET['csrf_token'] ?? '';
        if (!\App\Core\Auth::verifyCsrfToken($csrfToken)) {
            header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
            echo "<h1>400 Bad Request</h1><p>CSRF verification failed.</p>";
            exit;
        }
        $userId = (int)($params['id'] ?? 0);
        
        $userModel = new User();
        $user = $userModel->find($userId);

        if ($user) {
            $newStatus = ($user['status'] === 'active') ? 'inactive' : 'active';
            $userModel->update($userId, ['status' => $newStatus]);
            
            // Invalidate the site cache on status changes to reflect instantly
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT slug FROM `sites` WHERE `user_id` = :user_id LIMIT 1");
            $stmt->execute(['user_id' => $userId]);
            $slug = $stmt->fetchColumn();
            if ($slug) {
                \App\Services\ApprovalService::invalidateCache($slug);
            }

            $_SESSION['flash_success'] = "تم تغيير حالة حساب المستخدم وتحديث الكاش بنجاح.";
        } else {
            $_SESSION['flash_error'] = "المستخدم غير موجود.";
        }
        $this->redirect('/admin');
    }

    /**
     * Assign a template to a site.
     * Note: Changing a template re-initializes default sections for that site.
     */
    public function assignTemplate(array $params): void {
        $this->verifyCsrf();
        $siteId = (int)($params['id'] ?? 0);
        $templateId = (int)($_POST['template_id'] ?? 0);

        $siteModel = new Site();
        $site = $siteModel->find($siteId);

        if ($site && $templateId > 0) {
            $siteModel->update($siteId, [
                'template_id' => $templateId,
                'approval_status' => 'draft' // Reset to draft so it gets reviewed if needed
            ]);

            // Re-initialize default sections for the new template
            $sectionModel = new SiteSection();
            $sectionModel->initializeDefaultSections($siteId, $templateId);

            // Invalidate cache
            \App\Services\ApprovalService::invalidateCache($site['slug']);

            $_SESSION['flash_success'] = "تم تغيير قالب الموقع بنجاح وإعادة تهيئة الأقسام الافتراضية.";
        } else {
            $_SESSION['flash_error'] = "الموقع أو القالب غير موجود.";
        }
        $this->redirect('/admin');
    }

    /**
     * Assign a profession type to a site (INDEPENDENT from template_id).
     * Does NOT reset sections, does NOT change the template.
     */
    public function assignProfession(array $params): void {
        $this->verifyCsrf();
        $siteId = (int)($params['id'] ?? 0);
        $allowedProfessions = ['developer','engineer','doctor','pharmacist','lawyer','teacher','executive','accountant','student','other'];
        $profession = in_array($_POST['profession_type'] ?? '', $allowedProfessions) ? $_POST['profession_type'] : 'developer';

        $siteModel = new Site();
        $site = $siteModel->find($siteId);

        if ($site) {
            $siteModel->update($siteId, [
                'profession_type' => $profession
            ]);

            // Invalidate cache so next render shows new profession colors
            \App\Services\ApprovalService::invalidateCache($site['slug']);

            $_SESSION['flash_success'] = "تم تغيير مهنة الموقع بنجاح.";
        } else {
            $_SESSION['flash_error'] = "الموقع غير موجود.";
        }
        $this->redirect('/admin');
    }

    public function createClient(): void {
        $this->verifyCsrf();

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $fullName = trim($_POST['full_name'] ?? '');
        $templateId = (int)($_POST['template_id'] ?? 1);

        if (empty($email) || empty($password) || empty($fullName)) {
            $_SESSION['flash_error'] = "جميع حقول إنشاء العميل مطلوبة.";
            $this->redirect('/admin');
        }

        $userModel = new User();
        if ($userModel->emailExists($email)) {
            $_SESSION['flash_error'] = "البريد الإلكتروني مسجل بالفعل.";
            $this->redirect('/admin');
        }

        // 1. Create client
        $userId = $userModel->registerClient($email, $password);
        if (!$userId) {
            $_SESSION['flash_error'] = "فشل إنشاء حساب العميل.";
            $this->redirect('/admin');
        }

        // 2. Generate slug
        $emailPrefix = explode('@', $email)[0];
        $slug = preg_replace('/[^a-zA-Z0-9-]/', '-', $emailPrefix);
        $slug = trim(strtolower($slug), '-');
        
        $siteModel = new Site();
        $originalSlug = $slug;
        $counter = 1;
        while ($siteModel->slugExists($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // 3. Create site (Approved and published immediately since it's created by Admin)
        $allowedProfessions = ['developer','engineer','doctor','pharmacist','lawyer','teacher','executive','accountant','student','other'];
        $professionType = in_array($_POST['profession_type'] ?? '', $allowedProfessions) ? $_POST['profession_type'] : 'developer';
        $siteId = $siteModel->create([
            'user_id'         => $userId,
            'slug'            => $slug,
            'template_id'     => $templateId,
            'profession_type' => $professionType,
            'is_published'    => 1,
            'approval_status' => 'approved'
        ]);

        if ($siteId) {
            // 4. Create Profile
            $profileModel = new Profile();
            $profileModel->create([
                'site_id'   => $siteId,
                'full_name' => $fullName
            ]);

            // 5. Initialize sections
            $sectionModel = new SiteSection();
            $sectionModel->initializeDefaultSections($siteId, $templateId);

            $_SESSION['flash_success'] = "تم إنشاء حساب العميل وتفعيل موقعه بنجاح (الرابط: /{$slug}).";
        } else {
            $_SESSION['flash_error'] = "حدث خطأ أثناء تهيئة موقع العميل.";
        }

        $this->redirect('/admin');
    }

    /**
     * Impersonate a client user to edit their profile directly.
     */
    public function impersonate(array $params): void {
        $csrfToken = $_GET['csrf_token'] ?? '';
        if (!\App\Core\Auth::verifyCsrfToken($csrfToken)) {
            header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
            echo "<h1>400 Bad Request</h1><p>CSRF verification failed.</p>";
            exit;
        }
        $userId = (int)($params['id'] ?? 0);
        
        $userModel = new User();
        $user = $userModel->find($userId);
        
        if (!$user || $user['role'] !== 'client') {
            $_SESSION['flash_error'] = "مستخدم غير صالح أو ليس عميلاً.";
            $this->redirect('/admin');
            return;
        }
        
        // Fetch client's site_id
        $db = Database::getInstance()->getConnection();
        $stmtSite = $db->prepare("SELECT `id` FROM `sites` WHERE `user_id` = :user_id LIMIT 1");
        $stmtSite->execute(['user_id' => $user['id']]);
        $site = $stmtSite->fetch();
        $siteId = $site ? (int)$site['id'] : null;

        // Save the admin's original credentials in session
        $_SESSION['admin_user_id'] = $_SESSION['user_id'];
        
        // Switch session credentials to the client (match Auth keys)
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = 'client';
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['site_id'] = $siteId;
        
        $_SESSION['flash_success'] = "أنت الآن تتصفح وتعدل بيانات: " . htmlspecialchars($user['email']);
        $this->redirect('/dashboard');
    }

    /**
     * Stop impersonating and return to the admin panel.
     */
    public function stopImpersonating(): void {
        if (!empty($_SESSION['admin_user_id'])) {
            $adminId = (int)$_SESSION['admin_user_id'];
            
            $userModel = new User();
            $admin = $userModel->find($adminId);
            
            if ($admin && $admin['role'] === 'admin') {
                // Restore admin session credentials
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['user_role'] = 'admin';
                $_SESSION['user_email'] = $admin['email'];
                $_SESSION['site_id'] = null;
                
                unset($_SESSION['admin_user_id']);
                $_SESSION['flash_success'] = "تمت العودة للوحة الإدارة العامة بنجاح.";
                $this->redirect('/admin');
                return;
            }
        }
        
        // Fallback if not impersonating or admin not found
        $this->redirect('/logout');
    }

    /**
     * Delete a user completely from the database.
     */
    public function deleteUser(array $params): void {
        $this->verifyCsrf();
        $userId = (int)($params['id'] ?? 0);

        if ($userId === (int)\App\Core\Auth::id()) {
            $_SESSION['flash_error'] = "لا يمكنك حذف حسابك الحالي الذي تستخدمه لتسجيل الدخول.";
            $this->redirect('/admin');
            return;
        }

        $db = Database::getInstance()->getConnection();
        
        // Delete user (cascade will handle sites, profiles, sections, etc.)
        $stmt = $db->prepare("DELETE FROM `users` WHERE `id` = :id");
        $success = $stmt->execute(['id' => $userId]);

        if ($success) {
            $_SESSION['flash_success'] = "تم حذف المستخدم وكافة بياناته ومواقعه التابعة له بنجاح.";
        } else {
            $_SESSION['flash_error'] = "فشلت عملية حذف المستخدم.";
        }
        $this->redirect('/admin');
    }
}

// ✅ CHECKPOINT: AdminController.php — COMPLETE (المرحلة 6 من 8)
// التالي: app/Views/admin/dashboard.php
