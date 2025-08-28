<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BungaBank extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'hal',
        'jumlah',
    ];
    protected $table = 'bunga_bank';
}
