<?php
$databaseHost = 'localhost';
$databaseUsername = 'root';
$databasePassword = '';
$databaseName = 'polumpong';

if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/PROJECT/');
}
if (!defined('ADMIN_BASE_URL')) {
    define('ADMIN_BASE_URL', 'http://localhost/PROJECT/admin/');
}
if (!defined('ADMIN_BASE_PATH')) {
    define('ADMIN_BASE_PATH', '/admin');
}

$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
// echo "DB Connection Successful." . "<br>";
?>
