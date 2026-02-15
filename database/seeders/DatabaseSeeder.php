<?php

namespace Database\Seeders;

use App\Models\NCC;
use App\Models\LoaiHang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder tạo dữ liệu mẫu cho ứng dụng.
 *
 * Tạo dữ liệu NCC, Loại hàng, và Mặt hàng bằng Factory
 * để có sẵn dữ liệu demo khi chạy `php artisan migrate --seed`.
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Chạy seeder tạo dữ liệu mẫu.
     *
     * Thứ tự: Tạo Loại hàng trước, sau đó dùng hasMatHangs() để auto-create
     * Mặt hàng liên kết. Cuối cùng tạo NCC độc lập (không phụ thuộc bảng khác).
     */
    public function run(): void
    {
        // Tạo 5 Loại hàng, mỗi loại có 2 Mặt hàng (tổng 10 mặt hàng)
        LoaiHang::factory(5)->hasMatHangs(2)->create();

        // Tạo 5 Nhà cung cấp
        NCC::factory(5)->create();
    }
}
