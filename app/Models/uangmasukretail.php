<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class uangmasukretail extends Model
{
    use HasFactory;
    public $table = 'uangmasukretails';

    protected $guarded = [
        'id'
    ];

}
