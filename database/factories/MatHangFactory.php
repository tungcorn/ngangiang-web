<?php

namespace Database\Factories;

use App\Models\LoaiHang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MatHang>
 */
class MatHangFactory extends Factory
{
    public function definition(): array
    {
        return [
            'Ten_MatHang' => fake()->unique()->randomElement([
                'Laptop Dell Inspiron 15',
                'Màn hình Samsung 24 inch',
                'Bàn phím cơ Logitech G413',
                'Giấy A4 Double A',
                'Bút bi Thiên Long TL-027',
                'RAM DDR4 8GB Kingston',
                'SSD Samsung 500GB',
                'Card màn hình GTX 1660 Super',
                'Router Wifi TP-Link Archer C6',
                'Switch 8 cổng TP-Link',
                'Chuột không dây Logitech M331',
                'Tai nghe Sony WH-1000XM4',
            ]),
            'DonViTinh' => fake()->randomElement(['Cái', 'Hộp', 'Ram', 'Thanh']),
            'DonGia' => fake()->randomFloat(2, 50000, 15000000),
            'FK_Id_LoaiHang' => LoaiHang::factory(),
        ];
    }
}
