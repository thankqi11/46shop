-- phpMyAdmin SQL Dump
-- version 5.2.1
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2025
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `46shop_db`
--
CREATE DATABASE IF NOT EXISTS `46shop_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `46shop_db`;

-- --------------------------------------------------------

--
-- 1. Bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `MaDM` int(11) NOT NULL,
  `TenDM` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `danhmuc` (`MaDM`, `TenDM`) VALUES
(1, 'Giày'),
(2, 'Quần'),
(3, 'Áo'),
(4, 'Mũ'),
(5, 'Phụ kiện');

-- --------------------------------------------------------

--
-- 2. Bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(100) NOT NULL,
  `MaDM` int(11) NOT NULL,
  `Gia` decimal(10,2) NOT NULL CHECK (`Gia` >= 0),
  `ChiTietSP` text DEFAULT NULL,
  `TrangThai` tinyint(1) DEFAULT 1,
  `HinhAnh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `MaDM`, `Gia`, `ChiTietSP`, `TrangThai`, `HinhAnh`) VALUES
(101, 'Áo Thun Cotton Trắng', 3, 150000.00, 'Áo thun 100% cotton, thoáng mát', 1, '/images/101.jpg'),
(102, 'Quần thể thao', 2, 120000.00, 'Chất liệu thun lạnh co giãn', 1, '/images/102.jpg'),
(103, 'Giày Chạy Bộ', 1, 1200000.00, 'Đế đệm khí, phù hợp chạy bộ đường dài', 1, '/images/103.jpg'),
(104, 'Găng Tay Tập Gym Pro', 5, 180000.00, 'Chống trượt, bảo vệ cổ tay', 1, '/images/104.jpg'),
(105, 'Quần giữ nhiệt', 2, 150000.00, 'Kết cấu dày dặn, giữ ấm tốt', 1, '/images/105.jpg'),
(106, 'Áo ba lỗ', 3, 100000.00, 'Thiết kế hiện đại, năng động, với vải cotton', 1, '/images/106.jpg'),
(107, 'Mũ lưỡi trai chạy bộ', 4, 55000.00, 'Thiết kế thời trang với các lỗ thoáng khí', 1, '/images/107.jpg'),
(108, 'Túi Đeo Chéo', 5, 320000.00, 'Chất liệu vải dù chống nước, đựng các đồ dùng thể thao', 0, '/images/108.jpg'),
(109, 'Tất thể thao', 5, 25000.00, 'Chất liệu vải cotton thoáng khí', 1, '/images/109.jpg'),
(110, 'Giày cầu lông', 1, 250000.00, 'Thời trang, bền bỉ nhờ gia công chắc chắn', 1, '/images/110.jpg');

-- --------------------------------------------------------

--
-- 3. Bảng `kho`
--

