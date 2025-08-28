<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDropOut extends Model
{
    use HasFactory;

    public $table = 'list_drop_outs';

    protected $guarded = [
        'id'
    ];

    public function dropOut()
    {
        return $this->belongsTo(drop_out::class);
    }

}
