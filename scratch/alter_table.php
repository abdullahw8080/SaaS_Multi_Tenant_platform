<?php
require_once 'app/Core/Database.php';

try {
    $db = \App\Core\Database::getInstance()->getConnection();
    $db->exec("ALTER TABLE sites ADD COLUMN IF NOT EXISTS profession_type ENUM('developer','engineer','doctor','pharmacist','lawyer','teacher','executive','accountant','student','other') DEFAULT 'developer' AFTER template_id");
    echo "SUCCESS: ALTER TABLE executed.\n";
    
    $stmt = $db->query('DESCRIBE sites');
    foreach ($stmt->fetchAll() as $row) {
        if ($row['Field'] === 'profession_type') {
            echo "profession_type: " . $row['Type'] . " | Default: " . $row['Default'] . "\n";
        }
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
