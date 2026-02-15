<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory tạo dữ liệu mẫu cho Nhà Cung Cấp.
 */
class NCCFactory extends Factory
{
    /**
     * Định nghĩa dữ liệu mẫu cho NCC.
     *
     * Thêm prefix "Công ty" trước tên để tạo tên NCC thực tế hơn.
     * Email dùng unique() để tránh trùng lặp khi seed nhiều bản ghi.
     */
    public function definition(): array
    {
        return [
            'Ten_NCC' => 'Công ty ' . fake()->company(),
            'DiaChi' => fake()->address(),
            'Email' => fake()->unique()->safeEmail(),
        ];
    }
}
