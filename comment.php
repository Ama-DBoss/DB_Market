<?php
session_start();
include 'includes/db.con.php';

if (isset($_POST['postid']) && isset($_POST['comment'])) {
    $postid = $_POST['postid'];
    $comment = mysqli_real_escape_string($DBconn, $_POST['comment']);
    $username = $_SESSION['username'];

    // Insert comment into database
    $commentSql = "INSERT INTO comments (postid, username, comment) VALUES ('$postid', '$username', '$comment')";
    if ($DBconn->query($commentSql) === TRUE) {
        header('Location: mypage.php');
    } else {
        echo 'Error: ' . $DBconn->error;
    }
} else {
    echo 'Invalid request';
}

$DBconn->close();
?>