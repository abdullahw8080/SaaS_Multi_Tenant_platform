<?php
// Simulate page rendering and save output
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
$site = $siteModel->getSiteBySlug('abdullahw8080');
$data = $siteModel->getFullSiteData($site['id']);

$lang = 'ar';
$dir = 'rtl';

ob_start();
include 'templates/template-developer/index.php';
$html = ob_get_clean();

file_put_contents('scratch/render_output.html', $html);
echo "HTML written to scratch/render_output.html\n";
?>
