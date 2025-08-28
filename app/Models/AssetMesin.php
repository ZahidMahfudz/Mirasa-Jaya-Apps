<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMesin extends Model
{
    use HasFactory;
    protected $fillable = [
        'mesin/alat',
        'jenis',
        'jumlah_unit',
        'harga_beli',
        'jumlah',
    ];
    protected $table = 'asset_mesin';
}
