<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModalBankPermata extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'jumlah',
    ];
    protected $table = 'modal_bank_permata' ;
}
