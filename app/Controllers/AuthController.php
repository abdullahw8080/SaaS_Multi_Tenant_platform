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
        $siteId = $siteModel->create([
            'user_id'         => $userId,
            'slug'            => $slug,
            'template_id'     => 1, // Developer template by default
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
}

// ✅ CHECKPOINT: AuthController.php — COMPLETE (المرحلة 6 من 8)
// التالي: Phase 6 Views (auth/login.php & auth/register.php)
