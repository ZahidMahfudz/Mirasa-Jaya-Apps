<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\stokbb;
use App\Models\bahanbaku;
use App\Models\stok_kardus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorestokbbRequest;
use App\Http\Requests\UpdatestokbbRequest;
use App\Models\bahan_resep;
use App\Models\rekap_resep;
use App\Models\resep;
use App\Models\stokbp;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\CssSelector\Node\FunctionNode;

class StokbbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexstok()
    {
        //ambil tanggal maksimal dari tabel stokbb
        $tanggal = stokbb::max('tanggal');

        //ambil data dari tabel bahanbaku, dan pisahkan antara bahan baku dan bahan penolong
        $bb = bahanbaku::where('jenis', 'bahan baku')->get();
        $bp = bahanbaku::where('jenis', 'bahan penolong')->get();

        //sortir berdasarkan $bb dan $bp
        $stokbb = stokbb::where('tanggal', $tanggal)->whereIn('nama_bahan', $bb->pluck('nama_bahan'))->get();
        $stokbp = stokbp::where('tanggal', $tanggal)->whereIn('nama_bahan', $bp->pluck('nama_bahan'))->get();

        // Ambil semua rekap resep
        $rekapReseps = rekap_resep::where('tanggal', $tanggal)->with('resep.bahan_resep')->get();

        return view('manager.stok', compact('tanggal', 'bb', 'bp', 'stokbb', 'stokbp', 'rekapReseps'));
    }

    public function editstokbb(Request $request, $id)
    {
        $validatedData = $request->validate([
            'gudang' => 'required|numeric',
            'sisa_resep' => 'required|numeric',
        ]);

        $databahanbaku = stokbb::find($id);

        $databahanbaku->update([
            'gudang' => $validatedData['gudang'],
            'sisa_resep' => $validatedData['sisa_resep']
        ]);

        return redirect('/user/manager/stokbb')->with('success', 'Data berhasil diperbauri');
    }

    public function editstokbp(Request $request, $id)
    {
        $validatedData = $request->validate([
            'jumlah' => 'required|numeric'
        ]);

        $databahanpenolong = stokbp::find($id);

        $databahanpenolong->update([
            'jumlah' => $validatedData['jumlah']
        ]);

        return redirect('/user/manager/stokbb')->with('success', 'Data berhasil diperbauri');
    }

    public function generatestok()
    {
        $tanggalHariIni = Carbon::now()->toDateString();

        $stokbb = stokbb::where('tanggal', $tanggalHariIni)->first();
        $stokbp = stokbp::where('tanggal', $tanggalHariIni)->first();
        $wip = rekap_resep::where('tanggal', $tanggalHariIni)->first();

        if ($stokbb && $stokbp && $wip) {
            return redirect()->back()->with('error', 'Stok tanggal tersebut sudah dibuat');
        } else {
            $bb = bahanbaku::where('jenis', 'bahan baku')->get();
            $bp = bahanbaku::where('jenis', 'bahan penolong')->get();
            $workInProgress = resep::all();

            foreach ($bb as $bahanbaku) {
                stokbb::create([
                    'tanggal' => $tanggalHariIni,
                    'nama_bahan' => $bahanbaku->nama_bahan,
                    'gudang' => 0,
                    'sisa_resep' => 0
                ]);
            }

            foreach ($bp as $bahanpenolong) {
                stokbp::create([
                    'tanggal' => $tanggalHariIni,
                    'nama_bahan' => $bahanpenolong->nama_bahan,
                    'jumlah' => 0
                ]);
            }

            foreach ($workInProgress as $wip) {
                rekap_resep::create([
                    'resep_id' => $wip->id,
                    'tanggal' => $tanggalHariIni,
                    'jumlah_resep' => 0
                ]);
            }
            return redirect()->back()->with('success', 'Stok berhasil digenerate');
        }
    }

    public function indexkardus()
    {
        $endDate = stok_kardus::max('tanggal');
        $startDate = date('Y-m-d', strtotime('-5 days', strtotime($endDate)));

        $data_stok_kardus = stok_kardus::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();
        $groupedData = $data_stok_kardus->groupBy('nama_kardus');
        $uniqueDates = stok_kardus::whereBetween('tanggal', [$startDate, $endDate])->distinct('tanggal')->pluck('tanggal')->toArray();

        return view('manager.stokkardus', compact('groupedData', 'uniqueDates', 'startDate', 'endDate'));
    }

    public function generateStokKardus()
    {
        $tanggalHariIni = Carbon::now()->toDateString();

        $stok_kardus_hari_ini = stok_kardus::where('tanggal', $tanggalHariIni)->first();

        $stokkemaren = stok_kardus::where('tanggal', '<', $tanggalHariIni)->orderBy('tanggal', 'desc')->first();

        $kardus = bahanbaku::where('jenis', 'kardus')->get();

        if ($stok_kardus_hari_ini) {
            return redirect()->back()->with('error', 'Stok kardus untuk hari ini sudah ada.');
        }
        else if(!$stokkemaren){
            foreach($kardus as $kardus){
                stok_kardus::create([
                    'tanggal' => $tanggalHariIni,
                    'nama_kardus' => $kardus->nama_bahan,
                    'pakai' => 0,
                    'sisa' => 0
                ]);
            }

            return redirect()->back()->with('success', 'kardus berhasil digenerate');
        }
        else{
            foreach ($kardus as $item) {
                $sisaKemarin = stok_kardus::where('nama_kardus', $item->nama_bahan)
                    ->where('tanggal', '<', $tanggalHariIni)
                    ->orderBy('tanggal', 'desc')
                    ->first();
    
                $sisa = $sisaKemarin ? $sisaKemarin->sisa : 0;
    
                stok_kardus::create([
                    'tanggal' => $tanggalHariIni,
                    'nama_kardus' => $item->nama_bahan,
                    'pakai' => 0,
                    'sisa' => $sisa
                ]);
            }
            return redirect('/user/manager/kardus')->with('success', 'Data berhasil diperbarui');
        }
    }

    public function editStokKardus(Request $request, $id)
    {
        $request->validate([
            'pakai' => 'required|integer|min:0',
        ]);

        $stok_kardus = stok_kardus::findOrFail($id);

        $tanggal_sebelumnya = date('Y-m-d', strtotime('-1 day', strtotime($stok_kardus->tanggal)));

        $stok_kardus_sebelumnya = stok_kardus::where('tanggal', $tanggal_sebelumnya)->where('nama_kardus', $stok_kardus->nama_kardus)->first();

        if ($stok_kardus_sebelumnya) {
            $sisa_sebelumnya = $stok_kardus_sebelumnya->sisa;
        } else {
            // Jika tidak ada data untuk tanggal sebelumnya, asumsikan sisa sebelumnya adalah 0
            // $sisa_sebelumnya = 0;
            return redirect()->back()->with('error', 'Data hari kemarin tidak ditemukan');
        }

        if ($stok_kardus_sebelumnya->sisa === null) {
            // $sisa = $request->input('pakai');
            return redirect()->back()->with('error', 'silahkan tambahkan kardus '.$stok_kardus->nama_kardus.' terlebih dahulu');
        } elseif ($stok_kardus_sebelumnya->sisa == 0) {
            // $sisa = $request->input('pakai');
            return redirect()->back()->with('error', 'silahkan tambahkan kardus '.$stok_kardus->nama_kardus.' terlebih dahulu');
        } else {
            $sisa = $sisa_sebelumnya - $request->input('pakai');
        }

        $sisa = max(0, $sisa);

        $stok_kardus->update([
            'pakai' => $request->input('pakai'),
            'sisa' => $sisa
        ]);

        return redirect('/user/manager/kardus')->with('success', 'Data berhasil diperbarui');
    }

    public function tambahKardus(Request $request, $id)
    {
        $request->validate([
            'tambah' => 'required|integer|min:0',
        ]);

        $stok_kardus = stok_kardus::findOrFail($id);

        $stok_kardus->update([
            'sisa' => $stok_kardus->sisa + $request->input('tambah')
        ]);

        return redirect('/user/manager/kardus')->with('success', 'Data berhasil diperbarui');
    }

    public function indexownerkardus()
    {
        $endDate = stok_kardus::max('tanggal');
        $startDate = date('Y-m-d', strtotime('-5 days', strtotime($endDate)));

        $data_stok_kardus = stok_kardus::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();
        $groupedData = $data_stok_kardus->groupBy('nama_kardus');
        $uniqueDates = stok_kardus::whereBetween('tanggal', [$startDate, $endDate])->distinct('tanggal')->pluck('tanggal')->toArray();

        return view('owner.stokkardus', compact('groupedData', 'uniqueDates', 'startDate', 'endDate'));
    }

    public function cetakstokkardus($startDate, $endDate)
    {
        $startDate = $startDate;
        $endDate = $endDate;

        $data_stok_kardus = stok_kardus::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();
        $groupedData = $data_stok_kardus->groupBy('nama_kardus');
        $uniqueDates = stok_kardus::whereBetween('tanggal', [$startDate, $endDate])->distinct('tanggal')->pluck('tanggal')->toArray();

        return view('cetak.cetakstokkardus', compact('groupedData', 'uniqueDates', 'startDate', 'endDate'));
    }

    public function filterstokkardus(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
    
        // if ($endDate->lessThan($startDate)) {
        //     return redirect()->back()->with('error', 'Tanggal tidak valid');
        // }

        $data_stok_kardus = stok_kardus::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();
        $groupedData = $data_stok_kardus->groupBy('nama_kardus');
        $uniqueDates = stok_kardus::whereBetween('tanggal', [$startDate, $endDate])->distinct('tanggal')->pluck('tanggal')->toArray();

        return view('owner.stokkardus', compact('groupedData', 'uniqueDates', 'startDate', 'endDate'));
    }


    public function editwip(Request $request, $id)
    {
        $request->validate([
            'jumlah_resep' => 'required|integer|min:1'
        ]);

        $data_resep = rekap_resep::findOrFail($id);

        $data_resep->update([
            'jumlah_resep' => $request->input('jumlah_resep')
        ]);

        return redirect()->back()->with('success', 'Data Berhasil diperbarui');
    }

    public function indexresep()
    {
        $resep = resep::with('bahan_resep')->get();
        $bb = bahanbaku::where('jenis', 'bahan baku')->get();

        return view('admin.resepwip', compact('resep', 'bb'));
    }

    public function resepstore(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_resep' => 'required|string|max:255',
            'lini_produksi' => 'required|string|max:255',
            'nama_bahan.*' => 'required|string',
            'jumlah_bahan_gr.*' => 'required|numeric',
            'jumlah_bahan_kg.*' => 'required|numeric',
            'jumlah_bahan_zak.*' => 'required|numeric',
        ]);

        // Buat resep baru
        $resep = new resep();
        $resep->nama_resep = $request->nama_resep;
        $resep->lini_produksi = $request->lini_produksi;
        $resep->save();

        // Tambahkan bahan ke resep
        $bahanList = [];
        for ($i = 0; $i < count($request->nama_bahan); $i++) {
            $bahanList[] = [
                'resep_id' => $resep->id,
                'nama_bahan' => $request->nama_bahan[$i],
                'jumlah_bahan_gr' => $request->jumlah_bahan_gr[$i],
                'jumlah_bahan_kg' => $request->jumlah_bahan_kg[$i],
                'jumlah_bahan_zak' => $request->jumlah_bahan_zak[$i],
            ];
        }
        bahan_resep::insert($bahanList);

        return redirect()->back()->with('success', 'Resep berhasil ditambahkan');
    }

    public function bahan_resepstore(Request $request){
         // Validasi input
         $validatedData = $request->validate([
            'resep_id' => 'required|exists:reseps,id',
            'nama_bahan' => 'required|string|max:255',
            'jumlah_bahan_gr' => 'required|numeric',
            'jumlah_bahan_kg' => 'required|numeric',
            'jumlah_bahan_zak' => 'required|numeric',
        ]);

        // Buat bahan resep baru
        $bahanResep = new bahan_resep();
        $bahanResep->resep_id = $validatedData['resep_id'];
        $bahanResep->nama_bahan = $validatedData['nama_bahan'];
        $bahanResep->jumlah_bahan_gr = $validatedData['jumlah_bahan_gr'] ?? 0;
        $bahanResep->jumlah_bahan_kg = $validatedData['jumlah_bahan_kg'] ?? 0;
        $bahanResep->jumlah_bahan_zak = $validatedData['jumlah_bahan_zak'] ?? 0;
        $bahanResep->save();

        // Redirect ke halaman resep dengan pesan sukses
        return redirect()->back()->with('success', 'Bahan berhasil ditambahkan.');
    }

    public function resepupdate(Request $request, $id){
        $validatedData = $request->validate([
            'nama_resep' => 'required|string|max:255',
            'lini_produksi' => 'required|string|max:255',
            'jumlah_bahan_gr' => 'array',
            'jumlah_bahan_gr.*' => 'nullable|numeric|min:0',
            'jumlah_bahan_kg' => 'array',
            'jumlah_bahan_kg.*' => 'nullable|numeric|min:0',
            'jumlah_bahan_zak' => 'array',
            'jumlah_bahan_zak.*' => 'nullable|numeric|min:0',
        ]);

        $resep = resep::findOrFail($id);
        $resep->nama_resep = $request->input('nama_resep');
        $resep->lini_produksi = $request->input('lini_produksi');
        $resep->save();

        foreach ($resep->bahan_resep as $index => $bahanResep) {
            $bahanResep->jumlah_bahan_gr = $request->input('jumlah_bahan_gr')[$index] ?? 0;
            $bahanResep->jumlah_bahan_kg = $request->input('jumlah_bahan_kg')[$index] ?? 0;
            $bahanResep->jumlah_bahan_zak = $request->input('jumlah_bahan_zak')[$index] ?? 0;
            $bahanResep->save();
        }

        return redirect()->back()->with('success', 'Resep berhasil diperbarui.');
    }

    public function resepdestroy($id){
        // Cari resep berdasarkan ID
        $resep = Resep::find($id);

        // Jika resep ditemukan, hapus
        if ($resep) {
            // Hapus bahan-bahan yang terkait dengan resep tersebut
            bahan_resep::where('resep_id', $id)->delete();

            // Hapus resep
            $resep->delete();

            return redirect()->back()->with('success', 'Resep dan bahan-bahannya berhasil dihapus.');
        }

        // Jika resep tidak ditemukan, beri pesan error
        return redirect()->back()->with('error', 'Resep tidak ditemukan.');
    }

    public function indexstokowner(){
        //ambil tanggal maksimal dari tabel stokbb
        $tanggal = stokbb::max('tanggal');

        //ambil data dari tabel bahanbaku, dan pisahkan antara bahan baku dan bahan penolong
        $bb = bahanbaku::where('jenis', 'bahan baku')->get();
        $bp = bahanbaku::where('jenis', 'bahan penolong')->get();

        //sortir berdasarkan $bb dan $bp
        $stokbb = stokbb::where('tanggal', $tanggal)->whereIn('nama_bahan', $bb->pluck('nama_bahan'))->get();
        $stokbp = stokbp::where('tanggal', $tanggal)->whereIn('nama_bahan', $bp->pluck('nama_bahan'))->get();

        // Ambil semua rekap resep
        $rekapReseps = rekap_resep::where('tanggal', $tanggal)->with('resep.bahan_resep')->get();

        return view('owner.stok', compact('tanggal', 'bb', 'bp', 'stokbb', 'stokbp', 'rekapReseps'));
    }

    public function cetakstok($startDate){
        //ambil data dari tabel bahanbaku, dan pisahkan antara bahan baku dan bahan penolong
        $bb = bahanbaku::where('jenis', 'bahan baku')->get();
        $bp = bahanbaku::where('jenis', 'bahan penolong')->get();

        //sortir berdasarkan $bb dan $bp
        $stokbb = stokbb::where('tanggal', $startDate)->whereIn('nama_bahan', $bb->pluck('nama_bahan'))->get();
        $stokbp = stokbp::where('tanggal', $startDate)->whereIn('nama_bahan', $bp->pluck('nama_bahan'))->get();

        // Ambil semua rekap resep
        $rekapReseps = rekap_resep::where('tanggal', $startDate)->with('resep.bahan_resep')->get();

        return view('cetak.cetakstok', compact('startDate', 'bb', 'bp', 'stokbb', 'stokbp', 'rekapReseps'));
    }

    public function filterowner(Request $request){
        $tanggal = $request->input('startDate');

        $bb = bahanbaku::where('jenis', 'bahan baku')->get();
        $bp = bahanbaku::where('jenis', 'bahan penolong')->get();

        //sortir berdasarkan $bb dan $bp
        $stokbb = stokbb::where('tanggal', $tanggal)->whereIn('nama_bahan', $bb->pluck('nama_bahan'))->get();
        $stokbp = stokbp::where('tanggal', $tanggal)->whereIn('nama_bahan', $bp->pluck('nama_bahan'))->get();

        // Ambil semua rekap resep
        $rekapReseps = rekap_resep::where('tanggal', $tanggal)->with('resep.bahan_resep')->get();

        return view('owner.stok', compact('tanggal', 'bb', 'bp', 'stokbb', 'stokbp', 'rekapReseps'));
    }
}
