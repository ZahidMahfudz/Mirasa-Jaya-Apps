<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resep_wip extends Model
{
    use HasFactory;
    public $table = 'resep_wips';

    protected $guarded = [
        'id'
    ];
}
