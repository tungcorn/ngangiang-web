<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ChiTietDonNhap', function (Blueprint $table) {
            $table->unsignedBigInteger('FK_Id_DonNhapHang');
            $table->unsignedBigInteger('FK_Id_MatHang');
            $table->integer('Count');
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
