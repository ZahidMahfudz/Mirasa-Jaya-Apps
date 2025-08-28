<?php

namespace App\Http\Controllers;

use App\Models\piutang;
use App\Http\Requests\StorepiutangRequest;
use App\Http\Requests\UpdatepiutangRequest;
use App\Models\nota_pemasaran;
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
        // $totalsby = Piutang::where('status', 'belum_lunas')->groupBy('oleh')->selectRaw('oleh, sum(total_piutang) as total')->get();
        // $piutangbelumlunas = piutang::orderBy('tanggal_piutang', 'desc')->where('status', 'belum_lunas')->get();
        // $piutanglunas = piutang::orderBy('tanggal_piutang', 'desc')->where('status', 'lunas')->get();
        // $update = Piutang::orderBy('tanggal_piutang', 'desc')->value('tanggal_piutang');
        // $total_piutang = piutang::where('status', 'belum_lunas')->sum('total_piutang');

        $totalsby = nota_pemasaran::where('status', 'belum_lunas')->groupBy('oleh')->selectRaw('oleh, sum(total_nota) as total')->get();
        $piutangbelumlunas = nota_pemasaran::orderBy('tanggal', 'desc')->where('status', 'belum_lunas')->with('item_nota')->get();
        $piutanglunas = nota_pemasaran::orderBy('tanggal', 'desc')->where('status', 'lunas')->with('item_nota')->get();
        $update = nota_pemasaran::orderBy('tanggal', 'desc')->value('tanggal');
        $total_piutang = nota_pemasaran::where('status', 'belum_lunas')->sum('total_nota');

        if(request()->is('user/owner/cetakpiutang')){
            return view('cetak.cetakpiutang', compact('piutangbelumlunas','total_piutang', 'totalsby', 'update'));
        }

        if (auth()->user()->role === 'manager') {
            return view('manager.piutang', compact('piutangbelumlunas', 'piutanglunas', 'total_piutang', 'totalsby', 'update'));
        } elseif (auth()->user()->role === 'owner') {
            return view('owner.piutang', compact('piutangbelumlunas', 'piutanglunas', 'total_piutang', 'totalsby', 'update'));
        } else {
            abort(403, 'Unauthorized action.');
        }
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
            'status' => 'belum_lunas'
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

    public function piutanglunas($id){
        //cari data piutang 
        $dataPiutang = piutang::findorfail($id);

        //Buat entri baru di tabel uangmasukpiutangs
        $uangMasukPiutang = UangMasukPiutang::create([
            'tanggal' => $dataPiutang->tanggal_piutang,
            'tanggal_lunas' => now(),
            'nama_toko' => $dataPiutang->nama_toko,
            'keterangan' => 'piutang :'.$dataPiutang->tanggal_piutang . ' lunas: ' . now(),
            'total_piutang' => $dataPiutang->total_piutang,
        ]);

        //perbarui data ditabel piutang
        $dataPiutang->update([
            'tanggal_lunas' => now(),
            'status'=> 'lunas',
            'Keterangan' => 'lunas pada:'.now()
        ]);

        $data_total_uang_masuk = total_uang_masuk::first();
        if(!$data_total_uang_masuk){
            total_uang_masuk::create([
                'total_uang_masuk' => $dataPiutang->total_piutang,
                'update' => now()
            ]);
        }
        else{
            $totaluangmasuk = $dataPiutang->total_piutang + $data_total_uang_masuk->total_uang_masuk;
    
            total_uang_masuk::updateOrCreate(
                ['id'=>1],
                [
                    'total_uang_masuk'=>$totaluangmasuk,
                    'update'=>now()
                ]
            );
        }

        return redirect('user/manager/piutang')->with('success', 'Piutang dilunasi');
    }

    public function hapuspiutang($id){
        $data = piutang::find($id);

        $data->delete();

        return redirect('user/manager/piutang')->with('success', 'Piutang dihapus');
    }

}
