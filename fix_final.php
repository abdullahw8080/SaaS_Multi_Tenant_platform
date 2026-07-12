<?php
$baseDir = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\';

// 1. REWRITE index.php WITH BOTH: $secData loop and Image Extension Checking logic restored
$indexFile = $baseDir . 'templates\\template-developer\\index.php';
$indexContent = file_get_contents($indexFile);

// Insert the $secData loop right before the Education section
$secDataLoop = '        <!-- Populate secData for sections rendering -->
        <?php 
            $secData = [];
            foreach ($data[\'sections\'] as $s) {
                $secData[$s[\'type_key\']] = $s;
            }
        ?>
';

// Check if $secData is already in index.php
if (!str_contains($indexContent, '$secData = [];')) {
    $indexContent = str_replace('<!-- 1. Education -->', $secDataLoop . "\n        <!-- 1. Education -->", $indexContent);
}

// Restore photo extension logic in index.php
$oldPhotoLogic = '                                <?php 
                                    $photoUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($data[\'profile\'][\'photo\']), \'/\');
                                ?>';

$newPhotoLogic = '                                <?php 
                                    $photoUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($data[\'profile\'][\'photo\']), \'/\');
                                    $photoExt = strtolower(pathinfo($photoUrl, PATHINFO_EXTENSION));
                                    if (!in_array($photoExt, [\'jpg\', \'jpeg\', \'png\', \'webp\', \'gif\'])) {
                                        $photoUrl .= \'.jpg\';
                                    }
                                ?>';

$indexContent = str_replace($oldPhotoLogic, $newPhotoLogic, $indexContent);

file_put_contents($indexFile, $indexContent);


// 2. RESTORE extension checking inside projects.php for project covers
$projectsFile = $baseDir . 'templates\\template-developer\\sections\\projects.php';
$projectsContent = file_get_contents($projectsFile);

$oldProjImgLogic = '                        <?php 
                            $coverUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($proj[\'cover_image\']), \'/\');
                        ?>';

$newProjImgLogic = '                        <?php 
                            $coverUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($proj[\'cover_image\']), \'/\');
                            $coverExt = strtolower(pathinfo($coverUrl, PATHINFO_EXTENSION));
                            if (!in_array($coverExt, [\'jpg\', \'jpeg\', \'png\', \'webp\', \'gif\'])) {
                                $coverUrl .= \'.jpg\';
                            }
                        ?>';

$projectsContent = str_replace($oldProjImgLogic, $newProjImgLogic, $projectsContent);
file_put_contents($projectsFile, $projectsContent);


// 3. RESTORE extension checking in project_detail.php
$detailFile = $baseDir . 'templates\\template-developer\\sections\\project_detail.php';
$detailContent = file_get_contents($detailFile);

// Check cover image
$oldDetailCover = '                <?php 
                    $coverUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($project[\'cover_image\']), \'/\');
                ?>';
$newDetailCover = '                <?php 
                    $coverUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($project[\'cover_image\']), \'/\');
                    $coverExt = strtolower(pathinfo($coverUrl, PATHINFO_EXTENSION));
                    if (!in_array($coverExt, [\'jpg\', \'jpeg\', \'png\', \'webp\', \'gif\'])) {
                        $coverUrl .= \'.jpg\';
                    }
                ?>';
$detailContent = str_replace($oldDetailCover, $newDetailCover, $detailContent);

// Check gallery images
$oldDetailGallery = '                    <?php foreach ($images as $img): ?>
                        <?php 
                            $imgUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($img[\'file_path\']), \'/\');
                        ?>';
$newDetailGallery = '                    <?php foreach ($images as $img): ?>
                        <?php 
                            $imgUrl = BASE_URL . \'/\' . ltrim(htmlspecialchars($img[\'file_path\']), \'/\');
                            $imgExt = strtolower(pathinfo($imgUrl, PATHINFO_EXTENSION));
                            if (!in_array($imgExt, [\'jpg\', \'jpeg\', \'png\', \'webp\', \'gif\'])) {
                                $imgUrl .= \'.jpg\';
                            }
                        ?>';
$detailContent = str_replace($oldDetailGallery, $newDetailGallery, $detailContent);

file_put_contents($detailFile, $detailContent);

echo "Final fixes applied.";
?>
