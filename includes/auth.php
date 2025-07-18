<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is authenticated
 * @return bool True if user is authenticated, false otherwise
 */
function isAuthenticated() {
    return isset($_SESSION['username']) && !empty($_SESSION['username']);
}

/**
 * Authenticate user with username and password
 * @param string $username Username
 * @param string $password Plain text password
 * @return bool True if authentication successful, false otherwise
 */
function authenticateUser($username, $password) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM connect_users WHERE uname = :username LIMIT 1");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch();
        
        if ($user) {
            // Check if password is hashed with password_hash()
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['username'] = $user['uname'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['last_activity'] = time();
                
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                // Update last login timestamp
                $updateStmt = $pdo->prepare("UPDATE connect_users SET last_login = NOW() WHERE id = :id");
                $updateStmt->bindParam(':id', $user['id'], PDO::PARAM_INT);
                $updateStmt->execute();
                
                return true;
            }
            
            // Legacy password check (MD5) - migrate to secure hash if matched
            if ($user['password'] === md5($password)) {
                // Migrate to secure password hash
                $secureHash = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE connect_users SET password = :password WHERE id = :id");
                $updateStmt->bindParam(':password', $secureHash, PDO::PARAM_STR);
                $updateStmt->bindParam(':id', $user['id'], PDO::PARAM_INT);
                $updateStmt->execute();
                
                // Set session variables
                $_SESSION['username'] = $user['uname'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['last_activity'] = time();
                
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                return true;
            }
        }
        
        return false;
    } catch (PDOException $e) {
        error_log("Authentication error: " . $e->getMessage());
        return false;
    }
}

/**
 * Log out current user
 */
function logoutUser() {
    // Unset all session variables
    $_SESSION = [];
    
    // Delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
}

/**
 * Check if session has timed out
 * @param int $timeout Timeout in seconds (default: 30 minutes)
 * @return bool True if session has timed out, false otherwise
 */
function hasSessionTimedOut($timeout = 1800) {
    if (!isset($_SESSION['last_activity'])) {
        return true;
    }
    
    if (time() - $_SESSION['last_activity'] > $timeout) {
        return true;
    }
    
    // Update last activity time
    $_SESSION['last_activity'] = time();
    return false;
}

/**
 * Create notification for user
 * @param string $userId User ID to notify
 * @param string $type Notification type
 * @param string $message Notification message
 * @param string $fromUser User ID who triggered the notification
 * @return bool True if notification created, false otherwise
 */
function createNotification($userId, $type, $message, $fromUser = null) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO notifications (user_id, type, message, from_user, created_at) 
            VALUES (:user_id, :type, :message, :from_user, NOW())
        ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);
        $stmt->bindParam(':type', $type, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->bindParam(':from_user', $fromUser, PDO::PARAM_STR);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Notification creation error: " . $e->getMessage());
        return false;
    }
}
?>

