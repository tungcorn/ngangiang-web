-- ============================================
-- Script chèn dữ liệu mẫu
-- Bài test kỹ thuật - Ngân Giang
-- Tác giả: Ngô Quang Tùng
-- ============================================

USE QuanLyNhapHang;
GO

-- ============================================
-- 1. Dữ liệu Nhà Cung Cấp (NCC)
-- ============================================
INSERT INTO NCC (Ten_NCC, DiaChi, Email) VALUES
(N'Công ty TNHH Thiết bị Điện tử ABC', N'12 Trần Hưng Đạo, Q.1, TP.HCM', 'abc@email.com'),
(N'Công ty CP Công nghệ XYZ', N'45 Nguyễn Trãi, Q. Thanh Xuân, Hà Nội', 'xyz@email.com'),
(N'Công ty TNHH Thiết bị Văn phòng Minh Phát', N'78 Lê Lợi, Q. Hải Châu, Đà Nẵng', 'minhphat@email.com'),
(N'Công ty CP Phân phối Hàng Tiêu dùng Nam Việt', N'101 Láng Hạ, Q. Đống Đa, Hà Nội', 'namviet@email.com'),
(N'Công ty TNHH Linh kiện Máy tính Phong Vũ', N'256 Cách Mạng Tháng 8, Q.3, TP.HCM', 'phongvu@email.com');

-- ============================================
-- 2. Dữ liệu Loại Hàng (LoaiHang)
-- ============================================
INSERT INTO LoaiHang (Name) VALUES
(N'Điện tử'),
(N'Văn phòng phẩm'),
(N'Linh kiện máy tính'),
(N'Thiết bị mạng'),
(N'Phụ kiện');

-- ============================================
-- 3. Dữ liệu Mặt Hàng (MatHang)
-- ============================================
INSERT INTO MatHang (Ten_MatHang, DonViTinh, DonGia, FK_Id_LoaiHang) VALUES
-- Điện tử (LoaiHang Id = 1)
(N'Laptop Dell Inspiron 15', N'Cái', 15000000.00, 1),
(N'Màn hình Samsung 24 inch', N'Cái', 4500000.00, 1),
(N'Bàn phím cơ Logitech G413', N'Cái', 1800000.00, 1),
-- Văn phòng phẩm (LoaiHang Id = 2)
(N'Giấy A4 Double A', N'Ram', 85000.00, 2),
(N'Bút bi Thiên Long TL-027', N'Hộp', 45000.00, 2),
-- Linh kiện máy tính (LoaiHang Id = 3)
(N'RAM DDR4 8GB Kingston', N'Thanh', 650000.00, 3),
(N'SSD Samsung 500GB', N'Cái', 1200000.00, 3),
(N'Card màn hình GTX 1660 Super', N'Cái', 6500000.00, 3),
-- Thiết bị mạng (LoaiHang Id = 4)
(N'Router Wifi TP-Link Archer C6', N'Cái', 890000.00, 4),
(N'Switch 8 cổng TP-Link', N'Cái', 350000.00, 4),
-- Phụ kiện (LoaiHang Id = 5)
(N'Chuột không dây Logitech M331', N'Cái', 350000.00, 5),
(N'Tai nghe Sony WH-1000XM4', N'Cái', 5500000.00, 5);

GO
PRINT N'Chèn dữ liệu mẫu thành công!';
GO
