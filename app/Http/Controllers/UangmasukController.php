<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\produk;
use App\Models\total_uang_masuk;
use App\Models\uangmasukpiutang;
use App\Models\uangmasukretail;

class UangmasukController extends Controller
{
    public function index(){
        $retail = uangmasukretail::orderBy('tanggal', 'desc')->get();
        $piutang = uangmasukpiutang::orderBy('tanggal', 'desc')->get();
        $totaluangmasuk = total_uang_masuk::all();
        $produk = produk::all();
        return view('manager.uangmasuk', compact('retail','piutang','totaluangmasuk','produk'));
    }

    public function tambahuangmasukpiutang(Request $request){
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'tanggal_nota' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
            'total_piutang' => 'required|numeric|min:0',
        ]);

        $simpan = uangmasukpiutang::create([
            'tanggal'=>$request->input('tanggal_nota'),
            'tanggal_lunas'=>null,
            'nama_toko'=>$request->input('nama_toko'),
            'keterangan'=>$request->input('keterangan'),
            'total_piutang'=>$request->input('total_piutang'),
        ]);

        $totaluangmasuk = uangmasukpiutang::sum('total_piutang') + uangmasukretail::sum('jumlah');

        total_uang_masuk::updateOrCreate(
            ['id'=>1],
            [
                'total_uang_masuk'=>$totaluangmasuk,
                'update'=>now()
            ]
        );

        return redirect('user/manager/uang_masuk')->with('succsess', 'data berhasil ditambah');
    }

    public function tambahretail(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
            'nama_produk' => 'required',
            'qty' => 'required|numeric|min:1',
            'satuan' => 'required',
        ]);

        $produk = produk::where('nama_produk', $request->input('nama_produk'))->first();

        $jumlah = $request->input('qty') * $produk->harga_satuan;

        $simpan = uangmasukretail::create([
            'tanggal'=>$request->input('tanggal'),
            'nama_produk'=>$request->input('nama_produk'),
            'qty'=>$request->input('qty'),
            'satuan'=>$request->input('satuan'),
            'harga_satuan'=>$produk->harga_satuan,
            'jumlah'=>$jumlah,
        ]);

        $totaluangmasuk = uangmasukpiutang::sum('total_piutang') + uangmasukretail::sum('jumlah');

        total_uang_masuk::updateOrCreate(
            ['id'=>1],
            [
                'total_uang_masuk'=>$totaluangmasuk,
                'update'=>now()
            ]
        );

        return redirect('user/manager/uang_masuk')->with('succsess', 'data berhasil ditambah');
    }

    public function deleteuangmasukpiutang($id){
        $data = uangmasukpiutang::find($id);
        $total_uang_masuk = total_uang_masuk::first();

        $totaluangmasuk = $total_uang_masuk->total_uang_masuk - $data->total_piutang;

        total_uang_masuk::updateOrCreate(
            ['id'=>1],
            [
                'total_uang_masuk'=>$totaluangmasuk,
                'update'=>now()
            ]
        );

        $data->delete();

        return redirect('user/manager/uang_masuk')->with('succsess', 'data berhasil ditambah');
    }

    public function deleteuangmasukretail($id){
        $data = uangmasukretail::find($id);
        $total_uang_masuk = total_uang_masuk::first();

        $totaluangmasuk = $total_uang_masuk->total_uang_masuk - $data->jumlah;

        total_uang_masuk::updateOrCreate(
            ['id'=>1],
            [
                'total_uang_masuk'=>$totaluangmasuk,
                'update'=>now()
            ]
        );

        $data->delete();

        return redirect('user/manager/uang_masuk')->with('succsess', 'data berhasil ditambah');
    }

    public function edituangmasukpiutang(Request $request, $id){
        $request->validate([
            'tanggal_nota' => 'required|date',
            'keterangan' => 'required|string',
            'total_piutang' => 'required|numeric|min:0',
        ]);

        $uangmasukpiutang = uangmasukpiutang::find($id);

        $uangmasukpiutang->update([
            'tanggal'=>$request->input('tanggal_nota'),
            'keterangan'=>$request->input('keterangan'),
            'total_piutang'=>$request->input('total_piutang'),
        ]);

        $total_uang_masuk = total_uang_masuk::first();

        $totaluangmasuk = uangmasukpiutang::sum('total_piutang') + uangmasukretail::sum('jumlah');

        total_uang_masuk::updateOrCreate(
            ['id'=>1],
            [
                'total_uang_masuk'=>$totaluangmasuk,
                'update'=>now()
            ]
        );
        return redirect('user/manager/uang_masuk')->with('succsess', 'data berhasil ditambah');
    }

    public function edituangmasukretail(Request $request, $id){
        $request->validate([
            'qty' => 'required|numeric|min:1',
            'satuan' => 'required|string',
        ]);

        $produk = produk::where('nama_produk', $request->input('nama_produk'))->first();
        $jumlah = $request->input('qty') * $produk->harga_satuan;

        $uangmasukretail = uangmasukretail::find($id);
        $uangmasukretail->update([
            'qty'=>$request->input('qty'),
            'satuan'=>$request->input('satuan'),
            'jumlah'=>$jumlah,
        ]);

        $total_uang_masuk = total_uang_masuk::first();

        $totaluangmasuk = uangmasukpiutang::sum('total_piutang') + uangmasukretail::sum('jumlah');

        total_uang_masuk::updateOrCreate(
            ['id'=>1],
            [
                'total_uang_masuk'=>$totaluangmasuk,
                'update'=>now()
            ]
        );
        return redirect('user/manager/uang_masuk')->with('succsess', 'data berhasil ditambah');
    }

    public function indexowner(){
        $retail = uangmasukretail::orderBy('tanggal', 'desc')->get();
        $piutang = uangmasukpiutang::orderBy('tanggal', 'desc')->get();
        $totaluangmasuk = total_uang_masuk::all();
        $produk = produk::all();
        $jumlahpiutang = uangmasukpiutang::sum('total_piutang');
        $jumlahretail = uangmasukretail::sum('jumlah');
        $piutangplusretail = $jumlahpiutang + $jumlahretail;

        return view('owner.uangmasuk', compact('retail','piutang','totaluangmasuk','produk','jumlahpiutang', 'jumlahretail', 'startDate', 'endDate','piutangplusretail'));
    }

    public function filter(Request $request){
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $piutangQuery = uangmasukpiutang::orderBy('tanggal', 'desc');
        $retailQuery = uangmasukretail::orderBy('tanggal', 'desc');

        // Apply date filter if provided
        if ($startDate && $endDate) {
            $piutangQuery->whereBetween('tanggal', [$startDate, $endDate]);
            $retailQuery->whereBetween('tanggal', [$startDate, $endDate]);
        }

        $piutang = $piutangQuery->get();
        $retail = $retailQuery->get();

        $piutang = $piutangQuery->get();
        $retail = $retailQuery->get();
        $totaluangmasuk = total_uang_masuk::all();
        $produk = produk::all();
        $jumlahpiutang = $piutang->sum('total_piutang');
        $jumlahretail = $retail->sum('jumlah');
        $piutangplusretail = $jumlahpiutang + $jumlahretail;

        return view('owner.uangmasuk', compact('retail','piutang','totaluangmasuk','produk','jumlahpiutang', 'jumlahretail', 'startDate', 'endDate','piutangplusretail'));
    }

    public function cetakuangmasuk($startDate, $endDate){
        // dd('Mulai :'.$startDate, 'akhir :'.$endDate);

        $startDate = $startDate;
        $endDate = $endDate;

        $piutangQuery = uangmasukpiutang::whereBetween('tanggal', [$startDate, $endDate])->orderby('tanggal', 'desc');
        $retailQuery = uangmasukretail::whereBetween('tanggal', [$startDate, $endDate])->orderby('tanggal', 'desc');

        $piutang = $piutangQuery->get();
        $retail = $retailQuery->get();

        $jumlahpiutang = $piutang->sum('total_piutang');
        $jumlahretail = $retail->sum('jumlah');
        $totaluangmasuk = total_uang_masuk::all();
        $piutangplusretail = $jumlahpiutang + $jumlahretail;

        return view('owner.cetakuangmasuk', compact('piutang', 'retail', 'jumlahpiutang', 'jumlahretail', 'totaluangmasuk', 'startDate', 'endDate', 'piutangplusretail'));
    }
}
