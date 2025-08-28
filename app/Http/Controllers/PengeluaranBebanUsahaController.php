<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\pengeluaranBebanUsaha;
// use GuzzleHttp\Psr7\Request;
use App\Http\Requests\StorepengeluaranBebanUsahaRequest;
use App\Http\Requests\UpdatepengeluaranBebanUsahaRequest;

class PengeluaranBebanUsahaController extends Controller
{
    public function showPengeluaran($tanggal){
        $pengeluaran = pengeluaranBebanUsaha::where('tanggal_pengeluaran', $tanggal)->get();
        return view('admin.Pengeluaran', compact('pengeluaran', 'tanggal'));
    }

    public function tambahPengeluaran(Request $request){
        $request->validate([
            'jenisPengeluaran' => 'required|string|max:255',
            'namaPengeluaran' => 'required|string|max:255',
            'qty' => 'nullable|numeric|min:0',
            'harga_satuan' => 'nullable|numeric|min:0',
            'total_pengeluaran' => 'nullable|numeric|min:0'
        ]);

        $tanggalHariIni = now()->format('Y-m-d');

        $qty = $request->input('qty');
        $harga_satuan = $request->input('harga_satuan');
        $total_pengeluaran = $request->input('total_pengeluaran');

        if (!is_null($qty) && !is_null($harga_satuan) && is_null($total_pengeluaran)) {
            $total_pengeluaran = $qty * $harga_satuan;
        } elseif (is_null($qty) && is_null($harga_satuan) && !is_null($total_pengeluaran)) {
            $qty = null;
            $harga_satuan = null;
        } elseif (is_null($qty) && !is_null($harga_satuan) && !is_null($total_pengeluaran)) {
            return redirect()->back()->withErrors('Pastikan mengisi form dengan benar.');
        } elseif (!is_null($qty) && is_null($harga_satuan) && !is_null($total_pengeluaran)) {
            return redirect()->back()->withErrors('Pastikan mengisi form dengan benar.');
        }

        pengeluaranBebanUsaha::create([
            'jenis_pengeluaran' => $request->input('jenisPengeluaran'),
            'tanggal_pengeluaran' => $tanggalHariIni,
            'keterangan' => $request->input('namaPengeluaran'),
            'qty' => $qty,
            'harga_satuan' => $harga_satuan,
            'total_pengeluaran' => $total_pengeluaran
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function editPengeluaran(Request $request, $id){
        $request->validate([
            'jenisPengeluaran' => 'required|string|max:255',
            'namaPengeluaran' => 'required|string|max:255',
            'qty' => 'nullable|numeric|min:0',
            'harga_satuan' => 'nullable|numeric|min:0',
            'total_pengeluaran' => 'nullable|numeric|min:0'
        ]);

        $qty = $request->input('qty');
        $harga_satuan = $request->input('harga_satuan');
        $total_pengeluaran = $request->input('total_pengeluaran');

        if (!is_null($qty) && !is_null($harga_satuan) && is_null($total_pengeluaran)) {
            $total_pengeluaran = $qty * $harga_satuan;
        } elseif (is_null($qty) && is_null($harga_satuan) && !is_null($total_pengeluaran)) {
            $qty = null;
            $harga_satuan = null;
        } elseif (is_null($qty) && !is_null($harga_satuan) && !is_null($total_pengeluaran)) {
            return redirect()->back()->withErrors('Pastikan mengisi form dengan benar.');
        } elseif (!is_null($qty) && is_null($harga_satuan) && !is_null($total_pengeluaran)) {
            return redirect()->back()->withErrors('Pastikan mengisi form dengan benar.');
        }

        $pengeluaran = pengeluaranBebanUsaha::find($id);

        $pengeluaran->jenis_pengeluaran = $request->input('jenisPengeluaran');
        $pengeluaran->keterangan = $request->input('namaPengeluaran');
        $pengeluaran->qty = $qty;
        $pengeluaran->harga_satuan = $harga_satuan;
        $pengeluaran->total_pengeluaran = $total_pengeluaran;
        $pengeluaran->save();

        return redirect()->back()->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function deletePengeluaran($id){
        $pengeluaran = pengeluaranBebanUsaha::find($id);
        $pengeluaran->delete();

        return redirect()->back()->with('success', 'Pengeluaran berhasil dihapus.');
    }

    public function showPengeluaranManager($date){
        $pengeluaran = pengeluaranBebanUsaha::where('tanggal_pengeluaran', $date)->get();
        return view('manager.Pengeluaran', compact('pengeluaran', 'date'));
    }

    public function ShowBebanUsaha($startOfWeek, $endOfWeek){
        $endOfWeek = $endOfWeek;
        $startOfWeek = $startOfWeek;

        $pembelianbb = \Illuminate\Support\Facades\DB::table('pengeluaran_beban_usahas')
            ->selectRaw('tanggal_pengeluaran, SUM(total_pengeluaran) as total_pengeluaran')
            ->where('jenis_pengeluaran', 'bb')
            ->whereBetween('tanggal_pengeluaran', [$startOfWeek, $endOfWeek])
            ->groupBy('tanggal_pengeluaran')
            ->orderBy('tanggal_pengeluaran', 'asc')
            ->get();

        $akmodoasiPemasaran = \Illuminate\Support\Facades\DB::table('pengeluaran_beban_usahas')
            ->selectRaw('tanggal_pengeluaran, SUM(total_pengeluaran) as total_pengeluaran')
            ->where('jenis_pengeluaran', 'akpem')
            ->whereBetween('tanggal_pengeluaran', [$startOfWeek, $endOfWeek])
            ->groupBy('tanggal_pengeluaran')
            ->orderBy('tanggal_pengeluaran', 'asc')
            ->get();

        $akomodasiProduksi = \Illuminate\Support\Facades\DB::table('pengeluaran_beban_usahas')
            ->selectRaw('tanggal_pengeluaran, SUM(total_pengeluaran) as total_pengeluaran')
            ->where('jenis_pengeluaran', 'akpro')
            ->whereBetween('tanggal_pengeluaran', [$startOfWeek, $endOfWeek])
            ->groupBy('tanggal_pengeluaran')
            ->orderBy('tanggal_pengeluaran', 'asc')
            ->get();

        $perlengkapan = \Illuminate\Support\Facades\DB::table('pengeluaran_beban_usahas')
            ->selectRaw('tanggal_pengeluaran, SUM(total_pengeluaran) as total_pengeluaran')
            ->where('jenis_pengeluaran', 'perl')
            ->whereBetween('tanggal_pengeluaran', [$startOfWeek, $endOfWeek])
            ->groupBy('tanggal_pengeluaran')
            ->orderBy('tanggal_pengeluaran', 'asc')
            ->get();

        $makan = \Illuminate\Support\Facades\DB::table('pengeluaran_beban_usahas')
            ->selectRaw('tanggal_pengeluaran, SUM(total_pengeluaran) as total_pengeluaran')
            ->where('jenis_pengeluaran', 'm')
            ->whereBetween('tanggal_pengeluaran', [$startOfWeek, $endOfWeek])
            ->groupBy('tanggal_pengeluaran')
            ->orderBy('tanggal_pengeluaran', 'asc')
            ->get();

        $gajiKaryawan = \Illuminate\Support\Facades\DB::table('pengeluaran_beban_usahas')
            ->selectRaw('tanggal_pengeluaran, SUM(total_pengeluaran) as total_pengeluaran')
            ->where('jenis_pengeluaran', 'gk')
            ->whereBetween('tanggal_pengeluaran', [$startOfWeek, $endOfWeek])
            ->groupBy('tanggal_pengeluaran')
            ->orderBy('tanggal_pengeluaran', 'asc')
            ->get();

        $datesInRange = collect();
        $startDate = new \DateTime($startOfWeek);
        $endDate = new \DateTime($endOfWeek);

        for ($date = $startDate; $date <= $endDate; $date->modify('+1 day')) {
            $datesInRange->push($date->format('Y-m-d'));
        }

        $pembelianbb = $datesInRange->map(function ($date) use ($pembelianbb) {
            $found = $pembelianbb->firstWhere('tanggal_pengeluaran', $date);
            return [
            'tanggal_pengeluaran' => $date,
            'total_pengeluaran' => $found ? $found->total_pengeluaran : 0,
            ];
        });

        $akmodoasiPemasaran = $datesInRange->map(function ($date) use ($akmodoasiPemasaran) {
            $found = $akmodoasiPemasaran->firstWhere('tanggal_pengeluaran', $date);
            return [
            'tanggal_pengeluaran' => $date,
            'total_pengeluaran' => $found ? $found->total_pengeluaran : 0,
            ];
        });

        $akomodasiProduksi = $datesInRange->map(function ($date) use ($akomodasiProduksi) {
            $found = $akomodasiProduksi->firstWhere('tanggal_pengeluaran', $date);
            return [
            'tanggal_pengeluaran' => $date,
            'total_pengeluaran' => $found ? $found->total_pengeluaran : 0,
            ];
        });

        $perlengkapan = $datesInRange->map(function ($date) use ($perlengkapan) {
            $found = $perlengkapan->firstWhere('tanggal_pengeluaran', $date);
            return [
            'tanggal_pengeluaran' => $date,
            'total_pengeluaran' => $found ? $found->total_pengeluaran : 0,
            ];
        });

        $makan = $datesInRange->map(function ($date) use ($makan) {
            $found = $makan->firstWhere('tanggal_pengeluaran', $date);
            return [
            'tanggal_pengeluaran' => $date,
            'total_pengeluaran' => $found ? $found->total_pengeluaran : 0,
            ];
        });

        $gajiKaryawan = $datesInRange->map(function ($date) use ($gajiKaryawan) {
            $found = $gajiKaryawan->firstWhere('tanggal_pengeluaran', $date);
            return [
            'tanggal_pengeluaran' => $date,
            'total_pengeluaran' => $found ? $found->total_pengeluaran : 0,
            ];
        });

        $tanggalPertamaPengeluaran = pengeluaranBebanUsaha::orderBy('tanggal_pengeluaran', 'asc')->value('tanggal_pengeluaran');
        $perba = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'pera')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get()->isEmpty() ? null : pengeluaranBebanUsaha::where('jenis_pengeluaran', 'pera')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get();
        $pemba = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'pemba')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get()->isEmpty() ? null : pengeluaranBebanUsaha::where('jenis_pengeluaran', 'pemba')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get();
        $gajiDireksi = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'gd')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get()->isEmpty() ? null : pengeluaranBebanUsaha::where('jenis_pengeluaran', 'gd')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get();
        $listrik = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'lis')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get()->isEmpty() ? null : pengeluaranBebanUsaha::where('jenis_pengeluaran', 'lis')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get();
        $pajak = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'pajak')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get()->isEmpty() ? null : pengeluaranBebanUsaha::where('jenis_pengeluaran', 'pajak')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get();
        $sosial = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'sos')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get()->isEmpty() ? null : pengeluaranBebanUsaha::where('jenis_pengeluaran', 'sos')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get();
        $sewaTempat = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'st')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get()->isEmpty() ? null : pengeluaranBebanUsaha::where('jenis_pengeluaran', 'st')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get();
        $project = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'project')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get()->isEmpty() ? null : pengeluaranBebanUsaha::where('jenis_pengeluaran', 'project')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get();
        $thr = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'thr')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get()->isEmpty() ? null : pengeluaranBebanUsaha::where('jenis_pengeluaran', 'thr')->whereBetween('tanggal_pengeluaran', [$tanggalPertamaPengeluaran, $date])->get();
        
        if (request()->is("user/owner/cetak-beban-usaha/$startOfWeek/$endOfWeek")) {
            return view('cetak.cetakBebanUsaha', compact(
                'date',
                'startOfWeek',
                'endOfWeek', 
                'tanggalPertamaPengeluaran',
                'pembelianbb', 
                'akmodoasiPemasaran', 
                'akomodasiProduksi', 
                'perlengkapan', 
                'makan', 
                'gajiKaryawan', 
                'perba', 
                'pemba', 
                'gajiDireksi', 
                'listrik', 
                'pajak', 
                'sosial', 
                'sewaTempat', 
                'project', 
                'thr'
            ));
        }

        $user = auth()->user();

        if ($user->role === 'manager') {
            return view('manager.bebanUsaha', compact(
            'date',
            'startOfWeek',
            'endOfWeek', 
            'tanggalPertamaPengeluaran',
            'pembelianbb', 
            'akmodoasiPemasaran', 
            'akomodasiProduksi', 
            'perlengkapan', 
            'makan', 
            'gajiKaryawan', 
            'perba', 
            'pemba', 
            'gajiDireksi', 
            'listrik', 
            'pajak', 
            'sosial', 
            'sewaTempat', 
            'project', 
            'thr'
            ));
        } elseif ($user->role === 'owner') {
            return view('owner.bebanUsaha', compact(
                'date',
                'startOfWeek',
                'endOfWeek', 
                'tanggalPertamaPengeluaran',
                'pembelianbb', 
                'akmodoasiPemasaran', 
                'akomodasiProduksi', 
                'perlengkapan', 
                'makan', 
                'gajiKaryawan', 
                'perba', 
                'pemba', 
                'gajiDireksi', 
                'listrik', 
                'pajak', 
                'sosial', 
                'sewaTempat', 
                'project', 
                'thr'
            ));
        } else {
            return redirect()->back()->withErrors('Akses tidak diizinkan.');
        }
        

        // dd($startOfWeek);
    }
    
    // app/Http/Controllers/PengeluaranBebanUsahaController.php
    public function filterBebanUsaha(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date|before_or_equal:endDate',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        // Mengambil parameter dengan nama yang benar
        $startOfWeek = $request->input('startDate');
        $endOfWeek = $request->input('endDate');

        // Redirect dengan parameter yang sesuai
        return redirect("/user/owner/bebanUsaha/$startOfWeek/$endOfWeek");
    }

}
