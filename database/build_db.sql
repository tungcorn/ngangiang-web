-- ============================================
-- Script tạo Database và các bảng
-- Bài test kỹ thuật - Ngân Giang
-- Tác giả: Ngô Quang Tùng
-- ============================================

-- Tạo Database
CREATE DATABASE QuanLyNhapHang;
GO
USE QuanLyNhapHang;
GO

-- ============================================
-- 1. Bảng Nhà Cung Cấp (NCC)
-- ============================================
CREATE TABLE NCC (
    Id_NCC INT PRIMARY KEY IDENTITY(1,1),
    Ten_NCC NVARCHAR(255) NOT NULL,
    DiaChi NVARCHAR(500),
    Email VARCHAR(100)
);

-- ============================================
-- 2. Bảng Loại Hàng (LoaiHang)
-- ============================================
CREATE TABLE LoaiHang (
    Id_LoaiHang INT PRIMARY KEY IDENTITY(1,1),
    Name NVARCHAR(100) NOT NULL
);

-- ============================================
-- 3. Bảng Mặt Hàng (MatHang)
-- ============================================
CREATE TABLE MatHang (
    Id_MatHang INT PRIMARY KEY IDENTITY(1,1),
    Ten_MatHang NVARCHAR(255) NOT NULL,
    DonViTinh NVARCHAR(50),
    DonGia DECIMAL(18, 2),
    FK_Id_LoaiHang INT,
    CONSTRAINT FK_MatHang_LoaiHang FOREIGN KEY (FK_Id_LoaiHang) REFERENCES LoaiHang(Id_LoaiHang)
);

-- ============================================
-- 4. Bảng Đơn Nhập Hàng (DonNhapHang)
-- ============================================
CREATE TABLE DonNhapHang (
    Id_DonNhapHang INT PRIMARY KEY IDENTITY(1,1),
    NgayNhap DATETIME DEFAULT GETDATE(),
    FK_Id_NCC INT NOT NULL,
    CONSTRAINT FK_DonNhap_NCC FOREIGN KEY (FK_Id_NCC) REFERENCES NCC(Id_NCC)
);

-- ============================================
-- 5. Bảng Chi Tiết Đơn Nhập Hàng (ChiTietDonNhap)
-- ============================================
CREATE TABLE ChiTietDonNhap (
    FK_Id_DonNhapHang INT NOT NULL,
    FK_Id_MatHang INT NOT NULL,
    Count INT NOT NULL CHECK (Count > 0),
    CONSTRAINT PK_ChiTietDonNhap PRIMARY KEY (FK_Id_DonNhapHang, FK_Id_MatHang),
    CONSTRAINT FK_ChiTiet_DonNhap FOREIGN KEY (FK_Id_DonNhapHang) REFERENCES DonNhapHang(Id_DonNhapHang),
    CONSTRAINT FK_ChiTiet_MatHang FOREIGN KEY (FK_Id_MatHang) REFERENCES MatHang(Id_MatHang)
);

GO
PRINT N'Tạo Database và các bảng thành công!';
GO
