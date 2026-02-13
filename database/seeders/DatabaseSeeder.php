<?php

namespace Database\Seeders;

use App\Models\NCC;
use App\Models\LoaiHang;
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
        // Tạo 5 NCC
        NCC::factory(5)->create();

        // Tạo 5 LoaiHang, mỗi loại có 2 MatHang
        LoaiHang::factory(5)->hasMatHangs(2)->create();
    }
}
