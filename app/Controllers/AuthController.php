<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\User;
use App\Models\Site;
use App\Models\Profile;
use App\Models\SiteSection;

class AuthController extends BaseController {
    /**
     * Show login form.
     */
    public function showLogin(): void {
        if (Auth::check()) {
            $this->redirect(Auth::role() === 'admin' ? '/admin' : '/dashboard');
        }
        $this->view('auth/login', ['csrf_token' => $this->csrfToken()]);
    }

    /**
     * Process login request.
     */
    public function login(): void {
        $this->verifyCsrf();

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->view('auth/login', [
                'error'      => 'يرجى إدخال البريد الإلكتروني وكلمة المرور.',
                'csrf_token' => $this->csrfToken()
            ]);
            return;
        }

        if (Auth::login($email, $password)) {
            $this->redirect(Auth::role() === 'admin' ? '/admin' : '/dashboard');
        } else {
            $this->view('auth/login', [
                'error'      => 'بيانات الدخول غير صحيحة أو الحساب غير نشط.',
                'csrf_token' => $this->csrfToken()
            ]);
        }
    }

    /**
     * Show self-registration form.
     */
    public function showRegister(): void {
        if (Auth::check()) {
            $this->redirect(Auth::role() === 'admin' ? '/admin' : '/dashboard');
        }
        $this->view('auth/register', ['csrf_token' => $this->csrfToken()]);
    }

    /**
     * Process self-registration.
     */
    public function register(): void {
        $this->verifyCsrf();

        $email           = trim($_POST['email'] ?? '');
        $password        = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $fullName        = trim($_POST['full_name'] ?? '');

        if (empty($email) || empty($password) || empty($fullName)) {
            $this->view('auth/register', [
                'error'      => 'جميع الحقول مطلوبة.',
                'csrf_token' => $this->csrfToken()
            ]);
            return;
        }

        if ($password !== $confirmPassword) {
            $this->view('auth/register', [
                'error'      => 'كلمتا المرور غير متطابقتين.',
                'csrf_token' => $this->csrfToken()
            ]);
            return;
        }

        if (strlen($password) < 6) {
            $this->view('auth/register', [
                'error'      => 'يجب أن تكون كلمة المرور من 6 أحرف على الأقل.',
                'csrf_token' => $this->csrfToken()
            ]);
            return;
        }

        $userModel = new User();
        if ($userModel->emailExists($email)) {
            $this->view('auth/register', [
                'error'      => 'البريد الإلكتروني مسجل بالفعل.',
                'csrf_token' => $this->csrfToken()
            ]);
            return;
        }

        // 1. Create client user
        $userId = $userModel->registerClient($email, $password);
        if (!$userId) {
            $this->view('auth/register', [
                'error'      => 'حدث خطأ أثناء إنشاء الحساب، يرجى المحاولة لاحقاً.',
                'csrf_token' => $this->csrfToken()
            ]);
            return;
        }

        // 2. Generate a clean unique slug from email prefix
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

        // 3. Create site (Default template 1 = Developer Dark, status = pending/draft)
        $allowedProfessions = ['developer','engineer','doctor','pharmacist','lawyer','teacher','executive','accountant','student','other'];
        $profession = in_array($_POST['profession_type'] ?? '', $allowedProfessions) ? $_POST['profession_type'] : 'developer';

        $siteId = $siteModel->create([
            'user_id'         => $userId,
            'slug'            => $slug,
            'template_id'     => 1, // Developer template by default
            'profession_type' => $profession,
            'is_published'    => 0,
            'approval_status' => 'pending' // Initial status is pending approval workflow
        ]);

        if ($siteId) {
            // 4. Create Profile
            $profileModel = new Profile();
            $profileModel->create([
                'site_id'   => $siteId,
                'full_name' => $fullName
            ]);

            // 5. Initialize default sections
            $sectionModel = new SiteSection();
            $sectionModel->initializeDefaultSections($siteId, 1);
        }

        // 6. Log in and redirect to dashboard
        if (Auth::login($email, $password)) {
            $this->redirect('/dashboard');
        } else {
            $this->redirect('/login');
        }
    }

    /**
     * Logout.
     */
    public function logout(): void {
        Auth::logout();
        $this->redirect('/login');
    }

    /**
     * Verify email and profession for password reset.
     */
    public function forgotPasswordVerify(): void {
        header('Content-Type: application/json');
        
        $email      = trim($_POST['email'] ?? '');
        $profession = $_POST['profession_type'] ?? '';

        if (empty($email) || empty($profession)) {
            echo json_encode(['success' => false, 'error' => 'جميع الحقول مطلوبة.']);
            exit;
        }

        // Search user by email
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmtUser = $db->prepare("SELECT id FROM `users` WHERE `email` = :email AND `role` = 'client'");
        $stmtUser->execute(['email' => $email]);
        $user = $stmtUser->fetch(\PDO::FETCH_ASSOC);

        if (!$user) {
            echo json_encode(['success' => false, 'error' => 'البريد الإلكتروني المدخل غير مسجل لدينا أو حساب مدير.']);
            exit;
        }

        // Verify that the site matches this profession
        $stmtSite = $db->prepare("SELECT COUNT(*) FROM `sites` WHERE `user_id` = :user_id AND `profession_type` = :profession");
        $stmtSite->execute(['user_id' => $user['id'], 'profession' => $profession]);
        
        if ((int)$stmtSite->fetchColumn() === 0) {
            echo json_encode(['success' => false, 'error' => 'المهنة/الوظيفة المحددة غير متطابقة مع هذا الحساب.']);
            exit;
        }

        // Store reset state in session
        $_SESSION['reset_user_id'] = $user['id'];
        $_SESSION['reset_email']   = $email;

        echo json_encode(['success' => true]);
        exit;
    }

    /**
     * Process password reset.
     */
    public function forgotPasswordReset(): void {
        header('Content-Type: application/json');

        if (empty($_SESSION['reset_user_id']) || empty($_SESSION['reset_email'])) {
            echo json_encode(['success' => false, 'error' => 'غير مصرح لك بإجراء هذه العملية أو انتهت صلاحية الجلسة.']);
            exit;
        }

        $userId = $_SESSION['reset_user_id'];
        $email  = $_SESSION['reset_email'];

        $password        = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($password) || empty($confirmPassword)) {
            echo json_encode(['success' => false, 'error' => 'يرجى إدخال كلمة المرور وتأكيدها.']);
            exit;
        }

        if ($password !== $confirmPassword) {
            echo json_encode(['success' => false, 'error' => 'كلمتا المرور غير متطابقتين.']);
            exit;
        }

        if (strlen($password) < 6) {
            echo json_encode(['success' => false, 'error' => 'يجب أن تكون كلمة المرور من 6 أحرف على الأقل.']);
            exit;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmtUpdate = $db->prepare("UPDATE `users` SET `password_hash` = :hash WHERE `id` = :id");
        $success = $stmtUpdate->execute(['hash' => $hash, 'id' => $userId]);

        if ($success) {
            // Automatically log them in!
            Auth::login($email, $password);

            // Clean up session keys
            unset($_SESSION['reset_user_id']);
            unset($_SESSION['reset_email']);

            echo json_encode(['success' => true, 'redirect' => BASE_URL . '/dashboard']);
            exit;
        } else {
            echo json_encode(['success' => false, 'error' => 'فشل تحديث كلمة المرور، يرجى المحاولة لاحقاً.']);
            exit;
        }
    }
}

// ✅ CHECKPOINT: AuthController.php — COMPLETE (المرحلة 6 من 8)
// التالي: Phase 6 Views (auth/login.php & auth/register.php)
