<?php
session_start();

// Hủy tất cả các biến phiên
$_SESSION = array();

// Nếu muốn xóa hoàn toàn phiên, cũng nên xóa cookie phiên.
// Lưu ý: Điều này sẽ làm mất phiên, chứ không phải chỉ dữ liệu phiên.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Cuối cùng, hủy phiên
session_destroy();

// Chuyển hướng người dùng về trang chủ (index.php)
header("Location: index.php");
exit();
?>