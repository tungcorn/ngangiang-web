# Quản lý Đơn Nhập Hàng — Ngân Giang Tech

> Bài test kỹ thuật trước phỏng vấn — Web Application

## Mô tả

Ứng dụng web quản lý đơn nhập hàng từ nhà cung cấp, bao gồm:
- Xem danh sách đơn nhập hàng (phân trang, hiển thị chi tiết)
- Tạo mới đơn nhập hàng (chọn NCC, thêm nhiều mặt hàng)

## Công nghệ sử dụng

- **Backend**: Laravel 11, PHP 8.2
- **Database**: SQL Server
- **Frontend**: Blade Templates, Bootstrap 5, Bootstrap Icons

## Cấu trúc CSDL

```
NCC (Id_NCC, Ten_NCC, DiaChi, Email)
LoaiHang (Id_LoaiHang, Name)
MatHang (Id_MatHang, Ten_MatHang, DonViTinh, DonGia, FK_Id_LoaiHang)
DonNhapHang (Id_DonNhapHang, FK_Id_NCC)
ChiTietDonNhap (FK_Id_DonNhapHang, FK_Id_MatHang, Count)  -- Composite PK
```

## Cài đặt & Chạy

```bash
# 1. Cài dependencies
composer install

# 2. Cấu hình file .env (database connection)
cp .env.example .env

# 3. Tạo bảng & dữ liệu mẫu
php artisan migrate --seed

# 4. Chạy server
php artisan serve
```

## Tác giả

**Ngô Quang Tùng** — Bài test kỹ thuật Ngân Giang
