<?php
// Script to sync templates directory with public/templates directory

function xcopy($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst, 0755, true);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                xcopy($src . '/' . $file, $dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

// Sync root templates with public/templates
$srcDir = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\templates';
$dstDir = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\public\\templates';

xcopy($srcDir, $dstDir);
echo "Templates successfully synced to public directory.";
?>
