<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Lấy MaKH nếu user đã đăng nhập
$maKH = isset($_SESSION['ma_kh']) ? $_SESSION['ma_kh'] : 0;

// 1. XỬ LÝ THÊM SẢN PHẨM
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $maSP = $_POST['maSP'];
    $size = $_POST['size'];
    $mau = $_POST['mau'];
    $soLuong = (int) $_POST['soLuong'];

    $key = $maSP . "_" . $size . "_" . $mau;

    $item = [
        'maSP' => $maSP,
        'tenSP' => $_POST['tenSP'],
        'gia' => (int) $_POST['gia'],
        'hinhAnh' => $_POST['hinhAnh'],
        'size' => $size,
        'mau' => $mau,
        'soLuong' => $soLuong
    ];

    // Cập nhật Session
    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['soLuong'] += $soLuong;
    } else {
        $_SESSION['cart'][$key] = $item;
    }

    // [QUAN TRỌNG] LƯU VÀO DATABASE NẾU ĐÃ LOGIN
    if ($maKH > 0) {
        $check_sql = "SELECT id, SoLuong FROM giohang WHERE MaKH=? AND MaSP=? AND Size=? AND Mau=?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("iiss", $maKH, $maSP, $size, $mau);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $new_qty = $row['SoLuong'] + $soLuong;
            $conn->query("UPDATE giohang SET SoLuong = $new_qty WHERE id = " . $row['id']);
        } else {
            $stmt_ins = $conn->prepare("INSERT INTO giohang (MaKH, MaSP, Size, Mau, SoLuong) VALUES (?, ?, ?, ?, ?)");
            $stmt_ins->bind_param("iissi", $maKH, $maSP, $size, $mau, $soLuong);
            $stmt_ins->execute();
        }
    }

    // Quay lại trang chi tiết sản phẩm
    header("Location: product_detail.php?MaSP=" . $maSP . "&status=success");
    exit();
}

// 2. XỬ LÝ XÓA SẢN PHẨM
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['key'])) {
    $keyToRemove = $_GET['key'];
    if (isset($_SESSION['cart'][$keyToRemove])) {
        $item = $_SESSION['cart'][$keyToRemove];
        unset($_SESSION['cart'][$keyToRemove]);

        // [QUAN TRỌNG] XÓA KHỎI DATABASE NẾU ĐÃ LOGIN
        if ($maKH > 0) {
            $stmt_del = $conn->prepare("DELETE FROM giohang WHERE MaKH=? AND MaSP=? AND Size=? AND Mau=?");
            $stmt_del->bind_param("iiss", $maKH, $item['maSP'], $item['size'], $item['mau']);
            $stmt_del->execute();
        }
    }
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giỏ Hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #333;
        }
    </style>
</head>

<body class="min-h-screen bg-stone-900 text-stone-200">
    <header class="bg-red-950 p-4 shadow-xl text-white">
        <div class="max-w-6xl mx-auto flex justify-between">
            <div class="font-bold text-xl"><a href="index.php">← Tiếp tục mua sắm</a></div>
            <?php if ($maKH > 0): ?>
                <a href="logout.php" class="p-2 border border-red-400 rounded-lg hover:bg-red-800 transition text-sm">Đăng
                    xuất</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-8">
        <h1 class="text-3xl font-bold mb-8 text-center border-b border-stone-700 pb-4 text-white">Giỏ Hàng Của Bạn</h1>

        <?php if (empty($_SESSION['cart'])): ?>
            <div class="text-center py-20 bg-stone-800 rounded-lg">
                <p class="text-2xl text-stone-400 font-bold">Giỏ hàng đang trống!</p>
                <a href="index.php" class="inline-block mt-6 px-6 py-3 bg-red-700 text-white rounded-full">Quay lại trang
                    chủ</a>
            </div>
        <?php else: ?>
            <div class="bg-stone-800 rounded-lg overflow-hidden shadow-xl border border-stone-700">
                <table class="w-full text-left">
                    <thead class="bg-red-900 text-white">
                        <tr>
                            <th class="p-4">Sản phẩm</th>
                            <th class="p-4 hidden md:table-cell">Đơn giá</th>
                            <th class="p-4">SL</th>
                            <th class="p-4">Thành tiền</th>
                            <th class="p-4 text-center">Xóa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-600">
                        <?php
                        $tongTien = 0;
                        foreach ($_SESSION['cart'] as $key => $item):
                            $thanhTien = $item['gia'] * $item['soLuong'];
                            $tongTien += $thanhTien;
                            // Xử lý hiển thị ảnh nguyên bản
                            $hinh = $item['hinhAnh'];
                            if (empty($hinh))
                                $hinh = "https://via.placeholder.com/100";
                            ?>
                            <tr class="hover:bg-stone-700/50">
                                <td class="p-4 flex items-center gap-4">
                                    <img src="<?= $hinh ?>" class="w-16 h-16 object-cover bg-white rounded">
                                    <div>
                                        <div class="font-bold text-white"><?= htmlspecialchars($item['tenSP']) ?></div>
                                        <div class="text-sm text-yellow-500"><?= $item['size'] ?> / <?= $item['mau'] ?></div>
                                    </div>
                                </td>
                                <td class="p-4 hidden md:table-cell"><?= number_format($item['gia'], 0, ',', '.') ?> đ</td>
                                <td class="p-4 font-bold text-white"><?= $item['soLuong'] ?></td>
                                <td class="p-4 text-yellow-400 font-bold"><?= number_format($thanhTien, 0, ',', '.') ?> đ</td>
                                <td class="p-4 text-center">
                                    <a href="cart.php?action=remove&key=<?= $key ?>" onclick="return confirm('Xóa món này?');"
                                        class="text-stone-400 hover:text-red-500">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-8 flex justify-end items-center gap-6 bg-stone-800 p-6 rounded-lg border border-stone-700">
                <div class="text-2xl font-bold text-white">Tổng: <span
                        class="text-red-500"><?= number_format($tongTien, 0, ',', '.') ?> VNĐ</span></div>
                <a href="checkout.php"
                    class="bg-red-700 hover:bg-red-600 text-white font-bold py-4 px-10 rounded-lg shadow-lg">TIẾN HÀNH THANH
                    TOÁN</a>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>