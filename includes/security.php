<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate CSRF token
 * @return string CSRF token
 */
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 * @param string $token Token to validate
 * @return bool True if token is valid, false otherwise
 */
function validateCsrfToken($token) {
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Sanitize user input
 * @param string $input Input to sanitize
 * @return string Sanitized input
 */
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Log error message
 * @param string $message Error message
 */
function logError($message) {
    error_log("[" . date('Y-m-d H:i:s') . "] " . $message);
}

/**
 * Validate email address
 * @param string $email Email to validate
 * @return bool True if email is valid, false otherwise
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number
 * @param string $phone Phone number to validate
 * @return bool True if phone number is valid, false otherwise
 */
function isValidPhone($phone) {
    // Basic validation - customize based on your requirements
    return preg_match('/^[0-9]{10,15}$/', $phone) === 1;
}

/**
 * Generate secure random token
 * @param int $length Token length
 * @return string Random token
 */
function generateSecureToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Hash password securely
 * @param string $password Password to hash
 * @return string Hashed password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
}

/**
 * Verify password against hash
 * @param string $password Password to verify
 * @param string $hash Hash to verify against
 * @return bool True if password matches hash, false otherwise
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Check if password needs rehash
 * @param string $hash Hash to check
 * @return bool True if password needs rehash, false otherwise
 */
function passwordNeedsRehash($hash) {
    return password_needs_rehash($hash, PASSWORD_DEFAULT, ['cost' => 12]);
}

/**
 * Encrypt sensitive data
 * @param string $data Data to encrypt
 * @param string $key Encryption key
 * @return string Encrypted data
 */
function encryptData($data, $key) {
    $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

/**
 * Decrypt sensitive data
 * @param string $data Data to decrypt
 * @param string $key Encryption key
 * @return string Decrypted data
 */
function decryptData($data, $key) {
    $data = base64_decode($data);
    $ivlen = openssl_cipher_iv_length($cipher = "AES-256-CBC");
    $iv = substr($data, 0, $ivlen);
    $encrypted = substr($data, $ivlen);
    return openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
}

/**
 * Validate file upload
 * @param array $file File data from $_FILES
 * @param array $allowedTypes Allowed MIME types
 * @param int $maxSize Maximum file size in bytes
 * @return array Result with status and message
 */
function validateFileUpload($file, $allowedTypes, $maxSize = 2097152) {
    $result = ['status' => false, 'message' => ''];
    
    // Check if file was uploaded
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        $result['message'] = 'File upload failed';
        return $result;
    }
    
    // Check file size
    if ($file['size'] > $maxSize) {
        $result['message'] = 'File is too large';
        return $result;
    }
    
    // Check file type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $fileType = $finfo->file($file['tmp_name']);
    
    if (!in_array($fileType, $allowedTypes)) {
        $result['message'] = 'Invalid file type';
        return $result;
    }
    
    $result['status'] = true;
    return $result;
}

/**
 * Generate secure filename for uploaded file
 * @param string $originalName Original filename
 * @return string Secure filename
 */
function generateSecureFilename($originalName) {
    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
    return bin2hex(random_bytes(16)) . '.' . $extension;
}
?>

