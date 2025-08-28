<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kas;
use App\Models\R_D;
use App\Models\THR;
use App\Models\resep;
use App\Models\Sosial;
use App\Models\stokbb;
use App\Models\stokbp;
use App\Models\Listrik;
use App\Models\piutang;
use App\Models\Project;
use App\Models\bahanbaku;
use App\Models\BungaBank;
use App\Models\SparePart;
use App\Models\AssetMesin;
use App\Models\SewaTempat;
use App\Models\rekap_resep;
use App\Models\GajiDireksi;
use App\Models\ProfitOwner;
use App\Models\GajiKaryawan;
use Illuminate\Http\Request;
use App\Models\MakanDanMinum;
use App\Models\resume_produksi;
use App\Models\AkomodasiProduksi;
use App\Models\AkomodasiPemasaran;
use App\Models\PembelianBahanBaku;
use App\Http\Controllers\Controller;
use App\Models\hutangbahanbaku;
use App\Models\ModalBankPermata;
use App\Models\ModalDisetor;
use App\Models\PembelianMesinDanAlat;
use App\Models\PerawatanAlatProduksi;
use App\Models\ProfitDibagi;

class ManagerController extends Controller
{
    public function index()
    {
        return view('manager.dashboardUtama');
    }

    //stok bahan baku dan penolong
    public function getStokBahan($tanggal = null)
    {
        if (!$tanggal) {
            return 0; // Return 0 if no date is provided
        }

        // Get bahan baku and bahan penolong
        $bb = bahanbaku::where('jenis', 'bahan baku')->get();
        $bp = bahanbaku::where('jenis', 'bahan penolong')->get();

        // Get the stock for bahan baku and bahan penolong
        $stokbb = stokbb::where('tanggal', $tanggal)->whereIn('nama_bahan', $bb->pluck('nama_bahan'))->get();
        $stokbp = stokbp::where('tanggal', $tanggal)->whereIn('nama_bahan', $bp->pluck('nama_bahan'))->get();

        // Get all rekap resep
        $rekapReseps = rekap_resep::where('tanggal', $tanggal)->with('resep.bahan_resep')->get();

        // Calculate the total for bahan baku, including WIP
        $sumtotalbahanbaku = 0;
        foreach ($stokbb as $bahanbaku) {
            $satuanhargasat = $bb->firstWhere('nama_bahan', $bahanbaku->nama_bahan);
            $gudang = $bahanbaku->gudang;
            $sisaResep = $bahanbaku->sisa_resep;
            $satuanPerZak = $satuanhargasat->banyak_satuan;
            $hargaSatuan = $satuanhargasat->harga_persatuan;

            // Calculate WIP (Work in Progress)
            $wip = 0;
            foreach ($rekapReseps as $rekapResep) {
                foreach ($rekapResep->resep->bahan_resep as $bahanResep) {
                    if ($bahanResep->nama_bahan === $bahanbaku->nama_bahan) {
                        $wip += $bahanResep->jumlah_bahan_zak * $rekapResep->jumlah_resep;
                    }
                }
            }

            // Calculate total bahan baku
            $totalBahanBaku = $gudang + ($sisaResep / $satuanPerZak);
            $totalStokBahanBaku = $totalBahanBaku + $wip;
            $totalHarga = $totalStokBahanBaku * $hargaSatuan;

            $sumtotalbahanbaku += $totalHarga;
        }

        // Calculate the total for bahan penolong
        $sumtotalbahanpenolong = 0;
        foreach ($bp as $bahanpenolong) {
            $jumlah = $stokbp->firstWhere('nama_bahan', $bahanpenolong->nama_bahan);
            if ($jumlah) {
                $totalbp = $jumlah->jumlah * $bahanpenolong->harga_persatuan;
                $sumtotalbahanpenolong += $totalbp;
            }
        }

        // Return the grand total
        return $sumtotalbahanbaku + $sumtotalbahanpenolong;
    }

