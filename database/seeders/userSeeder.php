<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\resep;
use App\Models\produk;
use App\Models\drop_out;
use App\Models\preorder;
use App\Models\bahanbaku;
use App\Models\bahan_resep;
use App\Models\Data_Karyawan;
use App\Models\dataKaryawanBorongan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name'=>'admin',
                'username'=> 'admin',
                'password'=>bcrypt('admin'),
                'role'=>'admin'
            ],

            [
                'name'=>'Rusmin Utsman Wijaya',
                'username'=> 'rusminutsman',
                'password'=>bcrypt('rusminutsman'),
                'role'=>'manager'
            ],

            [
                'name'=>'Tanto Budi',
                'username'=> 'tantobudi',
                'password'=>bcrypt('tantobudi'),
                'role'=>'owner'
            ],
        ];
        foreach($user as $key => $val){
            User::create($val);
        };

        $bahanbaku = [
            [
                'nama_bahan'=>'Tepung Terigu Gerbang Biru',
                'jenis'=>'bahan baku',
                'satuan'=>'zak',
                'banyak_satuan'=>25,
                'jenis_satuan'=>'Kg',
                'harga_persatuan'=>228000,
                'harga_perkilo'=>9120,
            ],
            [
                'nama_bahan'=>'Tepung Terigu Melati',
                'jenis'=>'bahan baku',
                'satuan'=>'zak',
                'banyak_satuan'=>25,
                'jenis_satuan'=>'Kg',
                'harga_persatuan'=>222000,
                'harga_perkilo'=>8880,
            ],
            [
                'nama_bahan'=>'Tepung Terigu Gudang Aci',
                'jenis'=>'bahan baku',
                'satuan'=>'zak',
                'banyak_satuan'=>50,
                'jenis_satuan'=>'Kg',
                'harga_persatuan'=>540000,
                'harga_perkilo'=>10800,
            ],
            [
                'nama_bahan'=>'Gula Pasir',
                'jenis'=>'bahan baku',
                'satuan'=>'zak',
                'banyak_satuan'=>50,
                'jenis_satuan'=>'Kg',
                'harga_persatuan'=>765000,
                'harga_perkilo'=>15300,
            ],

            [
                'nama_bahan'=>'Gas Elpiji',
                'jenis'=>'bahan penolong',
                'satuan'=>'Tb',
                'banyak_satuan'=>12,
                'jenis_satuan'=>'Kg',
                'harga_persatuan'=>195000,
                'harga_perkilo'=>16250,
            ],
            [
                'nama_bahan'=>'Plastik BP (50x60x0,4)',
                'jenis'=>'bahan penolong',
                'satuan'=>'pak',
                'banyak_satuan'=>100,
                'jenis_satuan'=>'Biji',
                'harga_persatuan'=>100000,
                'harga_perkilo'=>1000,
            ],
            [
                'nama_bahan'=>'Plastik SAGU O (60x60x0,4)',
                'jenis'=>'bahan penolong',
                'satuan'=>'pak',
                'banyak_satuan'=>100,
                'jenis_satuan'=>'Biji',
                'harga_persatuan'=>118000,
                'harga_perkilo'=>1180,
            ],
            [
                'nama_bahan'=>'Kardus BP Jaya Mirasa 3 kg',
                'jenis'=>'kardus',
                'satuan'=>'Biji',
                'harga_persatuan'=>4055,
            ],
            [
                'nama_bahan'=>'Kardus Sagu Kerut Jaya Mirasa 5 kg',
                'jenis'=>'kardus',
                'satuan'=>'Biji',
                'harga_persatuan'=>5735,
            ],
            [
                'nama_bahan'=>'Kardus Sagu Kidung 5 kg',
                'jenis'=>'kardus',
                'satuan'=>'Biji',
                'harga_persatuan'=>5735,
            ],

        ];
        foreach($bahanbaku as $key => $val){
            bahanbaku::create($val);
        };

        $produk = [
            [
            'nama_produk' => 'Bagelen 2 kg',
            'harga_satuan' => 78000,
            'jenis_kardus' => 'Kardus BP Jaya Mirasa 3 kg',
            ],
            [
            'nama_produk' => 'Sagu Mini 5 Kg',
            'harga_satuan' => 145000,
            'jenis_kardus' => 'Kardus Sagu Kerut Jaya Mirasa 5 kg',
            ],
            [
            'nama_produk' => 'Sagu S Putih 5 Kg',
            'harga_satuan' => 145000,
            'jenis_kardus' => 'Kardus Sagu Kidung 5 kg',
            ],
            [
            'nama_produk' => 'Bolu Panggang Stick Polos 2 KG',
            'harga_satuan' => 135000,
            'jenis_kardus' => 'Kardus BP Jaya Mirasa 3 kg',
            ],
            [
            'nama_produk' => 'Bolu Panggang Marmer Mini KG',
            'harga_satuan' => 135000,
            'jenis_kardus' => 'Kardus BP Jaya Mirasa 3 kg',
            ],
        ];

        foreach($produk as $key => $val){
            produk::create($val);
        };

        //resep
        resep::create(['nama_resep' => 'Adonan Gula', 'lini_produksi' => 'BP']);
        resep::create(['nama_resep' => 'Terigu', 'lini_produksi' => 'BP']);
        resep::create(['nama_resep' => 'Jladren', 'lini_produksi' => 'SP,OP,Dahlia,Sagu Mini']);
        resep::create(['nama_resep' => 'Pati', 'lini_produksi' => 'SP,OP,Dahlia,Sagu Mini']);

        //bahan_resep
        // Data bahan untuk resep adonan gula
        bahan_resep::create(['resep_id' => 1, 'nama_bahan' => 'Gula Pasir', 'jumlah_bahan_gr' => 3550, 'jumlah_bahan_kg' => 3.550, 'jumlah_bahan_zak' => 3.550/50]);
        bahan_resep::create(['resep_id' => 1, 'nama_bahan' => 'Garam Halus Cipta Rasa', 'jumlah_bahan_gr' => 10.5, 'jumlah_bahan_kg' => 0.0105, 'jumlah_bahan_zak' => 0.0105/50]);
        bahan_resep::create(['resep_id' => 1, 'nama_bahan' => 'Pewarna Kuning Telur Bubuk', 'jumlah_bahan_gr' => 0, 'jumlah_bahan_kg' => 0, 'jumlah_bahan_zak' => 0]);
        bahan_resep::create(['resep_id' => 1, 'nama_bahan' => 'Perisa Vanila Penguin', 'jumlah_bahan_gr' => 2.0, 'jumlah_bahan_kg' => 2.0, 'jumlah_bahan_zak' => 2.0/100]);

        // Data bahan untuk resep Terigu
        bahan_resep::create(['resep_id' => 2, 'nama_bahan' => 'Tepung Terigu Melati', 'jumlah_bahan_gr' => 3650, 'jumlah_bahan_kg' => 3.650, 'jumlah_bahan_zak' => 3.650/25]);

        // Data bahan untuk resep Jladren
        bahan_resep::create(['resep_id' => 3, 'nama_bahan' => 'Gula Pasir', 'jumlah_bahan_gr' => 270000, 'jumlah_bahan_kg' => 270, 'jumlah_bahan_zak' => 5.4]);
        bahan_resep::create(['resep_id' => 3, 'nama_bahan' => 'Telur', 'jumlah_bahan_gr' => 67500, 'jumlah_bahan_kg' => 67.5, 'jumlah_bahan_zak' => 6.8]);
        bahan_resep::create(['resep_id' => 3, 'nama_bahan' => 'Margarin Sania/Simas/Sovia', 'jumlah_bahan_gr' => 162000, 'jumlah_bahan_kg' => 162, 'jumlah_bahan_zak' => 10.8]);
        bahan_resep::create(['resep_id' => 3, 'nama_bahan' => 'Susu Bubuk Innovate', 'jumlah_bahan_gr' => 10800, 'jumlah_bahan_kg' => 10.8, 'jumlah_bahan_zak' => 0.4]);
        bahan_resep::create(['resep_id' => 3, 'nama_bahan' => 'Santan', 'jumlah_bahan_gr' => 108000, 'jumlah_bahan_kg' => 108, 'jumlah_bahan_zak' => 108]);
        bahan_resep::create(['resep_id' => 3, 'nama_bahan' => 'Perisa Vanila Penguin', 'jumlah_bahan_gr' => 216, 'jumlah_bahan_kg' => 216, 'jumlah_bahan_zak' => 2.2]);
        bahan_resep::create(['resep_id' => 3, 'nama_bahan' => 'Garam Halus Cipta Rasa', 'jumlah_bahan_gr' => 594, 'jumlah_bahan_kg' => 0.6, 'jumlah_bahan_zak' => 0]);

        // Data bahan untuk resep Pati
        bahan_resep::create(['resep_id' => 4, 'nama_bahan' => 'Tepung Terigu Gudang Aci', 'jumlah_bahan_gr' => 265000, 'jumlah_bahan_kg' => 265, 'jumlah_bahan_zak' => 5.3]);
        bahan_resep::create(['resep_id' => 4, 'nama_bahan' => 'Tepung Terigu Melati', 'jumlah_bahan_gr' => 26500, 'jumlah_bahan_kg' => 26.5, 'jumlah_bahan_zak' => 1.1]);

        // //List Order
        // $preorder=[
        //     [
        //         'tanggal_order'=>'2025-01-14',
        //         'tanggal_selesai'=>'2025-01-15',
        //         'nama_pemesan'=>'khalim',
        //         'status'=>'pending'
        //     ],
        //     [
        //         'tanggal_order'=>'2025-01-14',
        //         'tanggal_selesai'=>'2025-01-15',
        //         'nama_pemesan'=>'khalim',
        //         'status'=>'pending'
        //     ],
        //     [
        //         'tanggal_order'=>'2025-01-14',
        //         'tanggal_selesai'=>'2025-01-15',
        //         'nama_pemesan'=>'PT. Bagelen',
        //         'status'=>'proses'
        //     ],
        //     [
        //         'tanggal_order'=>'2025-01-14',
        //         'tanggal_selesai'=>'2025-01-15',
        //         'nama_pemesan'=>'PT. Bagelen',
        //         'status'=>'selesai'
        //     ],
        //     [
        //         'tanggal_order'=>'2025-01-14',
        //         'tanggal_selesai'=>'2025-01-15',
        //         'nama_pemesan'=>'PT. Bagelen',
        //         'status'=>'selesai'
        //     ],
        // ];
        // foreach($preorder as $key => $val){
        //     $preorder = preorder::create($val);
        //     $preorder->detailOrder()->createMany([
        //         [
        //             'nama_barang'=>'Bagelen 2 KG',
        //             'jumlah_barang'=>100
        //         ],
        //         [
        //             'nama_barang'=>'Bagelen Sisir 2 Kg',
        //             'jumlah_barang'=>100
        //         ],
        //         [
        //             'nama_barang'=>'Bagelen Garlic Sisir 2 Kg',
        //             'jumlah_barang'=>100
        //         ],
        //         [
        //             'nama_barang'=>'Bagelen Cream Keju 2 KG',
        //             'jumlah_barang'=>100
        //         ],
        //         [
        //             'nama_barang'=>'Bagelen Jamur 1,5 KG',
        //             'jumlah_barang'=>100
        //         ],
        //     ]);
        // }

        // $dropout = [
        //     [
        //         'tanggal'=>'2025-01-14',
        //         'nama_pengambil'=>'Khalim',
        //         'status'=>'proses'
        //     ],
        //     [
        //         'tanggal'=>'2025-01-15',
        //         'nama_pengambil'=>'Tanto Budi',
        //         'status'=>'proses'
        //     ],
        //     [
        //         'tanggal'=>'2025-01-16',
        //         'nama_pengambil'=>'Indinayah',
        //         'status'=>'proses'
        //     ],
        //     [
        //         'tanggal'=>'2025-01-17',
        //         'nama_pengambil'=>'PT. Bagelen',
        //         'status'=>'proses'
        //     ],
        //     [
        //         'tanggal'=>'2025-01-18',
        //         'nama_pengambil'=>'PT. Bagelen',
        //         'status'=>'proses'
        //     ],
        // ];

        // foreach($dropout as $key => $val){
        //     $dropout = drop_out::create($val);
        //     $dropout->ListDropOut()->createMany([
        //         [
        //             'nama_barang'=>'Bagelen 2 KG',
        //             'jumlah_barang'=>100
        //         ],
        //         [
        //             'nama_barang'=>'Bagelen Sisir 2 Kg',
        //             'jumlah_barang'=>100
        //         ],
        //         [
        //             'nama_barang'=>'Bagelen Garlic Sisir 2 Kg',
        //             'jumlah_barang'=>100
        //         ],
        //         [
        //             'nama_barang'=>'Bagelen Cream Keju 2 KG',
        //             'jumlah_barang'=>100
        //         ],
        //         [
        //             'nama_barang'=>'Bagelen Jamur 1,5 KG',
        //             'jumlah_barang'=>100
        //         ],
        //     ]);
        // }

        $data_karyawan = [
            [
                'nama_karyawan'=>'Mba Tanti',
                'bagian'=>'Resep',
                'posisi'=>'Kepala Bagian',
                'gaji_pokok'=>60000,
                'makan'=>7000,
                'tunjangan'=>20000,
            ],
            [
                'nama_karyawan'=>'Mba Anna',
                'bagian'=>'bagelen',
                'posisi'=>'Kepala Bagian',
                'gaji_pokok'=>50000,
                'makan'=>7000,
                'tunjangan'=>10000,
            ],
            [
                'nama_karyawan'=>'Mba Sisil',
                'bagian'=>'Ngrajang',
                'posisi'=>'Operator',
                'gaji_pokok'=>50000,
                'makan'=>7000,
                'tunjangan'=>10000,
            ],
            [
                'nama_karyawan'=>'Mas Fathur',
                'bagian'=>'Oven & Packing',
                'posisi'=>'Operator',
                'gaji_pokok'=>60000,
                'makan'=>7000,
                'tunjangan'=>10000,
            ],
            [
                'nama_karyawan'=>'Mba Dewi',
                'bagian'=>'Oven & Packing',
                'posisi'=>'Operator',
                'gaji_pokok'=>60000,
                'makan'=>7000,
                'tunjangan'=>10000,
            ],
        ];

        foreach($data_karyawan as $key => $val){
            Data_Karyawan::create($val);
        };

        $data_karyawan_borongan = [
            [
                'nama_karyawan'=>'Mba Asih',
                'bagian'=>'Resep',
                'harga_s'=>22500,
                'harga_o'=>15000,
                'makan'=>7000,
                'tunjangan'=>10000,
            ],
            [
                'nama_karyawan'=>'Mba Is 1',
                'bagian'=>'bagelen',
                'harga_s'=>20000,
                'harga_o'=>15000,
                'makan'=>7000,
                'tunjangan'=>10000,
            ],
            [
                'nama_karyawan'=>'Mba Islamiyati 2',
                'bagian'=>'bagelen',
                'harga_s'=>20000,
                'harga_o'=>10000,
                'makan'=>7000,
                'tunjangan'=>10000,
            ],
        ];

        foreach($data_karyawan_borongan as $key => $val){
            dataKaryawanBorongan::create($val);
        };
        
    }
}
