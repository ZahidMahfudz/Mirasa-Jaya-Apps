<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataKaryawanBorongan extends Model
{
    use HasFactory;

    public $table = 'data_karyawan_borongans';
    protected $primaryKey = 'id_karyawan_borongan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [
        'id'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $lastKaryawan = self::where('id_karyawan_borongan', 'like', 'KRWB%')
                                ->orderBy('id_karyawan_borongan', 'desc')
                                ->first();

            $number = $lastKaryawan ? (int)substr($lastKaryawan->id_karyawan_borongan, 4) + 1 : 1;

            $model->id_karyawan_borongan = sprintf('KRWB%04d', $number);
        });
    }

    public function gajiKaryawanBorongan()
    {
        return $this->hasMany(GajiKaryawanBorongan::class, 'id_karyawan_borongan', 'id_karyawan_borongan');
    }
}
