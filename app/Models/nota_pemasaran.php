<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nota_pemasaran extends Model
{
    use HasFactory;

    public $table = 'nota_pemasarans';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = true;
    public $primaryKey = 'id_nota';

    protected $guarded = [
        'id'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $prefix = 'NT'; // Unified prefix for all types of nota
            $datePart = now()->format('md'); // Get current month and day in MMDD format

            $lastNota = self::where('id_nota', 'like', $prefix . $datePart . '%')
                    ->orderBy('id_nota', 'desc')
                    ->first();

            $number = $lastNota ? (int)substr($lastNota->id_nota, 6) + 1 : 1;

            $model->id_nota = sprintf('%s%s%03d', $prefix, $datePart, $number);
        });
    }

    public function item_nota()
    {
        return $this->hasMany(itemNota::class, 'id_nota', 'id_nota');
    }
}
