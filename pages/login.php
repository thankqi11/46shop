<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Shop Bán Đồ Thể Thao</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Sử dụng font Inter cho thẩm mỹ chung */
        body { font-family: 'Inter', sans-serif; background-color: #333; }
    </style>
</head>
<body class="min-h-screen bg-stone-900 flex flex-col">
    <!-- Header/Title Bar (Dark Brown/Black) -->
    <header class="bg-red-950 text-white shadow-lg p-5">
        
        <h1 class="text-3xl font-bold text-center">Shop Bán Đồ Thể Thao</h1>
    </header>

    <!-- Login Form Area (Centered) -->
    <main class="flex flex-grow items-center justify-center p-4">
        <div class="w-full max-w-sm p-8 rounded-xl shadow-2xl bg-purple-100/70 border border-purple-200">
            <h2 class="text-3xl font-extrabold text-stone-900 mb-6 text-center">Login</h2>

            <!-- Form: Trỏ đến chính nó (hoặc file xử lý) để kiểm tra đăng nhập -->
            <form action="login.php" method="POST" class="space-y-6">
                <!-- Username/Email Field -->
                <input type="text" name="username" placeholder="Tên đăng nhập hoặc Email" required 
                       class="w-full p-3 bg-white/70 border-none rounded-lg focus:ring-red-600 focus:border-red-600 text-lg placeholder-stone-600">
                
                <!-- Password Field -->
                <input type="password" name="password" placeholder="Mật khẩu" required 
                       class="w-full p-3 bg-white/70 border-none rounded-lg focus:ring-red-600 focus:border-red-600 text-lg placeholder-stone-600">
                
                <!-- Buttons/Links Container -->
                <div class="flex justify-between items-center pt-4">
                    <!-- Login Button -->
                    <button type="submit" 
                            class="text-lg font-semibold text-white bg-red-800 hover:bg-red-700 py-2 px-6 rounded-full shadow-md transition duration-200">
                        đăng nhập
                    </button>
                    
                    <!-- Forgot Password Link -->
                    <a href="#" class="text-stone-700 hover:text-red-700 text-lg underline">
                        quên mật khẩu
                    </a>
                </div>
            </form>

            <!-- Link to Register -->
            <div class="mt-8 text-center">
                <p class="text-stone-700">Chưa có tài khoản? 
                    <a href="register.php" class="text-red-700 font-semibold hover:text-red-900 underline">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </main>
</body>
</html>
<?php
// BẮT ĐẦU PHIÊN (SESSION)
session_start();

// PHẦN XỬ LÝ ĐĂNG NHẬP GIẢ ĐỊNH
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // --- Giả định Đăng nhập thành công (Trong dự án thực tế, bạn sẽ kiểm tra DB ở đây) ---
    if ($username && $password) {
        // Đặt biến session để đánh dấu người dùng đã đăng nhập
        $_SESSION['user_id'] = 'user_123';
        $_SESSION['username'] = $username; 

        // Chuyển hướng về trang chủ
        header("Location: index.php");
        exit();
    } else {
        // Hiển thị thông báo lỗi nếu cần
        // echo "<p style='color: red; text-align: center;'>Tên đăng nhập hoặc mật khẩu không đúng.</p>";
    }
}
?>