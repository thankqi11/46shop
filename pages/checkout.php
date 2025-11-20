<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Đơn Hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #333; }
        .checkout-header { background-color: #3e2723; } /* Darker Brown/Red */
        .info-box { background-color: #689f38; } /* Olive Green */
        .summary-box { background-color: #e0e0e0; } /* Light Grey */
        
        /* Bố cục chính */
        .main-grid {
            grid-template-columns: 2fr 1fr; /* Thông tin (2/3) - Thanh toán (1/3) */
        }
        @media (max-width: 1024px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
        }
        input[type="radio"]:checked + label .radio-dot {
            background-color: #b91c1c; /* Red-700 for selection */
            border-color: #b91c1c;
        }
        .order-item {
            border-bottom: 1px solid #ccc;
            padding-bottom: 0.5rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body class="min-h-screen bg-white">
<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total_amount = 0;

// Tính tổng tiền
foreach ($cart as $item) {
    $total_amount += $item['price'] * $item['qty'];
}

// Hàm định dạng tiền tệ
function format_currency($amount) {
    return number_format($amount, 0, ',', '.') . ' VNĐ';
}

// --- LOGIC XỬ LÝ ĐẶT HÀNG ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    // 1. (Trong dự án thực: Lưu thông tin đơn hàng vào Database)
    
    // 2. Mô phỏng hoàn tất: Xóa giỏ hàng trong Session
    unset($_SESSION['cart']);
    
    // 3. Chuyển hướng đến trang đặt hàng thành công
    header("Location: order_success.php");
    exit();
}
// KẾT THÚC LOGIC PHP
?>

    <!-- Top Header (Dark Red/Brown) -->
    <header class="checkout-header p-4 shadow-xl">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo/Placeholder -->
            <a href="index.php" class="w-16 h-16 bg-red-700 rounded-full border-2 border-red-500">
                <!-- Logo Placeholder -->
            </a>
            <!-- Tên SHOP Placeholder -->
            <div class="flex-grow max-w-2xl mx-4 bg-gray-300 p-4 text-center rounded-lg shadow-inner">
                <h1 class="text-2xl font-bold text-stone-800">Tên SHOP</h1>
            </div>
            <!-- Empty Space to balance layout -->
            <div class="w-16 h-16"></div>
        </div>
    </header>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto grid main-grid gap-8 p-8">
        
        <!-- Form Đặt hàng bao quanh cả thông tin nhận hàng và tóm tắt -->
        <form method="POST" action="checkout.php" class="grid main-grid gap-8 col-span-full">
            <input type="hidden" name="place_order" value="1">

            <!-- Left Column: Shipping Information -->
            <section>
                <h2 class="text-xl font-bold text-stone-800 mb-4">Thông tin nhận hàng</h2>
                <div class="space-y-4">
                    
                    <!-- Full Name -->
                    <div class="info-box p-4 rounded-lg shadow-md">
                        <input type="text" placeholder="Họ và Tên người nhận hàng" required name="full_name"
                               class="w-full bg-transparent text-white font-medium placeholder-white/80 focus:outline-none text-lg">
                    </div>

                    <!-- Phone -->
                    <div class="info-box p-4 rounded-lg shadow-md">
                        <input type="tel" placeholder="Số điện thoại" required name="phone"
                               class="w-full bg-transparent text-white font-medium placeholder-white/80 focus:outline-none text-lg">
                    </div>

                    <!-- Address -->
                    <div class="info-box p-4 rounded-lg shadow-md">
                        <input type="text" placeholder="Địa chỉ" required name="address"
                               class="w-full bg-transparent text-white font-medium placeholder-white/80 focus:outline-none text-lg">
                    </div>

                    <!-- Email -->
                    <div class="info-box p-4 rounded-lg shadow-md">
                        <input type="email" placeholder="Email" name="email"
                               class="w-full bg-transparent text-white font-medium placeholder-white/80 focus:outline-none text-lg">
                    </div>

                    <!-- Notes -->
                    <div class="info-box p-4 rounded-lg shadow-md">
                        <input type="text" placeholder="Ghi chú đơn hàng ( Tùy chọn )" name="notes"
                               class="w-full bg-transparent text-white font-medium placeholder-white/80 focus:outline-none text-lg">
                    </div>
                </div>
            </section>

            <!-- Right Column: Payment and Order Summary -->
            <section class="space-y-8">
                
                <!-- Payment Method -->
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-stone-800 mb-2">Thanh toán</h2>
                    <div class="summary-box p-4 rounded-lg shadow-md space-y-3">
                        <!-- Radio 1: COD -->
                        <div class="flex items-center">
                            <input type="radio" id="cod" name="payment_method" value="cod" checked class="hidden">
                            <label for="cod" class="flex items-center cursor-pointer text-stone-800">
                                <span class="w-4 h-4 inline-block mr-2 rounded-full border-2 border-gray-500 flex-shrink-0 relative">
                                    <span class="radio-dot w-2 h-2 bg-white rounded-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 transition duration-150"></span>
                                </span>
                                Thanh toán khi nhận hàng
                            </label>
                        </div>

                        <!-- Radio 2: Bank Transfer -->
                        <div class="flex items-center">
                            <input type="radio" id="bank" name="payment_method" value="bank" class="hidden">
                            <label for="bank" class="flex items-center cursor-pointer text-stone-800">
                                <span class="w-4 h-4 inline-block mr-2 rounded-full border-2 border-gray-500 flex-shrink-0 relative">
                                    <span class="radio-dot w-2 h-2 bg-white rounded-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 transition duration-150"></span>
                                </span>
                                Thanh toán qua ngân hàng
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-stone-800 mb-2">Đơn hàng</h2>
                    
                    <!-- Danh sách sản phẩm đã mua -->
                    <div class="summary-box p-4 rounded-lg shadow-md space-y-2">
                        <h3 class="font-bold text-stone-800 pb-2 border-b border-gray-400">Chi tiết đơn hàng:</h3>
                        <?php if (empty($cart)): ?>
                            <p class="text-sm text-red-600">Giỏ hàng trống.</p>
                        <?php else: ?>
                            <?php foreach ($cart as $item): ?>
                                <div class="order-item text-sm">
                                    <p class="font-medium text-stone-900"><?php echo $item['name']; ?></p>
                                    <p class="text-xs text-gray-600">Size: <?php echo $item['size']; ?> | SL: <?php echo $item['qty']; ?> | Giá: <?php echo $item['price_format']; ?></p>
                                    <p class="text-right font-semibold text-sm"><?php echo format_currency($item['price'] * $item['qty']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Mã giảm giá -->
                    <div class="summary-box p-3 rounded-lg shadow-md">
                        <input type="text" placeholder="Mã giảm giá ( nếu có):" name="discount_code"
                               class="w-full bg-transparent text-stone-800 placeholder-stone-600 focus:outline-none font-medium">
                    </div>

                    <!-- Tổng tiền cuối cùng và nút Đặt hàng -->
                    <div class="summary-box p-4 rounded-lg shadow-md flex justify-between items-center text-lg font-bold">
                        <p>Tổng :</p>
                        <p class="text-2xl font-extrabold text-red-700"><?php echo format_currency($total_amount); ?></p>
                        <!-- Nút Đặt hàng (Submit Form) -->
                        <button type="submit" class="bg-red-800 text-white py-2 px-6 rounded-full shadow-lg hover:bg-red-700 transition duration-200">
                            Đặt hàng
                        </button>
                    </div>

                    <!-- Edit Order Button -->
                    <div class="summary-box p-4 rounded-lg shadow-md text-center">
                        <!-- Liên kết quay lại trang giỏ hàng -->
                        <a href="products_list.php" class="block bg-gray-400 text-stone-800 font-semibold py-2 w-full rounded-lg hover:bg-gray-500 transition duration-200">
                            Sửa đơn hàng
                        </a>
                    </div>
                </div>
            </section>
        </form>
    </div>
</body>
</html>