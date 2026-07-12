<?php

namespace App\Core;

use PDO;

class Auth {
    /**
     * Start session safely if not already started.
     */
    public static function startSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Attempt login with email and password.
     */
    public static function login(string $email, string $password): bool {
        self::startSession();
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM `users` WHERE `email` = :email AND `status` = 'active' LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];

            // If the user is a client, retrieve and cache their site ID
            if ($user['role'] === 'client') {
                $stmtSite = $db->prepare("SELECT `id` FROM `sites` WHERE `user_id` = :user_id LIMIT 1");
                $stmtSite->execute(['user_id' => $user['id']]);
                $site = $stmtSite->fetch();
                $_SESSION['site_id'] = $site ? $site['id'] : null;
            } else {
                $_SESSION['site_id'] = null;
            }

            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            return true;
        }

        return false;
    }

    /**
     * Logout the current user and destroy the session.
     */
    public static function logout(): void {
        self::startSession();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * Check if a user is logged in.
     */
    public static function check(): bool {
        self::startSession();
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        
        // Strictly verify user exists in the database (handles db resets)
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM `users` WHERE `id` = :id LIMIT 1");
        $stmt->execute(['id' => $_SESSION['user_id']]);
        if ((int)$stmt->fetchColumn() === 0) {
            self::logout();
            return false;
        }
        
        return true;
    }

    /**
     * Get the logged-in user's ID.
     */
    public static function id(): ?int {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get the logged-in user's role.
     */
    public static function role(): ?string {
        self::startSession();
        return $_SESSION['user_role'] ?? null;
    }

    /**
     * Get the client user's site ID.
     */
    public static function siteId(): ?int {
        self::startSession();
        $siteId = $_SESSION['site_id'] ?? null;
        if ($siteId) {
            // Strictly verify site exists in the database
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT COUNT(*) FROM `sites` WHERE `id` = :id LIMIT 1");
            $stmt->execute(['id' => $siteId]);
            if ((int)$stmt->fetchColumn() === 0) {
                $_SESSION['site_id'] = null;
                return null;
            }
        }
        return $siteId;
    }

    /**
     * Cache or update the site ID in session (useful after new registration).
     */
    public static function setSiteId(int $siteId): void {
        self::startSession();
        $_SESSION['site_id'] = $siteId;
    }

    /**
     * Generate or fetch CSRF token.
     */
    public static function csrfToken(): string {
        self::startSession();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verify CSRF token.
     */
    public static function verifyCsrfToken(?string $token): bool {
        self::startSession();
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}

// ✅ CHECKPOINT: Auth.php — COMPLETE (المرحلة 3 من 8)
// التالي: app/Middleware/AuthMiddleware.php
