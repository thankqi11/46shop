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
    <!-- Header/Title Bar (Dark Brown/Black) -->
    <header class="bg-red-950 text-white shadow-lg p-6">
        <h1 class="text-3xl font-bold text-center">Đăng ký tài khoản</h1>
    </header>

    <!-- Registration Form Area (Centered) -->
    <main class="flex flex-grow items-center justify-center p-4">
        <div class="w-full max-w-lg p-10 rounded-xl shadow-2xl bg-purple-100/70 border border-purple-200">

            <!-- Form -->
            <form action="login.php" method="POST" class="space-y-6">
                <!-- Input Group: Tên đăng ký -->
                <div class="flex items-center space-x-4">
                    <label for="reg-name" class="w-1/3 text-lg font-medium text-stone-700">Tên đăng ký</label>
                    <input type="text" id="reg-name" required placeholder="Nhập tên đăng ký"
                           class="w-2/3 p-3 bg-white/70 border-none rounded-lg focus:ring-red-600 focus:border-red-600 text-lg placeholder-stone-600">
                </div>

                <!-- Input Group: Mật khẩu -->
                <div class="flex items-center space-x-4">
                    <label for="password" class="w-1/3 text-lg font-medium text-stone-700">Mật khẩu</label>
                    <input type="password" id="password" required placeholder="Nhập mật khẩu"
                           class="w-2/3 p-3 bg-white/70 border-none rounded-lg focus:ring-red-600 focus:border-red-600 text-lg placeholder-stone-600">
                </div>

                <!-- Input Group: Xác nhận mật khẩu -->
                <div class="flex items-center space-x-4">
                    <label for="confirm-password" class="w-1/3 text-lg font-medium text-stone-700">Xác nhận mật khẩu</label>
                    <input type="password" id="confirm-password" required placeholder="Nhập lại mật khẩu"
                           class="w-2/3 p-3 bg-white/70 border-none rounded-lg focus:ring-red-600 focus:border-red-600 text-lg placeholder-stone-600">
                </div>

                <!-- Input Group: Số điện thoại -->
                <div class="flex items-center space-x-4">
                    <label for="phone" class="w-1/3 text-lg font-medium text-stone-700">Số điện thoại</label>
                    <input type="tel" id="phone" required placeholder="Nhập số điện thoại"
                           class="w-2/3 p-3 bg-white/70 border-none rounded-lg focus:ring-red-600 focus:border-red-600 text-lg placeholder-stone-600">
                </div>

                <!-- Buttons/Links Container -->
                <div class="flex justify-between items-center pt-8">
                    <!-- Back to Login Link -->
                    <a href="login.php" class="text-stone-700 hover:text-red-700 text-lg font-medium underline">
                        Quay lại đăng nhập
                    </a>
                    
                    <!-- Register Button -->
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
<?php
// Đây là nơi bạn có thể thêm logic xử lý PHP cho việc đăng ký tài khoản (ví dụ: lưu vào cơ sở dữ liệu)
// echo "Logic PHP sẽ được đặt ở đây.";
?>