    public function getStokRotiJadi($tanggal = null)
    {
        if (!$tanggal) {
            return 0; // Return 0 if no date is provided
        }

        $dataStokRotiJadi = resume_produksi::select('resume_produksis.tanggal', 'resume_produksis.nama_produk', 'resume_produksis.sisa', 'ssses.sss', 'produks.harga_satuan')
            ->leftJoin('ssses', function ($join) {
                $join->on('resume_produksis.tanggal', '=', 'ssses.tanggal')
                    ->on('resume_produksis.nama_produk', '=', 'ssses.nama_produk');
            })
            ->leftJoin('produks', function ($join) {
                $join->on('resume_produksis.nama_produk', '=', 'produks.nama_produk');
            })
            ->where('resume_produksis.tanggal', $tanggal)
            ->orderBy('resume_produksis.tanggal', 'desc')
            ->get();

        // Calculate grand total for roti jadi
        $grandHargaTotal = 0;
        foreach ($dataStokRotiJadi as $item) {
            $grandHargaTotal += ($item->sss + $item->sisa) * $item->harga_satuan;
        }

        return $grandHargaTotal;
    }

    public function getPiutang($tanggal)
    {
        return piutang::where('status', 'belum_lunas')
                    ->where('tanggal_piutang', '<=', $tanggal) // Filter berdasarkan tanggal yang dimasukkan
                    ->sum('total_piutang');
    }

    public function getHutangbb($tanggal){
        return hutangbahanbaku::where('status', 'belum_lunas')
                                ->where('tanggal', '<=', $tanggal) // Filter berdasarkan tanggal yang dimasukkan
                                ->sum('jumlah');
    }

    public function getBebanUsaha($tanggal)
    {
        $dataAkun = [
            ['nama' => 'Pengeluaran Akomodasi Produksi', 'model' => AkomodasiProduksi::class],
            ['nama' => 'Pengeluaran Akomodasi Pemasaran', 'model' => AkomodasiPemasaran::class],
            ['nama' => 'Pembelian Perlengkapan Peralatan Produksi (Spare Part)', 'model' => SparePart::class],
            ['nama' => 'Perawatan Alat Produksi', 'model' => PerawatanAlatProduksi::class],
            ['nama' => 'Pembelian Mesin dan Alat Produksi', 'model' => PembelianMesinDanAlat::class],
            ['nama' => 'Gaji Karyawan', 'model' => GajiKaryawan::class],
            ['nama' => 'Gaji Direksi & Akomodasi Owner', 'model' => GajiDireksi::class],
            ['nama' => 'Profit Owner', 'model' => ProfitOwner::class],
            ['nama' => 'Biaya Makan & Minum', 'model' => MakanDanMinum::class],
            ['nama' => 'Biaya Listrik', 'model' => Listrik::class],
            ['nama' => 'Bunga Bank & Pajak', 'model' => BungaBank::class],
            ['nama' => 'Kepentingan Sosial & Kesehatan Karyawan', 'model' => Sosial::class],
            ['nama' => 'R & D', 'model' => R_D::class],
            ['nama' => 'Sewa Tempat', 'model' => SewaTempat::class],
            ['nama' => 'Project', 'model' => Project::class],
            ['nama' => 'THR & Bingkisan Lebaran', 'model' => THR::class],
            ['nama' => 'Profit Sharing', 'model' => ProfitDibagi::class],
            // Tambahkan lebih banyak akun sesuai kebutuhan...
        ];

        // Map setiap akun dan hitung total debit
        $akun = collect($dataAkun)->map(function ($akun) use ($tanggal){
            $debit = $akun['model']::where('tanggal', '<=', $tanggal)->sum('jumlah');
            return (object)[
                'nama' => $akun['nama'],
                'debit' => $debit,
                'kredit' => ''
            ];
        });

        return $akun; // Mengembalikan data akun
    }

    public function getKas($tanggal){
        return Kas::where('tanggal', $tanggal)->sum('jumlah');
    }

