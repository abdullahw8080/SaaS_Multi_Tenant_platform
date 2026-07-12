<?php
// Inspect $secData keys
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

$secData = [];
foreach ($data['sections'] as $s) {
    $secData[$s['type_key']] = $s;
}

echo "=== secData Keys ===\n";
print_r(array_keys($secData));

echo "\n=== education section array ===\n";
print_r($secData['education'] ?? 'NOT FOUND');
?>
