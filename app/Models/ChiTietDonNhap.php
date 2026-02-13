<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonNhap extends Model
{
    use HasFactory;

    protected $table = 'ChiTietDonNhap';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $fillable = ['FK_Id_DonNhapHang', 'FK_Id_MatHang', 'Count'];

    public function donNhapHang()
    {
        return $this->belongsTo(DonNhapHang::class, 'FK_Id_DonNhapHang', 'Id_DonNhapHang');
    }

    public function matHang()
    {
        return $this->belongsTo(MatHang::class, 'FK_Id_MatHang', 'Id_MatHang');
    }
}