CREATE TABLE `kho` (
  `MaKho` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `Size` varchar(10) NOT NULL,
  `Mau` varchar(30) NOT NULL,
  `SoLuong` int(11) NOT NULL CHECK (`SoLuong` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `kho` (`MaKho`, `MaSP`, `Size`, `Mau`, `SoLuong`) VALUES
(1, 101, 'M', 'Trắng', 50),
(2, 101, 'L', 'Trắng', 45),
(3, 101, 'M', 'Đen', 30),
(4, 102, '30', 'Xanh Đậm', 25),
(5, 102, '32', 'Xanh Đậm', 20),
(6, 103, '40', 'Đỏ', 15),
(7, 103, '41', 'Đỏ', 10),
(8, 107, 'L', 'Xám', 40),
(9, 109, 'One Size', 'Bạc', 5),
(10, 110, 'One Size', 'Đen', 55);

-- --------------------------------------------------------

--
-- 4. Bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MaKH` int(11) NOT NULL,
  `Ten` varchar(100) NOT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `SDT` varchar(20) DEFAULT NULL,
  `DiaChi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `khachhang` (`MaKH`, `Ten`, `Email`, `SDT`, `DiaChi`) VALUES
(1, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '0901234567', '123 Đường Trần Phú, Quận 1, TP.HCM'),
(2, 'Trần Thị B', 'tranthib@hotmail.com', '0902345678', '45 Hẻm 5, Đường Lạc Long Quân, Hà Nội'),
(3, 'Lê Văn C', 'levanc@yahoo.com', '0903456789', '67 Phố Kim Mã, Ba Đình, Hà Nội'),
(4, 'Phạm Thị D', 'phamd@gmail.com', '0904567890', '89/10 Đường 3/2, Quận 10, TP.HCM'),
(5, 'Hoàng Văn E', 'hoange@vnn.vn', '0905678901', '112 Khu Phố Mới, Đà Nẵng'),
(6, 'Vũ Thị F', 'vuf@gmail.com', '0906789012', '345 Đường Lý Thường Kiệt, Huế'),
(7, 'Đỗ Văn G', 'dog@fpt.vn', '0907890123', '78/9 Đường Nguyễn Huệ, Quận 1, TP.HCM'),
(8, 'Mai Thị H', 'maih@outlook.com', '0908901234', '15 Ngõ 20, Đường Quang Trung, Hà Đông'),
(9, 'Đặng Văn I', 'dangi@gmail.com', '0909012345', '99 Đường Hai Bà Trưng, Quận 3, TP.HCM'),
(10, 'Bùi Thị K', 'buik@gmail.com', '0910123456', '50/2 Ngõ 8, Đường Phạm Văn Đồng, Thủ Đức');

-- --------------------------------------------------------

--
-- 5. Bảng `taikhoan` (Đã thêm cột SoDienThoai)
--

CREATE TABLE `taikhoan` (
  `TenDangNhap` varchar(50) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `SoDienThoai` varchar(20) DEFAULT NULL,
  `PhanQuyen` varchar(10) DEFAULT 'user' COMMENT 'admin hoặc user',
  `TrangThai` tinyint(1) DEFAULT 1 COMMENT '1: Active, 0: Ban',
  `MaKH` int(11) DEFAULT NULL COMMENT 'Null nếu là Admin thuần túy'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dữ liệu mẫu (SDT khớp với bảng khách hàng)
INSERT INTO `taikhoan` (`TenDangNhap`, `MatKhau`, `SoDienThoai`, `PhanQuyen`, `TrangThai`, `MaKH`) VALUES
('admin', '123456', '0900000000', 'admin', 1, NULL),
('nguyenvana', '123456', '0901234567', 'user', 1, 1),
('tranthib', '123456', '0902345678', 'user', 1, 2),
('levanc', '123456', '0903456789', 'user', 1, 3);

-- --------------------------------------------------------

--
-- 6. Bảng `donhang`
--

CREATE TABLE `donhang` (
  `MaDH` int(11) NOT NULL,
  `MaKH` int(11) NOT NULL,
  `NgayDat` datetime DEFAULT current_timestamp(),
  `TongTien` decimal(10,2) NOT NULL DEFAULT 0.00,
  `TrangThaiDonHang` varchar(50) DEFAULT 'Chờ xử lý',
  `DiaChiGiaoHang` varchar(255) NOT NULL,
  `SDT_NguoiNhan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `donhang` (`MaDH`, `MaKH`, `NgayDat`, `TongTien`, `TrangThaiDonHang`, `DiaChiGiaoHang`, `SDT_NguoiNhan`) VALUES
(1, 1, '2025-11-15 10:00:00', 480000.00, 'Hoàn thành', '123 Đường Trần Phú, Quận 1, TP.HCM', '0901234567'),
(2, 2, '2025-11-16 14:30:00', 1200000.00, 'Đang giao', '45 Hẻm 5, Đường Lạc Long Quân, Hà Nội', '0902345678'),
(3, 4, '2025-11-17 09:00:00', 550000.00, 'Chờ xử lý', '89/10 Đường 3/2, Quận 10, TP.HCM', '0904567890'),
(4, 1, '2025-11-17 11:00:00', 998000.00, 'Hoàn thành', '123 Đường Trần Phú, Quận 1, TP.HCM', '0901234567'),
(5, 3, '2025-11-18 16:20:00', 2500000.00, 'Chờ xử lý', '67 Phố Kim Mã, Ba Đình, Hà Nội', '0903456789'),
(6, 5, '2025-11-18 17:00:00', 650000.00, 'Hoàn thành', '112 Khu Phố Mới, Đà Nẵng', '0905678901'),
(7, 8, '2025-11-19 08:30:00', 400000.00, 'Đang giao', '15 Ngõ 20, Đường Quang Trung, Hà Đông', '0908901234'),
(8, 10, '2025-11-19 09:15:00', 750000.00, 'Chờ xử lý', '50/2 Ngõ 8, Đường Phạm Văn Đồng, Thủ Đức', '0910123456'),
(9, 6, '2025-11-19 12:00:00', 150000.00, 'Chờ xử lý', '345 Đường Lý Thường Kiệt, Huế', '0906789012'),
(10, 7, '2025-11-19 15:45:00', 0.00, 'Chờ xử lý', '78/9 Đường Nguyễn Huệ, Quận 1, TP.HCM', '0907890123');

-- --------------------------------------------------------

--
-- 7. Bảng `chitietdonhang`
--

CREATE TABLE `chitietdonhang` (
  `MaDonChiTiet` int(11) NOT NULL,
  `MaDH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL CHECK (`SoLuong` > 0),
  `Size` varchar(10) NOT NULL,
  `Mau` varchar(30) NOT NULL,
  `DonGia` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `chitietdonhang` (`MaDonChiTiet`, `MaDH`, `MaSP`, `SoLuong`, `Size`, `Mau`, `DonGia`) VALUES
(1, 1, 101, 2, 'M', 'Trắng', 150000.00),
(2, 1, 104, 1, 'One Size', 'Đen', 180000.00),
(3, 2, 103, 1, '40', 'Đỏ', 1200000.00),
(4, 3, 107, 1, 'L', 'Xám', 550000.00),
(5, 4, 102, 2, '30', 'Xanh Đậm', 499000.00),
(6, 5, 109, 1, 'One Size', 'Bạc', 2500000.00),
(7, 6, 106, 1, 'M', 'Hoa Nhí', 650000.00),
(8, 7, 105, 5, 'L', 'Đen', 80000.00),
(9, 8, 110, 3, 'One Size', 'Đen', 250000.00),
(10, 9, 101, 1, 'L', 'Đen', 150000.00);

-- --------------------------------------------------------

--
-- 8. bảng giỏ hàng
--
CREATE TABLE `giohang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MaKH` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `Size` varchar(10) NOT NULL,
  `Mau` varchar(30) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_GioHang_KhachHang` (`MaKH`),
  KEY `FK_GioHang_SanPham` (`MaSP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- CẤU HÌNH KHÓA (INDEXES)
-- --------------------------------------------------------

ALTER TABLE `danhmuc` ADD PRIMARY KEY (`MaDM`);

ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`),
  ADD KEY `FK_SanPham_DanhMuc` (`MaDM`);

ALTER TABLE `kho`
  ADD PRIMARY KEY (`MaKho`),
  ADD UNIQUE KEY `UQ_Kho_SanPham_Variant` (`MaSP`,`Size`,`Mau`);

ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MaKH`),
  ADD UNIQUE KEY `Email` (`Email`);

-- Cập nhật Index cho bảng Tài khoản: Thêm Unique cho SoDienThoai
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`TenDangNhap`),
  ADD UNIQUE KEY `UQ_TaiKhoan_SDT` (`SoDienThoai`),
  ADD KEY `FK_TaiKhoan_KhachHang` (`MaKH`);

ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MaDH`),
  ADD KEY `FK_DonHang_KhachHang` (`MaKH`);

ALTER TABLE `chitietdonhang`
  ADD PRIMARY KEY (`MaDonChiTiet`),
  ADD KEY `FK_ChiTiet_DonHang` (`MaDH`),
  ADD KEY `FK_ChiTiet_SanPham` (`MaSP`);

-- --------------------------------------------------------
-- CẤU HÌNH AUTO INCREMENT
-- --------------------------------------------------------

ALTER TABLE `danhmuc` MODIFY `MaDM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `sanpham` MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
ALTER TABLE `kho` MODIFY `MaKho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `khachhang` MODIFY `MaKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `donhang` MODIFY `MaDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `chitietdonhang` MODIFY `MaDonChiTiet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

-- --------------------------------------------------------
-- CẤU HÌNH RÀNG BUỘC KHÓA NGOẠI (CONSTRAINTS)
-- --------------------------------------------------------

ALTER TABLE `sanpham`
  ADD CONSTRAINT `FK_SanPham_DanhMuc` FOREIGN KEY (`MaDM`) REFERENCES `danhmuc` (`MaDM`) ON UPDATE CASCADE;

ALTER TABLE `kho`
  ADD CONSTRAINT `FK_Kho_SanPham` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `taikhoan`
  ADD CONSTRAINT `FK_TaiKhoan_KhachHang` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `donhang`
  ADD CONSTRAINT `FK_DonHang_KhachHang` FOREIGN KEY (`MaKH`) REFERENCES `khachhang` (`MaKH`) ON UPDATE CASCADE;

ALTER TABLE `chitietdonhang`
  ADD CONSTRAINT `FK_ChiTiet_DonHang` FOREIGN KEY (`MaDH`) REFERENCES `donhang` (`MaDH`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ChiTiet_SanPham` FOREIGN KEY (`MaSP`) REFERENCES `sanpham` (`MaSP`) ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;