<?php
//session_start();
require 'includes/db.con.php';
require 'includes/functions.php';

// Initialize variables
$status = "";
$uploadFiles = [];
$postid = "";
$errors = [];
$successMessage = "";
$postuser = $_SESSION['username'] ?? ""; // Ensure the session variable is set

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["btnpost"])) {
    // Fetch the user's profile picture
    $ppquery = "SELECT user_pp FROM connect_users WHERE uname = ?";
    $stmt = $DBconn->prepare($ppquery);
    $stmt->bind_param('s', $postuser);
    $stmt->execute();
    $result = $stmt->get_result();

    $image = $result->num_rows > 0 ? htmlspecialchars($result->fetch_assoc()['user_pp']) : null;

    if (!$image) {
        $errors[] = "User profile picture not found.";
    }

    // Sanitize input
    $status = $DBconn->real_escape_string($_POST['status']);
    $new_num = rand(100, 999);
    $postid = $postuser . $new_num;
    $uploadDir = 'uploads/';
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'avif', 'webp', 'mov', 'mp3', 'wav', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'];
    $maxFileSize = 200 * 1024 * 1024; // 20MB

    // Create upload directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle file uploads
    if (!empty($_FILES['fileToUpload']['name'][0])) {
        $fileCount = count($_FILES['fileToUpload']['name']);

        if ($fileCount > 20) {
            $errors[] = "You can upload a maximum of 20 files at a time.";
        } else {
            for ($i = 0; $i < $fileCount; $i++) {
                $fileTmpPath = $_FILES['fileToUpload']['tmp_name'][$i];
                $fileName = basename($_FILES['fileToUpload']['name'][$i]);
                $fileSize = $_FILES['fileToUpload']['size'][$i];
                $fileError = $_FILES['fileToUpload']['error'][$i];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Check for upload errors
                if ($fileError !== UPLOAD_ERR_OK) {
                    $errors[] = "Error uploading file: $fileName.";
                    continue;
                }

                // Validate file type and size
                if (in_array($fileExtension, $allowedExtensions) && $fileSize <= $maxFileSize) {
                    $newFileName = uniqid($postid . '_') . '.' . $fileExtension;
                    $destination = $uploadDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destination)) {
                        $uploadFiles[] = $newFileName;
                    } else {
                        $errors[] = "Failed to upload file: $fileName.";
                    }
                } else {
                    $errors[] = "Invalid file: $fileName. Allowed extensions are " . implode(', ', $allowedExtensions) . " and size must not exceed 20MB.";
                }
            }
        }
    }

    // Insert post into the database
    if (empty($errors)) {
        $imagesJson = !empty($uploadFiles) ? json_encode($uploadFiles) : null;
        $query = "INSERT INTO posts (uname, u_pp, user_post, post_img, postid) VALUES (?, ?, ?, ?, ?)";
        $stmt = $DBconn->prepare($query);
        $stmt->bind_param('sssss', $postuser, $image, $status, $imagesJson, $postid);

        if ($stmt->execute()) {
            $successMessage = "Status updated successfully.";
            header('Location: mypage.php');
            exit();
        } else {
            $errors[] = "Database insertion failed: " . $stmt->error;
        }
    }
}

// Display errors or success messages
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p class='w3-text-red'>$error</p>";
    }
}
if (!empty($successMessage)) {
    echo "<p class='w3-text-green'>$successMessage</p>";
}
		?>