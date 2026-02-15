<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory tạo dữ liệu mẫu cho Loại Hàng.
 */
class LoaiHangFactory extends Factory
{
    /**
     * Định nghĩa dữ liệu mẫu cho Loại Hàng.
     *
     * Dùng danh sách cố định 5 loại hàng thực tế thay vì random text
     * để dữ liệu demo có ý nghĩa. unique() đảm bảo không tạo trùng loại.
     */
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
