<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل حساب جديد - منشئ المواقع الشخصية</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">بورتفوليو Hub</div>
                <h1 class="auth-title">إنشاء حساب جديد</h1>
                <p class="auth-subtitle">ابدأ بناء موقعك الشخصي والبورتفوليو الخاص بك في دقائق</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger">
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/register" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                
                <div class="form-group">
                    <label class="form-label" for="full_name">الاسم الكامل</label>
                    <input type="text" id="full_name" name="full_name" class="form-input" placeholder="أحمد علي" required autocomplete="name">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" class="form-input ltr" placeholder="yourname@example.com" required autocomplete="email">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">كلمة المرور</label>
                    <input type="password" id="password" name="password" class="form-input ltr" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="confirm_password">تأكيد كلمة المرور</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input ltr" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                    تسجيل الحساب
                </button>
            </form>

            <div class="auth-footer">
                لديك حساب بالفعل؟ <a href="<?= BASE_URL ?>/login" class="auth-link">سجل دخولك الآن</a>
            </div>
        </div>
    </div>
</body>
</html>
