<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration tạo bảng LoaiHang (Loại Hàng).
 *
 * Cột: Id_LoaiHang (PK), Name.
 * Dùng để phân loại mặt hàng theo nhóm (VD: Điện tử, Văn phòng phẩm).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('LoaiHang', function (Blueprint $table) {
            $table->id('Id_LoaiHang');
            $table->string('Name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('LoaiHang');
    }
};
