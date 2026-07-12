<?php

namespace App\Services;

class ImageCompressor {
    const MAX_WIDTH       = 1200;  // Maximum width for general images (e.g., project cover)
    const PROFILE_MAX_W   = 400;   // Maximum width for profile photos
    const THUMB_MAX_W     = 600;   // Maximum width for thumbnails
    const JPEG_QUALITY    = 80;    // JPEG quality percentage
    const WEBP_QUALITY    = 75;    // WebP quality percentage

    /**
     * Compress and resize an image, saving both JPEG and WebP versions.
     * 
     * @param string $sourcePath Path to the uploaded temporary file.
     * @param string $destPathNoExt Destination path without file extension.
     * @param string $type The image usage type ('general', 'profile', 'thumbnail')
     * @return array Array containing paths of the saved files: ['jpg' => '...', 'webp' => '...'] or empty on failure.
     */
    public function compress(string $sourcePath, string $destPathNoExt, string $type = 'general'): array {
        // 0. Safe Fallback if GD library is not loaded/enabled in php.ini
        if (!extension_loaded('gd') || !function_exists('imagecreatefromjpeg')) {
            $dir = dirname($destPathNoExt);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            
            $jpgPath = $destPathNoExt . '.jpg';
            $webpPath = $destPathNoExt . '.webp';
            
            // Just copy the original uploaded file directly
            copy($sourcePath, $jpgPath);
            copy($sourcePath, $webpPath);
            
            return [
                'jpg'  => $jpgPath,
                'webp' => $webpPath
            ];
        }

        // 1. Get original image information
        $info = getimagesize($sourcePath);
        if (!$info) {
            return [];
        }

        list($origWidth, $origHeight, $mimeType) = $info;

        // 2. Load the source image based on mime type
        switch ($mimeType) {
            case IMAGETYPE_JPEG:
            case 'image/jpeg':
            case 'image/jpg':
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
            case 'image/png':
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
            case 'image/gif':
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            case IMAGETYPE_WEBP:
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $sourceImage = imagecreatefromwebp($sourcePath);
                } else {
                    return [];
                }
                break;
            default:
                return []; // Unsupported type
        }

        if (!$sourceImage) {
            return [];
        }

        // 3. Determine target dimensions
        $targetWidth = self::MAX_WIDTH;
        if ($type === 'profile') {
            $targetWidth = self::PROFILE_MAX_W;
        } elseif ($type === 'thumbnail') {
            $targetWidth = self::THUMB_MAX_W;
        }

        $newWidth = $origWidth;
        $newHeight = $origHeight;

        if ($origWidth > $targetWidth) {
            $ratio = $origHeight / $origWidth;
            $newWidth = $targetWidth;
            $newHeight = (int)round($newWidth * $ratio);
        }

        // 4. Create new image resource and copy-resize
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve alpha transparency for PNGs and WebPs
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);

        imagecopyresampled(
            $newImage,
            $sourceImage,
            0, 0, 0, 0,
            $newWidth,
            $newHeight,
            $origWidth,
            $origHeight
        );

        // Ensure target directory exists
        $dir = dirname($destPathNoExt);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // 5. Save as JPEG version
        $jpgPath = $destPathNoExt . '.jpg';
        imagejpeg($newImage, $jpgPath, self::JPEG_QUALITY);

        // Save as WebP version (if system supports it)
        $webpPath = $destPathNoExt . '.webp';
        if (function_exists('imagewebp')) {
            imagewebp($newImage, $webpPath, self::WEBP_QUALITY);
        } else {
            $webpPath = $jpgPath; // Fallback to JPEG path if WebP not supported by GD
        }

        // Clean up resources
        imagedestroy($sourceImage);
        imagedestroy($newImage);

        return [
            'jpg'  => $jpgPath,
            'webp' => $webpPath
        ];
    }
}

// ✅ CHECKPOINT: ImageCompressor.php — COMPLETE (المرحلة 4 من 8)
// التالي: app/Services/FileUploadService.php
