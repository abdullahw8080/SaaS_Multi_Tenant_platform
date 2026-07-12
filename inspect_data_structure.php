<?php
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

echo "=== TOP LEVEL KEYS ===\n";
print_r(array_keys($data));

echo "\n=== education key value ===\n";
print_r($data['education'] ?? 'NOT SET');

echo "\n=== certificates key value ===\n";
print_r($data['certificates'] ?? 'NOT SET');
?>
