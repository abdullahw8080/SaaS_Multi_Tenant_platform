<?php
$baseDir = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\templates\\template-developer\\sections\\';

// Correcting the projects link to use $data['site']['domain_prefix'] and /projects/
$projectsContent = '<?php
use App\Services\BilingualHelper;
if (!empty($data[\'projects\'])): ?>
    <div class="projects-grid">
        <?php foreach ($data[\'projects\'] as $proj): ?>
            <div class="project-card">
                <?php if (!empty($proj[\'cover_image\'])): ?>
                    <div class="project-image" style="background-image: url(\'<?= BASE_URL . htmlspecialchars($proj[\'cover_image\']) ?>\');">
                        <div class="project-type-badge">
                            <?php 
                                $typeMap = [
                                    \'project\' => $lang === \'en\' ? \'Project\' : \'مشروع\',
                                    \'research\' => $lang === \'en\' ? \'Research\' : \'بحث\',
                                    \'case_study\' => $lang === \'en\' ? \'Case Study\' : \'دراسة حالة\'
                                ];
                                echo $typeMap[$proj[\'type\'] ?? \'project\'];
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="project-content">
                    <h3><?= htmlspecialchars(BilingualHelper::get($proj, \'title\', $lang)) ?></h3>
                    <?php if (!empty(BilingualHelper::get($proj, \'summary\', $lang))): ?>
                        <p class="project-summary"><?= htmlspecialchars(BilingualHelper::get($proj, \'summary\', $lang)) ?></p>
                    <?php endif; ?>
                    
                    <div class="project-links">
                        <?php if (!empty($proj[\'link\'])): ?>
                            <a href="<?= htmlspecialchars($proj[\'link\']) ?>" target="_blank" title="<?= $lang === \'en\' ? \'Live Demo\' : \'معاينة مباشرة\' ?>">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($proj[\'github_link\'])): ?>
                            <a href="<?= htmlspecialchars($proj[\'github_link\']) ?>" target="_blank" title="GitHub / Source">
                                <i class="fab fa-github"></i>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($proj[\'slug\'])): ?>
                            <!-- Secure Dynamic Routing strictly scoping to this Tenant\'s ID -->
                            <a href="<?= BASE_URL ?>/<?= htmlspecialchars($data[\'site\'][\'domain_prefix\']) ?>/projects/<?= htmlspecialchars($proj[\'slug\']) ?><?= $lang === \'en\' ? \'?lang=en\' : \'\' ?>" class="project-details-btn">
                                <?= $lang === \'en\' ? \'Details\' : \'التفاصيل\' ?> <i class="fas fa-arrow-<?= $lang === \'en\' ? \'right\' : \'left\' ?>"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'projects.php', $projectsContent);

// Injecting the new Tag Badges CSS into style.css
$styleFile = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\templates\\template-developer\\style.css';
$styleContent = file_get_contents($styleFile);

$newCss = '
/* --- Modern Developer Template Overhaul --- */

/* Skills Tags & Badges */
.skills-tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 20px;
}
.skill-tag-badge {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 12px 18px;
    transition: all 0.3s ease;
    flex: 1 1 auto;
    min-width: 140px;
    max-width: 100%;
}
.skill-tag-badge:hover {
    background: rgba(99, 102, 241, 0.1);
    border-color: rgba(99, 102, 241, 0.5);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}
.skill-tag-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 700;
    color: var(--text-primary);
}
.skill-tag-header i {
    color: var(--accent-glow);
    font-size: 1.1rem;
}
.skill-description {
    font-size: 0.85rem;
    color: var(--text-secondary);
    margin-top: 8px;
    line-height: 1.5;
}

/* Certificate Cards adjustments */
.cert-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 24px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.05);
    transition: all 0.3s;
}
.cert-card:hover {
    border-color: var(--accent-glow);
    transform: translateY(-5px);
}
.cert-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    flex-wrap: wrap;
}
.cert-btn {
    background: var(--accent-glow);
    color: #fff;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s;
}
.cert-btn.outline {
    background: transparent;
    border: 1px solid var(--accent-glow);
    color: var(--accent-glow);
}
.cert-btn.outline:hover {
    background: var(--accent-glow);
    color: #fff;
}
.cert-btn:hover:not(.outline) {
    background: #4f46e5;
}

/* Project Specific CSS */
.project-links {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 20px;
}
.project-links a {
    color: var(--text-secondary);
    font-size: 1.2rem;
    transition: color 0.3s;
}
.project-links a:hover {
    color: var(--accent-glow);
}
.project-details-btn {
    margin-right: auto; /* Arabic */
    margin-left: auto; /* English will override with JS or dir=ltr rules */
    background: rgba(99, 102, 241, 0.1);
    border: 1px solid rgba(99, 102, 241, 0.3);
    color: var(--accent-glow) !important;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem !important;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s;
}
[dir="ltr"] .project-details-btn {
    margin-right: 0;
    margin-left: auto;
}
.project-details-btn:hover {
    background: var(--accent-glow) !important;
    color: #fff !important;
}

/* Ensure responsiveness */
@media (max-width: 768px) {
    .skills-tags-container {
        flex-direction: column;
    }
    .cert-actions {
        flex-direction: column;
    }
    .cert-btn { width: 100%; justify-content: center; }
}
';

$styleContent .= $newCss;
file_put_contents($styleFile, $styleContent);

// Fix index.php to use the tag badges for personal skills
$indexPhpFile = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\templates\\template-developer\\index.php';
$indexContent = file_get_contents($indexPhpFile);

$personalSkillsOld = '/<section class="section" id="personal-skills" data-aos="fade-up">.*?<\/section>/s';
$personalSkillsNew = '<section class="section" id="personal-skills" data-aos="fade-up">
                <div class="section-title">
                    <i class="fas fa-user-check"></i>
                    <h2><?= $lang === \'en\' ? \'Personal Skills\' : \'المهارات الشخصية\' ?></h2>
                </div>
                <div class="skills-tags-container">
                    <?php foreach ($data[\'personal_skills\'] as $pskill): ?>
                        <div class="skill-tag-badge">
                            <div class="skill-tag-header">
                                <i class="fas fa-check-circle"></i>
                                <span class="skill-name"><?= htmlspecialchars(BilingualHelper::get($pskill, \'name\', $lang)) ?></span>
                            </div>
                            <?php if (!empty(BilingualHelper::get($pskill, \'description\', $lang))): ?>
                                <p class="skill-description"><?= htmlspecialchars(BilingualHelper::get($pskill, \'description\', $lang)) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>';

$indexContent = preg_replace($personalSkillsOld, $personalSkillsNew, $indexContent);
file_put_contents($indexPhpFile, $indexContent);

echo "Template completely updated and secured.";
?>
