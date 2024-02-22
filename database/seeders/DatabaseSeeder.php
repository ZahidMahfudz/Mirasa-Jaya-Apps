<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\bahanbaku;
use App\Models\hutangbahanbaku;
use App\Models\piutang;
use App\Models\produk;
use App\Models\total_hutang_bahan_baku;
use App\Models\total_uang_masuk;
use App\Models\uangmasukpiutang;
use App\Models\uangmasukretail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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

        $hutangbahanbaku = [
            [
                'nama_bahan'=>'Tepung Terigu Gerbang Biru',
                'qty'=>10,
                'satuan'=>'zak',
                'harga_satuan'=>228000,
                'jumlah'=>2280000,
                'supplier'=>'CV Inti Adika Makmur',
            ],
            [
                'nama_bahan'=>'Tepung Terigu Melati',
                'qty'=>10,
                'satuan'=>'zak',
                'harga_satuan'=>222000,
                'jumlah'=>2220000,
                'supplier'=>'CV Andini Inti Pangan',
            ],
        ];
        foreach($hutangbahanbaku as $key => $val){
            hutangbahanbaku::create($val);
        };

        $produk = [
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
        foreach($produk as $key => $val){
            produk::create($val);
        };

        $totalhutangbahanbaku = [
            [
                'total_hutang_bahan_baku'=>4500000,
                'update'=>now(),
            ]
        ];
        foreach($totalhutangbahanbaku as $key => $val){
            total_hutang_bahan_baku::create($val);
        };

        $totaluangmasuk = [
            [
                'total_uang_masuk'=>32015749,
                'update'=>now(),
            ]
        ];
        foreach($totaluangmasuk as $key => $val){
            total_uang_masuk::create($val);
        };

        $uangmasukpiutang = [
            [
                'tanggal' => now()->subDays(rand(1, 10)), // Tanggal acak 1 hingga 10 hari yang lalu
                'tanggal_lunas' => null,
                'nama_toko' => 'Bu Hj. Ragil Ngablak',
                'keterangan' => 'Cash',
                'total_piutang' => rand(3000000, 10000000), // Total piutang acak antara 3 juta hingga 10 juta
            ],
            [
                'tanggal' => now(),
                'tanggal_lunas' => now()->subDays(rand(1, 10)), // Tanggal acak 1 hingga 10 hari yang lalu
                'nama_toko' => 'Bu Hj. Ragil Ngablak',
                'keterangan' => 'piutang',
                'total_piutang' => rand(3000000, 10000000),
            ],
            [
                'tanggal' => now(),
                'tanggal_lunas' => now()->subDays(rand(1, 10)), // Tanggal acak 1 hingga 10 hari yang lalu
                'nama_toko' => 'Bu Hj. Ragil Ngablak',
                'keterangan' => 'titp',
                'total_piutang' => rand(3000000, 10000000),
            ],

        ];

        foreach ($uangmasukpiutang as $key => $val) {
            uangmasukpiutang::create($val);
        };

        $uangmasukretail = [
            [
                'tanggal' => now(),
                'nama_produk' => 'Bagelen',
                'qty' => 10.5,
                'satuan' => 'dus',
                'harga_satuan' => 75000,
                'jumlah' => 10.5 * 75000,
            ],
            [
                'tanggal' => now()->subDays(1),
                'nama_produk' => 'bagelen sisir',
                'qty' => 8,
                'satuan' => 'Kg',
                'harga_satuan' => 95000,
                'jumlah' => 8 * 95000,
            ],
            [
                'tanggal' => now()->subDays(2),
                'nama_produk' => 'sagu O Coklat',
                'qty' => 15,
                'satuan' => 'dus',
                'harga_satuan' => 150000,
                'jumlah' => 15 * 150000,
            ],
            [
                'tanggal' => now()->subDays(3),
                'nama_produk' => 'bagelen Cream Keju',
                'qty' => 20,
                'satuan' => 'Kg',
                'harga_satuan' => 95000,
                'jumlah' => 20 * 95000,
            ],
            [
                'tanggal' => now()->subDays(4),
                'nama_produk' => 'Sagu Keju',
                'qty' => 12,
                'satuan' => 'kg',
                'harga_satuan' => 36000,
                'jumlah' => 12 * 36000,
            ],
        ];

        foreach ($uangmasukretail as $key => $val) {
            uangmasukretail::create($val);
        }

        $jumlah_data = 5; // Jumlah data piutang yang diinginkan
        $piutang = [];

        $nama_random = ['Pak Khalim', 'Bp. Tanto', 'Bu Endang'];

        for ($i = 0; $i < $jumlah_data; $i++) {
            $piutang[] = [
                'tanggal_piutang' => now()->subDays(rand(1, 10))->format('Y-m-d'),
                'nama_toko' => 'Toko ' . ($i + 1),
                'keterangan' => 'Piutang : ' . now()->subDays(rand(1, 10))->format('d F Y'),
                'total_piutang' => rand(1000000, 10000000),
                'oleh' => $nama_random[array_rand($nama_random)],
            ];
        }


        foreach ($piutang as $key => $val) {
            piutang::create($val);
        }

        $total_piutang = 0;

        foreach ($piutang as $data) {
            $total_piutang += $data['total_piutang'];
        }
        DB::table('total_piutangs')->insert([
            'total_piutang' => $total_piutang,
            'update' => now()->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //nota_pemasaran

        $startDate = Carbon::create(2024, 2, 11);
        $endDate = Carbon::create(2024, 2, 18);

        for ($i = 0; $i < 8; $i++) {
            $randomDate = $startDate->copy()->addDays($i)->toDateString();
            // Generate random quantity between 1 to 10
            $qty = rand(1, 10);
            // Get random product
            $randomProduct = $produk[array_rand($produk)];
            // Generate random store name
            $storeName = 'Toko ' . ($i + 1);
            // Insert into database
            DB::table('nota_pemasarans')->insert([
                'jenis_nota' => rand(0, 1) ? 'nota_cash' : 'nota_noncash',
                'tanggal' => $randomDate,
                'nama_toko' => $storeName,
                'qty' => $qty,
                'nama_barang' => $randomProduct['nama_produk'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        //drop_out

        for ($i = 0; $i < 8; $i++) {
            $randomDate = $startDate->copy()->addDays($i)->toDateString();
            // Get random product
            $randomProduct = $produk[array_rand($produk)];
            // Generate random quantity between 1 to 100
            $quantity = rand(1, 100);
            // Insert into database
            DB::table('drop_outs')->insert([
                'tanggal_do' => $randomDate,
                'nama_produk' => $randomProduct['nama_produk'],
                'jumlah' => $quantity,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        //sss

        for ($i = 0; $i < 8; $i++) {
            $randomDate = $startDate->copy()->addDays($i)->toDateString();
            // Get random product
            $randomProduct = $produk[array_rand($produk)];
            // Generate random SSS value between 1000 to 10000
            $sss = rand(1000, 10000);
            // Insert into database
            DB::table('ssses')->insert([
                'tanggal' => $randomDate,
                'nama_produk' => $randomProduct['nama_produk'],
                'sss' => $sss,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
