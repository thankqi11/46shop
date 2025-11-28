<?php
session_start();
require_once 'db_connect.php';

$error_message = "";
$username_old = ""; 

// Nếu đã đăng nhập rồi thì chuyển trang
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_key = trim($_POST['login_key']); 
    $password = $_POST['password'];
    $username_old = $login_key;

    if (empty($login_key) || empty($password)) {
        $error_message = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        $sql = "SELECT * FROM taikhoan WHERE TenDangNhap = ? OR SoDienThoai = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $login_key, $login_key);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['MatKhau'])) {
                if ($user['TrangThai'] == 0) {
                    $error_message = "Tài khoản của bạn đã bị khóa!";
                } else {
                    // --- ĐĂNG NHẬP THÀNH CÔNG ---
                    $_SESSION['user_id'] = $user['TenDangNhap'];
                    $_SESSION['role'] = $user['PhanQuyen'];
                    $_SESSION['name'] = $user['TenDangNhap'];
                    
                    if (!empty($user['MaKH'])) {
                        $_SESSION['ma_kh'] = $user['MaKH'];

                        // [QUAN TRỌNG] NẠP GIỎ HÀNG TỪ DATABASE VÀO SESSION
                        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

                        $sql_cart = "SELECT g.*, s.TenSP, s.Gia, s.HinhAnh 
                                     FROM giohang g 
                                     JOIN sanpham s ON g.MaSP = s.MaSP 
                                     WHERE g.MaKH = ?";
                        $stmt_cart = $conn->prepare($sql_cart);
                        $stmt_cart->bind_param("i", $user['MaKH']);
                        $stmt_cart->execute();
                        $res_cart = $stmt_cart->get_result();

                        while ($row = $res_cart->fetch_assoc()) {
                            $key = $row['MaSP'] . "_" . $row['Size'] . "_" . $row['Mau'];
                            $_SESSION['cart'][$key] = [
                                'maSP' => $row['MaSP'],
                                'tenSP' => $row['TenSP'],
                                'gia' => $row['Gia'],
                                'hinhAnh' => $row['HinhAnh'],
                                'size' => $row['Size'],
                                'mau' => $row['Mau'],
                                'soLuong' => $row['SoLuong']
                            ];
                        }
                        $stmt_cart->close();
                        // -------------------------------------------------
                    }

                    if ($user['PhanQuyen'] == 'admin') {
                        header("Location: admin_add_product.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit();
                }
            } else {
                $error_message = "Mật khẩu không chính xác!";
            }
        } else {
            $error_message = "Tài khoản không tồn tại!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; background-color: #333; }</style>
</head>
<body class="min-h-screen bg-stone-900 flex flex-col">
    <header class="bg-red-950 text-white shadow-lg p-6">
        <h1 class="text-3xl font-bold text-center">Đăng nhập hệ thống</h1>
    </header>

    <main class="flex flex-grow items-center justify-center p-4">
        <div class="w-full max-w-lg p-10 rounded-xl shadow-2xl bg-purple-100/70 border border-purple-200">
            <?php if (!empty($error_message)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <strong class="font-bold">Lỗi!</strong>
                    <span class="block sm:inline"><?php echo $error_message; ?></span>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-8">
                <div class="space-y-2">
                    <label class="block text-lg font-medium text-stone-700">Tên đăng nhập hoặc SĐT</label>
                    <input type="text" name="login_key" required value="<?php echo htmlspecialchars($username_old); ?>"
                           class="w-full p-4 bg-white/70 border border-stone-300 rounded-lg text-lg">
                </div>
                <div class="space-y-2">
                    <label class="block text-lg font-medium text-stone-700">Mật khẩu</label>
                    <input type="password" name="password" required class="w-full p-4 bg-white/70 border border-stone-300 rounded-lg text-lg">
                </div>
                <div class="pt-4 flex flex-col space-y-4">
                    <button type="submit" class="w-full py-4 px-6 text-xl font-bold text-white bg-red-800 hover:bg-red-700 rounded-lg shadow-lg">ĐĂNG NHẬP</button>
                    <div class="flex justify-between items-center text-stone-700 mt-4">
                        <span class="text-sm">Chưa có tài khoản? <a href="register.php" class="font-bold text-red-800 hover:underline text-lg ml-1">Đăng ký ngay</a></span>
                    </div>
                </div>
            </form>
        </div>
    </main>
</body>
</html>