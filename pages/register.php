<?php
session_start();
require_once 'db_connect.php';

$error_message = "";
$success_message = "";

// Khởi tạo biến để lưu lại dữ liệu cũ (mặc định là rỗng)
$username_old = "";
$phone_old = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = trim($_POST['phone']);

    // GIỮ LẠI DỮ LIỆU CŨ: Gán giá trị vừa nhập vào biến để hiển thị lại
    $username_old = $username;
    $phone_old = $phone;

    // 1. Validate cơ bản
    if (empty($username) || empty($password) || empty($phone)) {
        $error_message = "Vui lòng nhập đầy đủ thông tin!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Mật khẩu xác nhận không khớp!";
    } else {
        // 2. Kiểm tra trùng lặp
        $sql_check = "SELECT TenDangNhap FROM taikhoan WHERE TenDangNhap = ? OR SoDienThoai = ?";
        $stmt = $conn->prepare($sql_check);
        $stmt->bind_param("ss", $username, $phone);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Tên đăng nhập hoặc Số điện thoại đã được sử dụng!";
        } else {
            // 3. Xử lý đăng ký (Transaction)
            $conn->begin_transaction();
            try {
                // Bước A: Thêm khách hàng
                $sql_kh = "INSERT INTO khachhang (Ten, SDT) VALUES (?, ?)";
                $stmt_kh = $conn->prepare($sql_kh);
                $stmt_kh->bind_param("ss", $username, $phone);
                $stmt_kh->execute();
                
                $new_MaKH = $conn->insert_id;

                // Bước B: Thêm tài khoản
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql_tk = "INSERT INTO taikhoan (TenDangNhap, MatKhau, SoDienThoai, MaKH, PhanQuyen, TrangThai) VALUES (?, ?, ?, ?, 'user', 1)";
                $stmt_tk = $conn->prepare($sql_tk);
                $stmt_tk->bind_param("sssi", $username, $hashed_password, $phone, $new_MaKH);
                $stmt_tk->execute();

                $conn->commit();
                
                $success_message = "Đăng ký thành công! Đang chuyển hướng...";
                // Reset lại các biến old để form trắng tinh (vì đã thành công)
                $username_old = "";
                $phone_old = "";
                
                header("refresh:2;url=login.php");
            } catch (Exception $e) {
                $conn->rollback();
                $error_message = "Lỗi hệ thống: " . $e->getMessage();
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Tài Khoản</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #333; }
    </style>
</head>
<body class="min-h-screen bg-stone-900 flex flex-col">
    <header class="bg-red-950 text-white shadow-lg p-6">
        <h1 class="text-3xl font-bold text-center">Đăng ký tài khoản</h1>
    </header>

    <main class="flex flex-grow items-center justify-center p-4">
        <div class="w-full max-w-lg p-10 rounded-xl shadow-2xl bg-purple-100/70 border border-purple-200">
            
            <?php if (!empty($error_message)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Lỗi!</strong>
                    <span><?php echo $error_message; ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Thành công!</strong>
                    <span><?php echo $success_message; ?></span>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6">
                
                <div class="flex items-center space-x-4">
                    <label for="reg-name" class="w-1/3 text-lg font-medium text-stone-700">Tên đăng ký</label>
                    <input type="text" id="reg-name" name="username" required 
                           value="<?php echo htmlspecialchars($username_old); ?>"
                           placeholder="Nhập tên đăng ký"
                           class="w-2/3 p-3 bg-white/70 border-none rounded-lg focus:ring-red-600 focus:border-red-600 text-lg placeholder-stone-600">
                </div>

                <div class="flex items-center space-x-4">
                    <label for="password" class="w-1/3 text-lg font-medium text-stone-700">Mật khẩu</label>
                    <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu"
                           class="w-2/3 p-3 bg-white/70 border-none rounded-lg focus:ring-red-600 focus:border-red-600 text-lg placeholder-stone-600">
                </div>

                <div class="flex items-center space-x-4">
                    <label for="confirm-password" class="w-1/3 text-lg font-medium text-stone-700">Xác nhận MK</label>
                    <input type="password" id="confirm-password" name="confirm_password" required placeholder="Nhập lại mật khẩu"
                           class="w-2/3 p-3 bg-white/70 border-none rounded-lg focus:ring-red-600 focus:border-red-600 text-lg placeholder-stone-600">
                </div>

                <div class="flex items-center space-x-4">
                    <label for="phone" class="w-1/3 text-lg font-medium text-stone-700">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" required 
                           value="<?php echo htmlspecialchars($phone_old); ?>"
                           placeholder="Nhập số điện thoại"
                           class="w-2/3 p-3 bg-white/70 border-none rounded-lg focus:ring-red-600 focus:border-red-600 text-lg placeholder-stone-600">
                </div>

                <div class="flex justify-between items-center pt-8">
                    <a href="login.php" class="text-stone-700 hover:text-red-700 text-lg font-medium underline">
                        Quay lại đăng nhập
                    </a>
                    
                    <button type="submit" 
                            class="text-lg font-semibold text-white bg-red-800 hover:bg-red-700 py-3 px-8 rounded-full shadow-xl transition duration-200">
                        Đăng ký
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>