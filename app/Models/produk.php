<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    protected $primaryKey = 'id_produk'; // Set primary key ke 'id_produk'
    public $incrementing = false; // Nonaktifkan auto-increment
    protected $keyType = 'string'; // Tentukan tipe kolom ID sebagai string

    protected $guarded = [
        'id'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $lastProduct = self::where('id_produk', 'like', 'PRD%')
                               ->orderBy('id_produk', 'desc')
                               ->first();

            $number = $lastProduct ? (int)substr($lastProduct->id_produk, 3) + 1 : 1;

            $model->id_produk = sprintf('PRD%03d', $number);
        });
    }
}
