<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static ?Database $instance = null;
    private PDO $connection;

    // Default configuration (designed for typical XAMPP setup)
    private string $host = '127.0.0.1';
    private string $dbname = 'saas_portfolios';
    private string $username = 'root';
    private string $password = '';
    private string $charset = 'utf8mb4';

    /**
     * Private constructor to prevent direct instantiation.
     */
    private function __construct() {
        // Allow environment overrides if defined
        $host = defined('DB_HOST') ? DB_HOST : $this->host;
        $dbname = defined('DB_NAME') ? DB_NAME : $this->dbname;
        $username = defined('DB_USER') ? DB_USER : $this->username;
        $password = defined('DB_PASS') ? DB_PASS : $this->password;

        $dsn = "mysql:host={$host};dbname={$dbname};charset={$this->charset}";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            // Keep connection alive in CLI/long running scripts if needed
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ];

        try {
            $this->connection = new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            // In a production environment, you should log this instead of print
            throw new PDOException("Database connection failed: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * Get the Singleton instance of the Database class.
     */
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get the PDO connection object.
     */
    public function getConnection(): PDO {
        return $this->connection;
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserializing of the instance
    public function __wakeup() {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}

// ✅ CHECKPOINT: Database.php — COMPLETE (المرحلة 2 من 8)
// التالي: app/Core/BaseModel.php
