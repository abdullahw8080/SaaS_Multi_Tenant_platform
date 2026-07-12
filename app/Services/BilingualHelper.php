<?php

namespace App\Services;

class BilingualHelper {
    /**
     * Get the translated value for a field.
     * Fallbacks to the Arabic version if English is requested but empty.
     * 
     * @param array|object $item The database record (array or object)
     * @param string $field The base field name (e.g. 'title', 'full_name')
     * @param string $lang The target language ('ar' or 'en')
     * @return string
     */
    public static function get($item, string $field, string $lang = 'ar'): string {
        $isObj = is_object($item);
        
        $arValue = $isObj ? ($item->$field ?? '') : ($item[$field] ?? '');
        $enField = $field . '_en';
        $enValue = $isObj ? ($item->$enField ?? '') : ($item[$enField] ?? '');

        if ($lang === 'en') {
            return !empty($enValue) ? (string)$enValue : (string)$arValue;
        }

        return (string)$arValue;
    }

    /**
     * Get text direction (RTL or LTR) based on the language.
     */
    public static function direction(string $lang = 'ar'): string {
        return $lang === 'en' ? 'ltr' : 'rtl';
    }

    /**
     * Get opposite language.
     */
    public static function opposite(string $lang = 'ar'): string {
        return $lang === 'en' ? 'ar' : 'en';
    }

    /**
     * Detect and return the current language.
     * Prioritizes Query String (?lang=en) -> Cookie -> Session -> Default
     */
    public static function getCurrentLanguage(string $default = 'ar'): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $lang = $default;

        if (isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'])) {
            $lang = $_GET['lang'];
            $_SESSION['lang'] = $lang;
            setcookie('lang', $lang, time() + (30 * 24 * 60 * 60), '/'); // 30 days
        } elseif (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['ar', 'en'])) {
            $lang = $_COOKIE['lang'];
            $_SESSION['lang'] = $lang;
        } elseif (isset($_SESSION['lang']) && in_array($_SESSION['lang'], ['ar', 'en'])) {
            $lang = $_SESSION['lang'];
        }

        return $lang;
    }
}

// ✅ CHECKPOINT: BilingualHelper.php — COMPLETE (المرحلة 4 من 8)
// التالي: app/Services/ApprovalService.php
