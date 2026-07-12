<?php
$file = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\app\\Views\\client\\dashboard.php';
$content = file_get_contents($file);

// 1. Remove 'level' from existing skills PHP loop
// Note: We need to change 'grid-3' to 'grid-2' for the first row of skills
$content = str_replace('<div class="grid grid-3">', '<div class="grid grid-2">', $content);

// The block for skill level:
$skillLevelPattern = '/<div class="form-group">\s*<label class="form-label">النسبة المئوية للمستوى \(1 - 100\)<\/label>\s*<input type="number" name="(personal_)?skills\[(.*?)\]\[level\]" class="form-input" min="1" max="100" value="(.*?)" required>\s*<\/div>/s';
$content = preg_replace($skillLevelPattern, '', $content);

// 2. Remove 'level' from addSkillRow JS
$addSkillPattern = '/<div class="form-group">\s*<label class="form-label">النسبة المئوية للمستوى \(1 - 100\)<\/label>\s*<input type="number" name="(personal_)?skills\[\$\{.*?\}\]\[level\]" class="form-input" min="1" max="100" value=".*?" required>\s*<\/div>/s';
$content = preg_replace($addSkillPattern, '', $content);

// 3. Certificates: Remove required from certificate_file (existing)
$content = preg_replace('/<input type="file" name="certificate_file_(.*?)" class="form-input" style="height: auto;" required>/', '<input type="file" name="certificate_file_$1" class="form-input" style="height: auto;">', $content);
$content = preg_replace('/<input type="file" name="certificate_file_\$\{certCounter\}" class="form-input" style="height: auto;" required>/', '<input type="file" name="certificate_file_${certCounter}" class="form-input" style="height: auto;">', $content);

// Add Certificate Link to JS template
$certJsSearch = '<div class="form-group">
                            <label class="form-label ltr">Issuer Organization (EN)</label>
                            <input type="text" name="certificates[${certCounter}][issuer_en]" class="form-input ltr">
                        </div>';
$certJsReplace = $certJsSearch . '
                        <div class="form-group">
                            <label class="form-label">رابط الشهادة (URL)</label>
                            <input type="url" name="certificates[${certCounter}][link]" class="form-input ltr" placeholder="https://...">
                        </div>';
$content = str_replace($certJsSearch, $certJsReplace, $content);

// Add Certificate Link to PHP loop
$certPhpSearch = '<div class="form-group">
                                        <label class="form-label ltr">Issuer Organization (EN)</label>
                                        <input type="text" name="certificates[<?= $i ?>][issuer_en]" class="form-input ltr" value="<?= htmlspecialchars($cert[\'issuer_en\'] ?? \'\') ?>">
                                    </div>';
$certPhpReplace = $certPhpSearch . '
                                    <div class="form-group">
                                        <label class="form-label">رابط الشهادة (URL)</label>
                                        <input type="url" name="certificates[<?= $i ?>][link]" class="form-input ltr" placeholder="https://..." value="<?= htmlspecialchars($cert[\'link\'] ?? \'\') ?>">
                                    </div>';
$content = str_replace($certPhpSearch, $certPhpReplace, $content);

// 4. Projects: Make Slug optional
$content = str_replace('name="projects[<?= $i ?>][slug]" class="form-input ltr" placeholder="project-slug-name" value="<?= htmlspecialchars($proj[\'slug\'] ?? \'\') ?>" required', 'name="projects[<?= $i ?>][slug]" class="form-input ltr" placeholder="project-slug-name" value="<?= htmlspecialchars($proj[\'slug\'] ?? \'\') ?>"', $content);
$content = str_replace('name="projects[${i}][slug]" class="form-input ltr" placeholder="project-slug-name" required', 'name="projects[${i}][slug]" class="form-input ltr" placeholder="project-slug-name"', $content);

// 5. Add "Cancel Changes" button
$saveBtnSearch = '<button type="submit" class="btn btn-primary" style="width: auto; padding: 14px 40px; font-size: 1.1rem; background-color: var(--primary);">';
$saveBtnReplace = '<button type="button" class="btn btn-secondary" style="width: auto; padding: 14px 30px; font-size: 1.1rem; background-color: var(--bg-input); border-color: var(--border-color); color: var(--text-main);" onclick="window.location.reload();">
                            إلغاء التعديلات <i class="fa-solid fa-xmark"></i>
                        </button>
                        ' . $saveBtnSearch;
$content = str_replace($saveBtnSearch, $saveBtnReplace, $content);

file_put_contents($file, $content);
echo "Dashboard updated successfully.";
?>
