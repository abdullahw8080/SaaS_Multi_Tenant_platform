<?php
// Initialize PSR-4 autoloader
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

if (!$site) {
    echo "Site abdullahw8080 not found!\n";
    exit;
}

$data = $siteModel->getFullSiteData($site['id']);

echo "=== SITE DATA ===\n";
echo "Photo Path: " . ($data['profile']['photo'] ?? 'NULL') . "\n";
echo "CV Path: " . ($data['profile']['cv_url'] ?? 'NULL') . "\n";

echo "\n=== SECTIONS ===\n";
foreach ($data['sections'] as $sec) {
    echo "Section: " . $sec['type_key'] . " | Visible: " . ($sec['is_visible'] ? 'Yes' : 'No') . "\n";
}

echo "\n=== PROJECTS ===\n";
foreach ($data['projects'] as $proj) {
    echo "Project: " . $proj['title'] . " | Cover: " . $proj['cover_image'] . " | Slug: " . $proj['slug'] . "\n";
}
?>
