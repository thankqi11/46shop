<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Hàng Thành Công</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #333; }
        .success-box { background-color: #e0e0e0; }
    </style>
</head>
<body class="min-h-screen bg-stone-900 flex items-center justify-center">

    <div class="success-box p-10 rounded-xl shadow-2xl w-full max-w-lg text-center">
        <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h1 class="text-3xl font-extrabold text-stone-800 mb-4">ĐẶT HÀNG THÀNH CÔNG!</h1>
        <p class="text-lg text-stone-600 mb-6">Cảm ơn bạn đã tin tưởng và mua sắm tại Shop Đồ Thể Thao. Chúng tôi sẽ liên hệ bạn sớm nhất để xác nhận đơn hàng.</p>
        
        <div class="space-y-3">
            <p class="text-sm font-medium">Mã đơn hàng của bạn (Mô phỏng): <span class="text-red-700 font-bold">#ORD<?php echo rand(100000, 999999); ?></span></p>
            <a href="index.php" class="inline-block bg-red-800 text-white font-semibold py-3 px-6 rounded-full shadow-lg hover:bg-red-700 transition duration-200">
                Tiếp tục mua sắm
            </a>
        </div>
    </div>

</body>
</html>
<?php
// Không cần thêm logic PHP nào khác ở đây.
?>