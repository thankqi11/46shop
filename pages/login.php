<?php

require_once __DIR__ . '/../includes/config.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = $conn->real_escape_string($_POST['username_or_email']);
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? OR email = ?"); 
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $message = "Đăng nhập thành công! Đang chuyển hướng...";
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = true;
            header("refresh:2; url=index.php");
            exit(); 
        } else {
            $message = "Lỗi: Mật khẩu không chính xác.";
        }
    } else {
        $message = "Lỗi: Tên đăng nhập không tồn tại.";
    }
    $stmt->close();
}

include '../includes/header.php'; 
?>

<main class="login-page-content">
  <?php if ($message): ?>
    <div class="message-box success"><?php echo htmlspecialchars($message); ?></div>
  <?php endif; ?>

  <h1>Đăng Nhập</h1>
  <form id="login-form" method="POST" action="login.php">
    <div class="input-field">
      <input type="text" name="username_or_email" placeholder="Tên đăng nhập / Email" class="login-input" required />
    </div>
    <div class="input-field">
      <input type="password" name="password" placeholder="Mật khẩu" class="login-input" required />
    </div>
    <button type="submit" class="btn-login">Đăng Nhập</button>
  </form>
</main>

<?php 
include '../includes/footer.php'; 
?>