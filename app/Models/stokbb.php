<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stokbb extends Model
{
    use HasFactory;
    public $table = 'stokbbs';

    protected $guarded = [
        'id'
    ];
}
