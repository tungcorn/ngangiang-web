-- ============================================
-- Script tạo dữ liệu đơn hàng giả để TEST
-- CHỈ DÙNG ĐỂ TEST, KHÔNG NỘP FILE NÀY
-- ============================================

USE QuanLyNhapHang;
GO

-- Tạo 60 đơn nhập hàng giả
DECLARE @i INT = 1;
DECLARE @IdDonNhap INT;
DECLARE @IdNCC INT;
DECLARE @SoMatHang INT;
DECLARE @j INT;
DECLARE @IdMatHang INT;
DECLARE @SoLuong INT;

WHILE @i <= 60
BEGIN
    -- Chọn ngẫu nhiên một NCC
    SELECT TOP 1 @IdNCC = Id_NCC FROM NCC ORDER BY NEWID();
    
    -- Tạo đơn nhập hàng
    INSERT INTO DonNhapHang (FK_Id_NCC) VALUES (@IdNCC);
    SET @IdDonNhap = SCOPE_IDENTITY();
    
    -- Mỗi đơn có 2-5 mặt hàng ngẫu nhiên
    SET @SoMatHang = 2 + (@i % 4);
    SET @j = 1;
    
    WHILE @j <= @SoMatHang
    BEGIN
        -- Chọn ngẫu nhiên một mặt hàng (đảm bảo không trùng trong cùng đơn)
        SELECT TOP 1 @IdMatHang = Id_MatHang 
        FROM MatHang 
        WHERE Id_MatHang NOT IN (
            SELECT FK_Id_MatHang 
            FROM ChiTietDonNhap 
            WHERE FK_Id_DonNhapHang = @IdDonNhap
        )
        ORDER BY NEWID();
        
        -- Số lượng ngẫu nhiên từ 1-20
        SET @SoLuong = 1 + (@i * @j % 20);
        
        -- Thêm chi tiết đơn nhập
        INSERT INTO ChiTietDonNhap (FK_Id_DonNhapHang, FK_Id_MatHang, Count)
        VALUES (@IdDonNhap, @IdMatHang, @SoLuong);
        
        SET @j = @j + 1;
    END
    
    SET @i = @i + 1;
END

GO
PRINT N'Đã tạo 60 đơn nhập hàng giả để test!';
GO
