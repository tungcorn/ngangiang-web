<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Mặt Hàng.
 *
 * Danh mục sản phẩm với thông tin: tên, đơn vị tính, đơn giá.
 * Quan hệ: Thuộc về một Loại hàng (N-1), có nhiều Chi tiết đơn nhập (1-N).
 */
class MatHang extends Model
{
    use HasFactory;

    protected $table = 'MatHang';
    protected $primaryKey = 'Id_MatHang';
    protected $fillable = ['Ten_MatHang', 'DonViTinh', 'DonGia', 'FK_Id_LoaiHang'];
    public $timestamps = false;

    /** Quan hệ N-1: Mặt hàng thuộc về một loại hàng. */
    public function loaiHang()
    {
        return $this->belongsTo(LoaiHang::class, 'FK_Id_LoaiHang', 'Id_LoaiHang');
    }

    /** Quan hệ 1-N: Một mặt hàng xuất hiện trong nhiều chi tiết đơn nhập. */
    public function chiTietDonNhaps()
    {
        return $this->hasMany(ChiTietDonNhap::class, 'FK_Id_MatHang', 'Id_MatHang');
    }
}
