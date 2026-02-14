<?php

namespace Database\Factories;

use App\Models\NCC;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonNhapHang>
 */
class DonNhapHangFactory extends Factory
{
    public function definition(): array
    {
        return [
            'FK_Id_NCC' => NCC::factory(),
            'NgayNhap' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
