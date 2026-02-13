<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoaiHang>
 */
class LoaiHangFactory extends Factory
{
    public function definition(): array
    {
        return [
            'Name' => fake()->unique()->randomElement([
                'Điện tử',
                'Văn phòng phẩm',
                'Linh kiện máy tính',
                'Thiết bị mạng',
                'Phụ kiện',
            ]),
        ];
    }
}
