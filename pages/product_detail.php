<?php
session_start();
require_once 'db_connect.php';

// Kiểm tra MaSP
if (!isset($_GET['MaSP']) || !is_numeric($_GET['MaSP'])) {
    die("Sản phẩm không tồn tại!");
}

$maSP = (int)$_GET['MaSP'];

// Lấy thông tin sản phẩm
$sql = "SELECT * FROM sanpham WHERE MaSP = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $maSP);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Sản phẩm không tìm thấy!");
}

$product = $result->fetch_assoc();

// --- SỬA LẠI: LẤY NGUYÊN GỐC ĐƯỜNG DẪN TỪ DB (Giống file index cũ) ---
// Không dùng ltrim hay kiểm tra file_exists nữa
$img_src = $product['HinhAnh'];

// Chỉ dùng ảnh thay thế nếu trong DB hoàn toàn không có gì
if (empty($img_src)) {
    $img_src = "https://via.placeholder.com/400";
}
// --------------------------------------------------------------------

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['TenSP']) ?> - Chi tiết</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #333; }
        /* Ẩn mũi tên mặc định của input number */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>
</head>
<body class="min-h-screen bg-stone-900 text-stone-200">

    <header class="bg-red-950 p-4 shadow-xl text-white flex justify-between items-center">
        <div class="font-bold text-xl"><a href="index.php">← Quay lại Shop</a></div>
        
        <div class="relative">
            <a href="cart.php" class="bg-yellow-500 text-stone-900 px-4 py-2 rounded font-bold hover:bg-yellow-400 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
                Giỏ hàng
            </a>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-8">
        <div class="bg-stone-800 rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
            
            <div class="md:w-1/2 p-8 bg-white flex items-center justify-center">
                <img src="<?= $img_src ?>" alt="<?= htmlspecialchars($product['TenSP']) ?>" class="max-h-[500px] object-contain hover:scale-105 transition duration-300">
            </div>

            <div class="md:w-1/2 p-8 space-y-6">
                <h1 class="text-4xl font-bold text-white"><?= htmlspecialchars($product['TenSP']) ?></h1>
                <p class="text-3xl text-red-500 font-bold"><?= number_format($product['Gia'], 0, ',', '.') ?> VNĐ</p>
                
                <div class="text-stone-400">
                    <h3 class="font-bold text-white mb-2">Mô tả sản phẩm:</h3>
                    <p><?= nl2br(htmlspecialchars($product['ChiTietSP'])) ?></p>
                </div>

                <form action="cart.php" method="POST" class="space-y-6 border-t border-stone-600 pt-6">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="maSP" value="<?= $product['MaSP'] ?>">
                    <input type="hidden" name="tenSP" value="<?= $product['TenSP'] ?>">
                    <input type="hidden" name="gia" value="<?= $product['Gia'] ?>">
                    <input type="hidden" name="hinhAnh" value="<?= $img_src ?>"> <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 font-bold">Size:</label>
                            <select name="size" class="w-full p-3 rounded bg-stone-700 border border-stone-600 text-white focus:border-red-500 outline-none">
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="One Size">One Size</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 font-bold">Màu sắc:</label>
                            <select name="mau" class="w-full p-3 rounded bg-stone-700 border border-stone-600 text-white focus:border-red-500 outline-none">
                                <option value="Trắng">Trắng</option>
                                <option value="Đen">Đen</option>
                                <option value="Đỏ">Đỏ</option>
                                <option value="Xanh">Xanh</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 font-bold">Số lượng:</label>
                        <div class="flex items-center">
                            <button type="button" onclick="decreaseQty()" class="bg-stone-600 hover:bg-red-600 text-white font-bold py-3 px-4 rounded-l border-r border-stone-500 transition">-</button>
                            <input type="number" id="soLuongInput" name="soLuong" value="1" min="1" max="10" 
                                   class="w-16 p-3 bg-stone-700 text-white text-center focus:outline-none" readonly>
                            <button type="button" onclick="increaseQty()" class="bg-stone-600 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-r border-l border-stone-500 transition">+</button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-red-700 hover:bg-red-600 text-white font-bold py-4 rounded-lg shadow-lg text-lg transition transform active:scale-95">
                        THÊM VÀO GIỎ HÀNG
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Tăng số lượng
        function increaseQty() {
            var input = document.getElementById('soLuongInput');
            var value = parseInt(input.value, 10);
            if (value < 10) { 
                input.value = value + 1;
            }
        }

        // Giảm số lượng
        function decreaseQty() {
            var input = document.getElementById('soLuongInput');
            var value = parseInt(input.value, 10);
            if (value > 1) { 
                input.value = value - 1;
            }
        }

        // Hiển thị thông báo Alert nếu URL có ?status=success
        // (Điều kiện: file cart.php phải redirect về đây kèm tham số này)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'success') {
            alert('✅ Thêm vào giỏ hàng thành công!');
            
            // Xóa tham số trên URL để nhìn cho đẹp (không bắt buộc)
            const newUrl = window.location.pathname + "?MaSP=" + urlParams.get('MaSP');
            window.history.replaceState(null, null, newUrl);
        }
    </script>
</body>
</html>