<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #333; }
        .product-image-box { background-color: #e0e0e0; }
        .size-option {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ccc;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.15s;
        }
        .size-option:hover, .size-option.selected {
            border-color: #b91c1c; /* Red-700 */
            background-color: #fee2e2; /* Red-100 */
        }
        .qty-input {
            width: 50px; 
            text-align: center;
            border: 1px solid #ccc;
            height: 35px;
            font-size: 16px;
        }
        .qty-btn {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            user-select: none;
            font-size: 1.25rem;
        }
        
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
    <script>
        function selectSize(element) {
            // Remove 'selected' class from all size options
            document.querySelectorAll('.size-option').forEach(el => {
                el.classList.remove('selected', 'border-red-700', 'bg-red-100');
            });
            // Add 'selected' class to the clicked element
            element.classList.add('selected', 'border-red-700', 'bg-red-100');
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Select the first size option by default
            const firstSize = document.querySelector('.size-option');
            if (firstSize) {
                selectSize(firstSize);
            }
        });
    </script>
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

        <!-- Product Detail Area -->
        <main class="bg-white p-6 rounded-xl shadow-inner space-y-6 flex flex-col lg:flex-row lg:space-x-6">
            
            <!-- Left Column: Image and Details -->
            <div class="w-full lg:w-2/3 space-y-4">
                <div class="product-image-box h-80 flex items-center justify-center rounded-lg shadow-md">
                    <p class="text-lg font-semibold">*Hình ảnh sản phẩm A</p>
                </div>
                <h3 class="text-xl font-bold text-stone-800 border-b pb-2">Chi tiết sản phẩm</h3>
                <p class="text-sm text-gray-700">Đây là khu vực mô tả chi tiết về sản phẩm A, bao gồm chất liệu, xuất xứ, tính năng nổi bật, và hướng dẫn sử dụng. Sản phẩm này là mẫu mới nhất trong bộ sưu tập Thu Đông 2025.</p>
                <ul class="list-disc list-inside text-sm text-gray-700 pl-4">
                    <li>Chất liệu: Cotton cao cấp, thoáng khí.</li>
                    <li>Màu sắc: Đỏ, Xanh, Đen.</li>
                    <li>Bảo hành: 12 tháng chính hãng.</li>
                </ul>
            </div>
            
            <!-- Right Column: Options and Actions -->
            <div class="w-full lg:w-1/3 space-y-6 pt-4 lg:pt-0">
                <h2 class="text-2xl font-extrabold text-stone-900 border-b pb-2">Sản Phẩm A</h2>
                <p class="text-xl font-bold text-red-700">Giá: 500.000 VNĐ</p>

                <!-- Size Selection -->
                <div class="space-y-2">
                    <p class="font-semibold text-stone-700">Size:</p>
                    <div class="flex space-x-2">
                        <div class="size-option" onclick="selectSize(this)">S</div>
                        <div class="size-option" onclick="selectSize(this)">M</div>
                        <div class="size-option" onclick="selectSize(this)">L</div>
                        <div class="size-option" onclick="selectSize(this)">XL</div>
                    </div>
                </div>

                <!-- Quantity Control -->
                <div class="space-y-2">
                    <p class="font-semibold text-stone-700">Số lượng:</p>
                    <div class="flex items-center">
                        <button class="qty-btn" onclick="this.nextElementSibling.value = Math.max(1, parseInt(this.nextElementSibling.value) - 1)">-</button>
                        <input type="number" value="1" min="1" class="qty-input focus:outline-none" style="text-align: center;">
                        <button class="qty-btn" onclick="this.previousElementSibling.value = parseInt(this.previousElementSibling.value) + 1">+</button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col space-y-3">
                    <button class="bg-red-800 text-white font-semibold py-3 rounded-full shadow-md hover:bg-red-700 transition duration-200">
                        Thêm vào giỏ
                    </button>
                    <!-- Liên kết đến trang giỏ hàng/danh sách sản phẩm -->
                    <a href="products_list.php" class="bg-gray-300 text-stone-800 font-semibold py-3 rounded-full text-center shadow-md hover:bg-gray-400 transition duration-200">
                        Mua hàng (Đi đến giỏ)
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
<?php
// Logic PHP để tải thông tin chi tiết sản phẩm dựa trên ID.
?>