<?php
// config.php
$servername = "localhost";
$db_username = "root"; // Thay bằng username của bạn
$db_password = "";     // Thay bằng password của bạn
$dbname = "shop_db";

// Tạo kết nối
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
// Thiết lập mã hóa UTF-8
$conn->set_charset("utf8mb4");

// Bắt đầu session để quản lý trạng thái đăng nhập
session_start();
?>