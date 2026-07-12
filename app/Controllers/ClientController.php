<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\Site;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\Project;
use App\Models\ProjectMedia;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Certificate;
use App\Models\SiteSection;
use App\Models\SectionItem;
use App\Services\FileUploadService;
use App\Services\ApprovalService;
use App\Services\ExportService;
use Templates\TemplateRenderer; // Will be built in Phase 7

class ClientController extends BaseController {
    /**
     * Ensure client is logged in and owns a site.
     */
    private function checkSite(): int {
        $siteId = Auth::siteId();
        if (!$siteId) {
            header($_SERVER["SERVER_PROTOCOL"] . " 403 Forbidden");
            echo "<h1>403 Forbidden</h1><p>لم يتم تخصيص موقع لهذا الحساب بعد. يرجى مراجعة الإدارة.</p>";
            exit;
        }
        return $siteId;
    }

    /**
     * Show client dashboard with bilingual editing tabs.
     */
    public function index(): void {
        $siteId = $this->checkSite();
        
        // Self-healing check: Ensure all default sections for the template exist
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmtSite = $db->prepare("SELECT template_id FROM `sites` WHERE id = :id LIMIT 1");
        $stmtSite->execute(['id' => $siteId]);
        $templateId = $stmtSite->fetchColumn();
        if ($templateId) {
            $stmtTpl = $db->prepare("SELECT `default_sections` FROM `templates` WHERE `id` = :template_id LIMIT 1");
            $stmtTpl->execute(['template_id' => $templateId]);
            $defaultSectionsJson = $stmtTpl->fetchColumn();
            if ($defaultSectionsJson) {
                $defaultSections = json_decode($defaultSectionsJson, true);
                foreach ($defaultSections as $index => $key) {
                    $stmtCheck = $db->prepare("
                        SELECT COUNT(*) FROM `site_sections` ss 
                        JOIN `section_types` st ON ss.section_type_id = st.id 
                        WHERE ss.site_id = :site_id AND st.key = :key
                    ");
                    $stmtCheck->execute(['site_id' => $siteId, 'key' => $key]);
                    if ((int)$stmtCheck->fetchColumn() === 0) {
                        $stmtType = $db->prepare("SELECT * FROM `section_types` WHERE `key` = :key LIMIT 1");
                        $stmtType->execute(['key' => $key]);
                        $type = $stmtType->fetch();
                        if ($type) {
                            $db->prepare("
                                INSERT INTO `site_sections` (`site_id`, `section_type_id`, `title`, `title_en`, `sort_order`, `is_visible`)
                                VALUES (:site_id, :section_type_id, :title, :title_en, :sort_order, 1)
                            ")->execute([
                                'site_id' => $siteId,
                                'section_type_id' => $type['id'],
                                'title' => $type['name'],
                                'title_en' => ucwords(str_replace('_', ' ', $key)),
                                'sort_order' => 10 + $index
                            ]);
                        }
                    }
                }
            }
        }

        $siteModel = new Site();
        $siteData = $siteModel->getFullSiteData($siteId);
        
        if (!$siteData) {
            echo "<h1>خطأ</h1><p>تعذر جلب بيانات الموقع.</p>";
            exit;
        }

        $this->view('client/dashboard', [
            'siteData'   => $siteData,
            'csrf_token' => $this->csrfToken()
        ]);
    }

    /**
     * Submit site for review.
     */
    public function submitReview(): void {
        $siteId = $this->checkSite();
        
        $approvalService = new ApprovalService();
        if ($approvalService->submitForReview($siteId)) {
            $_SESSION['flash_success'] = "تم إرسال موقعك للمراجعة بنجاح. سيتم نشره بعد موافقة الإدارة.";
        } else {
            $_SESSION['flash_error'] = "لا يمكن إرسال الموقع للمراجعة في الوقت الحالي.";
        }
        $this->redirect('/dashboard');
    }

