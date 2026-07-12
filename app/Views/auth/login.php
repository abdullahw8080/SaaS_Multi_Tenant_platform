<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - منشئ المواقع الشخصية</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
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
                    <label class="form-label" for="password">كلمة المرور</label>
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
</body>
</html>
