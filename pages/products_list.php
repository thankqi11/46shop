<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng / Danh Sách Sản Phẩm</title>
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

<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
$cart = $_SESSION['cart'] ?? [];
$total_amount = 0;

// Hàm định dạng tiền tệ
function format_currency($amount) {
    return number_format($amount, 0, ',', '.') . ' VNĐ';
}

// --- LOGIC CẬP NHẬT GIỎ HÀNG PHP (Xử lý khi JS submit form) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $key => $new_qty) {
            $new_qty = max(0, (int)$new_qty); // Số lượng không được âm
            
            if ($new_qty > 0 && isset($_SESSION['cart'][$key])) {
                // Cập nhật số lượng
                $_SESSION['cart'][$key]['qty'] = $new_qty;
            } elseif ($new_qty === 0 && isset($_SESSION['cart'][$key])) {
                // Xóa sản phẩm nếu số lượng là 0
                unset($_SESSION['cart'][$key]);
            }
        }
    }
    // Cập nhật lại giỏ hàng và chuyển hướng để tránh POST lại form
    header("Location: products_list.php");
    exit();
}
// --- KẾT THÚC LOGIC CẬP NHẬT GIỎ HÀNG PHP ---

// Tính lại tổng tiền sau khi cập nhật
foreach ($cart as $item) {
    $total_amount += $item['price'] * $item['qty'];
}
?>

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

            <!-- Auth Links (Đã Cập Nhật Logic) -->
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

        <!-- Product Listing Area / GIỎ HÀNG -->
        <main class="bg-gray-200 p-6 rounded-xl shadow-inner space-y-4">
            <h2 class="text-2xl font-bold text-stone-800 border-b-2 border-gray-400 pb-2">Giỏ Hàng Của Bạn</h2>

            <?php if (empty($cart)): ?>
                <!-- Thông báo nếu giỏ hàng trống -->
                <div class="p-8 text-center bg-white rounded-lg shadow-md">
                    <p class="text-lg text-stone-600">Giỏ hàng của bạn hiện đang trống. <a href="index.php" class="text-red-700 font-semibold underline">Tiếp tục mua sắm</a></p>
                </div>
            <?php else: ?>
                <!-- FORM GIỎ HÀNG -->
                <form method="POST" action="products_list.php">
                    <input type="hidden" name="update_cart" value="1">

                    <!-- Vòng lặp hiển thị các sản phẩm trong giỏ hàng -->
                    <?php foreach ($cart as $key => $item): ?>
                        <div class="product-item p-4 rounded-lg flex flex-col md:flex-row justify-between items-center shadow-md mb-4">
                            <div class="w-full md:w-1/3 space-y-1">
                                <p class="text-lg font-bold"><?php echo $item['name']; ?></p>
                                <p class="text-sm font-medium">Size: <?php echo $item['size']; ?></p>
                                <p class="text-sm font-medium">Giá mỗi SP: <?php echo $item['price_format']; ?></p>
                            </div>
                            
                            <div class="flex items-center space-x-4 mt-4 md:mt-0">
                                <p class="text-sm">Số lượng:</p>
                                <!-- Số lượng hiện tại - Gán name là quantities[key] để PHP nhận mảng -->
                                <div class="flex border rounded-lg overflow-hidden">
                                    <button type="button" class="qty-btn text-red-600" onclick="updateQuantity('qty-<?php echo $key; ?>', -1)">-</button>
                                    <input type="text" id="qty-<?php echo $key; ?>" name="quantities[<?php echo $key; ?>]" value="<?php echo $item['qty']; ?>" class="qty-input focus:outline-none">
                                    <button type="button" class="qty-btn text-green-600" onclick="updateQuantity('qty-<?php echo $key; ?>', 1)">+</button>
                                </div>
                            </div>
                            
                            <!-- Tổng phụ -->
                            <div class="text-right mt-4 md:mt-0">
                                <p class="text-sm font-medium text-stone-700">Thành tiền:</p>
                                <p class="text-lg font-bold text-red-700"><?php echo format_currency($item['price'] * $item['qty']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <!-- Nút Cập nhật giỏ hàng (Ẩn) - được gọi bởi JS sau khi thay đổi số lượng -->
                    <button type="submit" id="submit-update-cart" class="hidden">Cập nhật Giỏ hàng</button>
                </form>

                <!-- Total and Checkout Button -->
                <div class="bg-red-800 text-white p-4 rounded-lg mt-8 flex justify-between items-center shadow-xl">
                    <p class="text-xl font-bold">Tổng số tiền phải thanh toán:</p>
                    <div class="flex items-center space-x-6">
                        <p class="text-2xl font-extrabold"><?php echo format_currency($total_amount); ?></p>
                        <!-- Liên kết đến trang thanh toán -->
                        <a href="checkout.php" class="bg-white text-red-800 font-bold py-3 px-8 rounded-full shadow-lg hover:bg-gray-100 transition duration-200">
                            Thanh toán
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
    
    <!-- JavaScript để xử lý tăng/giảm số lượng trên giao diện và gửi form -->
    <script>
        function updateQuantity(inputId, change) {
            const inputElement = document.getElementById(inputId);
            let currentQty = parseInt(inputElement.value);
            let newQty = currentQty + change;

            // Đảm bảo số lượng không nhỏ hơn 0
            if (newQty >= 0) {
                inputElement.value = newQty;
                
                // Tự động submit form (Gửi yêu cầu cập nhật lên PHP)
                if (newQty === 0) {
                     if (confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng không?')) {
                        document.getElementById('submit-update-cart').click();
                    } else {
                        // Nếu người dùng chọn KHÔNG, giữ lại số lượng 1 và không submit
                        inputElement.value = 1; 
                    }
                } else {
                    // Cập nhật giỏ hàng sau khi thay đổi số lượng
                    document.getElementById('submit-update-cart').click();
                }
            }
        }
    </script>
</body>
</html>
<?php
// Logic PHP cho trang danh sách sản phẩm/giỏ hàng.
?>