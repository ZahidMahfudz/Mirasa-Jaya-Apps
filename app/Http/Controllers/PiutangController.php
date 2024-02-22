<?php

namespace App\Http\Controllers;

use App\Models\piutang;
use App\Http\Requests\StorepiutangRequest;
use App\Http\Requests\UpdatepiutangRequest;
use App\Models\total_piutang;
use Illuminate\Http\Request;
use App\Models\uangmasukpiutang;
use App\Models\uangmasukretail;
use App\Models\total_uang_masuk;

class PiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalsby = Piutang::groupBy('oleh')->selectRaw('oleh, sum(total_piutang) as total')->get();
        $piutang = piutang::orderBy('tanggal_piutang', 'desc')->get();
        $total_piutang = total_piutang::all();
        return view('manager.piutang', compact('piutang','total_piutang', 'totalsby'));
    }

    public function tambahpiutang(Request $request){
        // dd($request->input())->all();
        $validatedData = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'tanggal_piutang' => 'required|date',
            'total_piutang' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
            'oleh' => 'required|string|max:255'
        ]);

        $simpan = piutang::create([
            'tanggal_piutang'=>$request->input('tanggal_piutang'),
            'nama_toko'=>$request->input('nama_toko'),
            'Keterangan'=>$request->input('keterangan'),
            'total_piutang'=>$request->input('total_piutang'),
            'oleh'=>$request->input('oleh'),
        ]);

        $total_piutang = piutang::sum('total_piutang');

        total_piutang::updateOrCreate(
            ['id'=>1],
            [
                'total_piutang'=>$total_piutang,
                'update'=>now()
            ]
        );

        return redirect('user/manager/piutang')->with('success', 'data berhasil ditambah');
    }

    public function editpiutang(Request $request, $id){
        $request->validate([
            'tanggal_piutang' => 'required|date',
            'total_piutang' => 'required|numeric',
            'keterangan' => 'required|string',
            'oleh' => 'required|string',
        ]);

        $piutang = piutang::find($id);

        $piutang->update([
            'tanggal_piutang'=> $request->input('tanggal_piutang'),
            'total_piutang'=> $request->input('total_piutang'),
            'Keterangan'=> $request->input('keterangan'),
            'oleh'=> $request->input('oleh'),
        ]);

        $total_piutang = total_piutang::first();

        $totalpiutang = piutang::sum('total_piutang');

        $total_piutang::updateOrCreate(
            ['id'=>1],
            [
                'total_piutang'=>$totalpiutang,
                'update'=>now()
            ]
        );
        return redirect('user/manager/piutang')->with('success', 'data berhasil diedit');
    }


    public function piutanglunas($id)
    {
        // Cari data piutang
        $dataPiutang = Piutang::findOrFail($id);

        // Simpan total piutang sebelum penghapusan data
        $totalPiutang = total_piutang::first();
        $totalpiutang = Piutang::sum('total_piutang');

        // Simpan total uang masuk sebelum penambahan
        $totalUangMasuk = total_uang_masuk::find(1);
        $totaluangmasuk = UangMasukPiutang::sum('total_piutang');

        // Buat entri baru di tabel uangmasukpiutangs
        $uangMasukPiutang = UangMasukPiutang::create([
            'tanggal' => now(),
            'tanggal_lunas' => now(),
            'nama_toko' => $dataPiutang->nama_toko,
            'keterangan' => 'piutang :'.$dataPiutang->tanggal_piutang . ' lunas: ' . now(),
            'total_piutang' => $dataPiutang->total_piutang,
        ]);

        // Perbarui total uang masuk
        if (!$totalUangMasuk) {
            total_uang_masuk::create([
                'total_uang_masuk' => $totaluangmasuk,
                'update' => now()
            ]);
        } else {
            $totalUangMasuk->update([
                'total_uang_masuk' => $totaluangmasuk,
                'update' => now()
            ]);
        }
        $total_piutang = $totalPiutang->total_piutang - $dataPiutang->total_piutang;

        total_piutang::updateOrCreate(
            ['id'=>1],
            [
                'total_piutang'=>$total_piutang,
                'update'=>now()
            ]
        );

        // Hapus entri piutang
        $dataPiutang->delete();

        return redirect('user/manager/piutang')->with('success', 'Piutang dilunasi');
    }

    public function indexowner(){
        $totalsby = Piutang::groupBy('oleh')->selectRaw('oleh, sum(total_piutang) as total')->get();
        $piutang = piutang::orderBy('tanggal_piutang', 'desc')->get();
        $total_piutang = total_piutang::all();
        return view('owner.piutang', compact('piutang','total_piutang', 'totalsby'));
    }

    public function cetakpiutang(){
        $totalsby = Piutang::groupBy('oleh')->selectRaw('oleh, sum(total_piutang) as total')->get();
        $piutang = piutang::orderBy('tanggal_piutang', 'desc')->get();
        $total_piutang = total_piutang::all();
        return view('owner.cetakpiutang', compact('piutang','total_piutang', 'totalsby'));
    }

}
