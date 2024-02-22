<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class total_hutang_bahan_baku extends Model
{
    use HasFactory;
    public $table = 'total_hutang_bahan_bakus';

    protected $guarded = [
        'id'
    ];

}
