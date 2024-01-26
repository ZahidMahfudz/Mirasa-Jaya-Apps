<?php

namespace Database\Seeders;

use App\Models\produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'nama_produk'=>'Bagelen 2 KG',
                'harga_satuan'=>74000
            ],
            [
                'nama_produk'=>'Bagelen Sisir 2 KG',
                'harga_satuan'=>83000
            ],
            [
                'nama_produk'=>'Bagelen Garlic Sisir 2 KG',
                'harga_satuan'=>95000
            ],
            [
                'nama_produk'=>'Bagelen Cream Keju 2 KG',
                'harga_satuan'=>95000
            ],
            [
                'nama_produk'=>'Bagelen Jamur 1,5 KG',
                'harga_satuan'=>65000
            ],
        ];
        foreach($userData as $key => $val){
            produk::create($val);
        };
    }
}
