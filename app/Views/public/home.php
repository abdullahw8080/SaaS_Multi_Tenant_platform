<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بورتفوليو Hub - ابنِ موقعك الشخصي والبورتفوليو الخاص بك</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero {
            padding: 100px 24px;
            text-align: center;
            background: radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.08) 0%, transparent 60%);
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent);
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 24px;
            gap: 8px;
        }
        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
            letter-spacing: -2px;
            background: linear-gradient(135deg, #ffffff 30%, var(--text-muted));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero h1 span {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero p {
            max-width: 600px;
            margin: 0 auto 40px auto;
            color: var(--text-muted);
            font-size: 1.15rem;
        }
        .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            max-width: 440px;
            margin: 0 auto;
        }
        .features {
            padding: 80px 24px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 32px;
            border-radius: var(--radius-lg);
            transition: var(--transition);
        }
        .feature-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px -10px rgba(99, 102, 241, 0.2);
        }
        .feature-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 20px;
        }
        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 12px;
        }
        .feature-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        footer {
            text-align: center;
            padding: 40px 24px;
            border-top: 1px solid var(--border-color);
            color: var(--text-muted);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <header style="padding: 24px; border-bottom: 1px solid var(--border-color); background: rgba(11, 15, 25, 0.8); backdrop-filter: blur(12px); position: sticky; top:0; z-index: 100;">
        <div style="max-width: 1200px; margin:0 auto; display:flex; justify-content: space-between; align-items: center;">
            <div class="auth-logo" style="margin-bottom:0">بورتفوليو Hub</div>
            <div style="display:flex; gap:16px;">
                <a href="<?= BASE_URL ?>/login" class="btn btn-secondary" style="width:auto; padding: 8px 20px; font-size: 0.9rem;">تسجيل الدخول</a>
                <a href="<?= BASE_URL ?>/register" class="btn btn-primary" style="width:auto; padding: 8px 20px; font-size: 0.9rem;">ابدأ مجاناً</a>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-badge">
            <i class="fa-solid fa-sparkles"></i> النظام الأسرع لإنشاء المعارض الشخصية
        </div>
        <h1>اصنع <span>موقعك وبورتفوليو</span> أعمالك بثوانٍ معدودة</h1>
        <p>منصة سحابية متكاملة تتيح للمطورين، الأطباء، المهندسين والشركات إنشاء صفحات شخصية بورتفوليو احترافية فائقة السرعة مع تصديرها كأكواد ثابتة بأي وقت.</p>
        <div class="cta-buttons">
            <a href="<?= BASE_URL ?>/register" class="btn btn-primary" style="flex:1">إنشاء حسابي الآن</a>
            <a href="<?= BASE_URL ?>/login" class="btn btn-secondary" style="flex:1">لوحة التحكم</a>
        </div>
    </section>

    <!-- ATS CV Banner -->
    <section style="padding: 40px 24px; max-width: 1200px; margin: 0 auto;">
        <div style="background: linear-gradient(135deg, var(--bg-card), rgba(99,102,241,0.1)); border: 1px solid rgba(99,102,241,0.25); border-radius: var(--radius-lg); padding: 40px; text-align: center; box-shadow: var(--shadow-md); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, transparent 70%); pointer-events: none;"></div>
            <div style="font-size: 2.5rem; color: var(--accent); margin-bottom: 16px;">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>
            <h2 style="font-size: 1.6rem; font-weight: 800; margin-bottom: 12px; color: #ffffff;">خدمة تصميم السيرة الذاتية الاحترافية (ATS CV)</h2>
            <p style="color: var(--text-muted); max-width: 750px; margin: 0 auto 24px auto; font-size: 1rem; line-height: 1.7;">
                هل تبحث عن سيرة ذاتية تضمن لك المقابلات الشخصية؟ أقدم خدمة إنشاء وكتابة سير ذاتية احترافية متوافقة 100% مع أنظمة الفرز الآلي للتوظيف (ATS) في كبرى الشركات، مع تنظيم وتنسيق محتواك المهني بطريقة تبرز مهاراتك بشكل احترافي.
            </p>
            <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                <a href="https://wa.me/qr/O7TJJCCZBPGXD1" target="_blank" class="btn btn-primary" style="width: auto; padding: 10px 24px; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fa-brands fa-whatsapp"></i> طلب الخدمة عبر واتساب
                </a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features">
        <h2 style="text-align: center; font-size: 2rem; font-weight: 800;">لماذا تختار بورتفوليو Hub؟</h2>
        <p style="text-align: center; color: var(--text-muted); max-width: 500px; margin: 8px auto 0 auto;">كل ما تحتاجه لعرض خبراتك ومهاراتك أمام أصحاب العمل والشركات</p>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-gauge-high"></i></div>
                <h3>أداء فائق السرعة (Caching)</h3>
                <p>يتم توليد ملفات موقعك كـ HTML ثابت وتخزينه مؤقتاً لعرضه بلحظة للزوار وتحمل ملايين الزيارات دون ضغط على الخادم.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-crop-simple"></i></div>
                <h3>ضغط تلقائي للصور (WebP)</h3>
                <p>كل صورة بروفايل أو مشروع تقوم برفعها يتم تحجيمها وضغطها تلقائياً بالخلفية لسرعة تحميل لا تضاهى وتوفير المساحة.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-language"></i></div>
                <h3>ثنائية اللغة الكاملة (AR/EN)</h3>
                <p>ابنِ موقعك باللغتين العربية والإنجليزية بآنٍ واحد مع توفير ميزة تبديل اتجاه القالب (LTR/RTL) تلقائياً بنقرة زر.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-shapes"></i></div>
                <h3>قوالب ديناميكية متخصصة</h3>
                <p>قوالب مجهزة خصيصاً للمطورين، الأطباء، والشركات تتوافق تلقائياً مع حجم ونوع محتواك دون أي تعقيد برمجي.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-file-zipper"></i></div>
                <h3>تصدير كامل للموقع ZIP</h3>
                <p>احصل على كود موقعك بالكامل (HTML/CSS) بملف مضغوط لترفعه على أي استضافة خارجية خاصة بك دون قيود.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <h3>أمان وعزل متكامل</h3>
                <p>نظام حماية من ثغرات XSS و CSRF مع عزل تام للعملاء وضمان عدم تداخل البيانات بين المستأجرين.</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section style="padding: 60px 24px; max-width: 1000px; margin: 0 auto; text-align: center; border-top: 1px solid var(--border-color);">
        <h2 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 8px;">تواصل معي مباشرة</h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 30px;">يسعدني تواصلكم معي للاستفسار أو طلب الخدمات الشخصية</p>
        
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <a href="tel:00967784224565" class="btn btn-secondary" style="width: auto; padding: 10px 20px; display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem; text-decoration: none;">
                <i class="fa-solid fa-phone" style="color: var(--primary);"></i>
                اتصال: 00967784224565
            </a>
            <a href="https://wa.me/qr/O7TJJCCZBPGXD1" target="_blank" class="btn btn-secondary" style="width: auto; padding: 10px 20px; display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem; text-decoration: none;">
                <i class="fa-brands fa-whatsapp" style="color: #25d366;"></i>
                واتساب
            </a>
            <a href="https://www.facebook.com/share/1GHDCEhXRF/" target="_blank" class="btn btn-secondary" style="width: auto; padding: 10px 20px; display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem; text-decoration: none;">
                <i class="fa-brands fa-facebook" style="color: #1877f2;"></i>
                فيسبوك
            </a>
            <a href="mailto:abdullahw8080@gmail.com" class="btn btn-secondary" style="width: auto; padding: 10px 20px; display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem; text-decoration: none;">
                <i class="fa-solid fa-envelope" style="color: var(--primary);"></i>
                البريد الإلكتروني
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>© 2026 بورتفوليو Hub. جميع الحقوق محفوظة لشركة جوجل ديب مايند.</p>
    </footer>

</body>
</html>
