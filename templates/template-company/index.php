<?php
use App\Services\BilingualHelper;

$profession = $data['site']['profession_type'] ?? 'developer';
require_once __DIR__ . '/../../app/Config/ProfessionConfig.php';
$cssVars      = ProfessionConfig::getCssVariables($profession);
$extraCss     = ProfessionConfig::getExtraCss($profession);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang)) ?> | <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'title', $lang) ?: 'Corporate Website') ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= htmlspecialchars(mb_substr(BilingualHelper::get($data['profile'], 'bio', $lang), 0, 160)) ?>">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/templates/template-company/style.css">
    <!-- [PROFESSION COLORS] — CSS Variable Override per Profession -->
    <style>:root { <?= $cssVars ?> } <?= $extraCss ?></style>
</head>
<body>

    <!-- Header / Navbar -->
    <header class="navbar">
        <div class="nav-container">
            <a href="#" class="nav-logo">
                <i class="fa-solid fa-building"></i> <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang)) ?>
            </a>
            
            <nav class="nav-menu" id="navMenu">
                <?php foreach ($data['sections'] as $sec): ?>
                    <?php if ($sec['is_visible']): ?>
                        <a href="#<?= $sec['type_key'] ?>" class="nav-link"><?= htmlspecialchars(BilingualHelper::get($sec, 'title', $lang)) ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
                <a href="#contact" class="nav-link"><?= $lang === 'en' ? 'Contact Us' : 'اتصل بنا' ?></a>
                
                <?php if ($data['site']['is_bilingual']): ?>
                    <a href="?lang=<?= BilingualHelper::opposite($lang) ?>" class="lang-switch-btn">
                        <?= $lang === 'en' ? 'العربية' : 'English' ?>
                    </a>
                <?php endif; ?>
            </nav>

            <button class="hamburger" id="hamburgerBtn">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Hero / Main Corporate Profile -->
    <section class="hero-section" id="hero">
        <div class="hero-container">
            <h1 class="company-name"><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang)) ?></h1>
            <p class="company-tagline"><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'title', $lang)) ?></p>
            <p class="company-desc"><?= htmlspecialchars(BilingualHelper::get($data['profile'], 'bio', $lang)) ?></p>
            <div style="display:flex; gap:16px; justify-content:center; margin-top:30px;">
                <a href="#services" class="btn btn-primary" style="width:auto; padding:12px 30px;"><?= $lang === 'en' ? 'Our Services' : 'خدماتنا المميزة' ?></a>
                <a href="#contact" class="btn btn-secondary" style="width:auto; padding:12px 30px;"><?= $lang === 'en' ? 'Get a Quote' : 'طلب استشارة' ?></a>
            </div>
        </div>
    </section>

    <!-- Render Enabled Sections -->
    <?php foreach ($data['sections'] as $section): ?>
        <?php if ($section['is_visible']): ?>
            <section class="section-wrapper <?= $section['type_key'] ?>-section" id="<?= $section['type_key'] ?>">
                <div class="section-container">
                    <h2 class="section-title"><?= htmlspecialchars(BilingualHelper::get($section, 'title', $lang)) ?></h2>
                    <?php
                        $sectionFile = __DIR__ . "/sections/{$section['type_key']}.php";
                        if (file_exists($sectionFile)) {
                            include $sectionFile;
                        }
                    ?>
                </div>
            </section>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- Corporate Contact Section -->
    <section class="section-wrapper contact-section" id="contact">
        <div class="section-container" style="max-width: 700px; text-align: center;">
            <h2 class="section-title"><?= $lang === 'en' ? 'Connect With Our Team' : 'تواصل مع فريقنا اليوم' ?></h2>
            <p style="color: var(--text-muted); margin-bottom: 40px;">
                <?= $lang === 'en' ? 'Partner with us to accelerate your growth. Drop us an email or phone call.' : 'شريكك الاستراتيجي للنمو. راسلنا أو اتصل بنا للاستفسار عن عقود التشغيل والخدمات.' ?>
            </p>
            
            <div class="grid grid-2" style="gap:20px;">
                <?php
                    $emailLink = array_filter($data['social_links'], fn($s) => $s['platform'] === 'email');
                    $phoneLink = array_filter($data['social_links'], fn($s) => $s['platform'] === 'phone');
                    $emailVal = !empty($emailLink) ? reset($emailLink)['url'] : null;
                    $phoneVal = !empty($phoneLink) ? reset($phoneLink)['url'] : null;
                ?>
                <div class="card" style="padding: 30px;">
                    <div style="font-size:2rem; color:var(--primary); margin-bottom:12px;"><i class="fa-solid fa-envelope-open-text"></i></div>
                    <h3><?= $lang === 'en' ? 'Email Support' : 'الدعم الإلكتروني' ?></h3>
                    <p style="color:var(--text-muted); margin-bottom:16px;">للمراسلات العامة وعروض الأسعار</p>
                    <?php if ($emailVal): ?>
                        <a href="mailto:<?= htmlspecialchars($emailVal) ?>" style="color:var(--primary); font-weight:600; text-decoration:none;"><?= htmlspecialchars($emailVal) ?></a>
                    <?php else: ?>
                        <span>support@company.com</span>
                    <?php endif; ?>
                </div>

                <div class="card" style="padding: 30px;">
                    <div style="font-size:2rem; color:var(--primary); margin-bottom:12px;"><i class="fa-solid fa-headset"></i></div>
                    <h3><?= $lang === 'en' ? 'Hotline Call' : 'الرقم الموحد' ?></h3>
                    <p style="color:var(--text-muted); margin-bottom:16px;">الاتصال والاستفسار المباشر</p>
                    <?php if ($phoneVal): ?>
                        <a href="tel:<?= htmlspecialchars($phoneVal) ?>" style="color:var(--primary); font-weight:600; text-decoration:none;"><?= htmlspecialchars($phoneVal) ?></a>
                    <?php else: ?>
                        <span>+966 9200 0000</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Social Networks Links -->
            <div class="social-icons" style="margin-top: 40px; justify-content: center;">
                <?php foreach ($data['social_links'] as $sl): ?>
                    <a href="<?= htmlspecialchars($sl['url']) ?>" target="_blank" class="social-icon-btn">
                        <?php
                            switch ($sl['platform']) {
                                case 'linkedin': echo '<i class="fa-brands fa-linkedin-in"></i>'; break;
                                case 'twitter': echo '<i class="fa-brands fa-twitter"></i>'; break;
                                case 'facebook': echo '<i class="fa-brands fa-facebook-f"></i>'; break;
                                case 'instagram': echo '<i class="fa-brands fa-instagram"></i>'; break;
                                default: echo '<i class="fa-solid fa-link"></i>';
                            }
                        ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer class="footer-area">
        <p>© <?= date('Y') ?> <?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang)) ?>. All rights reserved.</p>
    </footer>

    <script>
        const btn = document.getElementById('hamburgerBtn');
        const menu = document.getElementById('navMenu');
        if(btn && menu) {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                menu.classList.toggle('open');
            });
            document.addEventListener('click', () => {
                menu.classList.remove('open');
            });
        }
    </script>
</body>
</html>
