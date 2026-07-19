<?php
use App\Services\BilingualHelper;

$fullName = htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', $lang), ENT_QUOTES, 'UTF-8');
$jobTitle = htmlspecialchars(BilingualHelper::get($data['profile'], 'title', $lang), ENT_QUOTES, 'UTF-8');
$bio = htmlspecialchars(mb_strimwidth(BilingualHelper::get($data['profile'], 'bio', $lang), 0, 155, '...'), ENT_QUOTES, 'UTF-8');

// Determine protocol and domain dynamically
$httpProtocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$domain = $_SERVER['HTTP_HOST'] ?? 'localhost';

$photo = !empty($data['profile']['photo']) 
    ? htmlspecialchars($httpProtocol . $domain . BASE_URL . $data['profile']['photo'], ENT_QUOTES, 'UTF-8') 
    : htmlspecialchars($httpProtocol . $domain . BASE_URL . '/assets/images/default-og.jpg', ENT_QUOTES, 'UTF-8');

$siteUrl = htmlspecialchars($httpProtocol . $domain . BASE_URL . '/' . $data['site']['slug'], ENT_QUOTES, 'UTF-8');
$locale = ($lang === 'ar') ? 'ar_SA' : 'en_US';
?>

<!-- Title & Meta Tags -->
<title><?= $fullName ?> | <?= $jobTitle ?></title>
<meta name="description" content="<?= $bio ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="profile">
<meta property="og:title" content="<?= $fullName ?> | <?= $jobTitle ?>">
<meta property="og:description" content="<?= $bio ?>">
<meta property="og:image" content="<?= $photo ?>">
<meta property="og:url" content="<?= $siteUrl ?>">
<meta property="og:locale" content="<?= $locale ?>">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= $fullName ?> | <?= $jobTitle ?>">
<meta name="twitter:description" content="<?= $bio ?>">
<meta name="twitter:image" content="<?= $photo ?>">

<!-- Canonical Link -->
<link rel="canonical" href="<?= $siteUrl ?>">

<!-- Robots Search Directives -->
<meta name="robots" content="index, follow">

<!-- JSON-LD Structured Data Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "<?= htmlspecialchars(BilingualHelper::get($data['profile'], 'full_name', 'en'), ENT_QUOTES, 'UTF-8') ?>",
  "jobTitle": "<?= htmlspecialchars(BilingualHelper::get($data['profile'], 'title', 'en') ?: BilingualHelper::get($data['profile'], 'title', 'ar'), ENT_QUOTES, 'UTF-8') ?>",
  "url": "<?= $siteUrl ?>"
  <?php if (!empty($data['profile']['photo'])): ?>
  ,"image": "<?= htmlspecialchars($httpProtocol . $domain . BASE_URL . $data['profile']['photo'], ENT_QUOTES, 'UTF-8') ?>"
  <?php endif; ?>
  <?php if (!empty($data['social_links'])): ?>
  ,"sameAs": [
    <?= implode(',', array_map(fn($s) => '"' . htmlspecialchars($s['url'], ENT_QUOTES, 'UTF-8') . '"', $data['social_links'])) ?>
  ]
  <?php endif; ?>
}
</script>
