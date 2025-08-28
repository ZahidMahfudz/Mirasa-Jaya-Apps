<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetMesin;

class AssetMesinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $jenisUrutan = ['Bagelen', 'Bolu_Panggang', 'Spet_Manual', 'Resep', 'Oven_Rotary', 'Mikser', 'Mesin_Kukies', 'Timbangan_Digital', 'Rak_Trolley_&_Loyang', 'Alat_Pendukung_Produksi'];
        $asset_mesin = AssetMesin::all()->sortBy(function ($item) use ($jenisUrutan) {
            $index = array_search($item->jenis, $jenisUrutan);
            return $index !== false ? $index : count($jenisUrutan);
        });
        return view('Manager.AssetMesin.index',['asset_mesin' => $asset_mesin]);
        
    }

    public function indexOwner(){
        $assets = AssetMesin::orderBy('jenis')->get()->groupBy('jenis');
        return view('owner.asetMesin', compact('assets'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Manager.AssetMesin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mesin/alat' => 'required',
            'jenis' => 'required',
            'jumlah_unit' => 'required|numeric',
            'harga_beli' => 'required|numeric',
        ]);

        $request['jumlah'] = $request['jumlah_unit'] * $request['harga_beli']; // Hitung jumlah

        AssetMesin::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $asset_mesin = AssetMesin::find($id);
        return view('Manager.AssetMesin.edit', ['asset_mesin' => $asset_mesin]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mesin/alat' => 'required',
            'jenis' => 'required',
            'jumlah_unit' => 'required|numeric',
            'harga_beli' => 'required|numeric',
        ]);

        $request['jumlah'] = $request['jumlah_unit'] * $request['harga_beli']; // Hitung jumlah

        AssetMesin::find($id)->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        AssetMesin::destroy($id);
        return redirect()->back();

    }
}
