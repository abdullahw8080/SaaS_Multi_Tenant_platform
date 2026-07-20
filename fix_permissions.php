<?php
/**
 * Helper Script to Automatically Fix File and Folder Permissions on Linux Hosting
 * 
 * Instructions:
 * 1. Upload this file to the root of your hosting directory (usually public_html or htdocs).
 * 2. Access it via your browser: http://yourdomain.com/fix_permissions.php
 * 3. Delete this file immediately after running it for security reasons.
 */

header('Content-Type: text/plain; charset=utf-8');

echo "=== بدء فحص وإصلاح أذونات الملفات والمجلدات ===\n\n";

$targetDir = __DIR__;
$dirCount = 0;
$fileCount = 0;
$errorCount = 0;

try {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($targetDir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    // 1. Fix root directory permissions first
    if (@chmod($targetDir, 0755)) {
        echo "✓ تم ضبط المجلد الرئيسي للمشروع على 755\n";
        $dirCount++;
    } else {
        echo "✗ فشل ضبط المجلد الرئيسي للمشروع على 755\n";
        $errorCount++;
    }

    foreach ($iterator as $item) {
        $path = $item->getPathname();
        
        // Skip this script itself to avoid modification while running
        if (basename($path) === basename(__FILE__)) {
            continue;
        }

        if ($item->isDir()) {
            if (@chmod($path, 0755)) {
                $dirCount++;
            } else {
                echo "✗ فشل تعديل المجلد: " . str_replace($targetDir, '', $path) . "\n";
                $errorCount++;
            }
        } else {
            if (@chmod($path, 0644)) {
                $fileCount++;
            } else {
                echo "✗ فشل تعديل الملف: " . str_replace($targetDir, '', $path) . "\n";
                $errorCount++;
            }
        }
    }

    echo "\n=== انتهى الفحص والإصلاح ===\n";
    echo "✓ تم إصلاح عدد المجلدات: $dirCount\n";
    echo "✓ تم إصلاح عدد الملفات: $fileCount\n";
    if ($errorCount > 0) {
        echo "⚠️ لم نتمكن من تعديل أذونات $errorCount عنصر (قد يكون بسبب قيود الاستضافة أو ملكية الملفات).\n";
    } else {
        echo "🎉 تم تحديث كافة الأذونات بنجاح!\n";
    }

} catch (Exception $e) {
    echo "حدث خطأ أثناء الفحص: " . $e->getMessage() . "\n";
}

echo "\n⚠️ هام جداً: يرجى حذف هذا الملف (fix_permissions.php) فوراً من الاستضافة لحماية موقعك.\n";
