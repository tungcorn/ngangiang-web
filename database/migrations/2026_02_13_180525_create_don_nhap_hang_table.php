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
        Schema::create('DonNhapHang', function (Blueprint $table) {
            $table->id('Id_DonNhapHang');
            $table->unsignedBigInteger('FK_Id_NCC');
            $table->foreign('FK_Id_NCC')->references('Id_NCC')->on('NCC')->onDelete('cascade');
            $table->timestamp('NgayNhap')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('DonNhapHang');
    }
};
