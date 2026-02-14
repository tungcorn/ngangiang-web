<?php

namespace Database\Factories;

use App\Models\DonNhapHang;
use App\Models\MatHang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChiTietDonNhap>
 */
class ChiTietDonNhapFactory extends Factory
{
    public function definition(): array
    {
        return [
            'FK_Id_DonNhapHang' => DonNhapHang::factory(),
            'FK_Id_MatHang' => MatHang::factory(),
            'Count' => fake()->numberBetween(1, 50),
        ];
    }
}
