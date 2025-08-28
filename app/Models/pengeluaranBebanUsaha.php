<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengeluaranBebanUsaha extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_beban_usahas';
    protected $primaryKey = 'id_pengeluaran_beban_usaha';
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
            $lastRecord = self::where('id_pengeluaran_beban_usaha', 'like', 'PB' . $date . '%')->orderBy('id_pengeluaran_beban_usaha', 'desc')->first();
            $number = $lastRecord ? intval(substr($lastRecord->id_pengeluaran_beban_usaha, 6)) + 1 : 1;
            $model->id_pengeluaran_beban_usaha = 'PB' . $date . str_pad($number, 4, '0', STR_PAD_LEFT);
        });
    }
}
