<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiKaryawan extends Model
{
    use HasFactory;

    public $table = 'gaji_karyawans';

    protected $primaryKey = 'id_gaji';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [
        'id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $date = now()->format('dm');
            $lastRecord = self::where('id_gaji', 'like', 'GJ' . $date . '%')->orderBy('id_gaji', 'desc')->first();
            $number = $lastRecord ? intval(substr($lastRecord->id_gaji, 6)) + 1 : 1;
            $model->id_gaji = 'GJ' . $date . str_pad($number, 4, '0', STR_PAD_LEFT);
        });
    }

    public function dataKaryawan()
    {
        return $this->belongsTo(Data_Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

}