    public function getPengeluaranDiluarProduksi($tanggal){
        // Hitung startDate (7 hari sebelum endDate)
        $endDate = Carbon::parse($tanggal)->endOfDay();
        $startDate = $endDate->copy()->subDays(7)->startOfDay();

        $PengeluaranDiluarProduksi = [
            ['nama' => 'Perawatan Alat Produksi', 'model' => PerawatanAlatProduksi::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],
            ['nama' => 'Gaji Direksi', 'model' => GajiDireksi::class, 'columns' => ['pembayaran', 'jumlah'], 'display_type' => 'column'],
            ['nama' => 'Biaya Listrik', 'model' => Listrik::class, 'columns' => ['pembayaran', 'jumlah'], 'display_type' => 'column'],
            ['nama' => 'Bunga Bank', 'model' => BungaBank::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],
            ['nama' => 'Sosial', 'model' => Sosial::class, 'columns' => ['kepentingan', 'jumlah'], 'display_type' => 'column'],
            ['nama' => 'Project', 'model' => Project::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],
            ['nama' => 'Pembelian Mesin dan Alat', 'model' => PembelianMesinDanAlat::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],
            ['nama' => 'Profit Owner', 'model' => ProfitOwner::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],
            ['nama' => 'R & D', 'model' => R_D::class, 'columns' => ['kepentingan', 'jumlah'], 'display_type' => 'column'],
            ['nama' => 'Sewa Tempat', 'model' => SewaTempat::class, 'columns' => ['pembayaran', 'jumlah'], 'display_type' => 'column'], 
            ['nama' => 'THR', 'model' => THR::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],
        ];

        return collect($PengeluaranDiluarProduksi)->map(function ($item) use ($startDate, $endDate) {
            $query = $item['model']::whereBetween('tanggal', [$startDate, $endDate]);

            if ($query->exists()) {
                $total = $query->sum('jumlah');
                $items = $query->get($item['columns']);
                return (object)[
                    'nama' => $item['nama'],
                    'total' => $total,
                    'items' => $items,
                    'display_type' => $item['display_type']
                ];
            }
            return null;
        })->filter();
    }

