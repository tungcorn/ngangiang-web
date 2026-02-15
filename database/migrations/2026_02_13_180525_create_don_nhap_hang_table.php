<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration tạo bảng DonNhapHang (Đơn Nhập Hàng).
 *
 * Cột: Id_DonNhapHang (PK), FK_Id_NCC (FK).
 * Đây là bảng header của đơn nhập, chỉ lưu thông tin NCC.
 * Chi tiết mặt hàng được lưu trong bảng ChiTietDonNhap (quan hệ 1-N).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('DonNhapHang', function (Blueprint $table) {
            $table->id('Id_DonNhapHang');
            $table->unsignedBigInteger('FK_Id_NCC');
            $table->foreign('FK_Id_NCC')->references('Id_NCC')->on('NCC')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('DonNhapHang');
    }
};
