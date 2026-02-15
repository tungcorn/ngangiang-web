<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Chi Tiết Đơn Nhập (bảng trung gian).
 *
 * Lưu từng dòng mặt hàng trong đơn nhập hàng kèm số lượng.
 * Bảng này dùng composite primary key (FK_Id_DonNhapHang + FK_Id_MatHang),
 * nên phải tắt auto-increment và đặt primaryKey = null.
 *
 * Quan hệ: Thuộc về 1 Đơn nhập (N-1) và 1 Mặt hàng (N-1).
 */
class ChiTietDonNhap extends Model
{
    use HasFactory;

    protected $table = 'ChiTietDonNhap';

    // Composite PK: Laravel không hỗ trợ sẵn composite key,
    // nên tắt auto-increment và đặt primaryKey = null.
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = ['FK_Id_DonNhapHang', 'FK_Id_MatHang', 'Count'];
    public $timestamps = false;

    /** Quan hệ N-1: Chi tiết thuộc về một đơn nhập hàng. */
    public function donNhapHang()
    {
        return $this->belongsTo(DonNhapHang::class, 'FK_Id_DonNhapHang', 'Id_DonNhapHang');
    }

    /** Quan hệ N-1: Chi tiết liên kết tới một mặt hàng cụ thể. */
    public function matHang()
    {
        return $this->belongsTo(MatHang::class, 'FK_Id_MatHang', 'Id_MatHang');
    }
}
