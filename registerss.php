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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = "Invalid form submission.";
    } else {
        $username = sanitizeInput($_POST['username'] ?? '');
        $email = sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $firstName = sanitizeInput($_POST['first_name'] ?? '');
        $lastName = sanitizeInput($_POST['last_name'] ?? '');
        $referredBy = sanitizeInput($_POST['referred_by'] ?? '');

        // Validate inputs
        if (empty($username) || empty($email) || empty($password) || empty($confirmPassword) || empty($firstName) || empty($lastName)) {
            $errors[] = "All fields are required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        } elseif ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        } elseif (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        } else {
            try {
                // Check if username or email already exists
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM connect_users WHERE uname = ? OR email = ?");
                $stmt->execute([$username, $email]);
                if ($stmt->fetchColumn() > 0) {
                    $errors[] = "Username or email already exists.";
                } else {
                    // Generate unique referral link
                    $referralLink = generateUniqueReferralLink($pdo);
                    
                    // Insert new user
                    $hashedPassword = hashPassword($password);
                    $stmt = $pdo->prepare("INSERT INTO connect_users (uname, email, password, fname, lname, user_ref_link, referredby, reg_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
                    $stmt->execute([$username, $email, $hashedPassword, $firstName, $lastName, $referralLink, $referredBy]);

                    $successMessage = "Registration successful! You can now login.";
                }
            } catch (PDOException $e) {
                logError("Registration error: " . $e->getMessage());
                $errors[] = "An error occurred during registration. Please try again.";
            }
        }
    }
}

function generateUniqueReferralLink($pdo) {
    do {
        $referralLink = bin2hex(random_bytes(8));
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM connect_users WHERE user_ref_link = ?");
        $stmt->execute([$referralLink]);
    } while ($stmt->fetchColumn() > 0);
    return $referralLink;
}

$csrfToken = generateCsrfToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connect | Register</title>
    <meta name="description" content="Register for a Connect account">
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

<!-- Navbar -->
<div class="w3-top">
    <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
        <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
        <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>Connect</a>
        <a href="index.php#about" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">About</a>
        <a href="index.php#features" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Features</a>
        <a href="index.php#contact" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Contact</a>
        <a href="login.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-right">Login</a>
        <a href="register.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white w3-right">Register</a>
    </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
    <a href="#about" class="w3-bar-item w3-button w3-padding-large">About</a>
    <a href="#features" class="w3-bar-item w3-button w3-padding-large">Features</a>
    <a href="#contact" class="w3-bar-item w3-button w3-padding-large">Contact</a>
    <a href="login.php" class="w3-bar-item w3-button w3-padding-large">Login</a>
    <a href="register.php" class="w3-bar-item w3-button w3-padding-large">Register</a>
</div>

<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
    <div class="w3-row">
        <div class="w3-col m3 w3-hide-small">&nbsp;</div>
        <div class="w3-col m6">
            <div class="w3-card w3-round w3-white">
                <div class="w3-container w3-padding">
                    <h2 class="w3-center">Register for Connect</h2>
                    
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
                            <label><b>Username</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="username" required>
                            
                            <label><b>Email</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="email" placeholder="Enter Email" name="email" required>
                            
                            <label><b>Password</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Enter Password" name="password" required>
                            
                            <label><b>Confirm Password</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Confirm Password" name="confirm_password" required>
                            
                            <label><b>First Name</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter First Name" name="first_name" required>
                            
                            <label><b>Last Name</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Last Name" name="last_name" required>
                            
                            <label><b>Referred By (optional)</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Referral Code" name="referred_by">
                            
                            <button class="w3-button w3-block w3-theme-l1 w3-section w3-padding" type="submit">Register</button>
                        </div>
                    </form>
                    
                    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                        <span class="w3-left w3-padding">Already have an account? <a href="login.php">Login</a></span>
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

