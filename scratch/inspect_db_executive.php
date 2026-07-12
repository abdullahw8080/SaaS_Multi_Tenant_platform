<?php
spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', '/', $class);
    if (str_starts_with($classPath, 'App/')) {
        $classPath = 'app/' . substr($classPath, 4);
    }
    $file = dirname(__DIR__) . '/' . $classPath . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

try {
    $db = \App\Core\Database::getInstance()->getConnection();
    
    // Check templates table
    $stmt = $db->query("SELECT * FROM templates");
    $templates = $stmt->fetchAll();
    echo "=== Templates Table ===\n";
    foreach ($templates as $t) {
        printf("ID: %d | Name: %s | Folder: %s | Active: %d\n", $t['id'], $t['name'], $t['folder_name'], $t['is_active']);
    }

    // Check if any sites use template-executive (which has template_id corresponding to Executive template)
    $stmt = $db->query("SELECT s.id, s.slug, t.folder_name FROM sites s JOIN templates t ON s.template_id = t.id WHERE t.folder_name = 'template-executive'");
    $sites = $stmt->fetchAll();
    echo "\n=== Sites Using template-executive ===\n";
    if (empty($sites)) {
        echo "None\n";
    } else {
        foreach ($sites as $s) {
            printf("Site ID: %d | Slug: %s | Folder: %s\n", $s['id'], $s['slug'], $s['folder_name']);
        }
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
