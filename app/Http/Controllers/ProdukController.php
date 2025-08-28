<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreprodukRequest;
use App\Http\Requests\UpdateprodukRequest;
use App\Models\bahanbaku;
use Illuminate\Http\Request;


class ProdukController extends Controller
{
    public function index()
    {
        $data = produk::all();
        $kardus = bahanbaku::where('jenis', 'kardus')->get();
        return view('admin.harga_produk', compact('data', 'kardus'));
    }

    public function tambah(Request $request){
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric|min:0',
        ],[
            'nama_produk.required'=>'Nama Produk Wajib Diisi',
            'Harga_satuan.required'=>'Harga satuan Wajib Diisi'
        ],[
            'jenis_kardus' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\bahanbaku::where('jenis', 'kardus')
                        ->where('nama_bahan', $value)
                        ->exists();
                    if (!$exists) {
                        $fail('Jenis kardus tidak valid atau tidak tersedia.');
                    }
                }
            ]
        ]);

        $store = produk::create([
            'nama_produk'=>$request->input('nama_produk'),
            'harga_satuan'=>$request->input('harga_satuan'),
            'jenis_kardus' =>$request->input('jenis_kardus')
        ]);
        return redirect()->back()->with('success', 'Produk Berhasil Ditambahkan');
    }

    public function edit(Request $request, $id){
        // Validasi input menggunakan fungsi validate()
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric|min:0',
            'jenis_kardus' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\bahanbaku::where('jenis', 'kardus')
                        ->where('nama_bahan', $value)
                        ->exists();
                    if (!$exists) {
                        $fail('Jenis kardus tidak valid atau tidak tersedia.');
                    }
                }
            ]
        ]);

        // Temukan produk berdasarkan ID
        $produk = produk::findOrFail($id);

        // Update data produk
        $produk->update([
            'nama_produk' => $request->input('nama_produk'),
            'harga_satuan' => $request->input('harga_satuan'),
            'jenis_kardus' =>$request->input('jenis_kardus')
        ]);

        // Redirect atau kembalikan respons sesuai kebutuhan
        return redirect()->back()->with('success', 'Produk berhasil diupdate.');
    }

    public function delete($id){
        $data = produk::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

}
