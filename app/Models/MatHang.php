<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatHang extends Model
{
    use HasFactory;

    protected $table = 'MatHang';
    protected $primaryKey = 'Id_MatHang';
    protected $fillable = ['Ten_MatHang', 'DonViTinh', 'DonGia', 'FK_Id_LoaiHang'];
    public $timestamps = false;

    public function loaiHang()
    {
        return $this->belongsTo(LoaiHang::class, 'FK_Id_LoaiHang', 'Id_LoaiHang');
    }

    public function chiTietDonNhaps()
    {
        return $this->hasMany(ChiTietDonNhap::class, 'FK_Id_MatHang', 'Id_MatHang');
    }
}
