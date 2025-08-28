<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class preorder extends Model
{
    use HasFactory;

    public $table = 'preorders';

    protected $guarded = [
        'id'
    ];

    public function detailOrder(){
        return $this->hasMany(listorder::class, 'preorder_id');
    }
}
