<?php

namespace Database\Seeders;

use App\Models\NCC;
use App\Models\LoaiHang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Tạo 5 Loại hàng, mỗi loại có 2 Mặt hàng
        LoaiHang::factory(5)->hasMatHangs(2)->create();

        // Tạo 5 NCC
        NCC::factory(5)->create();
    }
}
