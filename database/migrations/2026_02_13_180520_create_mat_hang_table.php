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
        Schema::create('MatHang', function (Blueprint $table) {
            $table->id('Id_MatHang');
            $table->string('Ten_MatHang');
            $table->string('DonViTinh')->nullable();
            $table->decimal('DonGia', 18, 2);
            $table->unsignedBigInteger('FK_Id_LoaiHang');
            $table->foreign('FK_Id_LoaiHang')->references('Id_LoaiHang')->on('LoaiHang')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('MatHang');
    }
};