    public function getPengeluaranDidalamProduksi($tanggal){
        // Hitung startDate (7 hari sebelum endDate)
        $endDate = Carbon::parse($tanggal)->endOfDay();
        $startDate = $endDate->copy()->subDays(7)->startOfDay();

        $PengeluaranDidalamProduksi = [
            ['nama' => 'Pembelian Bahan Baku', 'model' => PembelianBahanBaku::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        ['nama' => 'Pengeluaran Akomodasi Pemasaran', 'model' => AkomodasiPemasaran::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        ['nama' => 'Pengeluaran Akomodasi Produksi', 'model' => AkomodasiProduksi::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        ['nama' => 'Pembelian Spare Part', 'model' => SparePart::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        ['nama' => 'Gaji Karyawan', 'model' => GajiKaryawan::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        ['nama' => 'Makan dan Minum', 'model' => MakanDanMinum::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        ];

        return collect($PengeluaranDidalamProduksi)->map(function ($item) use ($startDate, $endDate) {
            $query = $item['model']::whereBetween('tanggal', [$startDate, $endDate]);

            if ($query->exists()) {
                $total = $query->sum('jumlah');
                $items = $query->get($item['columns']);
                return (object)[
                    'nama' => $item['nama'],
                    'total' => $total,
                    'items' => $items,
                    'display_type' => $item['display_type']
                ];
            }
            return null;
        })->filter();
    }

    public function getModalDisetor($tanggal){
        return ModalDisetor::where('tanggal', '<=', $tanggal) // Filter berdasarkan tanggal yang dimasukkan
                            ->sum('jumlah');
    }

    public function getModalBankPermata($tanggal){
        return ModalBankPermata::where('tanggal', '<=', $tanggal) // Filter berdasarkan tanggal yang dimasukkan
                                ->sum('jumlah');
    }

    public function dashboard(Request $request)
    {
        // Get the date from request or use today's date as default
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        $endDate = $tanggal;
        $startDate = date('Y-m-d', strtotime('-5 days', strtotime($endDate)));  

        // Call the helper functions with the date parameter
        $kas = $this->getKas($tanggal);
        $akun = $this->getBebanUsaha($tanggal);
        $bahanbaku = $this->getStokBahan($tanggal);
        $stokrotijadi = $this->getStokRotiJadi($tanggal);
        $piutang = $this->getPiutang($tanggal);
        $hutangbb = $this->getHutangbb($tanggal);

        $pengeluaranDiluarProduksi = $this->getPengeluaranDiluarProduksi($tanggal);
        $pengeluaranDidalamProduksi = $this->getPengeluaranDidalamProduksi($tanggal);

        $modalDisetor = $this->getModalDisetor($tanggal);
        $modalBankPermata = $this->getModalBankPermata($tanggal);

        // Return view with all data
        return view('manager.dashboard', compact('tanggal','kas','akun','bahanbaku', 'stokrotijadi', 'piutang', 'hutangbb', 'pengeluaranDiluarProduksi', 'pengeluaranDidalamProduksi', 'startDate', 'endDate', 'modalDisetor', 'modalBankPermata'));
    }

    public function ShowNeracaOwner(Request $request){

        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());

        $endDate = $tanggal;
        $startDate = date('Y-m-d', strtotime('-5 days', strtotime($endDate)));

        if(!$request->input('tanggal')){
            $tanggal = $request->input('tanggal', Carbon::today()->toDateString());
        } 

        // Call the helper functions with the date parameter
        $kas = $this->getKas($tanggal);
        $akun = $this->getBebanUsaha($tanggal);
        $bahanbaku = $this->getStokBahan($tanggal);
        $stokrotijadi = $this->getStokRotiJadi($tanggal);
        $piutang = $this->getPiutang($tanggal);
        $hutangbb = $this->getHutangbb($tanggal);
        $pengeluaranDiluarProduksi = $this->getPengeluaranDiluarProduksi($tanggal);
        $pengeluaranDidalamProduksi = $this->getPengeluaranDidalamProduksi($tanggal);
        $modalDisetor = $this->getModalDisetor($tanggal);
        $modalBankPermata = $this->getModalBankPermata($tanggal);

        // Return view with all data
        return view('owner.Neraca', compact('tanggal','kas','akun','bahanbaku', 'stokrotijadi', 'piutang', 'hutangbb', 'pengeluaranDiluarProduksi', 'pengeluaranDidalamProduksi', 'startDate', 'endDate', 'modalDisetor', 'modalBankPermata'));
    }

    public function cetakNeraca($tanggal){
        $endDate = $tanggal;
        $startDate = date('Y-m-d', strtotime('-5 days', strtotime($endDate)));

        // Call the helper functions with the date parameter
        $kas = $this->getKas($tanggal);
        $akun = $this->getBebanUsaha($tanggal);
        $bahanbaku = $this->getStokBahan($tanggal);
        $stokrotijadi = $this->getStokRotiJadi($tanggal);
        $piutang = $this->getPiutang($tanggal);
        $hutangbb = $this->getHutangbb($tanggal);
        $pengeluaranDiluarProduksi = $this->getPengeluaranDiluarProduksi($tanggal);
        $pengeluaranDidalamProduksi = $this->getPengeluaranDidalamProduksi($tanggal);

        // Return view with all data
        return view('cetak.cetakNeraca', compact('tanggal','kas','akun','bahanbaku', 'stokrotijadi', 'piutang', 'hutangbb', 'pengeluaranDiluarProduksi', 'pengeluaranDidalamProduksi', 'startDate', 'endDate'));
    }
    // function dashboard(){
    //     //stok bahan baku dan bahan penolong
    //     // Get the latest date from stokbb table
    //     $tanggal = stokbb::max('tanggal');

    //     // Get bahan baku and bahan penolong
    //     $bb = bahanbaku::where('jenis', 'bahan baku')->get();
    //     $bp = bahanbaku::where('jenis', 'bahan penolong')->get();

    //     // Get the stock for bahan baku and bahan penolong
    //     $stokbb = stokbb::where('tanggal', $tanggal)->whereIn('nama_bahan', $bb->pluck('nama_bahan'))->get();
    //     $stokbp = stokbp::where('tanggal', $tanggal)->whereIn('nama_bahan', $bp->pluck('nama_bahan'))->get();

    //     // Get all rekap resep
    //     $rekapReseps = rekap_resep::where('tanggal', $tanggal)->with('resep.bahan_resep')->get();

    //     // Calculate the total for bahan baku, including WIP
    //     $sumtotalbahanbaku = 0;
    //     foreach ($stokbb as $bahanbaku) {
    //         $satuanhargasat = $bb->firstWhere('nama_bahan', $bahanbaku->nama_bahan);
    //         $gudang = $bahanbaku->gudang;
    //         $sisaResep = $bahanbaku->sisa_resep;
    //         $satuanPerZak = $satuanhargasat->banyak_satuan;
    //         $hargaSatuan = $satuanhargasat->harga_persatuan;

    //         // Calculate WIP (Work in Progress)
    //         $wip = 0;
    //         foreach ($rekapReseps as $rekapResep) {
    //             foreach ($rekapResep->resep->bahan_resep as $bahanResep) {
    //                 if ($bahanResep->nama_bahan === $bahanbaku->nama_bahan) {
    //                     $wip += $bahanResep->jumlah_bahan_zak * $rekapResep->jumlah_resep;
    //                 }
    //             }
    //         }

    //         // Calculate total bahan baku
    //         $totalBahanBaku = $gudang + ($sisaResep / $satuanPerZak);
    //         $totalStokBahanBaku = $totalBahanBaku + $wip;
    //         $totalHarga = $totalStokBahanBaku * $hargaSatuan;

    //         $sumtotalbahanbaku += $totalHarga;
    //     }

    //     // Calculate the total for bahan penolong
    //     $sumtotalbahanpenolong = 0;
    //     foreach ($bp as $bahanpenolong) {
    //         $jumlah = $stokbp->firstWhere('nama_bahan', $bahanpenolong->nama_bahan);
    //         if ($jumlah) {
    //             $totalbp = $jumlah->jumlah * $bahanpenolong->harga_persatuan;
    //             $sumtotalbahanpenolong += $totalbp;
    //         }
    //     }

    //     // Calculate the final total sum
    //     $grandTotalBahan = $sumtotalbahanbaku + $sumtotalbahanpenolong;
    //     //stok roti jadi
    //     $endDate = resume_produksi::max('tanggal');

    //     $dataStokRotiJadi = resume_produksi::select('resume_produksis.tanggal', 'resume_produksis.nama_produk', 'resume_produksis.sisa', 'ssses.sss', 'produks.harga_satuan')
    //         ->leftJoin('ssses', function ($join) {
    //             $join->on('resume_produksis.tanggal', '=', 'ssses.tanggal')
    //                 ->on('resume_produksis.nama_produk', '=', 'ssses.nama_produk');
    //         })
    //         ->leftJoin('produks', function($join){
    //             $join->on('resume_produksis.nama_produk', '=', 'produks.nama_produk');
    //         })
    //         ->where('resume_produksis.tanggal', $endDate)
    //         ->orderBy('resume_produksis.tanggal', 'desc')
    //         ->get();

    //     if(!$dataStokRotiJadi){
    //         $grandHargaTotal = 0;
    //     }else{
    //         $grandHargaTotal = 0;
    
    //         foreach ($dataStokRotiJadi as $item) {
    //             $grandHargaTotal += ($item->sss + $item->sisa) * $item->harga_satuan;
    //         }
    //     }

    //     //Mengambil piutang usaha
    //     $piutang = piutang::where('status', 'belum_lunas')->sum('total_piutang');
    //     $asset_mesin = AssetMesin::all()->sum('jumlah'); // Mengambil jumlah asset mesin
    //     // return view('manager.dashboard',['asset_mesin' => $asset_mesin]);
    //     return view('manager.dashboard', compact('asset_mesin', 'piutang', 'grandHargaTotal', 'grandTotalBahan'));
    // }
    public function showNeraca()
    {
        $asset_mesin = AssetMesin::all()->sum('jumlah_unit');
        return view('manager.neraca',['asset_mesin' => $asset_mesin]);
    }

    public function showNeracaSaldo(Request $request)
    {   
        #$tanggalAwal = $request->input('tanggal_awal');
        #$tanggalAkhir = $request->input('tanggal_akhir');

        $dataAkun = [
            ['nama' => 'Kas', 'model' => Kas::class],

            ['nama' => 'Pengeluaran Akomodasi Produksi', 'model' => AkomodasiProduksi::class],
            ['nama' => 'Pengeluaran Akomodasi Pemasaran', 'model' => AkomodasiPemasaran::class],
            ['nama' => 'Pembelian Perlengkapan Peralatan Produksi (Spare Part)', 'model' => SparePart::class],
            ['nama' => 'Perawatan Alat Produksi', 'model' => PerawatanAlatProduksi::class],
            ['nama' => 'Pembelian Mesin dan Alat Produksi', 'model' => PembelianMesinDanAlat::class],
            ['nama' => 'Gaji Karyawan', 'model' => GajiKaryawan::class],
            ['nama' => 'Gaji Direksi & Akomodasi Owner', 'model' => GajiDireksi::class],
            ['nama' => 'Profit Owner', 'model' => ProfitOwner::class],
            ['nama' => 'Biaya Makan & Minum', 'model' => MakanDanMinum::class],
            ['nama' => 'Biaya Listrik', 'model' => Listrik::class],
            ['nama' => 'Bunga Bank & Pajak', 'model' => BungaBank::class],
            ['nama' => 'Kepentingan Sosial & Kesehatan Karyawan', 'model' => Sosial::class],
            ['nama' => 'R & D', 'model' => R_D::class],
            ['nama' => 'Sewa Tempat', 'model' => SewaTempat::class],
            ['nama' => 'Project', 'model' => Project::class],
            ['nama' => 'THR & Bingkisan Lebaran', 'model' => THR::class],
            // Tambahkan lebih banyak akun sesuai kebutuhan
        ];
    
        $akun = collect($dataAkun)->map(function ($akun) {
            $debit = $akun['model']::sum('jumlah');
            return (object)[
                'nama' => $akun['nama'],
                'debit' => $debit,
                'kredit' => ''
            ];
        });
        return view('manager.neraca_saldo', ['akun' => $akun]);
    
    }

    public function showLaporanRugiLaba()
    {
        #$tanggalAwal = $request->input('tanggal_awal');
        #$tanggalAkhir = $request->input('tanggal_akhir');

        $dataAkun = [
            ['nama' => 'Pengeluaran Akomodasi Produksi', 'model' => AkomodasiProduksi::class],
            ['nama' => 'Pengeluaran Akomodasi Pemasaran', 'model' => AkomodasiPemasaran::class],
            ['nama' => 'Pembelian Perlengkapan Peralatan Produksi (Spare Part)', 'model' => SparePart::class],
            ['nama' => 'Perawatan Alat Produksi', 'model' => PerawatanAlatProduksi::class],
            ['nama' => 'Pembelian Mesin dan Alat Produksi', 'model' => PembelianMesinDanAlat::class],
            ['nama' => 'Gaji Karyawan', 'model' => GajiKaryawan::class],
            ['nama' => 'Gaji Direksi & Akomodasi Owner', 'model' => GajiDireksi::class],
            ['nama' => 'Profit Owner', 'model' => ProfitOwner::class],
            ['nama' => 'Biaya Makan & Minum', 'model' => MakanDanMinum::class],
            ['nama' => 'Biaya Listrik', 'model' => Listrik::class],
            ['nama' => 'Bunga Bank & Pajak', 'model' => BungaBank::class],
            ['nama' => 'Kepentingan Sosial & Kesehatan Karyawan', 'model' => Sosial::class],
            ['nama' => 'R & D', 'model' => R_D::class],
            ['nama' => 'Sewa Tempat', 'model' => SewaTempat::class],
            ['nama' => 'Project', 'model' => Project::class],
            ['nama' => 'THR & Bingkisan Lebaran', 'model' => THR::class],
            // Tambahkan lebih banyak akun sesuai kebutuhan
        ];
    
        $akun = collect($dataAkun)->map(function ($akun) {
            $jumlah = $akun['model']::sum('jumlah');
            return (object)[
                'nama' => $akun['nama'],
                'jumlah' => $jumlah,
                'kredit' => ''
            ];
        });
        return view('manager.laporan_rugi_laba', ['akun' => $akun]);
    
    }

    public function showPengeluaran(Request $request)
    {
    // Ambil parameter filter dari request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    
    if ($startDate && $endDate) {
        // Parse tanggal dari input dan hitung total saldo dalam rentang tanggal tersebut
        $startOfWeek = Carbon::parse($startDate)->startOfDay();
        $endOfWeek = Carbon::parse($endDate)->endOfDay();
    } else {
        // Jika tidak ada filter tanggal, gunakan rentang default (minggu ini)
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Set nilai default untuk view
        $startDate = $startOfWeek->toDateString();  // Untuk menampilkan di form
        $endDate = $endOfWeek->toDateString();      // Untuk menampilkan di form
    }

    $PengeluaranDiluarProduksi = [
        ['nama' => 'Perawatan Alat Produksi', 'model' => PerawatanAlatProduksi::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],
        ['nama' => 'Gaji Direksi', 'model' => GajiDireksi::class, 'columns' => ['pembayaran', 'jumlah'], 'display_type' => 'column'],
        ['nama' => 'Biaya Listrik', 'model' => Listrik::class, 'columns' => ['pembayaran', 'jumlah'], 'display_type' => 'column'],
        ['nama' => 'Bunga Bank', 'model' => BungaBank::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],
        ['nama' => 'Sosial', 'model' => Sosial::class, 'columns' => ['kepentingan', 'jumlah'], 'display_type' => 'column'],
        ['nama' => 'Project', 'model' => Project::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],

        //Masih Belum Tau masuk yg mana
        ['nama' => 'Pembelian Mesin dan Alat', 'model' => PembelianMesinDanAlat::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],
        ['nama' => 'Profit Owner', 'model' => ProfitOwner::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],
        ['nama' => 'R & D', 'model' => R_D::class, 'columns' => ['kepentingan', 'jumlah'], 'display_type' => 'column'],
        ['nama' => 'Sewa Tempat', 'model' => SewaTempat::class, 'columns' => ['pembayaran', 'jumlah'], 'display_type' => 'column'], 
        ['nama' => 'THR', 'model' => THR::class, 'columns' => ['hal', 'jumlah'], 'display_type' => 'column'],
        //['nama' => 'Asset Mesin', 'model' => AssetMesin::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        
    ];

    $PengeluaranDidalamProduksi = [
        ['nama' => 'Pembelian Bahan Baku', 'model' => PembelianBahanBaku::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        ['nama' => 'Pengeluaran Akomodasi Pemasaran', 'model' => AkomodasiPemasaran::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        ['nama' => 'Pengeluaran Akomodasi Produksi', 'model' => AkomodasiProduksi::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        ['nama' => 'Pembelian Spare Part', 'model' => SparePart::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        ['nama' => 'Gaji Karyawan', 'model' => GajiKaryawan::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
        ['nama' => 'Makan dan Minum', 'model' => MakanDanMinum::class, 'columns' => ['jumlah'], 'display_type' => 'value'],
    ];

    //Pengeluaran Di luar Produksi
    $DiluarProduksi = collect($PengeluaranDiluarProduksi)->map(function ($DiluarProduksi) use ($startDate, $endDate) {
        // Ambil data dalam rentang waktu minggu ini
        $query = $DiluarProduksi ['model']::whereBetween('tanggal', [$startDate, $endDate]);
    
        if ($query->exists()) {  // Hanya tampilkan jika ada data
            $total = $query->sum('jumlah');
            
            // Ambil kolom dinamis yang ditentukan dalam 'columns'
            $items = $query->get($DiluarProduksi ['columns']);  // Ambil kolom sesuai dengan 'columns'
    
            return (object)[
                'nama' => $DiluarProduksi ['nama'],
                'total' => $total,
                'items' => $items,
                'display_type' => $DiluarProduksi ['display_type']
            ];
        }
        return null;  // Return null jika tidak ada data
    })->filter();
    //dd($akun);

    //Pengeluaran Di dalam Produksi
    $DidalamProduksi = collect($PengeluaranDidalamProduksi)->map(function ($DidalamProduksi) use ($startDate, $endDate) {
        // Ambil data dalam rentang waktu minggu ini
        $query = $DidalamProduksi ['model']::whereBetween('tanggal', [$startDate, $endDate]);
    
        if ($query->exists()) {  // Hanya tampilkan jika ada data
            $total = $query->sum('jumlah');
            
            // Ambil kolom dinamis yang ditentukan dalam 'columns'
            $items = $query->get($DidalamProduksi ['columns']);  // Ambil kolom sesuai dengan 'columns'
    
            return (object)[
                'nama' => $DidalamProduksi ['nama'],
                'total' => $total,
                'items' => $items,
                'display_type' => $DidalamProduksi['display_type']
            ];
        }
        return null;  // Return null jika tidak ada data
    })->filter();
    //dd($akun);

        return view('manager.pengeluaran', compact('startDate', 'endDate','DiluarProduksi','DidalamProduksi'));
    }


    //Controller untuk Profit Minggu ini
    public function DashboardOwner(Request $request)
    {
        // If no date is provided, fetch the last 4 Saturdays
        if (!$request->has('tanggal')) {
            $tanggal = Carbon::now();
            $dates = $this->getLastFourSaturdays();
        } else {
            $tanggal = Carbon::parse($request->input('tanggal'));
        
            // Mengganti nextOrSame dengan solusi alternatif
            $saturday = $tanggal->isSaturday() ? $tanggal : $tanggal->copy()->next(Carbon::SATURDAY); // Ambil Sabtu minggu ini dari tanggal yang diinput
    
            $dates = [$saturday]; // Sabtu minggu ini
            // Tambahkan Sabtu minggu-minggu sebelumnya
            for ($i = 1; $i < 4; $i++) {
                $dates[] = $saturday->copy()->subWeek($i);
            }
    
            // Membalik urutan array agar Sabtu terbaru tetap di paling kanan
            $dates = array_reverse($dates);
        }

        // Fetch data for each date
        $data = [];
        foreach ($dates as $date) {
            $formattedDate = $date->format('Y-m-d');

            $data[] = [
                'tanggal' => $date->format('d-M-y'),
                'kas' => $this->getKas($formattedDate),
                'piutang' => $this->getPiutang($formattedDate),
                'stok_roti_jadi' => $this->getStokRotiJadi($formattedDate),
                'stok_bahan_baku' => $this->getStokBahan($formattedDate),
                'hutang_bb' => $this->getHutangbb($formattedDate),
                'profit' => $this->calculateProfit($formattedDate),
            ];
        }

        return view('owner.dashboard', compact('data', 'tanggal'));
    }

    // Function to get the last 4 Saturdays
    private function getLastFourSaturdays()
    {
        $saturdays = [];
        $today = Carbon::now();
        
        // Ambil Sabtu dalam minggu ini
        $saturdays[] = $today->next(Carbon::SATURDAY);
        
        // Tambahkan Sabtu minggu-minggu sebelumnya
        for ($i = 1; $i < 4; $i++) {
            $saturdays[] = $saturdays[$i - 1]->copy()->subWeek();
        }

        // Membalik urutan array agar Sabtu terbaru di paling kanan
        return array_reverse($saturdays);
    }

    // Function to calculate profit based on the date
    private function calculateProfit($tanggal)
    {
        $kas = $this->getKas($tanggal);
        $piutang = $this->getPiutang($tanggal);
        $stok_roti_jadi = $this->getStokRotiJadi($tanggal);
        $stok_bahan_baku = $this->getStokBahan($tanggal);
        $hutang_bb = $this->getHutangbb($tanggal);

        // Example of a basic profit calculation (adjust as necessary)
        return ($kas + $piutang + $stok_roti_jadi + $stok_bahan_baku) - ($hutang_bb);
    }

    public function cetakprofitmingguan($tanggal)
    {
        // Ubah $tanggal menjadi objek Carbon
        $tanggalcetak = Carbon::parse($tanggal);
        
        // Mengganti nextOrSame dengan solusi alternatif
        $saturday = $tanggalcetak->isSaturday() ? $tanggalcetak : $tanggalcetak->copy()->next(Carbon::SATURDAY); // Ambil Sabtu minggu ini dari tanggal yang diinput

        $dates = [$saturday]; // Sabtu minggu ini
        // Tambahkan Sabtu minggu-minggu sebelumnya
        for ($i = 1; $i < 4; $i++) {
            $dates[] = $saturday->copy()->subWeek($i);
        }

        // Membalik urutan array agar Sabtu terbaru tetap di paling kanan
        $dates = array_reverse($dates);

        // Fetch data for each date
        $data = [];
        foreach ($dates as $date) {
            $formattedDate = $date->format('Y-m-d');

            $data[] = [
                'tanggal' => $date->format('d-M-y'),
                'kas' => $this->getKas($formattedDate),
                'piutang' => $this->getPiutang($formattedDate),
                'stok_roti_jadi' => $this->getStokRotiJadi($formattedDate),
                'stok_bahan_baku' => $this->getStokBahan($formattedDate),
                'hutang_bb' => $this->getHutangbb($formattedDate),
                'profit' => $this->calculateProfit($formattedDate),
            ];
        }

        return view('cetak.cetakprofitMingguan', compact('data', 'tanggal'));
    }

}
