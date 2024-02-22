<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class total_uang_masuk extends Model
{
    use HasFactory;
    public $table = 'total_uang_masuks';

    protected $guarded = [
        'id'
    ];

}
