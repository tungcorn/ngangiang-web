<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NCC>
 */
class NCCFactory extends Factory
{
    public function definition(): array
    {
        return [
            'Ten_NCC' => 'Công ty ' . fake()->company(),
            'DiaChi' => fake()->address(),
            'Email' => fake()->unique()->safeEmail(),
        ];
    }
}
