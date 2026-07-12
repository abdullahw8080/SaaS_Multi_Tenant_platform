<?php
// Trace the condition evaluations inside the template context
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

$secData = [];
foreach ($data['sections'] as $s) {
    $secData[$s['type_key']] = $s;
}

echo "=== TRACING CONDITIONS ===\n";
foreach (['education', 'certificates', 'skills', 'projects', 'experiences', 'languages'] as $key) {
    $exists = isset($secData[$key]);
    $visible = $exists ? $secData[$key]['is_visible'] : 'N/A';
    echo "Section: $key | Exists: " . ($exists ? 'Yes' : 'No') . " | Visible: $visible\n";
}
?>
