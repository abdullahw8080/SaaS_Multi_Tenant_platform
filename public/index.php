<?php

// 1. PSR-4 Compliant Autoloader
spl_autoload_register(function ($class) {
    // Normalize class name to path format
    $classPath = str_replace('\\', '/', $class);

    // Map namespaces to directories
    if (str_starts_with($classPath, 'App/')) {
        // App\Controllers -> app/Controllers.php
        $classPath = 'app/' . substr($classPath, 4);
    } elseif (str_starts_with($classPath, 'Templates/')) {
        // Templates\TemplateRenderer -> templates/TemplateRenderer.php
        $classPath = 'templates/' . substr($classPath, 10);
    }

    $file = dirname(__DIR__) . '/' . $classPath . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// 2. Constants & Environment
define('DEBUG', true); // Toggle to false in production

// Detect subdirectory path dynamically for asset paths
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$basePath = dirname(dirname($scriptName));
$basePath = str_replace('\\', '/', $basePath);
$basePath = rtrim($basePath, '/');
define('BASE_URL', $basePath);

// 3. Start Session safely
\App\Core\Auth::startSession();

// 4. Setup Router
use App\Core\Router;
use App\Middleware\AuthMiddleware;
use App\Middleware\RoleMiddleware;
use App\Middleware\SiteOwnershipMiddleware;

$router = new Router();

// --- Public Routes ---
$router->get('/', 'SiteController@showHome');

// --- Auth Routes ---
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');

// --- Admin Panel Routes (Protected) ---
$adminMiddlewares = [AuthMiddleware::class, RoleMiddleware::class];
$router->get('/admin', 'AdminController@index', $adminMiddlewares);
$router->get('/admin/approve/{id}', 'AdminController@approve', $adminMiddlewares);
$router->post('/admin/reject/{id}', 'AdminController@reject', $adminMiddlewares);
$router->get('/admin/toggle-status/{id}', 'AdminController@toggleUserStatus', $adminMiddlewares);
$router->post('/admin/assign-template/{id}', 'AdminController@assignTemplate', $adminMiddlewares);
$router->post('/admin/create-client', 'AdminController@createClient', $adminMiddlewares);
$router->get('/admin/impersonate/{id}', 'AdminController@impersonate', $adminMiddlewares);
$router->get('/admin/stop-impersonating', 'AdminController@stopImpersonating', [AuthMiddleware::class]);

// --- Client Dashboard Routes (Protected & segregated by ownership) ---
$clientMiddlewares = [AuthMiddleware::class, RoleMiddleware::class, SiteOwnershipMiddleware::class];
$router->get('/dashboard', 'ClientController@index', [AuthMiddleware::class, RoleMiddleware::class]); // Landing doesn't need ownership check
$router->post('/dashboard/save', 'ClientController@save', [AuthMiddleware::class, RoleMiddleware::class]); // Save checks ownership internally
$router->post('/dashboard/submit-review', 'ClientController@submitReview', [AuthMiddleware::class, RoleMiddleware::class]);
$router->get('/dashboard/export', 'ClientController@exportSite', [AuthMiddleware::class, RoleMiddleware::class]);

// --- Dynamic Tenant Slugs (Public) ---
// Note: These must go at the end so they do not block static routes
$router->get('/{slug}', 'SiteController@showSite');
$router->get('/{slug}/projects/{project_slug}', 'SiteController@showProjectDetail');

// 5. Dispatch Routing request
$router->dispatch();

// ✅ CHECKPOINT: index.php — COMPLETE (المرحلة 8 من 8)
// التالي: public/.htaccess
