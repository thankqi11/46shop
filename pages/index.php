<?php
// 1. QUAN TRỌNG: Thêm dòng này để nhận biết trạng thái đăng nhập
session_start();

// db_connect.php phải được nhúng ở đầu file
require_once 'db_connect.php';

// Khởi tạo biến cho bộ lọc
$maDM_filter = null;
$tenDM_hien_tai = "Tất Cả Sản Phẩm"; // Tên danh mục mặc định

// KIỂM TRA ĐIỀU KIỆN LỌC (FILTERING LOGIC)
if (isset($_GET['MaDM']) && is_numeric($_GET['MaDM'])) {
    $maDM_filter = (int) $_GET['MaDM'];
}

// XÂY DỰNG CÂU TRUY VẤN SQL
$sql = "SELECT MaSP, TenSP, Gia, HinhAnh, MaDM FROM sanpham WHERE TrangThai = 1";

// Nếu có lọc theo danh mục, thêm điều kiện AND
if ($maDM_filter !== null) {
    $sql .= " AND MaDM = ?";
}

$sql .= " ORDER BY MaSP DESC";

$result = null;

// THỰC THI TRUY VẤN VỚI PREPARED STATEMENT
if ($stmt = $conn->prepare($sql)) {

    // Nếu có lọc, bind tham số MaDM
    if ($maDM_filter !== null) {
        $stmt->bind_param("i", $maDM_filter);

        // (Tùy chọn) Truy vấn tên danh mục để hiển thị tiêu đề
        $stmt_dm = $conn->prepare("SELECT TenDM FROM danhmuc WHERE MaDM = ?");
        $stmt_dm->bind_param("i", $maDM_filter);
        $stmt_dm->execute();
        $dm_result = $stmt_dm->get_result();
        if ($dm_row = $dm_result->fetch_assoc()) {
            $tenDM_hien_tai = htmlspecialchars($dm_row['TenDM']);
        }
        $stmt_dm->close();
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

} else {
    die("Lỗi truy vấn SQL: " . $conn->error);
}

// Lưu ý: Đóng kết nối ở cuối file HTML
?>

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
            min-height: 100px;
            /* Chiều cao tối thiểu cho Quảng cáo nhỏ */
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

    <header class="bg-red-950 p-4 shadow-xl">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">

            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-red-700 rounded-full border-2 border-red-500">
                    <img src="/images/logo46shop.png" alt="logo" class="w-full h-full rounded-full object-cover">
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="block md:hidden text-white text-sm">
                        <span>Chào, <b><?php echo htmlspecialchars($_SESSION['user_id']); ?></b></span>
                        <a href="logout.php" class="ml-2 text-red-300 underline">Thoát</a>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="block md:hidden text-white font-semibold hover:text-red-300">
                        Đăng kí / Đăng nhập
                    </a>
                <?php endif; ?>
            </div>

            <div class="flex-grow max-w-xl mx-4 w-full md:w-auto">
                <div class="flex rounded-lg overflow-hidden shadow-inner bg-gray-300">
                    <input type="text" placeholder="Thanh tìm kiếm"
                        class="w-full p-3 text-lg bg-transparent focus:outline-none placeholder-gray-600 text-stone-900">
                    <button class="bg-stone-900 text-white p-3 px-6 hover:bg-stone-700 transition duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    <div class="w-10 bg-white border-l border-gray-400"></div>
                </div>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="hidden md:flex items-center text-white gap-4">
                    <div class="relative">
                        <a href="cart.php"
                            class="bg-yellow-500 text-stone-900 px-4 py-2 rounded font-bold hover:bg-yellow-400 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path
                                    d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            </svg>
                            Giỏ hàng
                        </a>
                    </div>
                    <span>Xin chào, <b
                            class="text-yellow-400"><?php echo htmlspecialchars($_SESSION['user_id']); ?></b></span>
                    <a href="logout.php"
                        class="p-2 border border-red-400 rounded-lg hover:bg-red-800 transition text-sm">Đăng xuất</a>
                </div>
            <?php else: ?>
                <a href="login.php"
                    class="hidden md:block text-white font-semibold hover:text-red-300 p-2 border border-white/20 rounded-lg transition duration-200">
                    Đăng kí / Đăng nhập
                </a>
            <?php endif; ?>

        </div>
    </header>

    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-[180px_1fr_200px] gap-4 p-4">

        <aside class="space-y-4 bg-red-950/90 p-4 rounded-xl md:p-0 md:bg-transparent">
            <nav class="space-y-3">
                <a href="index.php"
                    class="block bg-stone-700 text-white p-3 rounded-lg font-semibold hover:bg-stone-600 transition duration-150 shadow-md">
                    Tất Cả Sản Phẩm
                </a>
                <a href="index.php?MaDM=1"
                    class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Giày</a>
                <a href="index.php?MaDM=2"
                    class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Quần</a>
                <a href="index.php?MaDM=3"
                    class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Áo</a>
                <a href="index.php?MaDM=4"
                    class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Mũ</a>
                <a href="index.php?MaDM=5"
                    class="block bg-red-800 text-white p-3 rounded-lg font-semibold hover:bg-red-700 transition duration-150 shadow-md">Phụ
                    Kiện</a>
            </nav>

            <div class="pt-6 text-white text-sm">
                <p class="font-bold">Thông tin Liên Lạc</p>
                <p>0522 222 333</p>
            </div>
        </aside>

        <main class="space-y-4">
            <div
                class="bg-red-700 text-white p-12 text-center rounded-xl shadow-lg h-48 md:h-64 flex items-center justify-center">
                <p class="text-3xl font-bold">Quảng cáo Lớn</p>
            </div>

            <div class="bg-gray-200 p-6 rounded-xl shadow-inner space-y-6">
                <h2 class="text-2xl font-bold text-stone-800 mb-4 border-b-2 border-gray-400 pb-2">Các Sản Phẩm Nổi Bật
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    <?php
                    // 4. Kiểm tra và Lặp qua dữ liệu sản phẩm
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Lấy các giá trị cần thiết từ dòng dữ liệu
                            $ma_sp = htmlspecialchars($row['MaSP']);
                            $ten_sp = htmlspecialchars($row['TenSP']);
                            $gia_sp = number_format($row['Gia'], 0, ',', '.'); // Định dạng giá: 1.200.000
                            $hinh_anh_sp = htmlspecialchars($row['HinhAnh']);

                            // Bắt đầu cấu trúc HTML cho mỗi Product Card
                            echo '<div class="product-card bg-white rounded-xl overflow-hidden text-center">';
                            echo '    <div class="bg-green-600 text-white p-3 font-semibold text-lg">' . $ten_sp . '</div>';
                            echo '    <div class="p-4 space-y-3">';

                            // Placeholder cho Hình ảnh (GIỮ NGUYÊN CODE CỦA BẠN)
                            echo '        <div class="h-32 bg-white border border-gray-300 flex items-center justify-center rounded-lg">';
                            echo '            ';
                            echo "<img src='" . $hinh_anh_sp . "'alt='" . htmlspecialchars($ten_sp) . "'class='object-contain h-full w-full' >";
                            echo '        </div>';

                            // Giá tiền
                            echo '        <div class="bg-yellow-400 text-stone-800 font-bold p-1 rounded-md">Giá tiền: ' . $gia_sp . ' VNĐ</div>';

                            // Liên kết Xem chi tiết
                            echo '        <a href="product_detail.php?MaSP=' . htmlspecialchars($row['MaSP']) . '" class="text-red-700 font-semibold hover:text-red-900 underline">Xem chi tiết</a>';

                            echo '    </div>';
                            echo '</div>';
                        }
                    } else {
                        // Hiển thị nếu không có sản phẩm nào
                        echo '<div class="col-span-full text-center p-8 text-xl text-gray-600">Hiện tại không có sản phẩm nào nổi bật.</div>';
                    }
                    ?>
                </div>

                <p class="text-center text-stone-600 pt-6 italic text-lg">Shop quần áo gì cũng có mua hết ở đây</p>
            </div>
        </main>

        <aside class="space-y-4">
            <div
                class="ad-box bg-red-800 text-white p-4 text-center rounded-xl shadow-lg flex items-center justify-center h-32">
                <p class="font-semibold">Quảng cáo 1</p>
            </div>
            <div
                class="ad-box bg-red-800 text-white p-4 text-center rounded-xl shadow-lg flex items-center justify-center h-32">
                <p class="font-semibold">Quảng cáo 2</p>
            </div>
            <div class="hidden md:block ad-box bg-red-950/70 text-white p-4 text-center rounded-xl shadow-lg h-32">
                <p class="font-semibold">Quảng cáo 3</p>
            </div>
        </aside>
    </div>

    <footer class="bg-red-950 text-white text-center p-4 mt-6">
        <p>© 2025 Shop Đồ Thể Thao. Tất cả quyền được bảo lưu.</p>
    </footer>
</body>

</html>
<?php
// Đóng kết nối
$conn->close();
?>