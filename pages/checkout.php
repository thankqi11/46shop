<?php
session_start();
require_once 'db_connect.php';

// Kiểm tra giỏ hàng và đăng nhập
if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}
if (!isset($_SESSION['user_id'])) {
    die('<div style="background:#333; color:white; padding:50px; text-align:center;">Vui lòng <a href="login.php" style="color:red; font-weight:bold;">Đăng nhập</a> để thanh toán.</div>');
}

$maKH = isset($_SESSION['ma_kh']) ? $_SESSION['ma_kh'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tenNguoiNhan = $_POST['tenNguoiNhan'];
    $sdt = $_POST['sdt'];
    $diaChi = $_POST['diaChi'];
    $tongTien = 0;

    foreach ($_SESSION['cart'] as $item) {
        $tongTien += $item['gia'] * $item['soLuong'];
    }

    $conn->begin_transaction();
    try {
        // 1. Tạo đơn hàng
        $stmt = $conn->prepare("INSERT INTO donhang (MaKH, TongTien, TrangThaiDonHang, DiaChiGiaoHang, SDT_NguoiNhan) VALUES (?, ?, 'Chờ xử lý', ?, ?)");
        $stmt->bind_param("idss", $maKH, $tongTien, $diaChi, $sdt);
        $stmt->execute();
        $maDH = $conn->insert_id;

        // 2. Lưu chi tiết đơn hàng
        $stmt_ct = $conn->prepare("INSERT INTO chitietdonhang (MaDH, MaSP, SoLuong, Size, Mau, DonGia) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($_SESSION['cart'] as $item) {
            $stmt_ct->bind_param("iiissd", $maDH, $item['maSP'], $item['soLuong'], $item['size'], $item['mau'], $item['gia']);
            $stmt_ct->execute();
        }

        // 3. Xóa giỏ hàng (Session + Database)
        unset($_SESSION['cart']);

        if ($maKH > 0) {
            $stmt_clean = $conn->prepare("DELETE FROM giohang WHERE MaKH = ?");
            $stmt_clean->bind_param("i", $maKH);
            $stmt_clean->execute();
        }

        $conn->commit();
        echo "<script>alert('Đặt hàng thành công! Mã đơn: #$maDH'); window.location.href='index.php';</script>";

    } catch (Exception $e) {
        $conn->rollback();
        echo "Lỗi: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Inter', sans-serif; background-color: #333; }</style>
</head>
<body class="min-h-screen bg-stone-900 text-stone-200">
    <header class="bg-red-950 p-4 shadow-xl text-white">
        <div class="max-w-2xl mx-auto font-bold text-xl"><a href="cart.php">← Quay lại giỏ hàng</a></div>
    </header>

    <main class="max-w-2xl mx-auto p-8">
        <div class="bg-stone-800 p-8 rounded-xl shadow-2xl border border-stone-700">
            <h2 class="text-3xl font-bold mb-6 text-center text-red-500">Thông Tin Giao Hàng</h2>
            <form action="" method="POST" class="space-y-6">
                <div>
                    <label class="block mb-1 text-sm font-bold">Họ tên người nhận</label>
                    <input type="text" name="tenNguoiNhan" required class="w-full p-3 rounded bg-stone-700 border border-stone-600 focus:border-red-500 outline-none">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-bold">Số điện thoại</label>
                    <input type="text" name="sdt" required class="w-full p-3 rounded bg-stone-700 border border-stone-600 focus:border-red-500 outline-none">
                </div>
                <div>
                    <label class="block mb-1 text-sm font-bold">Địa chỉ giao hàng</label>
                    <textarea name="diaChi" required rows="3" class="w-full p-3 rounded bg-stone-700 border border-stone-600 focus:border-red-500 outline-none"></textarea>
                </div>
                <div class="bg-stone-900 p-4 rounded text-center border border-stone-600">
                    <p class="text-stone-400">Phương thức thanh toán</p>
                    <p class="font-bold text-white">Thanh toán khi nhận hàng (COD)</p>
                </div>
                <button type="submit" class="w-full bg-red-700 hover:bg-red-600 text-white font-bold py-4 rounded shadow-lg">XÁC NHẬN ĐẶT HÀNG</button>
            </form>
        </div>
    </main>
</body>
</html>