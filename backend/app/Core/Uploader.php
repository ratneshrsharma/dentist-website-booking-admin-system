<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Clean & Secure File Uploader for CMS Images
 */
class Uploader
{
    private static array $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];
    private static array $allowedMimes = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/svg+xml',
        'image/gif'
    ];

    /**
     * Upload an image file and return its public URL
     *
     * @param array $file $_FILES['input_name']
     * @param string $prefix Prefix for generated file name
     * @param string $subFolder Optional page-name subfolder inside /uploads/ (e.g. 'home', 'about-us')
     * @return string|null The uploaded file URL or null if failed/empty
     */
    public static function uploadImage(array $file, string $prefix = 'img', string $subFolder = ''): ?string
    {
        if (empty($file['name']) || empty($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Validate extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::$allowedExtensions, true)) {
            return null;
        }

        // Validate MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, self::$allowedMimes, true)) {
            return null;
        }

        // Sanitize subfolder name
        $subFolder = trim(preg_replace('/[^a-zA-Z0-9_-]/', '', $subFolder));
        $relativeDir = $subFolder !== '' ? '/uploads/' . $subFolder : '/uploads';

        // Target upload directory
        $targetDir = dirname(__DIR__, 2) . '/public' . $relativeDir;
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }

        // Generate safe unique filename
        $fileName = sprintf('%s_%s_%s.%s', $prefix, date('Ymd_His'), bin2hex(random_bytes(4)), $ext);
        $targetPath = $targetDir . '/' . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return App::url($relativeDir . '/' . $fileName);
        }

        return null;
    }
}
