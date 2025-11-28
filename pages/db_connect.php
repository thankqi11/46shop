<?php
// Thông tin kết nối CSDL (Cấu hình phpMyAdmin/MySQL của bạn)
$servername = "localhost"; // Địa chỉ máy chủ CSDL (thường là localhost)
$username = "root";       // Tên người dùng CSDL (mặc định của XAMPP/WAMP là root)
$password = "";           // Mật khẩu CSDL (mặc định của XAMPP/WAMP là rỗng)
$dbname = "46shop_db"; // Thay bằng tên CSDL bạn đã tạo

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    // Nếu kết nối thất bại, hiển thị lỗi và dừng chương trình
    die("Kết nối CSDL thất bại: " . $conn->connect_error);
}

// Thiết lập mã hóa ký tự UTF-8 để hiển thị tiếng Việt
$conn->set_charset("utf8mb4"); 
// echo "Kết nối CSDL thành công"; 

// KHÔNG CẦN THẺ ĐÓNG ?>