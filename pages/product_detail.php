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
        // Chọn size
        function selectSize(element, sizeValue) {
            // Remove 'selected' class from all size options
            document.querySelectorAll('.size-option').forEach(el => {
                el.classList.remove('selected', 'border-red-700', 'bg-red-100');
            });
            // Add 'selected' class to the clicked element
            element.classList.add('selected', 'border-red-700', 'bg-red-100');
            // Cập nhật giá trị size vào input ẩn
            document.getElementById('selected-size').value = sizeValue;
        }

        // Khởi tạo trạng thái size khi trang tải xong
        document.addEventListener('DOMContentLoaded', () => {
            const firstSize = document.querySelector('.size-option');
            if (firstSize) {
                // Chọn size đầu tiên và cập nhật giá trị
                selectSize(firstSize, firstSize.getAttribute('data-size'));
            }
        });
    </script>
</head>
<body class="min-h-screen bg-stone-900">
<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);

// --- Dữ liệu sản phẩm giả định (thường lấy từ Database) ---
$products = [
    'A' => [
        'name' => 'Quần Thể Thao Cao Cấp',
        'price' => 150000,
        'price_format' => '150.000 VNĐ',
        'desc' => 'Quần short tập luyện chuyên nghiệp, chất liệu co giãn 4 chiều, thoáng khí, phù hợp cho gym và chạy bộ.',
        'image' => 'images/quan_the_thao.jpg',
        'sizes' => ['S', 'M', 'L', 'XL']
    ],
    'B' => [
        'name' => 'Áo Thun Thể Thao Coolmax',
        'price' => 250000,
        'price_format' => '250.000 VNĐ',
        'desc' => 'Áo thun công nghệ Coolmax giúp thấm hút mồ hôi cực nhanh, giữ cơ thể luôn khô thoáng. Thiết kế thời trang, năng động.',
        'image' => 'images/ao_thun_the_thao.jpg',
        'sizes' => ['M', 'L', 'XL']
    ],
    'C' => [
        'name' => 'Mũ Lưỡi Trai Logo Thêu',
        'price' => 150000,
        'price_format' => '150.000 VNĐ',
        'desc' => 'Mũ lưỡi trai phong cách cổ điển, chất liệu cotton dày dặn, logo thêu tinh tế. Bảo vệ khỏi ánh nắng khi luyện tập ngoài trời.',
        'image' => 'images/Mu-the-thao.jpg',
        'sizes' => ['Freesize']
    ]
];

$product_id = isset($_GET['id']) ? $_GET['id'] : null;
$current_product = null;
if ($product_id && isset($products[$product_id])) {
    $current_product = $products[$product_id];
    $current_product['id'] = $product_id; // Thêm ID vào mảng
} else {
    $current_product = [
        'id' => null,
        'name' => 'Sản Phẩm Không Tìm Thấy',
        'price' => 0,
        'price_format' => '---',
        'desc' => 'Xin lỗi, sản phẩm này hiện không có sẵn hoặc đã bị xóa.',
        'image' => 'https://placehold.co/320x320/cccccc/333333?text=404+Not+Found',
        'sizes' => []
    ];
}

