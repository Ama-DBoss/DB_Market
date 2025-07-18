<?php
session_start();
require_once 'includes/db.con.php';
require_once 'includes/auth.php';
require_once 'includes/security.php';

$errors = [];
$successMessage = '';

if (isAuthenticated()) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = "Invalid form submission.";
    } else {
        $email = sanitizeInput($_POST['email'] ?? '');

        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        } else {
            try {
                $stmt = $pdo->prepare("SELECT * FROM connect_users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user) {
                    // Generate password reset token
                    $token = bin2hex(random_bytes(32));
                    $tokenExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

                    $stmt = $pdo->prepare("UPDATE connect_users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
                    $stmt->execute([$token, $tokenExpiry, $email]);

                    // Send password reset email
                    $resetLink = "https://connect.com/reset_password.php?token=" . $token;
                    $to = $email;
                    $subject = "Password Reset Request";
                    $message = "Hello,\n\nYou have requested to reset your password. Click the link below to reset your password:\n\n$resetLink\n\nIf you did not request this, please ignore this email.\n\nBest regards,\nConnect Team";
                    $headers = "From: noreply@connect.com";

                    if (mail($to, $subject, $message, $headers)) {
                        $successMessage = "Password reset instructions have been sent to your email.";
                    } else {
                        $errors[] = "Failed to send password reset email. Please try again later.";
                    }
                } else {
                    // To prevent email enumeration, we'll show the same message as if the email was sent
                    $successMessage = "If your email is registered, you will receive password reset instructions shortly.";
                }
            } catch (PDOException $e) {
                logError("Password reset error: " . $e->getMessage());
                $errors[] = "An error occurred. Please try again later.";
            }
        }
    }
}

$csrfToken = generateCsrfToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connect | Forgot Password</title>
    <meta name="description" content="Reset your Connect account password">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/w3-theme-blue-grey.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
		.bgimg {
  background-image: url('images/forestbridge.jpg');
  min-height: 100%;
  background-position: center;
  background-size: cover;
}
    </style>
</head>
<body class="w3-theme-l5">

<?php
  include 'includes/pubnav.php';
  ?>

<div  class="bgimg w3-display-container w3-animate-opacity w3-text-white w3-animate-zoom">
        <div class="w3-col m3 w3-hide-small">&nbsp;</div>
    <div class="w3-row">
        <div class="w3-col m3 w3-hide-small">&nbsp;</div>
        <div class="w3-col m6">
            <div style="margin-top:80px; margin-bottom:80px" class="w3-card w3-round w3-white">
                <div class="w3-container w3-padding">
                    <h2 class="w3-center">Forgot Password</h2>
                    
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

                    <form method="POST" action="" class="w3-container">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                        
                        <div class="w3-section">
                            <label><b>Email</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Enter your email" name="email" required>
                            
                            <button class="w3-button w3-block w3-theme-d2 w3-section w3-padding" type="submit">Reset Password</button>
                        </div>
                    </form>
                    
                    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                        <span class="w3-left w3-padding w3-text-red"><a href="login.php"><i class="fa fa-caret-left"></i> Back to Login</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="w3-col m3 w3-hide-small">&nbsp;</div>
    </div>
        <div class="w3-col m3 w3-hide-small">&nbsp;</div>
</div>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

<script>
// Script to open and close sidebar
function openNav() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>

<script src="js/w3.js"></script>
</body>
</html>