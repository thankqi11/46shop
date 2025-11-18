<?php
// config.php
$servername = "localhost";
$db_username = "root"; 
$db_password = "";     
$dbname = "shop_db";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

session_start();
?>