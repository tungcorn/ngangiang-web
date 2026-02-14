<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonNhapHang extends Model
{
    use HasFactory;

    protected $table = 'DonNhapHang';
    protected $primaryKey = 'Id_DonNhapHang';
    protected $fillable = ['FK_Id_NCC'];
    public $timestamps = false;

    public function ncc()
    {
        return $this->belongsTo(NCC::class, 'FK_Id_NCC', 'Id_NCC');
    }

    public function chiTiet()
    {
        return $this->hasMany(ChiTietDonNhap::class, 'FK_Id_DonNhapHang', 'Id_DonNhapHang');
    }
}
