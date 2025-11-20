<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Shop Đồ Thể Thao</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background-color: #333;
        }
        .product-card {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-4px);
        }
        .ad-box {
            min-height: 100px; /* Chiều cao tối thiểu cho Quảng cáo nhỏ */
        }
        @media (max-width: 768px) {
            .main-grid {
                grid-template-areas: 
                    "sidebar" 
                    "ad-main" 
                    "ad-right" 
                    "products";
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-stone-900">
    
<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
?>

    <!-- Top Header (Dark Red/Brown) -->
    <header class="bg-red-950 p-4 shadow-xl">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            
            <!-- Logo/Placeholder -->
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-red-700 rounded-full border-2 border-red-500">
                    <!-- Logo Placeholder -->
                </div>
                <!-- Login/Register Link (Top Right - Mobile Only) -->
                <?php if ($is_logged_in): ?>
                    <a href="logout.php" class="block md:hidden text-white font-semibold hover:text-red-300">
                        Đăng xuất
                    </a>
                <?php else: ?>
                    <a href="login.php" class="block md:hidden text-white font-semibold hover:text-red-300">
                        Đăng kí / Đăng nhập
                    </a>
                <?php endif; ?>
            </div>

            <!-- Search Bar (Đã Cập Nhật cho tính năng Gợi ý) -->
            <div class="flex-grow max-w-xl mx-4 w-full md:w-auto relative"> <!-- Thêm relative ở đây -->
                <div class="flex rounded-lg overflow-hidden shadow-inner bg-gray-300">
                    <input type="text" id="search-input" placeholder="Thanh tìm kiếm" onkeyup="showSuggestions(this.value)"
                           class="w-full p-3 text-lg bg-transparent focus:outline-none placeholder-gray-600 text-stone-900">
                    <button class="bg-stone-900 text-white p-3 px-6 hover:bg-stone-700 transition duration-150">
                        <!-- Icon Placeholder -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                    <!-- Small White Box Placeholder from image -->
                    <div class="w-10 bg-white border-l border-gray-400"></div>
                </div>
                
                <!-- Search Suggestions Dropdown -->
                <div id="suggestions-box" class="absolute z-10 w-[90%] md:w-[80%] mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden left-0 right-0 mx-auto">
                    <!-- Suggestions will be inserted here by JavaScript -->
                </div>
            </div>

            <!-- Auth Links (Desktop Only) -->
            <?php if ($is_logged_in): ?>
                <a href="logout.php" class="hidden md:block text-white font-semibold hover:text-red-300 p-2 border border-white/20 rounded-lg transition duration-200">
                    Đăng xuất
                </a>
            <?php else: ?>
                <a href="login.php" class="hidden md:block text-white font-semibold hover:text-red-300 p-2 border border-white/20 rounded-lg transition duration-200">
                    Đăng kí / Đăng nhập
                </a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-[180px_1fr_200px] gap-4 p-4">
        
        <!-- Left Sidebar (Navigation) -->
        <aside class="space-y-4 bg-red-950/90 p-4 rounded-xl md:p-0 md:bg-transparent">
            <!-- Navigation Items -->
            <nav class="space-y-3">
                <a href="#" class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Giày</a>
                <a href="#" class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Quần</a>
                <a href="#" class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Áo</a>
                <a href="#" class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Mũ</a>
                <a href="#" class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Phụ Kiện</a>
            </nav>
            
            <!-- Contact Info -->
            <div class="pt-6 text-white text-sm">
                <p class="font-bold">Thông tin Liên Lạc</p>
                <p>0522 222 333</p>
            </div>
        </aside>

        <!-- Center Content -->
        <main class="space-y-4">
            <!-- Main Advertisement Area (Red Box) -->
            <div class="bg-red-700 text-white p-12 text-center rounded-xl shadow-lg h-48 md:h-64 flex items-center justify-center">
                <img src="images/banner-chinh.jpg" >
                
            </div>

            <!-- Product Listing Area (Light Grey/Green Background) -->
            <div class="bg-gray-200 p-6 rounded-xl shadow-inner space-y-6">
                <h2 class="text-2xl font-bold text-stone-800 mb-4 border-b-2 border-gray-400 pb-2">Các Sản Phẩm Nổi Bật</h2>
                
                <!-- Product Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- Product Card A (Quần) -->
                    <div class="product-card bg-white rounded-xl overflow-hidden text-center">
                        <div class="bg-green-600 text-white p-3 font-semibold text-lg">Quần Thể Thao</div>
                        <div class="p-4 space-y-3">
                            <div class="h-32 bg-white border border-gray-300 flex items-center justify-center rounded-lg overflow-hidden">
                                <img src="images/Quan-the-thao.jpg">
                            </div>
                            <div class="bg-yellow-400 text-stone-800 font-bold p-1 rounded-md">Giá tiền: 150.000 VNĐ</div>
                            <a href="product_detail.php?id=A" class="text-red-700 font-semibold hover:text-red-900 underline">Xem chi tiết</a>
                        </div>
                    </div>

                    <!-- Product Card B (Áo) -->
                    <div class="product-card bg-white rounded-xl overflow-hidden text-center">
                        <div class="bg-green-600 text-white p-3 font-semibold text-lg">Áo Thun Thể Thao</div>
                        <div class="p-4 space-y-3">
                            <div class="h-32 bg-white border border-gray-300 flex items-center justify-center rounded-lg overflow-hidden">
                                <img src="images/Ao-the_thao.png">
                            </div>
                            <div class="bg-yellow-400 text-stone-800 font-bold p-1 rounded-md">Giá tiền: 200.000 VNĐ</div>
                            <a href="product_detail.php?id=B" class="text-red-700 font-semibold hover:text-red-900 underline">Xem chi tiết</a>
                        </div>
                    </div>

                    <!-- Product Card C (Mũ) -->
                    <div class="product-card bg-white rounded-xl overflow-hidden text-center">
                        <div class="bg-green-600 text-white p-3 font-semibold text-lg">Mũ Lưỡi Trai</div>
                        <div class="p-4 space-y-3">
                            <div class="h-32 bg-white border border-gray-300 flex items-center justify-center rounded-lg overflow-hidden">
                                <img src="images/Mu-the-thao.jpg">
                            </div>
                            <div class="bg-yellow-400 text-stone-800 font-bold p-1 rounded-md">Giá tiền: 150.000 VNĐ</div>
                            <a href="product_detail.php?id=C" class="text-red-700 font-semibold hover:text-red-900 underline">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                
                <!-- Footer Text -->
                <p class="text-center text-stone-600 pt-6 italic text-lg">Shop quần áo gì cũng có mua hết ở đây</p>
            </div>
        </main>

        <!-- Right Sidebar (Small Ads) -->
        <aside class="space-y-4">
            <!-- Small Ad 1 (Dark Brown/Red) -->
            <div class="ad-box bg-red-800 text-white p-1 text-center rounded-xl shadow-lg flex items-center justify-center h-32">
                <img src="images/1_3.jpg">
            </div>
            <!-- Small Ad 2 (Dark Brown/Red) -->
            <div class="ad-box bg-red-800 text-white p-1 text-center rounded-xl shadow-lg flex items-center justify-center h-32">
                <img src="images/banner-phu.jpg">
            </div>
            <!-- Additional Space/Ad Placeholder -->
            <div class="hidden md:block ad-box bg-red-950/70 text-white p-1 text-center rounded-xl shadow-lg h-32">
                <img src="images/2.jpg">
            </div>
        </aside>
    </div>

    <!-- Overall Footer (Simple) -->
    <footer class="bg-red-950 text-white text-center p-4 mt-6">
        <p>© 2025 Shop Đồ Thể Thao. Tất cả quyền được bảo lưu.</p>
    </footer>
    
    <!-- JavaScript for Search Suggestions -->
    <script>
        // Danh sách sản phẩm giả định để mô phỏng tìm kiếm
        const products = [
            "Áo thun thể thao",
            "Áo khoác dù",
            "Áo polo cotton",
            "Quần short tập gym",
            "Quần dài jogger",
            "Quần bò rách",
            "Giày chạy bộ Nike",
            "Giày bóng rổ",
            "Mũ lưỡi trai đen",
            "Phụ kiện dây đeo tay"
        ];

        function showSuggestions(searchTerm) {
            const box = document.getElementById('suggestions-box');
            
            // Xóa khoảng trắng và chuyển sang chữ thường để tìm kiếm không phân biệt chữ hoa/thường
            const term = searchTerm.trim().toLowerCase();
            
            if (term.length === 0) {
                box.classList.add('hidden');
                return;
            }

            // Lọc danh sách sản phẩm
            const filteredProducts = products.filter(product => 
                product.toLowerCase().includes(term)
            );

            // Tạo HTML cho các gợi ý
            let html = '';
            if (filteredProducts.length > 0) {
                html = filteredProducts.map(product => `
                    <a href="#" class="block p-3 hover:bg-gray-100 text-stone-800 border-b border-gray-100 last:border-b-0" 
                       onclick="selectSuggestion('${product.replace(/'/g, "\\'")}')">
                        ${product}
                    </a>
                `).join('');
                box.innerHTML = html;
                box.classList.remove('hidden');
            } else {
                box.classList.add('hidden');
            }
        }
        
        // Hàm này được gọi khi người dùng nhấp vào một gợi ý
        function selectSuggestion(productName) {
            document.getElementById('search-input').value = productName;
            document.getElementById('suggestions-box').classList.add('hidden');
            
            // THỰC HIỆN TÌM KIẾM SAU KHI CHỌN (Ví dụ: chuyển hướng đến trang tìm kiếm)
            // Trong dự án thực, bạn sẽ chuyển hướng đến trang search.php?query=productName
            console.log("Tìm kiếm sản phẩm: " + productName);
            // window.location.href = "search.php?query=" + encodeURIComponent(productName);
        }

        // Ẩn hộp gợi ý khi nhấp chuột ra ngoài
        document.addEventListener('click', function(event) {
            const searchContainer = document.querySelector('.relative > .flex');
            const box = document.getElementById('suggestions-box');
            if (searchContainer && !searchContainer.contains(event.target) && !box.contains(event.target)) {
                box.classList.add('hidden');
            }
        });

    </script>
</body>
</html>
<?php
// Không cần thêm logic PHP nào khác ở đây.
?>