<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stokbp extends Model
{
    use HasFactory;
    public $table = 'stokbps';

    protected $guarded = [
        'id'
    ];
}
