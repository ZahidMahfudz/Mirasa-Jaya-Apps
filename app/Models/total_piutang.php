<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class total_piutang extends Model
{
    use HasFactory;
    public $table = 'total_piutangs';

    protected $guarded = [
        'id'
    ];
}
