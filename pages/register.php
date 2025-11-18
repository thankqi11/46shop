<?php
require_once __DIR__ . '/../includes/config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($conn->real_escape_string($_POST['username']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = trim($conn->real_escape_string($_POST['phone']));

    if ($password !== $confirm_password) {
        $message = "Lỗi: Mật khẩu xác nhận không khớp.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (username, password, phone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $phone);

        if ($stmt->execute()) {
            $message = "Đăng ký thành công! Đang chuyển hướng...";
            header("refresh:2; url=login.php");
            exit(); 
        } else {
            
            $message = "Lỗi Đăng ký: Tên đăng ký đã tồn tại hoặc lỗi khác.";
        }
        $stmt->close();
    }
}

include '../includes/header.php';
?>

<main class="register-page-content">
  <?php if ($message): ?>
    <div class="message-box error"><?php echo htmlspecialchars($message); ?></div>
  <?php endif; ?>

  <h1>Đăng Ký Tài Khoản</h1>
  <form id="register-form" method="POST" action="register.php">
    <div class="input-row">
      <label class="input-label">Tên đăng ký</label>
      <input type="text" name="username" required class="login-input" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" />
    </div>
    <div class="input-row">
      <label class="input-label">Mật khẩu</label>
      <input type="password" name="password" required class="login-input" />
    </div>
    <div class="input-row">
      <label class="input-label">Xác nhận mật khẩu</label>
      <input type="password" name="confirm_password" required class="login-input" />
    </div>
    <div class="input-row">
      <label class="input-label">Điện thoại</label>
      <input type="text" name="phone" required class="login-input" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" />
    </div>
    <button type="submit" class="btn-register">Đăng Ký</button>
  </form>
</main>

<?php 
include '../includes/footer.php'; 
?>