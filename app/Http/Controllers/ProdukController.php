<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreprodukRequest;
use App\Http\Requests\UpdateprodukRequest;
use Illuminate\Http\Request;


class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreprodukRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(produk $produk)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprodukRequest $request, produk $produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(produk $produk)
    {
        //
    }
}
