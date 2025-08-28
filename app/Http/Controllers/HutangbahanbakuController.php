<?php

namespace App\Http\Controllers;

use App\Models\hutangbahanbaku;
use App\Models\total_hutang_bahan_baku;
use App\Models\bahanbaku;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorehutangbahanbakuRequest;
use App\Http\Requests\UpdatehutangbahanbakuRequest;
use Illuminate\Http\Request;


class HutangbahanbakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bahanbaku = bahanbaku::where('jenis', 'bahan baku')->get();
        // $hutangbahanbaku = hutangbahanbaku::all();
        $hutangbelumlunas = hutangbahanbaku::where('status', 'belum_lunas')->orderBy('tanggal', 'desc')->get();
        $hutanglunas = hutangbahanbaku::where('status', 'lunas')->orderBy('tanggal', 'desc')->get();
        // $totalHutangBahanBaku = total_hutang_bahan_baku::all();
        $totalHutangBahanBaku = hutangbahanbaku::where('status', 'belum_lunas')->sum('jumlah');
        $update = hutangbahanbaku::orderBy('tanggal', 'desc')->value('tanggal');
        return view('manager.hutangbahanbaku',compact('bahanbaku', 'hutangbelumlunas', 'hutanglunas', 'totalHutangBahanBaku', 'update'));
    }

    public function tambahhutangbahanbaku(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'nama_bahan' => 'required',
            'tanggal_hutang' => 'required|date',
            'qty' => 'required|numeric',
            'supplier' => 'required',
            'ppn' => 'nullable|numeric',
        ]);

        $bahanbaku = bahanbaku::where('nama_bahan', $request->input('nama_bahan'))->first();

        $jumlah = ($request->input('qty') * $bahanbaku->harga_persatuan) + ($request->input('ppn') ?? 0);

        hutangbahanbaku::create([
            'tanggal' => $request->input('tanggal_hutang'),
            'nama_bahan'=>$request->input('nama_bahan'),
            'qty'=>$request->input('qty'),
            'satuan'=>$bahanbaku->satuan,
            'harga_satuan'=>$bahanbaku->harga_persatuan,
            'ppn'=>$request->input('ppn'),
            'jumlah'=>$jumlah,
            'supplier'=>$request->input('supplier'),
            'status' => 'belum_lunas'
        ]);

        return redirect('user/manager/hutang_bahan_baku')->with('success', 'hutang berhasil ditambahkan');

    }

    public function lunas($id){
        $datahutang = hutangbahanbaku::find($id);

        if(!$datahutang){
            return redirect()->back()->with('error', 'Data Hutang Tidak Ditemukan');
        }

        $datahutang->update([
            'tanggal_lunas' => now(),
            'status' => 'lunas'
        ]);

        return redirect('user/manager/hutang_bahan_baku')->with('success', 'hutang berhasil dilunasi');
    }

    // public function lunas($id){
    //     $data = hutangbahanbaku::find($id);

    //     $total_hutang = total_hutang_bahan_baku::first();

    //     $totalHutangBahanBaku = $total_hutang->total_hutang_bahan_baku - $data->jumlah;

    //     // Simpan atau perbarui data di tabel total_hutang_bahan_bakus
    //     total_hutang_bahan_baku::updateOrCreate(
    //         ['id' => 1], // Sesuaikan dengan id yang sesuai dengan data total_hutang_bahan_bakus Anda
    //         [
    //             'total_hutang_bahan_baku' => $totalHutangBahanBaku,
    //             'update' => now(),
    //         ]
    //     );

    //     $data->delete();
    //     return redirect('user/manager/hutang_bahan_baku')->with('success', 'hutang berhasil dilunasi');
    // }

    public function edit(Request $request, $id){
        // Validate the incoming request data
        $request->validate([
            'qty' => 'required|numeric',
            'supplier' => 'required',
            'ppn' => 'nullable|numeric',
        ]);

        $hutang = hutangbahanbaku::findorfail($id);
        $jumlah = $request->input('qty') * $hutang->harga_satuan + ($request->input('ppn') ?? 0);

        $hutang->update([
            'qty'=>$request->input('qty'),
            'harga_satuan'=>$hutang->harga_satuan,
            'ppn'=>$request->input('ppn'),
            'jumlah'=>$jumlah,
            'supplier'=>$request->input('supplier')
        ]);

        $totalHutangBahanBaku = hutangbahanbaku::sum('jumlah');

        // Simpan atau perbarui data di tabel total_hutang_bahan_bakus
        total_hutang_bahan_baku::updateOrCreate(
            ['id' => 1], // Sesuaikan dengan id yang sesuai dengan data total_hutang_bahan_bakus Anda
            [
                'total_hutang_bahan_baku' => $totalHutangBahanBaku,
                'update' => now(),
            ]
        );
        return redirect('user/manager/hutang_bahan_baku')->with('success', 'hutang berhasil diedit');
    }

    public function indexowner(){
        $hutangbelumlunas = hutangbahanbaku::where('status', 'belum_lunas')->orderBy('tanggal', 'desc')->get();
        $hutanglunas = hutangbahanbaku::where('status', 'lunas')->orderBy('tanggal', 'desc')->get();
        $totalHutangBahanBaku = hutangbahanbaku::where('status', 'belum_lunas')->sum('jumlah');
        $update = hutangbahanbaku::orderBy('tanggal', 'desc')->value('tanggal');
        return view('owner.hutangbahanbaku',compact('hutangbelumlunas', 'hutanglunas', 'totalHutangBahanBaku', 'update'));
    }

    public function cetakhutangbahanbaku(){
        $hutangbelumlunas = hutangbahanbaku::where('status', 'belum_lunas')->orderBy('tanggal', 'desc')->get();
        $totalHutangBahanBaku = hutangbahanbaku::where('status', 'belum_lunas')->sum('jumlah');
        $update = hutangbahanbaku::orderBy('tanggal', 'desc')->value('tanggal');
        return view('cetak.cetakhutangbahanbaku',compact('hutangbelumlunas', 'totalHutangBahanBaku', 'update'));
    }
}