// --- LOGIC THÊM SẢN PHẨM VÀO GIỎ HÀNG (Session) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart']) && $current_product['id']) {
    // 1. Kiểm tra đăng nhập trước khi cho phép thêm vào giỏ
    if (!$is_logged_in) {
        header("Location: login.php");
        exit();
    }
    
    // 2. Lấy dữ liệu từ form
    $item_id = $current_product['id'];
    $quantity = max(1, (int)($_POST['quantity'] ?? 1));
    $size = $_POST['selected_size'] ?? ($current_product['sizes'][0] ?? 'N/A');

    // 3. Tạo khóa duy nhất cho sản phẩm (kết hợp ID và Size)
    $cart_item_key = $item_id . '_' . $size;

    // 4. Khởi tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // 5. Lấy thông tin đầy đủ của sản phẩm
    $item_details = $current_product;
    $item_details['size'] = $size;
    $item_details['qty'] = $quantity;

    // 6. Thêm/Cập nhật vào giỏ hàng Session
    if (isset($_SESSION['cart'][$cart_item_key])) {
        // Nếu sản phẩm đã tồn tại, tăng số lượng
        $_SESSION['cart'][$cart_item_key]['qty'] += $quantity;
    } else {
        // Nếu là sản phẩm mới, thêm vào giỏ
        $_SESSION['cart'][$cart_item_key] = $item_details;
    }

    // 7. Chuyển hướng đến trang Giỏ hàng
    header("Location: products_list.php");
    exit();
}
// KẾT THÚC LOGIC PHP
?>

    <!-- Top Header (Dark Red/Brown) -->
    <header class="bg-red-950 p-4 shadow-xl">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            
            <!-- Logo/Placeholder -->
            <div class="flex items-center space-x-4">
                <a href="index.php" class="w-20 h-16 bg-red-700 rounded-full border-2 border-red-500">
                    <img src="images/logo.jpg">
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
                <?php if ($is_logged_in): ?>
                    <!-- Nút Đăng xuất nếu đã đăng nhập -->
                    <a href="logout.php" class="text-white font-semibold hover:text-red-300 p-2 text-sm border border-white/20 rounded-lg transition duration-200">
                        Đăng xuất
                    </a>
                <?php else: ?>
                    <!-- Nút Đăng ký và Đăng nhập nếu chưa đăng nhập -->
                    <a href="register.php" class="text-white font-semibold hover:text-red-300 p-2 text-sm border border-white/20 rounded-lg transition duration-200">
                        Đăng ký
                    </a>
                    <a href="login.php" class="text-white font-semibold hover:text-red-300 p-2 text-sm border border-white/20 rounded-lg transition duration-200">
                        Đăng nhập
                    </a>
                <?php endif; ?>
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
                <div class="product-image-box h-80 flex items-center justify-center rounded-lg shadow-md overflow-hidden">
                    <!-- Ảnh sản phẩm được tải động từ mảng PHP -->
                    <img src="<?php echo $current_product['image']; ?>" alt="<?php echo $current_product['name']; ?>" class="w-full h-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-stone-800 border-b pb-2">Chi tiết sản phẩm</h3>
                <!-- Mô tả được điền động -->
                <p class="text-sm text-gray-700"><?php echo $current_product['desc']; ?></p>
                
                <!-- Mô tả chi tiết thêm -->
                <ul class="list-disc list-inside text-sm text-gray-700 pl-4">
                    <li>Chất liệu: Tùy theo sản phẩm (Mô phỏng).</li>
                    <li>Màu sắc: Tùy theo sản phẩm (Mô phỏng).</li>
                    <li>Bảo hành: 12 tháng chính hãng.</li>
                </ul>
            </div>
            
            <!-- Right Column: Options and Actions -->
            <div class="w-full lg:w-1/3 space-y-6 pt-4 lg:pt-0">
                <!-- Tên sản phẩm được điền động -->
                <h2 class="text-2xl font-extrabold text-stone-900 border-b pb-2"><?php echo $current_product['name']; ?></h2>
                <!-- Giá sản phẩm được điền động -->
                <p class="text-xl font-bold text-red-700">Giá: <?php echo $current_product['price_format']; ?></p>

                <!-- Form THÊM VÀO GIỎ HÀNG -->
                <form action="product_detail.php?id=<?php echo $product_id; ?>" method="POST" class="space-y-6">
                    <input type="hidden" name="add_to_cart" value="1">
                    <input type="hidden" id="selected-size" name="selected_size" value="">

                    <!-- Size Selection -->
                    <div class="space-y-2">
                        <p class="font-semibold text-stone-700">Size:</p>
                        <div class="flex space-x-2">
                            <!-- Vòng lặp để hiển thị Size động -->
                            <?php foreach ($current_product['sizes'] as $size): ?>
                                <div class="size-option" data-size="<?php echo $size; ?>" onclick="selectSize(this, '<?php echo $size; ?>')"><?php echo $size; ?></div>
                            <?php endforeach; ?>
                            <?php if (empty($current_product['sizes'])): ?>
                                <p class="text-sm text-gray-500">Không áp dụng size</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Quantity Control -->
                    <div class="space-y-2">
                        <p class="font-semibold text-stone-700">Số lượng:</p>
                        <div class="flex items-center">
                            <button type="button" class="qty-btn" onclick="this.nextElementSibling.value = Math.max(1, parseInt(this.nextElementSibling.value) - 1)">-</button>
                            <input type="number" name="quantity" value="1" min="1" class="qty-input focus:outline-none" style="text-align: center;">
                            <button type="button" class="qty-btn" onclick="this.previousElementSibling.value = parseInt(this.previousElementSibling.value) + 1">+</button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col space-y-3">
                        <!-- Nút Thêm vào giỏ (Submit form) -->
                        <button type="submit" class="bg-red-800 text-white font-semibold py-3 rounded-full shadow-md hover:bg-red-700 transition duration-200">
                            Thêm vào giỏ
                        </button>
                        <!-- Nút Mua hàng (Chuyển hướng dựa trên trạng thái đăng nhập) -->
                        <?php 
                            // Nếu chưa đăng nhập, nút này sẽ trỏ về login.php
                            $checkout_link = $is_logged_in ? 'products_list.php' : 'login.php';
                        ?>
                        <a href="<?php echo $checkout_link; ?>" class="bg-gray-300 text-stone-800 font-semibold py-3 rounded-full text-center shadow-md hover:bg-gray-400 transition duration-200">
                            Mua hàng (Đi đến giỏ)
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>