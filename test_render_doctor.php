<?php
// Simulate doctor page rendering and capture errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', '/', $class);
    if (str_starts_with($classPath, 'App/')) {
        $classPath = 'app/' . substr($classPath, 4);
    }
    $file = __DIR__ . '/' . $classPath . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

define('BASE_URL', '/SaaS_Multi_Tenant_platform');
\App\Core\Auth::startSession();

$siteModel = new \App\Models\Site();
$site = $siteModel->getSiteBySlug('abdullahw8080'); // or whatever slug, let's just render the data
$data = $siteModel->getFullSiteData($site['id']);

$lang = 'ar';
$dir = 'rtl';

echo "--- RUNNING DOCTOR RENDER ---\n";
ob_start();
include 'templates/template-doctor/index.php';
$html = ob_get_clean();
echo "Render completed without script termination.\n";
echo "HTML Length: " . strlen($html) . "\n";
echo "First 1000 chars:\n" . substr($html, 0, 1000) . "\n";
?>
