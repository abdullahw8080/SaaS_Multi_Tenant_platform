<?php

namespace App\Core;

use PDO;

abstract class BaseModel {
    protected PDO $db;
    protected string $table;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Find a single record by ID.
     */
    public function find($id) {
        $sql = "SELECT * FROM `{$this->table}` WHERE `id` = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Find a single record by a custom column.
     */
    public function findOneBy(string $column, $value) {
        $sql = "SELECT * FROM `{$this->table}` WHERE `{$column}` = :val LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['val' => $value]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Find all records matching specific conditions.
     */
    public function findAll(array $conditions = [], string $orderBy = null, int $limit = null, int $offset = null): array {
        $sql = "SELECT * FROM `{$this->table}`";
        $params = [];

        if (!empty($conditions)) {
            $whereParts = [];
            foreach ($conditions as $column => $value) {
                if ($value === null) {
                    $whereParts[] = "`{$column}` IS NULL";
                } else {
                    $whereParts[] = "`{$column}` = :cond_{$column}";
                    $params["cond_{$column}"] = $value;
                }
            }
            $sql .= " WHERE " . implode(" AND ", $whereParts);
        }

        if ($orderBy) {
            // Basic sanitization on order by clause
            $sql .= " ORDER BY " . preg_replace('/[^a-zA-Z0-9_ ,]/', '', $orderBy);
        }

        if ($limit !== null) {
            $sql .= " LIMIT " . (int)$limit;
            if ($offset !== null) {
                $sql .= " OFFSET " . (int)$offset;
            }
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Insert a new record.
     * Returns the last inserted ID or false.
     */
    public function create(array $data) {
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":ins_{$col}", $columns);

        $sql = "INSERT INTO `{$this->table}` (`" . implode("`, `", $columns) . "`) VALUES (" . implode(", ", $placeholders) . ")";
        
        $params = [];
        foreach ($data as $col => $val) {
            $params["ins_{$col}"] = $val;
        }

        $stmt = $this->db->prepare($sql);
        if ($stmt->execute($params)) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Update an existing record by ID.
     */
    public function update($id, array $data): bool {
        if (empty($data)) {
            return false;
        }

        $setParts = [];
        $params = ['id' => $id];

        foreach ($data as $col => $val) {
            $setParts[] = "`{$col}` = :upd_{$col}";
            $params["upd_{$col}"] = $val;
        }

        $sql = "UPDATE `{$this->table}` SET " . implode(", ", $setParts) . " WHERE `id` = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Delete a record by ID.
     */
    public function delete($id): bool {
        $sql = "DELETE FROM `{$this->table}` WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Delete records matching specific conditions (e.g. site_id = X).
     */
    public function deleteWhere(array $conditions): bool {
        if (empty($conditions)) {
            return false;
        }

        $whereParts = [];
        $params = [];
        foreach ($conditions as $column => $value) {
            $whereParts[] = "`{$column}` = :del_{$column}";
            $params["del_{$column}"] = $value;
        }

        $sql = "DELETE FROM `{$this->table}` WHERE " . implode(" AND ", $whereParts);
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Helper for custom raw queries.
     */
    public function query(string $sql, array $params = []): array {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        // Return results if SELECT, otherwise return status
        if (stripos(trim($sql), 'select') === 0 || stripos(trim($sql), 'show') === 0 || stripos(trim($sql), 'describe') === 0) {
            return $stmt->fetchAll();
        }
        return [];
    }
    
    /**
     * Helper to run raw write queries (INSERT, UPDATE, DELETE).
     */
    public function executeRaw(string $sql, array $params = []): bool {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
}

// ✅ CHECKPOINT: BaseModel.php — COMPLETE (المرحلة 2 من 8)
// التالي: app/Core/Router.php
