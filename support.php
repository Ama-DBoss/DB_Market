<?php
session_start();
require_once 'includes/db.con.php';
require_once 'includes/auth.php';
require_once 'includes/security.php';

// Check if user is logged in
if (!isAuthenticated()) {
    header('Location: login.php');
    exit();
}

// Check for session timeout
if (hasSessionTimedOut()) {
    logoutUser();
    header('Location: logins.php?timeout=1');
    exit();
}

$currentUser = $_SESSION['username'];
$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
        $errors[] = "Invalid form submission.";
    } else {
        $subject = sanitizeInput($_POST['subject'] ?? '');
        $message = sanitizeInput($_POST['message'] ?? '');

        if (empty($subject) || empty($message)) {
            $errors[] = "Subject and message are required.";
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO support_tickets (uname, subject, message, status, created_at) VALUES (?, ?, ?, 'open', NOW())");
                $stmt->execute([$currentUser, $subject, $message]);
                $successMessage = "Your support ticket has been submitted successfully.";
            } catch (PDOException $e) {
                logError("Support ticket submission error: " . $e->getMessage());
                $errors[] = "An error occurred while submitting your ticket. Please try again.";
            }
        }
    }
}

// Fetch user's support tickets
try {
    $stmt = $pdo->prepare("SELECT * FROM support_tickets WHERE uname = ? ORDER BY created_at DESC LIMIT 5");
    $stmt->execute([$currentUser]);
    $tickets = $stmt->fetchAll();
} catch (PDOException $e) {
    logError("Error fetching support tickets: " . $e->getMessage());
    $tickets = [];
}

$csrfToken = generateCsrfToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connect | Support</title>
    <meta name="description" content="Get support for your Connect account">
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

<?php include 'includes/nav.php'; ?>

<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
    <div class="w3-row">
        <div class="w3-col m3">
            <!-- Left Column -->
            <div class="w3-card w3-round w3-white">
                <div class="w3-container">
                    <h4 class="w3-center">Support Options</h4>
                    <p class="w3-center"><i class="fa fa-question-circle fa-4x"></i></p>
                    <hr>
                    <p><i class="fa fa-envelope fa-fw w3-margin-right w3-text-theme"></i> support@connect.com</p>
                    <p><i class="fa fa-phone fa-fw w3-margin-right w3-text-theme"></i> +1 (123) 456-7890</p>
                    <p><i class="fa fa-globe fa-fw w3-margin-right w3-text-theme"></i> <a href="https://connect.com/faq" target="_blank">FAQ</a></p>
                </div>
            </div>
            <br>
        </div>

        <div class="w3-col m9">
            <div class="w3-row-padding">
                <div class="w3-col m12">
                    <div class="w3-card w3-round w3-white">
                        <div class="w3-container w3-padding">
                            <h2 class="w3-text-theme">Submit a Support Ticket</h2>
                            
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
                                    <label><b>Subject</b></label>
                                    <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter subject" name="subject" required>
                                    
                                    <label><b>Message</b></label>
                                    <textarea class="w3-input w3-border w3-margin-bottom" placeholder="Enter your message" name="message" rows="4" required></textarea>
                                    
                                    <button class="w3-button w3-block w3-theme-l1 w3-section w3-padding" type="submit">Submit Ticket</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="w3-row-padding w3-margin-top">
                <div class="w3-col m12">
                    <div class="w3-card w3-round w3-white">
                        <div class="w3-container w3-padding">
                            <h3 class="w3-text-theme">Your Recent Tickets</h3>
                            <table class="w3-table w3-striped w3-bordered w3-hoverable">
                                <thead>
                                    <tr class="w3-theme">
                                        <th>Ticket ID</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($tickets)): ?>
                                        <tr>
                                            <td colspan="4" class="w3-center">No support tickets found.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($tickets as $ticket): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($ticket['id']); ?></td>
                                                <td><?php echo htmlspecialchars($ticket['subject']); ?></td>
                                                <td><?php echo htmlspecialchars(ucfirst($ticket['status'])); ?></td>
                                                <td><?php echo htmlspecialchars(date('M j, Y H:i', strtotime($ticket['created_at']))); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="js/w3.js"></script>
<script src="includes/sessionTimeout.js"></script>
</body>
</html>

