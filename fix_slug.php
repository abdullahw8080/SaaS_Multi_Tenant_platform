<?php
$projectsFile = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\templates\\template-developer\\sections\\projects.php';
$content = file_get_contents($projectsFile);

// Replace domain_prefix with slug for the site routing
$content = str_replace("\$data['site']['domain_prefix']", "\$data['site']['slug']", $content);

file_put_contents($projectsFile, $content);

// Clear the cache to ensure the changes take effect
$cacheDir = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\cache\\';
$files = glob($cacheDir . '*');
foreach($files as $file) {
    if(is_file($file)) {
        unlink($file);
    }
}
echo "Fixed project routing and cleared cache.";
?>
