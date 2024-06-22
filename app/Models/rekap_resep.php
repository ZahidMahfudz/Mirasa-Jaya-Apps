<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rekap_resep extends Model
{
    use HasFactory;

    protected $table = 'rekap_reseps';

    protected $guarded = [
        'id'
    ];

    public function resep()
    {
        return $this->belongsTo(resep::class, 'resep_id');
    }
}
