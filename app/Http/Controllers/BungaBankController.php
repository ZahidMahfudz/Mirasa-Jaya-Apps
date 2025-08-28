<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BungaBank;

class BungaBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tanggalAkhir = $request->input('tanggalAkhir');
        $tanggalAwal = $request->input('tanggalAwal');

        if(!$request->input('tanggalAkhir')){
            $tanggalAkhir = BungaBank::max('tanggal');
            $tanggalAwal = date('Y-m-d', strtotime('-5 days', strtotime($tanggalAkhir)));  
        }

        $bunga_bank = BungaBank::when($tanggalAwal && $tanggalAkhir, function ($query) use ($tanggalAwal, $tanggalAkhir) {
            return $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        })->get();
        return view('Manager.BungaBank.index', ['bunga_bank' => $bunga_bank, 'tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir]);

    }

    public function indexOwner(Request $request){
        $tanggalAkhir = $request->input('tanggalAkhir');

        if(!$request->input('tanggalAkhir')){
            $tanggalAkhir = BungaBank::max('tanggal');
        }

        $bunga_bank = BungaBank::where('tanggal', '<=', $tanggalAkhir)->get();
        $totalBunga = BungaBank::where('tanggal', '<=', $tanggalAkhir)->sum('jumlah');
        return view('owner.BebanUsaha.BungaBank', ['bunga_bank' => $bunga_bank, 'totalBunga' => $totalBunga, 'tanggalAkhir' => $tanggalAkhir]);
    }

    public function cetak($tanggalAkhir){
        $bunga_bank = BungaBank::where('tanggal', '<=', $tanggalAkhir)->get();
        $totalBunga = BungaBank::where('tanggal', '<=', $tanggalAkhir)->sum('jumlah');
        return view('cetak.cetakBungaBank', ['bunga_bank' => $bunga_bank, 'totalBunga' => $totalBunga, 'tanggalAkhir' => $tanggalAkhir]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Manager.BungaBank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'hal' => 'required',
            'jumlah' => 'required|numeric',
        ]);
        BungaBank::create($request->all());
        return redirect()->back()->with('success', 'Data berhasil ditambah');
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
        $data = BungaBank::find($id);
        return view('Manager.BungaBank.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal' => 'required',
            'hal' => 'required',
            'jumlah' => 'required|numeric',
        ]);
        BungaBank::find($id)->update($request->all());
        return redirect()->back()->with('success', 'Data berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        BungaBank::destroy($id);
        return redirect()->back()->with('success', 'Data berhasil dihapus');

    }
}
