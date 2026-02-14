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
