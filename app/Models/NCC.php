<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NCC extends Model
{
    /** @use HasFactory<\Database\Factories\NCCFactory> */
    use HasFactory;

    protected $table = 'NCC';
    protected $primaryKey = 'Id_NCC';
    protected $fillable = ['Ten_NCC', 'DiaChi', 'Email'];

    public function donNhapHangs()
    {
        return $this->hasMany(DonNhapHang::class, 'FK_Id_NCC', 'Id_NCC');
    }
}
