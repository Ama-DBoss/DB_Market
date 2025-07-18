<?php
// logout.php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page
header("Location: codegen.php");
exit();

if (isset($_GET['logout'])) {
	session_start();
	$_SESSION =[];
  session_destroy();
  setcookie(session_name(), '', time() -3600, '/'); //Expire the session cookie
  unset($_SESSION['username']);
  header("location: codegen.php");
  exit();
}
?>