<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalDisetor extends Model
{
    use HasFactory;
    protected $fillable = [
        'jenis_modal',
        'tanggal',
        'jumlah',
    ];
    protected $table = 'modal_disetor';
}
