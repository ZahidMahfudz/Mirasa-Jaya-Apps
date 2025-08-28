<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasBankPermata extends Model
{
    use HasFactory;

    protected $table = 'kas_bank_permata'; // Menentukan nama tabel yang digunakan oleh model

    protected $fillable = [
        'tanggal',
        'hal',
        'mutasi',
        'debit',
        'kredit',
        'saldo'
    ]; // Menentukan atribut yang dapat diisi
}
