<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration tạo bảng MatHang (Mặt Hàng).
 *
 * Cột: Id_MatHang (PK), Ten_MatHang, DonViTinh (nullable), DonGia, FK_Id_LoaiHang (FK).
 * FK_Id_LoaiHang liên kết tới bảng LoaiHang với onDelete('cascade'),
 * nghĩa là khi xóa một loại hàng thì tất cả mặt hàng thuộc loại đó cũng bị xóa.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('MatHang', function (Blueprint $table) {
            $table->id('Id_MatHang');
            $table->string('Ten_MatHang');
            $table->string('DonViTinh')->nullable();
            $table->decimal('DonGia', 18, 2);
            $table->unsignedBigInteger('FK_Id_LoaiHang');
            $table->foreign('FK_Id_LoaiHang')->references('Id_LoaiHang')->on('LoaiHang')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('MatHang');
    }
};
