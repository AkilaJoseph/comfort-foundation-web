<?php
/**
 * Comfort Foundation — image upload handling.
 * Every accepted upload is re-encoded to WebP, which keeps the whole
 * site on a single modern image format.
 */

declare(strict_types=1);

const CF_UPLOAD_MAX_BYTES = 8388608;   // 8 MB
const CF_UPLOAD_MAX_EDGE  = 1800;      // px — longest side after resize

function upload_dir(): string
{
    return CF_ROOT . '/uploads/media';
}

/** Can this server produce WebP files? */
function webp_supported(): bool
{
    return function_exists('imagewebp')
        || (class_exists('Imagick') && in_array('WEBP', Imagick::queryFormats('WEBP') ?: [], true));
}

/**
 * Handle one uploaded file.
 *
 * @return array{ok:bool, path?:string, error?:string}
 */
function handle_upload(array $file): array
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['ok' => false, 'error' => 'No file was selected.'];
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'error' => 'The file could not be uploaded (error code ' . (int) $file['error'] . ').'];
    }
    if (($file['size'] ?? 0) > CF_UPLOAD_MAX_BYTES) {
        return ['ok' => false, 'error' => 'That image is larger than 8 MB. Please choose a smaller file.'];
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        return ['ok' => false, 'error' => 'Upload verification failed.'];
    }

    $info = @getimagesize($file['tmp_name']);
    if (!$info) {
        return ['ok' => false, 'error' => 'That file is not a readable image.'];
    }
    $allowed = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP];
    if (!in_array($info[2], $allowed, true)) {
        return ['ok' => false, 'error' => 'Please upload a JPG, PNG, GIF or WebP image.'];
    }

    $dir = upload_dir();
    if (!is_dir($dir) && !@mkdir($dir, 0775, true)) {
        return ['ok' => false, 'error' => 'The uploads folder could not be created. Check folder permissions.'];
    }
    if (!is_writable($dir)) {
        return ['ok' => false, 'error' => 'The uploads folder is not writable. Set permissions to 755 or 775.'];
    }

    $stem = slugify(pathinfo((string) ($file['name'] ?? 'image'), PATHINFO_FILENAME));
    $stem = substr($stem, 0, 60) . '-' . substr(bin2hex(random_bytes(4)), 0, 8);

    // ---- preferred path: re-encode to WebP -----------------------------
    if (webp_supported()) {
        $dest = $dir . '/' . $stem . '.webp';
        if (convert_to_webp($file['tmp_name'], $dest, $info[2])) {
            return ['ok' => true, 'path' => 'uploads/media/' . basename($dest)];
        }
    }

    // ---- fallback: store the original --------------------------------
    $ext  = image_type_to_extension($info[2], false) ?: 'jpg';
    $dest = $dir . '/' . $stem . '.' . $ext;
    if (!@move_uploaded_file($file['tmp_name'], $dest)) {
        return ['ok' => false, 'error' => 'The image could not be saved.'];
    }
    @chmod($dest, 0644);
    return ['ok' => true, 'path' => 'uploads/media/' . basename($dest)];
}

/** Re-encode an image file to WebP, resizing if it is very large. */
function convert_to_webp(string $src, string $dest, int $type): bool
{
    if (function_exists('imagewebp')) {
        $im = match ($type) {
            IMAGETYPE_JPEG => function_exists('imagecreatefromjpeg') ? @imagecreatefromjpeg($src) : false,
            IMAGETYPE_PNG  => function_exists('imagecreatefrompng')  ? @imagecreatefrompng($src)  : false,
            IMAGETYPE_GIF  => function_exists('imagecreatefromgif')  ? @imagecreatefromgif($src)  : false,
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($src) : false,
            default        => false,
        };
        if (!$im) {
            return false;
        }

        $w = imagesx($im);
        $h = imagesy($im);
        $max = CF_UPLOAD_MAX_EDGE;
        if (max($w, $h) > $max) {
            $scale = $max / max($w, $h);
            $nw = max(1, (int) round($w * $scale));
            $nh = max(1, (int) round($h * $scale));
            $resized = imagecreatetruecolor($nw, $nh);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $im, 0, 0, 0, 0, $nw, $nh, $w, $h);
            imagedestroy($im);
            $im = $resized;
        } else {
            imagealphablending($im, false);
            imagesavealpha($im, true);
        }

        $ok = @imagewebp($im, $dest, 82);
        imagedestroy($im);
        if ($ok) {
            @chmod($dest, 0644);
        }
        return (bool) $ok;
    }

    if (class_exists('Imagick')) {
        try {
            $im = new Imagick($src);
            $im->setImageFormat('webp');
            $im->setImageCompressionQuality(82);
            if (max($im->getImageWidth(), $im->getImageHeight()) > CF_UPLOAD_MAX_EDGE) {
                $im->resizeImage(CF_UPLOAD_MAX_EDGE, CF_UPLOAD_MAX_EDGE, Imagick::FILTER_LANCZOS, 1, true);
            }
            $ok = $im->writeImage($dest);
            $im->clear();
            if ($ok) {
                @chmod($dest, 0644);
            }
            return (bool) $ok;
        } catch (Throwable $e) {
            error_log('[Comfort Foundation] Imagick WebP conversion failed: ' . $e->getMessage());
        }
    }

    return false;
}

/** Remove an uploaded file (only inside uploads/). */
function delete_upload(?string $path): void
{
    $path = ltrim((string) $path, '/');
    if ($path === '' || !str_starts_with($path, 'uploads/')) {
        return;
    }
    $full = realpath(CF_ROOT . '/' . $path);
    $base = realpath(CF_ROOT . '/uploads');
    if ($full && $base && str_starts_with($full, $base) && is_file($full)) {
        @unlink($full);
    }
}
