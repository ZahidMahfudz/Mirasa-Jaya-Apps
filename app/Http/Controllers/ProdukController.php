<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreprodukRequest;
use App\Http\Requests\UpdateprodukRequest;
use Illuminate\Http\Request;


class ProdukController extends Controller
{
    public function index()
    {
        $data = produk::all();
        return view('manager.harga_produk', compact('data'));
    }

    public function tambah(Request $request){
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric|min:0',
        ],[
            'nama_produk.required'=>'Nama Produk Wajib Diisi',
            'Harga_satuan.required'=>'Harga satuan Wajib Diisi'
        ]);

        $store = produk::create([
            'nama_produk'=>$request->input('nama_produk'),
            'harga_satuan'=>$request->input('harga_satuan')
        ]);
        return redirect('user/manager/harga_produk')->with('success', 'databerhasil di input');
    }

    public function edit(Request $request, $id){
        // Validasi input menggunakan fungsi validate()
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        // Temukan produk berdasarkan ID
        $produk = produk::findOrFail($id);

        // Update data produk
        $produk->update([
            'nama_produk' => $request->input('nama_produk'),
            'harga_satuan' => $request->input('harga_satuan'),
        ]);

        // Redirect atau kembalikan respons sesuai kebutuhan
        return redirect('user/manager/harga_produk')->with('success', 'Produk berhasil diupdate.');
    }

    public function delete($id){
        $data = produk::find($id);
        $data->delete();
        return redirect('user/manager/harga_produk')->with('success', 'Produk berhasil diupdate.');
    }

}
