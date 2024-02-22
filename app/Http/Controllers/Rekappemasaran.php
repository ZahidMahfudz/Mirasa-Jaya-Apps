<?php

namespace App\Http\Controllers;

use App\Models\nota_pemasaran;
use App\Models\produk;
use Illuminate\Http\Request;

class Rekappemasaran extends Controller
{
    public function index(){
        $produk = produk::all();
        $produks = produk::all();
        $notacash = nota_pemasaran::where('jenis_nota', 'nota_cash')->get();
        $notanoncash = nota_pemasaran::where('jenis_nota', 'nota_noncash')->get();
        return view('manager.rekappemasaran', compact('produk', 'produks', 'notacash', 'notanoncash'));
    }

    public function tambahNota(Request  $request){
        $request->validate([
            'jenis_nota' => 'required|in:nota_cash,nota_noncash',
            'tanggal_Nota' => 'required|date',
            'nama_toko' => 'required|string',
            'QTY' => 'required|integer|min:1',
            'nama_produk_nota' => 'required|string',
        ]);

        $simpan = nota_pemasaran::create([
            'jenis_nota'=>$request->input('jenis_nota'),
            'tanggal'=>$request->input('tanggal_Nota'),
            'nama_toko'=>$request->input('nama_toko'),
            'qty'=>$request->input('QTY'),
            'nama_barang'=>$request->input('nama_produk_nota'),
        ]);

        return redirect('user/manager/rekappemasaran')->with('success', 'nota berhasil ditambahkan');
    }

    public function editNota(Request $request, $id){
        $request->validate([
            'QTY' => 'required|numeric|min:1',
            'nama_produk_nota' => 'required|exists:produks,nama_produk',
        ], [
            'QTY.required' => 'Kolom QTY harus diisi.',
            'QTY.numeric' => 'Kolom QTY harus berupa angka.',
            'QTY.min' => 'Kolom QTY harus bernilai minimal 1.',
            'nama_produk_nota.required' => 'Kolom Nama Produk harus diisi.',
            'nama_produk_nota.exists' => 'Nama Produk tidak valid.',
        ]);

        $nota = nota_pemasaran::find($id);

        $nota->update([
            'qty'=>$request->input('QTY'),
            'nama_barang'=>$request->input('nama_produk_nota')
        ]);

        return redirect('user/manager/rekappemasaran')->with('success', 'nota berhasil diedit');
    }

    public function deleteNota($id){
        $data = nota_pemasaran::find($id);
        $data->delete();
        return redirect('user/manager/rekappemasaran')->with('success', 'nota berhasil dihapus');
    }
}
