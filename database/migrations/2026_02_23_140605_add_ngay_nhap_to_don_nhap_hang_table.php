<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Migration thêm cột NgayNhap vào bảng DonNhapHang.
 *
 * Dữ liệu cũ (chưa có NgayNhap) sẽ được gán ngày hiện tại làm giá trị mặc định.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('DonNhapHang', function (Blueprint $table) {
            $table->date('NgayNhap')->default(DB::raw('GETDATE()'))->after('FK_Id_NCC');
        });

        Schema::table('DonNhapHang', function (Blueprint $table) {
            $table->date('NgayNhap')->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('DonNhapHang', function (Blueprint $table) {
            $table->dropColumn('NgayNhap');
        });
    }
};
