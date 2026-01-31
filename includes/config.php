<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DB_HOST', 'localhost');
define('DB_NAME', 'royal_dental');
define('DB_USER', 'root');
define('DB_PASS', '');

define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('UPLOAD_IMAGES', UPLOAD_DIR . 'images/');
define('UPLOAD_PDF', UPLOAD_DIR . 'pdf/');
define('UPLOAD_APPOINTMENTS', UPLOAD_DIR . 'appointments/');

define('MAX_IMAGE_SIZE', 5 * 1024 * 1024);
define('MAX_PDF_SIZE', 10 * 1024 * 1024);

define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp']);
define('ALLOWED_PDF_TYPES', ['application/pdf']);
define('ALLOWED_3D_TYPES', ['application/octet-stream', 'model/stl', 'application/sla', 'application/vnd.ms-pki.stl', 'application/x-navistyle']);
define('ALLOWED_DICOM_TYPES', ['application/dicom', 'application/x-dicom']);
define('ALLOWED_FILE_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'stl', 'obj', 'ply', 'dcm']);

define('SITE_NAME', 'Royal Dental');
define('SITE_URL', 'http://localhost');

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Contact.php';
require_once __DIR__ . '/Service.php';
require_once __DIR__ . '/GalleryItem.php';

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isAdmin()
{
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function requireAdmin()
{
    requireLogin();
    if (!isAdmin()) {
        header('Location: index.php');
        exit;
    }
}

function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function uploadFile($file, $destination, $allowedTypes, $maxSize, $allowedExtensions = null)
{
    if (!isset($file['error']) || is_array($file['error'])) {
        return ['success' => false, 'message' => 'Invalid file upload'];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload'
        ];
        $errorMsg = isset($errorMessages[$file['error']]) ? $errorMessages[$file['error']] : 'File upload error';
        return ['success' => false, 'message' => $errorMsg];
    }

    if ($file['size'] > $maxSize) {
        return ['success' => false, 'message' => 'File too large. Maximum size: ' . ($maxSize / 1024 / 1024) . 'MB'];
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if ($allowedExtensions !== null && !in_array($extension, $allowedExtensions)) {
        return ['success' => false, 'message' => 'Invalid file extension. Allowed: ' . implode(', ', $allowedExtensions)];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    $is3dOrSpecial = in_array($extension, ['stl', 'obj', 'ply', 'dcm']);
    $mimeAllowed = $is3dOrSpecial || in_array($mimeType, $allowedTypes);
    if (!$mimeAllowed) {
        return ['success' => false, 'message' => 'Invalid file type: ' . $mimeType];
    }

    if (!is_dir($destination)) {
        if (!mkdir($destination, 0755, true)) {
            return ['success' => false, 'message' => 'Failed to create upload directory'];
        }
    }

    $filename = uniqid() . '_' . time() . '.' . $extension;
    $filepath = $destination . $filename;

    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        return ['success' => false, 'message' => 'Failed to move uploaded file'];
    }

    return ['success' => true, 'filename' => $filename, 'filepath' => $filepath];
}