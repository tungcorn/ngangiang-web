<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration tạo bảng NCC (Nhà Cung Cấp).
 *
 * Cột: Id_NCC (PK), Ten_NCC, DiaChi (nullable), Email (nullable).
 * DiaChi và Email nullable vì không phải NCC nào cũng cung cấp đầy đủ thông tin.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('NCC', function (Blueprint $table) {
            $table->id('Id_NCC');
            $table->string('Ten_NCC');
            $table->string('DiaChi')->nullable();
            $table->string('Email')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('NCC');
    }
};
