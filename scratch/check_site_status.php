<?php
define('BASE_URL', '/SaaS_Multi_Tenant_platform');

spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', '/', $class);
    if (str_starts_with($classPath, 'App/')) {
        $classPath = 'app/' . substr($classPath, 4);
    }
    $file = dirname(__DIR__) . '/' . $classPath . '.php';
    if (file_exists($file)) require_once $file;
});

App\Core\Auth::startSession();

$siteModel = new App\Models\Site();
$site = $siteModel->getSiteBySlug('abdullahw8080');

if (!$site) {
    echo "❌ الموقع غير موجود في قاعدة البيانات\n";
    exit;
}

echo "✅ الموقع موجود\n";
echo "slug           = " . $site['slug'] . "\n";
echo "template       = " . ($site['template_folder'] ?? 'غير محدد') . "\n";
echo "is_published   = " . $site['is_published'] . "\n";
echo "approval_status= " . $site['approval_status'] . "\n";
echo "user_status    = " . $site['user_status'] . "\n";
echo "site_id        = " . $site['id'] . "\n";
echo "default_lang   = " . ($site['default_lang'] ?? 'ar') . "\n";
echo "is_bilingual   = " . ($site['is_bilingual'] ?? '0') . "\n";
