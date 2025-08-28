<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemNota extends Model
{
    use HasFactory;

    public $table = 'item_notas';
    public $incrementing = false;
    public $keyType = 'string';
    public $timestamps = true;
    public $primaryKey = 'id_item_nota';

    protected $guarded = [
        'id'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $prefix = 'IT'; // Unified prefix for all types of item
            $datePart = now()->format('md'); // Get current month and day in MMDD format

            $lastItemNota = self::where('id_item_nota', 'like', $prefix . $datePart . '%')
                    ->orderBy('id_item_nota', 'desc')
                    ->first();

            $number = $lastItemNota ? (int)substr($lastItemNota->id_item_nota, 6) + 1 : 1;

            $model->id_item_nota = sprintf('%s%s%03d', $prefix, $datePart, $number);
        });
    }
    
    public function nota_pemasaran()
    {
        return $this->belongsTo(nota_pemasaran::class, 'id_nota', 'id_nota');
    }
}
