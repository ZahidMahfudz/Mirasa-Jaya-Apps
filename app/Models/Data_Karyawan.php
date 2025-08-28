<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_Karyawan extends Model
{
    use HasFactory;

    public $table = 'data__karyawans';
    protected $primaryKey = 'id_karyawan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [
        'id'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $lastKaryawan = self::where('id_karyawan', 'like', 'KRWN%')
                                ->orderBy('id_karyawan', 'desc')
                                ->first();

            $number = $lastKaryawan ? (int)substr($lastKaryawan->id_karyawan, 4) + 1 : 1;

            $model->id_karyawan = sprintf('KRWN%04d', $number);
        });
    }

    public function gajiKaryawan()
    {
        return $this->hasMany(GajiKaryawan::class, 'id_karyawan', 'id_karyawan');
    }
}
