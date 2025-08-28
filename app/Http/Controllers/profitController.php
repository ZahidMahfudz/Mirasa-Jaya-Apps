<?php

namespace App\Http\Controllers;

use App\Models\resep;
use App\Models\stokbb;
use App\Models\stokbp;
use App\Models\rekap_resep;
use App\Models\bahanbaku;
use App\Models\Kas;
use Illuminate\Http\Request;
use App\Models\resume_produksi;
use Illuminate\Support\Facades\DB;

class profitController extends Controller
{
    public function getKas($tanggal){
        // Ambil total kas dalam periode satu minggu sebelum $tanggal
        $startDate = \Carbon\Carbon::parse($tanggal)->subDays(6)->toDateString();
        $totalKas = Kas::whereBetween('tanggal', [$startDate, $tanggal])->sum('jumlah');
        // Ambil saldo terakhir dari kas_bank_permatas dalam periode satu minggu sebelum $tanggal
        $totalKasBankPermata = DB::table('kas_bank_permata')
            ->whereBetween('tanggal', [$startDate, $tanggal])
            ->orderBy('tanggal', 'desc')
            ->value('saldo');
        
        $totalKas += $totalKasBankPermata ?? 0;

        return $totalKas;
    }

    public function getPiutang($tanggal){
        $totalPiutang = DB::table('nota_pemasarans')
            ->where('tanggal', '<=', $tanggal)
            ->where(function($query) use ($tanggal) {
            $query->whereNull('tanggal_lunas')
                  ->orWhere('tanggal_lunas', '>', $tanggal);
            })
            ->where('jenis_nota', '!=', 'nota_cash')
            ->sum('total_nota');

        return $totalPiutang;
    }

    public function getStokRotiJadi($tanggal){
        $dataStokRotiJadi = resume_produksi::select(
            'resume_produksis.tanggal',
            'resume_produksis.nama_produk',
            'resume_produksis.sisa',
            'ssses.sss',
            'produks.harga_satuan'
            )
            ->leftJoin('ssses', function ($join) {
            $join->on('resume_produksis.tanggal', '=', 'ssses.tanggal')
                 ->on('resume_produksis.nama_produk', '=', 'ssses.nama_produk');
            })
            ->leftJoin('produks', function($join){
            $join->on('resume_produksis.nama_produk', '=', 'produks.nama_produk');
            })
            ->where('resume_produksis.tanggal', $tanggal)
            ->orderBy('resume_produksis.tanggal', 'desc')
            ->get();

        $totalNominal = 0;
        foreach ($dataStokRotiJadi as $item) {
            $sisa = $item->sisa ?? 0;
            $sss = $item->sss ?? 0;
            $harga_satuan = $item->harga_satuan ?? 0;
            $totalNominal += ($sisa + $sss) * $harga_satuan;
        }

        return $totalNominal;
    }

    public function getStok($tanggal){
        //ambil data dari tabel bahanbaku, dan pisahkan antara bahan baku dan bahan penolong
        $bb = bahanbaku::where('jenis', 'bahan baku')->get();
        $bp = bahanbaku::where('jenis', 'bahan penolong')->get();

        //sortir berdasarkan $bb dan $bp
        $stokbb = stokbb::where('tanggal', $tanggal)->whereIn('nama_bahan', $bb->pluck('nama_bahan'))->get();
        $stokbp = stokbp::where('tanggal', $tanggal)->whereIn('nama_bahan', $bp->pluck('nama_bahan'))->get();

        // Ambil semua rekap resep
        $rekapReseps = rekap_resep::where('tanggal', $tanggal)->with('resep.bahan_resep')->get();

        //mencari total stok bahan baku
        $wipData = [];
        foreach ($rekapReseps as $rekapResep) {
            foreach ($rekapResep->resep->bahan_resep as $bahanResep) {
                if (!isset($wipData[$bahanResep->nama_bahan])) {
                    $wipData[$bahanResep->nama_bahan] = 0;
                }
                $wipData[$bahanResep->nama_bahan] += $bahanResep->jumlah_bahan_zak * $rekapResep->jumlah_resep;
            }
        }

        $sumtotalbahanbaku = 0;
        foreach ($stokbb as $bahanbaku) {
            // Ambil satuan dan harga
            $satuanhargasat = $bb->firstWhere('nama_bahan', $bahanbaku->nama_bahan);

            // Hitung stok bahan baku
            $totalBahanBaku = $bahanbaku->gudang + ($bahanbaku->sisa_resep / $satuanhargasat->banyak_satuan);
            $wip = $wipData[$bahanbaku->nama_bahan] ?? 0;
            $totalStokBahanBaku = $totalBahanBaku + $wip;

            // Hitung total harga
            $totalHarga = $totalStokBahanBaku * $satuanhargasat->harga_persatuan;
            $sumtotalbahanbaku += $totalHarga;
        }

        //mencari total stok bahan penolong
        $sumtotalbahanpenolong = 0;
        $stokbpData = $stokbp->keyBy('nama_bahan'); // Mapping nama bahan untuk akses cepat

        foreach ($bp as $bahanpenolong) {
            if (isset($stokbpData[$bahanpenolong->nama_bahan])) {
                $jumlah = $stokbpData[$bahanpenolong->nama_bahan]->jumlah;
                $hargaPersatuan = $bahanpenolong->harga_persatuan;
                $sumtotalbahanpenolong += $jumlah * $hargaPersatuan;
            }
        }

        return $sumtotalbahanpenolong + $sumtotalbahanbaku;

    }

    public function getHutangBB($tanggal){
        $totalHutang = DB::table('hutangbahanbakus')
            ->where('tanggal', '<=', $tanggal)
            ->where(function($query) use ($tanggal) {
                $query->whereNull('tanggal_lunas')
                      ->orWhere('tanggal_lunas', '>', $tanggal);
            })
            ->sum('jumlah');

        return $totalHutang;
    }

    public function getPreviousSaturdays($tanggal, $count = 4) {
            $dates = [];
            $date = \Carbon\Carbon::parse($tanggal);
            // Cari Sabtu terdekat ke belakang (atau sama)
            if ($date->dayOfWeek !== \Carbon\Carbon::SATURDAY) {
                $date->subDays(($date->dayOfWeek + 1) % 7);
            }
            // Ambil dari 4 minggu lalu ke minggu ini
            for ($i = $count - 1; $i >= 0; $i--) {
                $dates[] = $date->copy()->subWeeks($i)->toDateString();
            }
            return $dates;
    }

    public function showProfit($tanggal){

        $saturdays = $this->getPreviousSaturdays($tanggal, 4);

        $data = [];
        foreach ($saturdays as $tgl) {
            $data[] = [
            'tanggal' => $tgl,
            'kas' => $this->getKas($tgl),
            'piutang' => $this->getPiutang($tgl),
            'stok_roti_jadi' => $this->getStokRotiJadi($tgl),
            'stok_bahan_baku' => $this->getStok($tgl),
            'hutang_bb' => $this->getHutangBB($tgl),
            ];
        }

        if(request()->is("/user/owner/cetak-profit-mingguan/$tanggal")){
            return view('owner.cetak_profit_mingguan', compact('data', 'saturdays', 'tanggal'));
        }

        return view('owner.dashboard', compact('data', 'saturdays', 'tanggal'));
        // dd($data);
    }

    public function filterProfit(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        $tanggal = $request->input('tanggal');
        return redirect("/user/owner/dasboard/$tanggal");
    }
}
