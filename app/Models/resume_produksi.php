<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resume_produksi extends Model
{
    use HasFactory;
    public $table = 'resume_produksis';

    protected $guarded = [
        'id'
    ];
}
