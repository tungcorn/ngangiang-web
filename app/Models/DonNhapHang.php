<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Đơn Nhập Hàng (header).
 *
 * Lưu thông tin đơn nhập hàng, liên kết tới Nhà cung cấp.
 * Quan hệ: Thuộc về 1 NCC (N-1), có nhiều Chi tiết đơn nhập (1-N).
 */
class DonNhapHang extends Model
{
    use HasFactory;

    protected $table = 'DonNhapHang';
    protected $primaryKey = 'Id_DonNhapHang';
    protected $fillable = ['FK_Id_NCC'];
    public $timestamps = false;

    /** Quan hệ N-1: Đơn nhập thuộc về một nhà cung cấp. */
    public function ncc()
    {
        return $this->belongsTo(NCC::class, 'FK_Id_NCC', 'Id_NCC');
    }

    /** Quan hệ 1-N: Một đơn nhập có nhiều dòng chi tiết mặt hàng. */
    public function chiTiet()
    {
        return $this->hasMany(ChiTietDonNhap::class, 'FK_Id_DonNhapHang', 'Id_DonNhapHang');
    }
}
