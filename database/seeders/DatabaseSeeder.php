<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\bahan_resep;
use App\Models\bahanbaku;
use App\Models\drop_out;
use App\Models\hutangbahanbaku;
use App\Models\nota_pemasaran;
use App\Models\piutang;
use App\Models\produk;
use App\Models\rekap_resep;
use App\Models\Resep;
use App\Models\resume_produksi;
use App\Models\sss;
use App\Models\stok_kardus;
use App\Models\stokbb;
use App\Models\stokbp;
use App\Models\total_hutang_bahan_baku;
use App\Models\total_uang_masuk;
use App\Models\uangmasukpiutang;
use App\Models\uangmasukretail;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

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
                'nama_produk'=>'Bagelen Sisir 2 Kg',
                'harga_satuan'=>83000
            ],
            [
                'nama_produk'=>'Bagelen Garlic Sisir 2 Kg',
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

        $uangmasukpiutang = [
            [
                'tanggal' => now()->subDays(rand(1, 10)), // Tanggal acak 1 hingga 10 hari yang lalu
                'tanggal_lunas' => null,
                'nama_toko' => 'Bu Hj. Ragil Ngablak',
                'keterangan' => 'Cash',
                'total_piutang' => 4598847, // Total piutang acak antara 3 juta hingga 10 juta
            ],
            [
                'tanggal' => now(),
                'tanggal_lunas' => now()->subDays(rand(1, 10)), // Tanggal acak 1 hingga 10 hari yang lalu
                'nama_toko' => 'Bu Hj. Ragil Ngablak',
                'keterangan' => 'piutang',
                'total_piutang' => 9055776,
            ],
            [
                'tanggal' => now(),
                'tanggal_lunas' => now()->subDays(rand(1, 10)), // Tanggal acak 1 hingga 10 hari yang lalu
                'nama_toko' => 'Bu Hj. Ragil Ngablak',
                'keterangan' => 'titp',
                'total_piutang' => 4893165,
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

        $totaluangmasuk = [
            [
                'total_uang_masuk'=>24677288,
                'update'=>now(),
            ]
        ];
        foreach($totaluangmasuk as $key => $val){
            total_uang_masuk::create($val);
        };

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
        $nota_pemasaran = [
            [
                'jenis_nota'=>'nota_cash',
                'tanggal'=>'2024-02-2',
                'nama_toko'=>'Bu Hj, Ragil, Ngablak',
                'qty'=>50,
                'nama_barang' => 'Bagelen 2 KG'
            ],
            [
                'jenis_nota'=>'nota_cash',
                'tanggal'=>'2024-02-3',
                'nama_toko'=>'Bp. Tanto',
                'qty'=>25,
                'nama_barang' => 'Bagelen Sisir 2 Kg'
            ],
            [
                'jenis_nota'=>'nota_cash',
                'tanggal'=>'2024-02-3',
                'nama_toko'=>'Bu Hj Kartika, Kebumen',
                'qty'=>20,
                'nama_barang' => 'Bagelen Sisir 2 Kg'
            ],
            [
                'jenis_nota'=>'nota_cash',
                'tanggal'=>'2024-02-3',
                'nama_toko'=>'Mb. Siwi, Ps Muntilan',
                'qty'=>30,
                'nama_barang' => 'Bagelen Garlic Sisir 2 Kg'
            ],
            [
                'jenis_nota'=>'nota_cash',
                'tanggal'=>'2024-02-4',
                'nama_toko'=>'Mb. Siwi, Ps Muntilan',
                'qty'=>30,
                'nama_barang' => 'Bagelen Garlic Sisir 2 Kg'
            ],
            [
                'jenis_nota'=>'nota_cash',
                'tanggal'=>'2024-02-4',
                'nama_toko'=>'Eco Roso, Magelang',
                'qty'=>5,
                'nama_barang' => 'Bagelen 2 KG'
            ],
            [
                'jenis_nota'=>'nota_noncash',
                'tanggal'=>'2024-02-1',
                'nama_toko'=>'Eco Roso, Magelang',
                'qty'=>15,
                'nama_barang' => 'Bagelen 2 KG'
            ],
            [
                'jenis_nota'=>'nota_noncash',
                'tanggal'=>'2024-02-1',
                'nama_toko'=>'Seruni, Magelang',
                'qty'=>25,
                'nama_barang' => 'Bagelen Garlic Sisir 2 Kg'
            ],
            [
                'jenis_nota'=>'nota_noncash',
                'tanggal'=>'2024-02-2',
                'nama_toko'=>'Mb In, Magelang',
                'qty'=>35,
                'nama_barang' => 'Bagelen 2 KG'
            ],
            [
                'jenis_nota'=>'nota_noncash',
                'tanggal'=>'2024-02-2',
                'nama_toko'=>'Mb Siti, Magelang',
                'qty'=>35,
                'nama_barang' => 'Bagelen Sisir 2 Kg'
            ],
            [
                'jenis_nota'=>'nota_noncash',
                'tanggal'=>'2024-02-3',
                'nama_toko'=>'Niki Mantep, Salatiga',
                'qty'=>35,
                'nama_barang' => 'Bagelen Garlic Sisir 2 Kg'
            ],
            [
                'jenis_nota'=>'nota_noncash',
                'tanggal'=>'2024-02-3',
                'nama_toko'=>'Bu Lastry, Ambarawa',
                'qty'=>35,
                'nama_barang' => 'Bagelen Sisir 2 Kg'
            ],
            [
                'jenis_nota'=>'nota_noncash',
                'tanggal'=>'2024-02-4',
                'nama_toko'=>'Mb. Azizah, Kebumen',
                'qty'=>10,
                'nama_barang' => 'Bagelen 2 KG'
            ],
            [
                'jenis_nota'=>'nota_noncash',
                'tanggal'=>'2024-02-5',
                'nama_toko'=>'Mb. Siti, Magelang',
                'qty'=>35,
                'nama_barang' => 'Bagelen 2 KG'
            ],
        ];
        foreach ($nota_pemasaran as $key => $val) {
            nota_pemasaran::create($val);
        };

        //resume produksi
        $resume_produksi = [
            [
                'tanggal' => '2024-01-31',
                'nama_produk' => 'Bagelen 2 KG',
                'in' => 0,
                'out' => 0,
                'sisa' => 0,
            ],
            [
                'tanggal' => '2024-01-31',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'in' => 0,
                'out' => 0,
                'sisa' => 0,
            ],
            [
                'tanggal' => '2024-01-31',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'in' => 0,
                'out' => 0,
                'sisa' => 0,
            ],
            [
                'tanggal' => '2024-02-1',
                'nama_produk' => 'Bagelen 2 KG',
                'in' => 10,
                'out' => 10,
                'sisa' => 100,
            ],
            [
                'tanggal' => '2024-02-1',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'in' => 10,
                'out' => 10,
                'sisa' => 100,
            ],
            [
                'tanggal' => '2024-02-1',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'in' => 10,
                'out' => 10,
                'sisa' => 100,
            ],
            [
                'tanggal' => '2024-02-2',
                'nama_produk' => 'Bagelen 2 KG',
                'in' => 5,
                'out' => 15,
                'sisa' => 90,
            ],
            [
                'tanggal' => '2024-02-2',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'in' => 25,
                'out' => 10,
                'sisa' => 115,
            ],
            [
                'tanggal' => '2024-02-2',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'in' => 30,
                'out' => 15,
                'sisa' => 115,
            ],
            [
                'tanggal' => '2024-02-3',
                'nama_produk' => 'Bagelen 2 KG',
                'in' => 30,
                'out' => 15,
                'sisa' => 105,
            ],
            [
                'tanggal' => '2024-02-3',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'in' => 25,
                'out' => 35,
                'sisa' => 105,
            ],
            [
                'tanggal' => '2024-02-3',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'in' => 25,
                'out' => 35,
                'sisa' => 105,
            ],
            [
                'tanggal' => '2024-02-04',
                'nama_produk' => 'Bagelen 2 KG',
                'in' => 20,
                'out' => 10,
                'sisa' => 115,
            ],
            [
                'tanggal' => '2024-02-04',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'in' => 15,
                'out' => 25,
                'sisa' => 95,
            ],
            [
                'tanggal' => '2024-02-04',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'in' => 30,
                'out' => 20,
                'sisa' => 120,
            ],
            [
                'tanggal' => '2024-02-05',
                'nama_produk' => 'Bagelen 2 KG',
                'in' => 25,
                'out' => 15,
                'sisa' => 125,
            ],
            [
                'tanggal' => '2024-02-05',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'in' => 20,
                'out' => 20,
                'sisa' => 95,
            ],
            [
                'tanggal' => '2024-02-05',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'in' => 15,
                'out' => 25,
                'sisa' => 110,
            ],
        ];

        foreach ($resume_produksi as $key => $val) {
            resume_produksi::create($val);
        }

        $sss = [
            [
                'tanggal' => '2024-01-31',
                'nama_produk' => 'Bagelen 2 KG',
                'sss' => 100,
            ],
            [
                'tanggal' => '2024-01-31',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'sss' => 100,
            ],
            [
                'tanggal' => '2024-01-31',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'sss' => 100,
            ],
            [
                'tanggal' => '2024-02-1',
                'nama_produk' => 'Bagelen 2 KG',
                'sss' => 95//100+10-(15+0),
            ],
            [
                'tanggal' => '2024-02-1',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'sss' => 110//100+10,
            ],
            [
                'tanggal' => '2024-02-1',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'sss' => 85 //100+10-(25),
            ],
            [
                'tanggal' => '2024-02-2',
                'nama_produk' => 'Bagelen 2 KG',
                'sss' => 25// 95+15-(50+35),
            ],
            [
                'tanggal' => '2024-02-2',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'sss' => 85 //110+10-(35),
            ],
            [
                'tanggal' => '2024-02-2',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'sss' => 100 //85+15,
            ],
            [
                'tanggal' => '2024-02-3',
                'nama_produk' => 'Bagelen 2 KG',
                'sss' => 40 //25+15
            ],
            [
                'tanggal' => '2024-02-3',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'sss' => 40 //85+35-(20+25+35)
            ],
            [
                'tanggal' => '2024-02-3',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'sss' => 70 //100+35-(30+35) ,
            ],
            [
                'tanggal' => '2024-02-4',
                'nama_produk' => 'Bagelen 2 KG',
                'sss' => 35 //40+10-(5+10)
            ],
            [
                'tanggal' => '2024-02-4',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'sss' => 65 //40+25-()
            ],
            [
                'tanggal' => '2024-02-4',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'sss' => 60 //70+20-(30+)
            ],
            [
                'tanggal' => '2024-02-5',
                'nama_produk' => 'Bagelen 2 KG',
                'sss' => 15 //35+15-(35)
            ],
            [
                'tanggal' => '2024-02-5',
                'nama_produk' => 'Bagelen Sisir 2 Kg',
                'sss' => 85 //65+20
            ],
            [
                'tanggal' => '2024-02-5',
                'nama_produk' => 'Bagelen Garlic Sisir 2 Kg',
                'sss' => 85 //60+25
            ],
        ];
        foreach ($sss as $key => $val) {
            sss::create($val);
        }


        //stok kardus
        $stokkardus = [
            [
                'nama_kardus'=>'Kardus BP Jaya Mirasa 3 kg',
                'tanggal'=>'2024-4-30',
                'pakai'=>0,
                'sisa'=>100,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kerut Jaya Mirasa 5 kg',
                'tanggal'=>'2024-4-30',
                'pakai'=>0,
                'sisa'=>100,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kidung 5 kg',
                'tanggal'=>'2024-4-30',
                'pakai'=>0,
                'sisa'=>100,
            ],
            [
                'nama_kardus'=>'Kardus BP Jaya Mirasa 3 kg',
                'tanggal'=>'2024-05-1',
                'pakai'=>50,
                'sisa'=>50,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kerut Jaya Mirasa 5 kg',
                'tanggal'=>'2024-05-1',
                'pakai'=>10,
                'sisa'=>90,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kidung 5 kg',
                'tanggal'=>'2024-05-1',
                'pakai'=>30,
                'sisa'=>70,
            ],
            [
                'nama_kardus'=>'Kardus BP Jaya Mirasa 3 kg',
                'tanggal'=>'2024-05-2',
                'pakai'=>10,
                'sisa'=>40,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kerut Jaya Mirasa 5 kg',
                'tanggal'=>'2024-05-2',
                'pakai'=>20,
                'sisa'=>70,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kidung 5 kg',
                'tanggal'=>'2024-05-2',
                'pakai'=>10,
                'sisa'=>60,
            ],
            [
                'nama_kardus'=>'Kardus BP Jaya Mirasa 3 kg',
                'tanggal'=>'2024-05-3',
                'pakai'=>0,
                'sisa'=>150,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kerut Jaya Mirasa 5 kg',
                'tanggal'=>'2024-05-3',
                'pakai'=>0,
                'sisa'=>150,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kidung 5 kg',
                'tanggal'=>'2024-05-3',
                'pakai'=>0,
                'sisa'=>150,
            ],
            [
                'nama_kardus'=>'Kardus BP Jaya Mirasa 3 kg',
                'tanggal'=>'2024-05-4',
                'pakai'=>35,
                'sisa'=>115,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kerut Jaya Mirasa 5 kg',
                'tanggal'=>'2024-05-4',
                'pakai'=>20,
                'sisa'=>130,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kidung 5 kg',
                'tanggal'=>'2024-05-4',
                'pakai'=>10,
                'sisa'=>140,
            ],
            [
                'nama_kardus'=>'Kardus BP Jaya Mirasa 3 kg',
                'tanggal'=>'2024-05-5',
                'pakai'=>50,
                'sisa'=>65,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kerut Jaya Mirasa 5 kg',
                'tanggal'=>'2024-05-5',
                'pakai'=>40,
                'sisa'=>90,
            ],
            [
                'nama_kardus'=>'Kardus Sagu Kidung 5 kg',
                'tanggal'=>'2024-05-5',
                'pakai'=>40,
                'sisa'=>100,
            ],
        ];
        foreach ($stokkardus as $key => $val) {
            stok_kardus::create($val);
        };

        $stokbahanbaku = [
            [
                'tanggal'=> '2024-05-4',
                'nama_bahan'=>'Tepung Terigu Gerbang Biru',
                'gudang'=> 12.5,
                'sisa_resep'=> 5.5
            ],
            [
                'tanggal'=> '2024-05-4',
                'nama_bahan'=>'Tepung Terigu Melati',
                'gudang'=> 12.5,
                'sisa_resep'=> 5.5
            ],
            [
                'tanggal'=> '2024-05-4',
                'nama_bahan'=>'Tepung Terigu Gudang Aci',
                'gudang'=> 12.5,
                'sisa_resep'=> 5.5
            ],
            [
                'tanggal'=> '2024-05-4',
                'nama_bahan'=>'Gula Pasir',
                'gudang'=> 12.5,
                'sisa_resep'=> 5.5
            ],
            [
                'tanggal'=> '2024-05-11',
                'nama_bahan'=>'Tepung Terigu Gerbang Biru',
                'gudang'=> 50,
                'sisa_resep'=> 5.5
            ],
            [
                'tanggal'=> '2024-05-11',
                'nama_bahan'=>'Tepung Terigu Melati',
                'gudang'=> 25,
                'sisa_resep'=> 5.5
            ],
            [
                'tanggal'=> '2024-05-11',
                'nama_bahan'=>'Tepung Terigu Gudang Aci',
                'gudang'=> 65.5,
                'sisa_resep'=> 5.5
            ],
            [
                'tanggal'=> '2024-05-11',
                'nama_bahan'=>'Gula Pasir',
                'gudang'=> 65.5,
                'sisa_resep'=> 5.5
            ],
            [
                'tanggal'=> '2024-05-18',
                'nama_bahan'=>'Tepung Terigu Gerbang Biru',
                'gudang'=> 24.5,
                'sisa_resep'=> 3.5
            ],
            [
                'tanggal'=> '2024-05-18',
                'nama_bahan'=>'Tepung Terigu Melati',
                'gudang'=> 20,
                'sisa_resep'=> 2.5
            ],
            [
                'tanggal'=> '2024-05-18',
                'nama_bahan'=>'Tepung Terigu Gudang Aci',
                'gudang'=> 30.5,
                'sisa_resep'=> 1.5
            ],
            [
                'tanggal'=> '2024-05-18',
                'nama_bahan'=>'Gula Pasir',
                'gudang'=> 30.5,
                'sisa_resep'=> 1.5
            ],
            [
                'tanggal'=> '2024-05-25',
                'nama_bahan'=>'Tepung Terigu Gerbang Biru',
                'gudang'=> 50.5,
                'sisa_resep'=> 3.5
            ],
            [
                'tanggal'=> '2024-05-25',
                'nama_bahan'=>'Tepung Terigu Melati',
                'gudang'=> 120,
                'sisa_resep'=> 2.5
            ],
            [
                'tanggal'=> '2024-05-25',
                'nama_bahan'=>'Tepung Terigu Gudang Aci',
                'gudang'=> 60.5,
                'sisa_resep'=> 1.5
            ],
            [
                'tanggal'=> '2024-05-25',
                'nama_bahan'=>'Gula Pasir',
                'gudang'=> 75.5,
                'sisa_resep'=> 1.5
            ],
        ];
        foreach ($stokbahanbaku as $key => $val) {
            stokbb::create($val);
        };

        $stokbahanpenolong = [
            [
                'tanggal'=> '2024-05-4',
                'nama_bahan'=> 'Gas Elpiji',
                'jumlah'=> 5
            ],
            [
                'tanggal'=> '2024-05-4',
                'nama_bahan'=> 'Plastik BP (50x60x0,4)',
                'jumlah'=> 3
            ],
            [
                'tanggal'=> '2024-05-4',
                'nama_bahan'=> 'Plastik SAGU O (60x60x0,4)',
                'jumlah'=> 4
            ],
            [
                'tanggal'=> '2024-05-11',
                'nama_bahan'=> 'Gas Elpiji',
                'jumlah'=> 6
            ],
            [
                'tanggal'=> '2024-05-11',
                'nama_bahan'=> 'Plastik BP (50x60x0,4)',
                'jumlah'=> 9.5
            ],
            [
                'tanggal'=> '2024-05-11',
                'nama_bahan'=> 'Plastik SAGU O (60x60x0,4)',
                'jumlah'=> 8.5
            ],
            [
                'tanggal'=> '2024-05-18',
                'nama_bahan'=> 'Gas Elpiji',
                'jumlah'=> 2
            ],
            [
                'tanggal'=> '2024-05-18',
                'nama_bahan'=> 'Plastik BP (50x60x0,4)',
                'jumlah'=> 4.5
            ],
            [
                'tanggal'=> '2024-05-18',
                'nama_bahan'=> 'Plastik SAGU O (60x60x0,4)',
                'jumlah'=> 6.5
            ],
            [
                'tanggal'=> '2024-05-25',
                'nama_bahan'=> 'Gas Elpiji',
                'jumlah'=> 2
            ],
            [
                'tanggal'=> '2024-05-25',
                'nama_bahan'=> 'Plastik BP (50x60x0,4)',
                'jumlah'=> 4.5
            ],
            [
                'tanggal'=> '2024-05-25',
                'nama_bahan'=> 'Plastik SAGU O (60x60x0,4)',
                'jumlah'=> 6.5
            ],
        ];
        foreach ($stokbahanpenolong as $key => $val) {
            stokbp::create($val);
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

        //rekapresep
        // Define dates
        $dates = [
            '2024-05-04',
            '2024-05-11',
            '2024-05-18',
            '2024-05-25',
        ];

        // Get all reseps
        $reseps = Resep::all();

        // Insert dummy data for each date and each resep
        foreach ($dates as $date) {
            foreach ($reseps as $resep) {
                rekap_resep::create([
                    'resep_id' => $resep->id,
                    'tanggal' => Carbon::parse($date),
                    'jumlah_resep' => rand(1, 10), // Random amount for dummy data
                ]);
            }
        }
    }

}
