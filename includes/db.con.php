<?php
/* $dbServer = 'localhost';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'crdb';

$DBconn = mysqli_connect($dbServer,$dbUser,$dbPassword,$dbName);

if (!$DBconn){
    die('Connection to database failed'.mysqli_connect_error());
} */

$db_host = 'localhost';
$db_name = 'crdb';
$db_user = 'root'; // Replace with your actual database username
$db_pass = ''; // Replace with your actual database password

// PDO connection options
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
];

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, $options);
} catch (PDOException $e) {
    // Log error and display generic message
    error_log("Database connection failed: " . $e->getMessage());
    die("Sorry, we're experiencing technical difficulties. Please try again later.");
}

// Legacy mysqli connection for backward compatibility
try {
    $DBconn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($DBconn->connect_error) {
        throw new Exception("Connection failed: " . $DBconn->connect_error);
    }
    $DBconn->set_charset("utf8mb4");
} catch (Exception $e) {
    error_log("MySQLi connection failed: " . $e->getMessage());
    die("Sorry, we're experiencing technical difficulties. Please try again later.");
}
?>