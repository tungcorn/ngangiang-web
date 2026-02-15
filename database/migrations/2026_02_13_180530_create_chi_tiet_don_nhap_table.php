<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration tạo bảng ChiTietDonNhap (Chi Tiết Đơn Nhập).
 *
 * Bảng trung gian lưu từng dòng mặt hàng trong đơn nhập hàng.
 * Sử dụng composite primary key (FK_Id_DonNhapHang + FK_Id_MatHang),
 * đảm bảo mỗi mặt hàng chỉ xuất hiện tối đa 1 lần trong 1 đơn nhập.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ChiTietDonNhap', function (Blueprint $table) {
            $table->unsignedBigInteger('FK_Id_DonNhapHang');
            $table->unsignedBigInteger('FK_Id_MatHang');
            $table->integer('Count');

            // Composite PK: mỗi mặt hàng chỉ xuất hiện 1 lần trong 1 đơn nhập
            $table->primary(['FK_Id_DonNhapHang', 'FK_Id_MatHang']);

            $table->foreign('FK_Id_DonNhapHang')->references('Id_DonNhapHang')->on('DonNhapHang')->onDelete('cascade');
            $table->foreign('FK_Id_MatHang')->references('Id_MatHang')->on('MatHang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ChiTietDonNhap');
    }
};
