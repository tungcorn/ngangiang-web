<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Nhà Cung Cấp (NCC).
 *
 * Lưu trữ thông tin nhà cung cấp: tên, địa chỉ, email.
 * Quan hệ: Một NCC có nhiều Đơn nhập hàng (1-N).
 */
class NCC extends Model
{
    /** @use HasFactory<\Database\Factories\NCCFactory> */
    use HasFactory;

    protected $table = 'NCC';
    protected $primaryKey = 'Id_NCC';
    protected $fillable = ['Ten_NCC', 'DiaChi', 'Email'];
    public $timestamps = false;

    /** Quan hệ 1-N: Một NCC có nhiều đơn nhập hàng. */
    public function donNhapHangs()
    {
        return $this->hasMany(DonNhapHang::class, 'FK_Id_NCC', 'Id_NCC');
    }
}
