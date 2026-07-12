<?php

namespace App\Services;

class FileUploadService {
    private ImageCompressor $compressor;
    private string $uploadRootDir;

    public function __construct() {
        $this->compressor = new ImageCompressor();
        // Uploads will be saved in public/uploads for direct web access
        $this->uploadRootDir = dirname(__DIR__, 2) . '/public/uploads/sites';
    }

    /**
     * Upload and compress an image file.
     * 
     * @param array $file The $_FILES['name'] array.
     * @param int $siteId The ID of the site.
     * @param string $type The image usage type ('general', 'profile', 'thumbnail')
     * @return string|null The relative web path to the saved image (without extension, or with WebP) or null on failure.
     */
    public function uploadImage(array $file, int $siteId, string $type = 'general'): ?string {
        // Validate PHP upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // 1. Reject massive files (> 10MB)
        if ($file['size'] > 10 * 1024 * 1024) {
            throw new \Exception("File size exceeds the maximum limit of 10MB.");
        }

        // 2. Validate MIME type strictly
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedMimeTypes = [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif',
            'image/webp'
        ];

        if (!in_array($mimeType, $allowedMimeTypes)) {
            throw new \Exception("Invalid image file type. Allowed: JPG, PNG, GIF, WEBP.");
        }

        // 3. Prepare tenant directory
        $tenantDir = $this->uploadRootDir . '/' . $siteId;
        if (!is_dir($tenantDir)) {
            mkdir($tenantDir, 0755, true);
        }

        // 4. Generate unique filename prefix
        $fileName = uniqid($type . '_', true);
        $destPathNoExt = $tenantDir . '/' . $fileName;

        // 5. Compress and save
        $result = $this->compressor->compress($file['tmp_name'], $destPathNoExt, $type);

        // Delete temporary file
        if (file_exists($file['tmp_name'])) {
            @unlink($file['tmp_name']);
        }

        if (empty($result)) {
            return null;
        }

        // Return relative path from public root without extension
        // e.g., "/uploads/sites/1/general_5f9..."
        // In the HTML, we can append .jpg or .webp dynamically
        return '/uploads/sites/' . $siteId . '/' . $fileName;
    }

    /**
     * Upload a PDF document.
     * 
     * @param array $file The $_FILES['name'] array.
     * @param int $siteId The ID of the site.
     * @return string|null The relative web path to the saved PDF or null on failure.
     */
    public function uploadPdf(array $file, int $siteId): ?string {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Reject > 10MB
        if ($file['size'] > 10 * 1024 * 1024) {
            throw new \Exception("File size exceeds the maximum limit of 10MB.");
        }

        // Validate MIME type strictly
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        $allowedPdfMimes = [
            'application/pdf',
            'application/x-pdf',
            'application/acrobat',
            'applications/vnd.pdf',
            'text/pdf',
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/webp'
        ];

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($mimeType, $allowedPdfMimes) && !in_array($extension, $allowedExtensions)) {
            throw new \Exception("Invalid file type: {$file['name']} (Detected MIME: {$mimeType}). Only PDF and Image files (JPG, PNG) are allowed.");
        }

        // Prepare tenant docs directory
        $tenantDocsDir = $this->uploadRootDir . '/' . $siteId . '/docs';
        if (!is_dir($tenantDocsDir)) {
            mkdir($tenantDocsDir, 0755, true);
        }

        $fileName = uniqid('doc_', true) . '.' . $extension;
        $destPath = $tenantDocsDir . '/' . $fileName;

        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            return '/uploads/sites/' . $siteId . '/docs/' . $fileName;
        }

        return null;
    }
}

// ✅ CHECKPOINT: FileUploadService.php — COMPLETE (المرحلة 4 من 8)
// التالي: app/Services/BilingualHelper.php
