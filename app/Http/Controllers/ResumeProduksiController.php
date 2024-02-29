<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;
use App\Models\resume_produksi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Storeresume_produksiRequest;
use App\Http\Requests\Updateresume_produksiRequest;

class ResumeProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_resume = resume_produksi::all();
        $groupedData = $data_resume->groupBy('nama_produk');
        $uniqueDates = resume_produksi::distinct('tanggal')->pluck('tanggal')->toArray();
        $produk = produk::all();
        $produks = produk::all();

        return view('manager.resumeproduksi', compact('groupedData', 'uniqueDates', 'produk', 'produks'));
    }

    public function tambahResume(Request $request){
        // return dd($request->input());
        $request->validate([
            'tanggal_resume' => 'required|date',
            'nama_produk' => 'required|string',
            'in' => 'required|integer|min:0',
            'OUT' => 'required|integer|min:0',
        ]);

        $produk = resume_produksi::where('nama_produk', $request->input('nama_produk'))
            ->orderBy('tanggal', 'desc') // Urutkan berdasarkan tanggal secara descending
            ->first(); // Ambil record pertama

        if($produk === NULL){
            $sisa = $request->input('in') - $request->input('OUT');
        }
        else if($produk->sisa == 0){
            $sisa = $request->input('in') - $request->input('OUT');
        }
        else{
            $sisa = $produk->sisa + $request->input('in') - $request->input('OUT');
        }

        $simpan = resume_produksi::create([
            'tanggal'=>$request->input('tanggal_resume'),
            'nama_produk'=>$request->input('nama_produk'),
            'in'=>$request->input('in'),
            'out'=>$request->input('OUT'),
            'sisa'=>$sisa
        ]);

        return redirect('user/manager/resumeproduksi')->with('success', 'data berhasil ditambah');
    }

}
