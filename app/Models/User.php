<?php

namespace App\Models;

use App\Core\BaseModel;

class User extends BaseModel {
    protected string $table = 'users';

    /**
     * Check if an email is already registered.
     */
    public function emailExists(string $email): bool {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM `{$this->table}` WHERE `email` = :email");
        $stmt->execute(['email' => $email]);
        return (int)$stmt->fetchColumn() > 0;
    }

    /**
     * Register a new client user.
     * Hashes password automatically.
     */
    public function registerClient(string $email, string $password, string $phone): int|bool {
        if ($this->emailExists($email)) {
            return false;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        
        return $this->create([
            'email'         => $email,
            'phone'         => $phone,
            'password_hash' => $hash,
            'role'          => 'client',
            'status'        => 'active'
        ]);
    }
}

// ✅ CHECKPOINT: User.php — COMPLETE (المرحلة 5 من 8)
// التالي: app/Models/Site.php
