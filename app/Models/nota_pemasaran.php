<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nota_pemasaran extends Model
{
    use HasFactory;

    public $table = 'nota_pemasarans';

    protected $guarded = [
        'id'
    ];
}
