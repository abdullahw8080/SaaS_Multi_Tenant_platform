<?php
spl_autoload_register(function ($class) {
    $classPath = str_replace('\\', '/', $class);
    if (str_starts_with($classPath, 'App/')) {
        $classPath = 'app/' . substr($classPath, 4);
    } elseif (str_starts_with($classPath, 'Templates/')) {
        $classPath = 'templates/' . substr($classPath, 10);
    }
    $file = dirname(__DIR__) . '/' . $classPath . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

try {
    $db = \App\Core\Database::getInstance()->getConnection();
    
    // Check tables
    echo "SKILLS TABLE COLUMNS:\n";
    $q = $db->query("DESCRIBE skills");
    print_r($q->fetchAll(PDO::FETCH_ASSOC));
    
    echo "\nPERSONAL_SKILLS TABLE COLUMNS:\n";
    try {
        $q2 = $db->query("DESCRIBE personal_skills");
        print_r($q2->fetchAll(PDO::FETCH_ASSOC));
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
