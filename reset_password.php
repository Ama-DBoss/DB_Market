<?php
session_start();
require_once 'includes/db.config.php';
require_once 'includes/auth.php';
require_once 'includes/security.php';

$errors = [];
$successMessage = '';

if (isAuthenticated()) {
    header('Location: dashboard.php');
    exit();
}

$token = $_GET['token'] ?? '';

if (empty($token)) {
    header('Location: login.php');
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM connect_users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        $errors[] = "Invalid or expired reset token.";
    }
} catch (PDOException $e) {
    logError("Token verification error: " . $e->getMessage());
    $errors[] = "An error occurred. Please try again later.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) {
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = "Invalid form submission.";
    } else {
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($password) || empty($confirmPassword)) {
            $errors[] = "Both password fields are required.";
        } elseif ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        } elseif (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        } else {
            try {
                $hashedPassword = hashPassword($password);
                $stmt = $pdo->prepare("UPDATE connect_users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
                $stmt->execute([$hashedPassword, $user['id']]);

                $successMessage = "Your password has been reset successfully. You can now login with your new password.";
            } catch (PDOException $e) {
                logError("Password reset error: " . $e->getMessage());
                $errors[] = "An error occurred while resetting your password. Please try again.";
            }
        }
    }
}

$csrfToken = generateCsrfToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connect | Reset Password</title>
    <meta name="description" content="Reset your Connect account password">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/w3-theme-blue-grey.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
    </style>
</head>
<body class="w3-theme-l5">

<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
    <div class="w3-row">
        <div class="w3-col m3 w3-hide-small">&nbsp;</div>
        <div class="w3-col m6">
            <div class="w3-card w3-round w3-white">
                <div class="w3-container w3-padding">
                    <h2 class="w3-center">Reset Password</h2>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="w3-panel w3-red w3-display-container">
                            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
                            <h3>Error!</h3>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ($successMessage): ?>
                        <div class="w3-panel w3-green w3-display-container">
                            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">&times;</span>
                            <h3>Success!</h3>
                            <p><?php echo htmlspecialchars($successMessage); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (empty($errors) && empty($successMessage)): ?>
                        <form method="POST" action="" class="w3-container">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                            
                            <div class="w3-section">
                                <label><b>New Password</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Enter new password" name="password" required>
                                
                                <label><b>Confirm New Password</b></label>
                                <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Confirm new password" name="confirm_password" required>
                                
                                <button class="w3-button w3-block w3-theme-l1 w3-section w3-padding" type="submit">Reset Password</button>
                            </div>
                        </form>
                    <?php endif; ?>
                    
                    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                        <span class="w3-left w3-padding"><a href="login.php">Back to Login</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w3-col m3 w3-hide-small">&nbsp;</div>
    </div>
</div>

<script src="js/w3.js"></script>
</body>
</html>

