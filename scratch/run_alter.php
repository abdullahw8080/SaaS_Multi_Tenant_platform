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
    
    // Check if columns exist
    $q = $db->query("SHOW COLUMNS FROM skills LIKE 'description'");
    if ($q->rowCount() === 0) {
        echo "Adding 'description' and 'description_en' to skills table...\n";
        $db->exec("ALTER TABLE skills 
                   ADD COLUMN description VARCHAR(255) NULL AFTER level, 
                   ADD COLUMN description_en VARCHAR(255) NULL AFTER description");
        echo "Columns added successfully!\n";
    } else {
        echo "Columns already exist.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