    /**
     * Save/Sync all site data (Profile, Skills, Projects, Experiences, Education, Certificates).
     */
    public function save(): void {
        $this->verifyCsrf();
        $siteId = $this->checkSite();
        
        $fileUpload = new FileUploadService();
        $db = \App\Core\Database::getInstance()->getConnection();
        
        try {
            $db->beginTransaction();

            // 1. Process and Save Profile
            $profileData = $_POST['profile'] ?? [];
            if (!empty($_FILES['profile_photo']['name'])) {
                $photoPath = $fileUpload->uploadImage($_FILES['profile_photo'], $siteId, 'profile');
                if ($photoPath) {
                    $profileData['photo'] = $photoPath;
                }
            } else {
                $profileData['photo'] = $_POST['profile']['existing_photo'] ?? null;
            }

            if (!empty($_FILES['profile_cv']['name'])) {
                $cvPath = $fileUpload->uploadPdf($_FILES['profile_cv'], $siteId);
                if ($cvPath) {
                    $profileData['cv_url'] = $cvPath;
                }
            } else {
                $profileData['cv_url'] = $_POST['profile']['existing_cv'] ?? null;
            }

            $profileModel = new Profile();
            $profileModel->saveProfile($siteId, $profileData);

            // 2. Process and Sync Social Links
            $socialData = $_POST['social'] ?? [];
            $db->prepare("DELETE FROM `social_links` WHERE `site_id` = :site_id")->execute(['site_id' => $siteId]);
            $stmtSocial = $db->prepare("INSERT INTO `social_links` (`site_id`, `platform`, `url`, `sort_order`) VALUES (:site_id, :platform, :url, :sort_order)");
            $index = 0;
            foreach ($socialData as $platform => $url) {
                if (!empty($url)) {
                    $stmtSocial->execute([
                        'site_id'    => $siteId,
                        'platform'   => $platform,
                        'url'        => $url,
                        'sort_order' => $index++
                    ]);
                }
            }

            // 3. Sync Technical Skills
            $skills = $_POST['skills'] ?? [];
            $skillModel = new Skill();
            $skillModel->sync($siteId, $skills, 'technical');

            // 3b. Sync Personal Skills
            $personalSkills = $_POST['personal_skills'] ?? [];
            $skillModel->sync($siteId, $personalSkills, 'personal');

            // 3c. Sync Languages
            $languages = $_POST['languages'] ?? [];
            $languageModel = new \App\Models\Language();
            $languageModel->sync($siteId, $languages);

            // 4. Sync Experiences
            $experiences = $_POST['experiences'] ?? [];
            $experienceModel = new Experience();
            $experienceModel->sync($siteId, $experiences);

            // 5. Sync Education
            $educations = $_POST['education'] ?? [];
            $educationModel = new Education();
            $educationModel->sync($siteId, $educations);

            // 6. Sync Certificates
            $certificates = $_POST['certificates'] ?? [];
            // Map certificate uploads
            foreach ($certificates as $i => &$cert) {
                $fileInputKey = "certificate_file_{$i}";
                if (!empty($_FILES[$fileInputKey]['name'])) {
                    $certPdfPath = $fileUpload->uploadPdf($_FILES[$fileInputKey], $siteId);
                    if ($certPdfPath) {
                        $cert['file_url'] = $certPdfPath;
                    }
                } else {
                    $cert['file_url'] = $_POST['certificates'][$i]['existing_file'] ?? null;
                }
            }
            $certificateModel = new Certificate();
            $certificateModel->sync($siteId, $certificates);

            // 7. Sync Projects and Project Media
            $projects = $_POST['projects'] ?? [];
            foreach ($projects as $i => &$proj) {
                // Project Cover
                $coverInputKey = "project_cover_{$i}";
                if (!empty($_FILES[$coverInputKey]['name'])) {
                    $coverPath = $fileUpload->uploadImage($_FILES[$coverInputKey], $siteId, 'thumbnail');
                    if ($coverPath) {
                        $proj['cover_image'] = $coverPath;
                    }
                } else {
                    $proj['cover_image'] = $_POST['projects'][$i]['existing_cover'] ?? null;
                }

                // Project Media Gallery
                $proj['media'] = [];
                // Check if project has media items in POST
                $projMediaPost = $_POST['projects'][$i]['media'] ?? [];
                
                foreach ($projMediaPost as $j => $mediaItem) {
                    $mediaFileInputKey = "project_media_file_{$i}_{$j}";
                    $mediaFilePath = $_POST['projects'][$i]['media'][$j]['existing_file'] ?? null;

                    if (!empty($_FILES[$mediaFileInputKey]['name'])) {
                        // Check extension to decide if pdf or image
                        $fileName = $_FILES[$mediaFileInputKey]['name'];
                        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                        if ($ext === 'pdf') {
                            $pdfPath = $fileUpload->uploadPdf($_FILES[$mediaFileInputKey], $siteId);
                            if ($pdfPath) {
                                $mediaFilePath = $pdfPath;
                            }
                        } else {
                            $imgPath = $fileUpload->uploadImage($_FILES[$mediaFileInputKey], $siteId, 'general');
                            if ($imgPath) {
                                $mediaFilePath = $imgPath;
                            }
                        }
                    }

                    if ($mediaFilePath) {
                        $proj['media'][] = [
                            'file_path'  => $mediaFilePath,
                            'file_type'  => (str_ends_with($mediaFilePath, '.pdf')) ? 'pdf' : 'image',
                            'caption'    => $mediaItem['caption'] ?? '',
                            'caption_en' => $mediaItem['caption_en'] ?? ''
                        ];
                    }
                }
            }
            $projectModel = new Project();
            $projectModel->sync($siteId, $projects);

            // 8. Sync Dynamic Sections Visibility and Titles
            $sectionsData = $_POST['sections'] ?? [];
            $sectionModel = new SiteSection();
            foreach ($sectionsData as $sectionId => $sec) {
                $sectionModel->update((int)$sectionId, [
                    'title'      => $sec['title'] ?? '',
                    'title_en'   => $sec['title_en'] ?? '',
                    'is_visible' => isset($sec['is_visible']) ? 1 : 0
                ]);
            }

            // Update site settings: default language, bilingual support, and profession type (independent)
            $siteModel = new Site();
            $allowedProfessions = ['developer','engineer','doctor','pharmacist','lawyer','teacher','executive','accountant','student','other'];
            $siteModel->update($siteId, [
                'default_lang'    => in_array($_POST['default_lang'] ?? '', ['ar', 'en']) ? $_POST['default_lang'] : 'ar',
                'is_bilingual'    => isset($_POST['is_bilingual']) ? 1 : 0,
                'profession_type' => in_array($_POST['profession_type'] ?? '', $allowedProfessions) ? $_POST['profession_type'] : 'developer',
                // Automatically transition site status to draft on edit so they can re-submit
                'approval_status' => ($_POST['approval_status'] ?? '') === 'approved' ? 'approved' : 'draft'
            ]);

            $db->commit();

            // Clear static cache for the site slug on save
            $site = $siteModel->find($siteId);
            \App\Services\ApprovalService::invalidateCache($site['slug']);

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => "تم حفظ جميع التعديلات بنجاح."]);
                exit;
            }

            $_SESSION['flash_success'] = "تم حفظ التعديلات بنجاح. إذا كان موقعك معطلاً أو مسودة، يرجى إرساله للمراجعة.";
        } catch (\Exception $e) {
            $db->rollBack();

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => "حدث خطأ أثناء حفظ البيانات: " . $e->getMessage()]);
                exit;
            }

            $_SESSION['flash_error'] = "حدث خطأ أثناء حفظ البيانات: " . $e->getMessage();
        }

        $this->redirect('/dashboard');
    }

    /**
     * Export site as static ZIP.
     */
    public function exportSite(): void {
        $siteId = $this->checkSite();

        // 1. We require rendering the page inside a buffer
        // Since we will build TemplateRenderer in Phase 7, we import and instantiate it
        require_once dirname(__DIR__, 2) . '/templates/TemplateRenderer.php';
        $renderer = new \Templates\TemplateRenderer();
        
        $siteModel = new Site();
        $site = $siteModel->find($siteId);
        $templateFolder = $db = \App\Core\Database::getInstance()->getConnection()
            ->query("SELECT t.folder_name FROM `sites` s JOIN `templates` t ON s.template_id = t.id WHERE s.id = {$siteId}")
            ->fetchColumn();

        // Render twice: once for Arabic, once for English if bilingual
        // For simplicity, we export the default rendering, or we can compile them together
        $html = $renderer->render($siteId);

        $exportService = new ExportService();
        $zipUrl = $exportService->export($siteId, $html, $templateFolder);

        if ($zipUrl) {
            // Force download
            $zipFilePath = dirname(__DIR__, 2) . '/public' . $zipUrl;
            if (file_exists($zipFilePath)) {
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename="' . basename($zipFilePath) . '"');
                header('Content-Length: ' . filesize($zipFilePath));
                readfile($zipFilePath);
                exit;
            }
        }

        $_SESSION['flash_error'] = "فشل تصدير الموقع، يرجى المحاولة لاحقاً.";
        $this->redirect('/dashboard');
    }
}

// ✅ CHECKPOINT: ClientController.php — COMPLETE (المرحلة 6 من 8)
// التالي: app/Views/client/dashboard.php
