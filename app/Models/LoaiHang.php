<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Loại Hàng.
 *
 * Phân loại mặt hàng theo nhóm (VD: Điện tử, Văn phòng phẩm, ...).
 * Quan hệ: Một loại hàng chứa nhiều mặt hàng (1-N).
 */
class LoaiHang extends Model
{
    use HasFactory;

    protected $table = 'LoaiHang';
    protected $primaryKey = 'Id_LoaiHang';
    protected $fillable = ['Name'];
    public $timestamps = false;

    /** Quan hệ 1-N: Một loại hàng có nhiều mặt hàng. */
    public function matHangs()
    {
        return $this->hasMany(MatHang::class, 'FK_Id_LoaiHang', 'Id_LoaiHang');
    }
}
