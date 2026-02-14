<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiHang extends Model
{
    use HasFactory;

    protected $table = 'LoaiHang';
    protected $primaryKey = 'Id_LoaiHang';
    protected $fillable = ['Name'];
    public $timestamps = false;

    public function matHangs()
    {
        return $this->hasMany(MatHang::class, 'FK_Id_LoaiHang', 'Id_LoaiHang');
    }
}
