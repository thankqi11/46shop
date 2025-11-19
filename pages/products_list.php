<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #333; }
        .product-item { background-color: #e0e0e0; }
        .qty-input {
            width: 40px; 
            text-align: center;
            border: 1px solid #ccc;
            height: 30px;
            font-size: 14px;
        }
        .qty-btn {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            user-select: none;
            transition: background-color 0.15s;
        }
        .qty-btn:hover { background-color: #ddd; }
        
        /* Bố cục chính tương tự trang index.php */
        .main-grid {
            grid-template-columns: 180px 1fr;
        }
        @media (max-width: 768px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-stone-900">

    <!-- Top Header (Dark Red/Brown) -->
    <header class="bg-red-950 p-4 shadow-xl">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            
            <!-- Logo/Placeholder -->
            <div class="flex items-center space-x-4">
                <a href="index.php" class="w-16 h-16 bg-red-700 rounded-full border-2 border-red-500">
                    <!-- Logo Placeholder -->
                </a>
            </div>

            <!-- Search Bar -->
            <div class="flex-grow max-w-xl mx-4 w-full md:w-auto">
                <div class="flex rounded-lg overflow-hidden shadow-inner bg-gray-300">
                    <input type="text" placeholder="Tìm kiếm sản phẩm" 
                           class="w-full p-3 text-lg bg-transparent focus:outline-none placeholder-gray-600 text-stone-900">
                    <button class="bg-stone-900 text-white p-3 px-6 hover:bg-stone-700 transition duration-150">
                        <!-- Icon Placeholder -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                    <div class="w-10 bg-white border-l border-gray-400"></div>
                </div>
            </div>

            <!-- Auth Links -->
            <div class="flex space-x-2">
                <a href="register.php" class="text-white font-semibold hover:text-red-300 p-2 text-sm border border-white/20 rounded-lg transition duration-200">
                    Đăng ký
                </a>
                <a href="login.php" class="text-white font-semibold hover:text-red-300 p-2 text-sm border border-white/20 rounded-lg transition duration-200">
                    Đăng nhập
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto grid main-grid gap-4 p-4">
        
        <!-- Left Sidebar (Navigation) -->
        <aside class="space-y-4 bg-red-950/90 p-4 rounded-xl md:p-0 md:bg-transparent">
            <!-- Navigation Items -->
            <nav class="space-y-3">
                <a href="#" class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Giày</a>
                <a href="#" class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Quần</a>
                <a href="#" class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Áo</a>
                <a href="#" class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Mũ</a>
                <a href="#" class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Phụ kiện</a>
            </nav>
            
            <!-- Contact Info -->
            <div class="pt-6 text-white text-sm">
                <p class="font-bold">Thông tin liên lạc</p>
                <p>0522 222 333</p>
            </div>
        </aside>

        <!-- Product Listing Area -->
        <main class="bg-gray-200 p-6 rounded-xl shadow-inner space-y-4">
            
            <!-- Product Item A -->
            <div class="product-item p-4 rounded-lg flex flex-col md:flex-row justify-between items-center shadow-md">
                <div class="w-full md:w-1/3 space-y-1">
                    <p class="text-lg font-bold">Sản phẩm A</p>
                    <p class="text-sm font-medium">Giá tiền: 500.000 VNĐ</p>
                </div>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <p class="text-sm">Số lượng:</p>
                    <div class="flex border rounded-lg overflow-hidden">
                        <button class="qty-btn text-red-600">-</button>
                        <input type="text" value="1" class="qty-input focus:outline-none">
                        <button class="qty-btn text-green-600">+</button>
                    </div>
                </div>
            </div>

            <!-- Product Item B -->
            <div class="product-item p-4 rounded-lg flex flex-col md:flex-row justify-between items-center shadow-md">
                <div class="w-full md:w-1/3 space-y-1">
                    <p class="text-lg font-bold">Sản phẩm B</p>
                    <p class="text-sm font-medium">Giá tiền: 850.000 VNĐ</p>
                </div>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <p class="text-sm">Số lượng:</p>
                    <div class="flex border rounded-lg overflow-hidden">
                        <button class="qty-btn text-red-600">-</button>
                        <input type="text" value="1" class="qty-input focus:outline-none">
                        <button class="qty-btn text-green-600">+</button>
                    </div>
                </div>
            </div>
            
            <!-- Product Item C -->
            <div class="product-item p-4 rounded-lg flex flex-col md:flex-row justify-between items-center shadow-md">
                <div class="w-full md:w-1/3 space-y-1">
                    <p class="text-lg font-bold">Sản phẩm C</p>
                    <p class="text-sm font-medium">Giá tiền: 1.200.000 VNĐ</p>
                </div>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <p class="text-sm">Số lượng:</p>
                    <div class="flex border rounded-lg overflow-hidden">
                        <button class="qty-btn text-red-600">-</button>
                        <input type="text" value="1" class="qty-input focus:outline-none">
                        <button class="qty-btn text-green-600">+</button>
                    </div>
                </div>
            </div>

            <!-- Total and Checkout Button -->
            <div class="bg-red-800 text-white p-4 rounded-lg mt-8 flex justify-between items-center shadow-xl">
                <p class="text-xl font-bold">Tổng số tiền phải thanh toán:</p>
                <!-- Liên kết đến trang thanh toán -->
                <a href="checkout.php" class="bg-white text-red-800 font-bold py-3 px-8 rounded-full shadow-lg hover:bg-gray-100 transition duration-200">
                    Thanh toán
                </a>
            </div>
        </main>
    </div>
</body>
</html>
<?php
// Logic PHP cho trang danh sách sản phẩm/giỏ hàng.
// Ví dụ: tính tổng tiền, cập nhật số lượng.
?>