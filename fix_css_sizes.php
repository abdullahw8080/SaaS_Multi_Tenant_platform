<?php
$cssFile = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\templates\\template-developer\\style.css';
$cssContent = file_get_contents($cssFile);

// Reduce heading sizes
$cssContent = str_replace('.hero-text-content h2 { font-size: 3.5rem;', '.hero-text-content h2 { font-size: 2.8rem;', $cssContent);
$cssContent = str_replace('.job-title { font-size: 1.5rem;', '.job-title { font-size: 1.3rem;', $cssContent);
$cssContent = str_replace('.section-title h2 { font-size: 2.2rem;', '.section-title h2 { font-size: 1.8rem;', $cssContent);

// Also fix the RTL issue on the image so it properly aligns
$cssContent .= '
[dir="rtl"] .hero-mobile-reverse { flex-direction: row-reverse; }
@media (max-width: 992px) {
    [dir="rtl"] .hero-mobile-reverse { flex-direction: column-reverse !important; }
}
';

file_put_contents($cssFile, $cssContent);
echo "CSS sizes adjusted.";
?>
