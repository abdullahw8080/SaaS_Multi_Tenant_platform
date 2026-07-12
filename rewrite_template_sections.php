<?php
$baseDir = 'c:\\xampp\\htdocs\\SaaS_Multi_Tenant_platform\\templates\\template-developer\\sections\\';

// 1. skills.php
$skillsContent = '<?php
use App\Services\BilingualHelper;
if (!empty($data[\'skills\'])): ?>
    <div class="skills-tags-container">
        <?php foreach ($data[\'skills\'] as $skill): ?>
            <div class="skill-tag-badge">
                <div class="skill-tag-header">
                    <i class="fas fa-check-circle"></i>
                    <span class="skill-name"><?= htmlspecialchars(BilingualHelper::get($skill, \'name\', $lang)) ?></span>
                </div>
                <?php if (!empty(BilingualHelper::get($skill, \'description\', $lang))): ?>
                    <p class="skill-description"><?= htmlspecialchars(BilingualHelper::get($skill, \'description\', $lang)) ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'skills.php', $skillsContent);

// 2. certificates.php
$certificatesContent = '<?php
use App\Services\BilingualHelper;
if (!empty($data[\'certificates\'])): ?>
    <div class="cert-grid">
        <?php foreach ($data[\'certificates\'] as $cert): ?>
            <div class="cert-card">
                <i class="fas fa-award cert-icon"></i>
                <h3><?= htmlspecialchars(BilingualHelper::get($cert, \'title\', $lang)) ?></h3>
                <p class="cert-issuer"><i class="fas fa-building"></i> <?= htmlspecialchars(BilingualHelper::get($cert, \'issuer\', $lang)) ?></p>
                <?php if (!empty($cert[\'year\'])): ?>
                    <p class="cert-year"><i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($cert[\'year\']) ?></p>
                <?php endif; ?>
                
                <div class="cert-actions">
                    <?php if (!empty($cert[\'file\'])): ?>
                        <a href="<?= BASE_URL . htmlspecialchars($cert[\'file\']) ?>" target="_blank" class="cert-btn">
                            <i class="fas fa-file-pdf"></i> <?= $lang === \'en\' ? \'View File\' : \'عرض الملف\' ?>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($cert[\'link\'])): ?>
                        <a href="<?= htmlspecialchars($cert[\'link\']) ?>" target="_blank" class="cert-btn outline">
                            <i class="fas fa-external-link-alt"></i> <?= $lang === \'en\' ? \'Verify Link\' : \'رابط التحقق\' ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'certificates.php', $certificatesContent);

// 3. projects.php
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
                            <!-- Secure Dynamic Routing to specific project of this specific tenant -->
                            <a href="<?= BASE_URL ?>/<?= htmlspecialchars($tenant[\'domain_prefix\']) ?>/project/<?= htmlspecialchars($proj[\'slug\']) ?><?= $lang === \'en\' ? \'?lang=en\' : \'\' ?>" class="project-details-btn">
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

// 4. experiences.php
$experiencesContent = '<?php
use App\Services\BilingualHelper;
if (!empty($data[\'experiences\'])): ?>
    <div class="timeline">
        <?php foreach ($data[\'experiences\'] as $exp): ?>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <h3><?= htmlspecialchars(BilingualHelper::get($exp, \'position\', $lang)) ?></h3>
                    <h4><?= htmlspecialchars(BilingualHelper::get($exp, \'company\', $lang)) ?></h4>
                    <?php if (!empty($exp[\'start_date\']) || !empty($exp[\'end_date\'])): ?>
                        <div class="timeline-date">
                            <i class="far fa-calendar-alt"></i>
                            <?= htmlspecialchars($exp[\'start_date\'] ?? \'\') ?> <?= (!empty($exp[\'start_date\']) && !empty($exp[\'end_date\'])) ? \'-\' : \'\' ?> <?= htmlspecialchars($exp[\'end_date\'] ?? \'\') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty(BilingualHelper::get($exp, \'description\', $lang))): ?>
                        <p class="timeline-desc"><?= nl2br(htmlspecialchars(BilingualHelper::get($exp, \'description\', $lang))) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'experiences.php', $experiencesContent);

// 5. education.php
$educationContent = '<?php
use App\Services\BilingualHelper;
if (!empty($data[\'education\'])): ?>
    <div class="timeline edu-timeline">
        <?php foreach ($data[\'education\'] as $edu): ?>
            <div class="timeline-item">
                <div class="timeline-dot"><i class="fas fa-graduation-cap" style="font-size:0.8rem; color:#fff; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);"></i></div>
                <div class="timeline-content">
                    <h3><?= htmlspecialchars(BilingualHelper::get($edu, \'degree\', $lang)) ?></h3>
                    <h4><?= htmlspecialchars(BilingualHelper::get($edu, \'institution\', $lang)) ?></h4>
                    <?php if (!empty($edu[\'year\'])): ?>
                        <div class="timeline-date">
                            <i class="far fa-calendar-alt"></i> <?= htmlspecialchars($edu[\'year\']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>';
file_put_contents($baseDir . 'education.php', $educationContent);

echo "Successfully rewrote template sections.";
?>
