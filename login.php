<?php
//session_start();
//session_regenerate_id(true); //Regenerate session ID to prevent fixation attacks
//ini_set('session.cookie_httponly', 1); //Prevent Javascript access to session
//ini_set('session.cookie_secure', 1); //Ensure cookies are sent only over HTTPS
//ini_set('session.use_only_cookies', 1); //Enforce use of cookies instead of URL-based sessions

// Include necessary files for database connection and functions
require_once 'includes/db.con.php';
include 'includes/functions.php';

// Redirect logged-in users
if (isset($_SESSION['username'])) {
    header('Location: mypage.php');
    exit();
}

$usernameErr = $passwordErr = "";
$username = "";
$password = "";
$errors = array();
$successMessage = '';

// LOGIN USER
if (isset($_POST['login'])) {
    // Securely handle input data
    $username = mysqli_real_escape_string($DBconn, $_POST['username']);
    $password = mysqli_real_escape_string($DBconn, $_POST['psw']);

    // Validate input fields
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Proceed only if there are no validation errors
    if (count($errors) === 0) {
        // Prepare the query to fetch user data
        $query = "SELECT * FROM connect_users WHERE uname = ? AND active = '1'";
        $stmt = mysqli_prepare($DBconn, $query);
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);

        // Check if a user is found
        if (mysqli_num_rows($results) === 1) {
            $row = mysqli_fetch_assoc($results);

            // Verify the password
            if (password_verify($password, $row['user_pwd'])) {
                // Successful login
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $row['email'];
                $_SESSION['logged_in'] = true;

                // Redirect to user's page
                $_SESSION['success_message'] = "Login successful!";
                header('Location: mypage.php');
                exit();
            } else {
                // Incorrect password
                $_SESSION['error_message'] = "Wrong username/password combination.";
            }
        } else {
            // No active user found
            $_SESSION['error_message'] = "No active account found with the provided username.";
        }
        mysqli_stmt_close($stmt);
    } else {
        // Display validation errors
        $_SESSION['error_message'] = implode(' ', $errors);
    }
}

// RESET PASSWORD
if (isset($_POST['reset']) && $_POST['usrname'] && $_POST['pswd'] && $_POST['resetemail']) {
    $passwd = $_POST['pswd'];
    $remail = $_POST['resetemail'];

    // Database connection
    $DBconn = mysqli_connect('localhost', 'root', '', 'crdb');
    if (!$DBconn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepared statement to check user existence and password
    $query = $DBconn->prepare("SELECT email, user_pwd FROM connect_users WHERE email = ?");
    $query->bind_param("s", $remail);  // 's' denotes string type
    $query->execute();
    $result = $query->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($passwd, $row['user_pwd'])) {
            $email = $row['email'];
            $resetKey = md5(uniqid(rand(), true));  // Generate a unique reset key

            // Send reset email using PHPMailer
            require_once('phpmail/PHPMailerAutoload.php');
            $mail = new PHPMailer();
            $mail->CharSet = "utf-8";
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Username = "your_email_id@gmail.com";
            $mail->Password = "your_gmail_password";
            $mail->SMTPSecure = "ssl";
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->From = 'password_reset@connectresourcemedia.com';
            $mail->FromName = 'PASSWORD RESET';
            $mail->AddAddress($remail);  // Send to the reset email
            $mail->Subject = 'Reset Password';
            $mail->IsHTML(true);
            $mail->Body = 'Click on this link to reset your password: <a href="https://www.connectresourcemedia.com/reset.php?key=' . $email . '&reset=' . $resetKey . '">Reset Password</a>';

            if ($mail->Send()) {
                $_SESSION['success_message'] = "Please check your email to reset the password.";
            } else {
                $_SESSION['error_message'] = "Mail Error: " . $mail->ErrorInfo;
            }
        } else {
            $_SESSION['error_message'] = "Incorrect password entered.";
        }
    } else {
        $_SESSION['error_message'] = "No user found with the provided email address.";
    }

    $DBconn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connect | Login</title>
    <meta name="description" content="Login to your Connect account">
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
        <div style="margin-top:80px; margin-bottom:80px" class="w3-col m6">
            <div class="w3-card w3-round w3-white">
                <div class="w3-container w3-padding">
                    <h2 class="w3-center">Login to Connect</h2>
                    
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
                            
                            <label><b>Password</b></label>
                            <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="psw" required>
                            
                            <button class="w3-button w3-block w3-theme-d2 w3-section w3-padding" type="submit" name="login">Login</button>
                        </div>
                    </form>
                    
                    <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
                        <span class="w3-left w3-padding w3-text-blue">Don't have an account? <a href="register.php">Register</a></span>
                        <span class="w3-right w3-padding w3-text-green"><a href="forgot_password.php">Forgot password?</a></span>
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

