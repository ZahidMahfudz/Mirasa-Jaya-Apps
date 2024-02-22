<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class drop_out extends Model
{
    use HasFactory;
    public $table = 'drop_outs';

    protected $guarded = [
        'id'
    ];
}
