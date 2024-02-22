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
        $hutangbahanbaku = hutangbahanbaku::all();
        $totalHutangBahanBaku = total_hutang_bahan_baku::all();
        return view('manager.hutangbahanbaku',compact('bahanbaku', 'hutangbahanbaku', 'totalHutangBahanBaku'));
    }

    public function tambahhutangbahanbaku(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'nama_bahan' => 'required',
            'qty' => 'required|numeric',
            'supplier' => 'required',
        ]);

        $bahanbaku = bahanbaku::where('nama_bahan', $request->input('nama_bahan'))->first();

        $jumlah = $request->input('qty') * $bahanbaku->harga_persatuan;

        hutangbahanbaku::create([
            'nama_bahan'=>$request->input('nama_bahan'),
            'qty'=>$request->input('qty'),
            'satuan'=>$bahanbaku->satuan,
            'harga_satuan'=>$bahanbaku->harga_persatuan,
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

        return redirect('user/manager/hutang_bahan_baku')->with('success', 'hutang berhasil ditambahkan');

    }

    public function lunas($id){
        $data = hutangbahanbaku::find($id);

        $total_hutang = total_hutang_bahan_baku::first();

        $totalHutangBahanBaku = $total_hutang->total_hutang_bahan_baku - $data->jumlah;

        // Simpan atau perbarui data di tabel total_hutang_bahan_bakus
        total_hutang_bahan_baku::updateOrCreate(
            ['id' => 1], // Sesuaikan dengan id yang sesuai dengan data total_hutang_bahan_bakus Anda
            [
                'total_hutang_bahan_baku' => $totalHutangBahanBaku,
                'update' => now(),
            ]
        );

        $data->delete();
        return redirect('user/manager/hutang_bahan_baku')->with('success', 'hutang berhasil dilunasi');
    }

    public function edit(Request $request, $id){
        // Validate the incoming request data
        $request->validate([
            'qty' => 'required|numeric',
            'supplier' => 'required',
        ]);

        $hutang = hutangbahanbaku::findorfail($id);
        $jumlah = $request->input('qty') * $hutang->harga_satuan;

        $hutang->update([
            'qty'=>$request->input('qty'),
            'harga_satuan'=>$hutang->harga_satuan,
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
        $bahanbaku = bahanbaku::where('jenis', 'bahan baku')->get();
        $hutangbahanbaku = hutangbahanbaku::all();
        $totalHutangBahanBaku = total_hutang_bahan_baku::all();
        return view('owner.hutangbahanbaku',compact('bahanbaku', 'hutangbahanbaku', 'totalHutangBahanBaku'));
    }

    public function cetakhutangbahanbaku(){
        $bahanbaku = bahanbaku::where('jenis', 'bahan baku')->get();
        $hutangbahanbaku = hutangbahanbaku::all();
        $totalHutangBahanBaku = total_hutang_bahan_baku::all();
        return view('owner.cetakhutangbahanbaku',compact('bahanbaku', 'hutangbahanbaku', 'totalHutangBahanBaku'));
    }
}
