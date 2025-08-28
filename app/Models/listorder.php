<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listorder extends Model
{
    use HasFactory;

    protected $table = 'listorders';

    protected $guarded = [
        'id'
    ];

    public function preorder(){
        return $this->belongsTo(preorder::class, 'preorder_id');
    }
}
