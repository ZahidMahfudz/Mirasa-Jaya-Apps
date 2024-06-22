<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resep extends Model
{
    use HasFactory;

    protected $table = 'reseps';

    protected $guarded = [
        'id'
    ];

    public function bahan_resep(){
        return $this->hasMany(bahan_resep::class, 'resep_id');
    }

    public function rekap_resep(){
        return $this->hasMany(rekap_resep::class, 'resep_id');
    }
}
