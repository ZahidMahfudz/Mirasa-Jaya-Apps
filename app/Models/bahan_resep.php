<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bahan_resep extends Model
{
    use HasFactory;

    protected $table = 'bahan_reseps';

    protected $guarded = [
        'id'
    ];

    public function resep(){
        return $this->belongsTo(resep::class, 'resep_id');
    }
}
