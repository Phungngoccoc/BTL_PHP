-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 16, 2024 lúc 05:31 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlyhanghoa`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `MADONHANG` varchar(5) NOT NULL,
  `MAHANG` varchar(5) NOT NULL,
  `TENKHACHHANG` varchar(255) DEFAULT NULL,
  `SOLUONG` int(11) DEFAULT NULL,
  `DIACHIDONHANG` varchar(100) DEFAULT NULL,
  `TRANGTHAI` varchar(50) DEFAULT NULL,
  `NGAYDATHANG` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`MADONHANG`, `MAHANG`, `TENKHACHHANG`, `SOLUONG`, `DIACHIDONHANG`, `TRANGTHAI`, `NGAYDATHANG`) VALUES
('DH001', 'HH01', 'Khách hàng A', 2, 'Địa chỉ A', 'Chưa xử lý', '0000-00-00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hanghoa`
--

CREATE TABLE `hanghoa` (
  `MAHANG` varchar(5) NOT NULL,
  `TENHANG` varchar(255) NOT NULL,
  `DONGIA` decimal(10,2) NOT NULL,
  `DONVITINH` varchar(255) DEFAULT NULL,
  `SOLUONG` int(11) DEFAULT NULL,
  `MANCC` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hanghoa`
--

INSERT INTO `hanghoa` (`MAHANG`, `TENHANG`, `DONGIA`, `DONVITINH`, `SOLUONG`, `MANCC`) VALUES
('HH01', 'IPHONE 15 PROMAX', 30000000.00, 'cái', 100, 'NCC02'),
('HH02', 'TỦ LẠNH', 15000000.00, 'cái', 200, 'NCC02'),
('HH03', 'Hàng hóa 3', 20000.00, 'kg', 150, 'NCC03'),
('HH04', 'Hàng hóa 4', 25000.00, 'líty', 80, 'NCC04'),
('HH05', 'Hàng hóa 5', 30000.00, 'cm', 50, 'NCC05'),
('HH06', 'Hàng hóa 6', 12000.00, 'mét', 60, 'NCC01'),
('HH07', 'Hàng hóa 7', 18000.00, 'cái', 90, 'NCC02'),
('HH08', 'Hàng hóa 8', 22000.00, 'kg', 110, 'NCC03'),
('HH09', 'Hàng hóa 9', 27000.00, 'lít', 75, 'NCC04'),
('HH10', 'Hàng hóa 10', 32000.00, 'mg', 65, 'NCC05'),
('HH11', 'Hàng hóa 20', 33000.00, 'cm', 45, 'NCC05'),
('HH12', 'IPHONE 15 PROMAX', 30000000.00, 'cái', 100, 'NCC02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhacungcap`
--

CREATE TABLE `nhacungcap` (
  `MANCC` varchar(5) NOT NULL,
  `TENNCC` varchar(255) NOT NULL,
  `DIACHINCC` varchar(255) NOT NULL,
  `Email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhacungcap`
--

INSERT INTO `nhacungcap` (`MANCC`, `TENNCC`, `DIACHINCC`, `Email`) VALUES
('NCC01', 'Sony', 'Hà Nội', ''),
('NCC02', 'Apple', 'Hà Nam', ''),
('NCC03', 'Toshiba', 'Thái Nguyên', ''),
('NCC04', 'Yamaha', 'Hải Dương', ''),
('NCC05', 'HP', 'PHÚ THỌ', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `MATK` varchar(5) NOT NULL,
  `TENTK` varchar(255) NOT NULL,
  `MATKHAU` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`MATK`, `TENTK`, `MATKHAU`) VALUES
('TK001', 'admin', '123456');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`MADONHANG`),
  ADD KEY `FK_DH_HH` (`MAHANG`);

--
-- Chỉ mục cho bảng `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD PRIMARY KEY (`MAHANG`),
  ADD KEY `FK_HH_NCC` (`MANCC`);

--
-- Chỉ mục cho bảng `nhacungcap`
--
ALTER TABLE `nhacungcap`
  ADD PRIMARY KEY (`MANCC`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`MATK`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `FK_DH_HH` FOREIGN KEY (`MAHANG`) REFERENCES `hanghoa` (`MAHANG`);

--
-- Các ràng buộc cho bảng `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD CONSTRAINT `FK_HH_NCC` FOREIGN KEY (`MANCC`) REFERENCES `nhacungcap` (`MANCC`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
