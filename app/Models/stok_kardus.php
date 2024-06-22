<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stok_kardus extends Model
{
    use HasFactory;
    public $table = 'stok_karduses';

    protected $guarded = [
        'id'
    ];
}
