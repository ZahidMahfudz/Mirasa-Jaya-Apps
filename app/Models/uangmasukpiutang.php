<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class uangmasukpiutang extends Model
{
    use HasFactory;
    public $table = 'uangmasukpiutangs';

    protected $guarded = [
        'id'
    ];

}
