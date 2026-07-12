<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة غير موجودة - 404</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .error-container {
            text-align: center;
            padding: 80px 24px;
        }
        .error-code {
            font-size: 8rem;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, var(--primary), var(--danger));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }
        .error-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 12px;
        }
        .error-desc {
            color: var(--text-muted);
            max-width: 500px;
            margin: 0 auto 40px auto;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="error-container">
            <div class="error-code">404</div>
            <h1 class="error-title">عذراً، الصفحة غير متوفرة!</h1>
            <p class="error-desc"><?= htmlspecialchars($message ?? 'ربما تم حذف الرابط، أو أن الموقع بانتظار موافقة الإدارة للنشر.') ?></p>
            <div style="max-width: 260px; margin: 0 auto;">
                <a href="<?= BASE_URL ?>/" class="btn btn-primary">
                    <i class="fa-solid fa-home"></i> العودة للرئيسية
                </a>
            </div>
        </div>
    </div>
</body>
</html>
