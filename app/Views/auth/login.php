<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - منشئ المواقع الشخصية</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
    <style>
        /* Forgot Password Modal Styling */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(11, 15, 25, 0.85);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
        .modal-card {
            background: #111827;
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 12px;
            width: 90%;
            max-width: 450px;
            padding: 30px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            direction: rtl;
            text-align: right;
            color: #ffffff;
        }
        .modal-overlay.active .modal-card {
            transform: scale(1);
        }
        .modal-close {
            position: absolute;
            top: 15px;
            left: 15px;
            background: transparent;
            border: none;
            color: #9ca3af;
            font-size: 1.5rem;
            cursor: pointer;
            line-height: 1;
        }
        .modal-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            margin-top: 0;
        }
        .modal-subtitle {
            font-size: 0.875rem;
            color: #9ca3af;
            margin-bottom: 20px;
        }
        /* Style option text correctly inside selects */
        select option {
            background-color: #111827 !important;
            color: #f8fafc !important;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">بورتفوليو Hub</div>
                <h1 class="auth-title">تسجيل الدخول</h1>
                <p class="auth-subtitle">مرحباً بك مجدداً! قم بالدخول لإدارة موقعك</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/login" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                
                <div class="form-group">
                    <label class="form-label" for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" class="form-input ltr" placeholder="yourname@example.com" required autocomplete="email">
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label class="form-label" for="password" style="margin: 0;">كلمة المرور</label>
                        <a href="#" id="forgot-password-link" style="font-size: 0.8rem; color: #818cf8; text-decoration: none; font-weight: 600;">نسيت كلمة المرور؟</a>
                    </div>
                    <input type="password" id="password" name="password" class="form-input ltr" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                    دخول
                </button>
            </form>

            <div class="auth-footer">
                ليس لديك حساب؟ <a href="<?= BASE_URL ?>/register" class="auth-link">سجل حساباً جديداً</a>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal-overlay" id="forgot-password-modal">
        <div class="modal-card">
            <button class="modal-close" id="modal-close-btn">&times;</button>
            
            <div id="forgot-step-1">
                <h3 class="modal-title">استعادة كلمة المرور</h3>
                <p class="modal-subtitle">أدخل بريدك الإلكتروني والمهنة المسجلة للتحقق من هويتك</p>
                
                <div class="alert alert-danger" id="forgot-error-1" style="display: none; font-size: 0.85rem; padding: 10px; margin-bottom: 15px;"></div>
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" id="forgot-email" class="form-input ltr" placeholder="yourname@example.com" required style="width: 100%; box-sizing: border-box;">
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label">المهنة/الوظيفة المسجلة</label>
                    <select id="forgot-profession" class="form-input" style="width: 100%; box-sizing: border-box; cursor: pointer; background: #1f2937; color: #fff;">
                        <?php
                        require_once dirname(__DIR__, 2) . '/Config/ProfessionConfig.php';
                        $professions = \App\Config\ProfessionConfig::getAvailableProfessions('ar');
                        foreach ($professions as $key => $name): ?>
                            <option value="<?= $key ?>"><?= htmlspecialchars($name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="button" class="btn btn-primary" id="btn-verify-identity" style="width: 100%;">
                    تحقق واستمرار
                </button>
            </div>
            
            <div id="forgot-step-2" style="display: none;">
                <h3 class="modal-title">تعيين كلمة المرور الجديدة</h3>
                <p class="modal-subtitle">قم بتعيين كلمة مرور قوية وجديدة لحسابك</p>
                
                <div class="alert alert-danger" id="forgot-error-2" style="display: none; font-size: 0.85rem; padding: 10px; margin-bottom: 15px;"></div>
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label class="form-label">كلمة المرور الجديدة</label>
                    <input type="password" id="forgot-new-password" class="form-input ltr" placeholder="••••••••" required style="width: 100%; box-sizing: border-box;">
                </div>
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label">تأكيد كلمة المرور الجديدة</label>
                    <input type="password" id="forgot-confirm-password" class="form-input ltr" placeholder="••••••••" required style="width: 100%; box-sizing: border-box;">
                </div>
                
                <button type="button" class="btn btn-primary" id="btn-reset-password" style="width: 100%;">
                    حفظ كلمة المرور والدخول للموقع
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('forgot-password-modal');
            const openLink = document.getElementById('forgot-password-link');
            const closeBtn = document.getElementById('modal-close-btn');
            
            const step1 = document.getElementById('forgot-step-1');
            const step2 = document.getElementById('forgot-step-2');
            
            const emailInput = document.getElementById('forgot-email');
            const professionSelect = document.getElementById('forgot-profession');
            
            const verifyBtn = document.getElementById('btn-verify-identity');
            const resetBtn = document.getElementById('btn-reset-password');
            
            const error1 = document.getElementById('forgot-error-1');
            const error2 = document.getElementById('forgot-error-2');
            
            const newPasswordInput = document.getElementById('forgot-new-password');
            const confirmPasswordInput = document.getElementById('forgot-confirm-password');

            // Open Modal
            openLink.addEventListener('click', function(e) {
                e.preventDefault();
                modal.classList.add('active');
                step1.style.display = 'block';
                step2.style.display = 'none';
                error1.style.display = 'none';
                error2.style.display = 'none';
                emailInput.value = '';
                newPasswordInput.value = '';
                confirmPasswordInput.value = '';
            });

            // Close Modal
            closeBtn.addEventListener('click', function() {
                modal.classList.remove('active');
            });
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.remove('active');
                }
            });

            // Verify Step 1
            verifyBtn.addEventListener('click', function() {
                const email = emailInput.value.trim();
                const profession = professionSelect.value;

                if (!email) {
                    error1.textContent = 'يرجى إدخال البريد الإلكتروني.';
                    error1.style.display = 'block';
                    return;
                }

                error1.style.display = 'none';
                verifyBtn.disabled = true;
                verifyBtn.innerHTML = 'جاري التحقق...';

                const formData = new FormData();
                formData.append('email', email);
                formData.append('profession_type', profession);

                fetch('<?= BASE_URL ?>/forgot-password/verify', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    verifyBtn.disabled = false;
                    verifyBtn.textContent = 'تحقق واستمرار';
                    if (data.success) {
                        step1.style.display = 'none';
                        step2.style.display = 'block';
                    } else {
                        error1.textContent = data.error || 'حدث خطأ غير معروف.';
                        error1.style.display = 'block';
                    }
                })
                .catch(err => {
                    verifyBtn.disabled = false;
                    verifyBtn.textContent = 'تحقق واستمرار';
                    error1.textContent = 'حدث خطأ في الاتصال بالخادم.';
                    error1.style.display = 'block';
                });
            });

            // Reset Step 2
            resetBtn.addEventListener('click', function() {
                const password = newPasswordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (!password || !confirmPassword) {
                    error2.textContent = 'يرجى إدخال كلمة المرور وتأكيدها.';
                    error2.style.display = 'block';
                    return;
                }

                if (password !== confirmPassword) {
                    error2.textContent = 'كلمتا المرور غير متطابقتين.';
                    error2.style.display = 'block';
                    return;
                }

                if (password.length < 6) {
                    error2.textContent = 'يجب أن تكون كلمة المرور من 6 أحرف على الأقل.';
                    error2.style.display = 'block';
                    return;
                }

                error2.style.display = 'none';
                resetBtn.disabled = true;
                resetBtn.innerHTML = 'جاري الحفظ والدخول...';

                const formData = new FormData();
                formData.append('password', password);
                formData.append('confirm_password', confirmPassword);

                fetch('<?= BASE_URL ?>/forgot-password/reset', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    resetBtn.disabled = false;
                    resetBtn.textContent = 'حفظ كلمة المرور والدخول للموقع';
                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        error2.textContent = data.error || 'حدث خطأ غير معروف.';
                        error2.style.display = 'block';
                    }
                })
                .catch(err => {
                    resetBtn.disabled = false;
                    resetBtn.textContent = 'حفظ كلمة المرور والدخول للموقع';
                    error2.textContent = 'حدث خطأ في الاتصال بالخادم.';
                    error2.style.display = 'block';
                });
            });
        });
    </script>
</body>
</html>
