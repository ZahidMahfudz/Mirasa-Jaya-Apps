<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gajiKaryawanBorongan extends Model
{
    use HasFactory;

    public $table = 'gaji_karyawan_borongans';
    protected $primaryKey = 'id_gaji_borongan';
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
            $lastRecord = self::where('id_gaji_borongan', 'like', 'GJ' . $date . '%')->orderBy('id_gaji_borongan', 'desc')->first();
            $number = $lastRecord ? intval(substr($lastRecord->id_gaji_borongan, 6)) + 1 : 1;
            $model->id_gaji_borongan = 'GJ' . $date . str_pad($number, 4, '0', STR_PAD_LEFT);
        });
    }

    public function dataKaryawanBorongan()
    {
        return $this->belongsTo(dataKaryawanBorongan::class, 'id_karyawan_borongan', 'id_karyawan_borongan');
    }
}
