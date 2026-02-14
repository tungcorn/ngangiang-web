<?php

namespace Database\Seeders;

use App\Models\NCC;
use App\Models\LoaiHang;
use App\Models\DonNhapHang;
use App\Models\MatHang;
use App\Models\ChiTietDonNhap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo 5 Loại hàng, mỗi loại có 2 Mặt hàng
        LoaiHang::factory(5)->hasMatHangs(2)->create();

        // Tạo 5 NCC, mỗi NCC có 2 Đơn nhập hàng
        NCC::factory(5)->hasDonNhapHangs(2)->create();

        // Tạo chi tiết cho mỗi đơn hàng (lấy mặt hàng từ danh mục đã tạo)
        $matHangs = MatHang::all();
        DonNhapHang::all()->each(function ($don) use ($matHangs) {
            $selectedItems = $matHangs->random(rand(2, 4));
            foreach ($selectedItems as $mh) {
                ChiTietDonNhap::factory()->create([
                    'FK_Id_DonNhapHang' => $don->Id_DonNhapHang,
                    'FK_Id_MatHang' => $mh->Id_MatHang,
                ]);
            }
        });
    }
}
