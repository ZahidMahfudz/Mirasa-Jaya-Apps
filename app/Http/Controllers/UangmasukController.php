<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\nota_pemasaran;
use App\Models\produk;
use App\Models\total_uang_masuk;
use App\Models\uangmasukpiutang;
use App\Models\uangmasukretail;

class UangmasukController extends Controller
{
    public function showUangMasuk($startDate, $endDate){
        $retail = nota_pemasaran::where('keterangan', 'retail')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();
        $piutang = nota_pemasaran::where('status', 'lunas')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereDoesntHave('item_nota', function ($query) {
                $query->where('keterangan', 'like', '%retail%');
            })
            ->with('item_nota')
            ->orderBy('tanggal', 'desc')
            ->get();
        $totalpiutang = nota_pemasaran::where('status', 'lunas')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereDoesntHave('item_nota', function ($query) {
            $query->where('keterangan', 'retail');
            })
            ->sum('total_nota');
        $totalretail = nota_pemasaran::where('keterangan', 'retail')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->sum('total_nota');
        $totaluangmasuk = $totalpiutang + $totalretail;
        $update = nota_pemasaran::whereNotNull('tanggal_lunas')
            ->whereBetween('tanggal_lunas', [$startDate, $endDate])
            ->orderBy('tanggal_lunas', 'desc')
            ->value('tanggal_lunas');

        if(request()->is("user/owner/cetak-uang-masuk/$startDate/$endDate")){
            return view('cetak.cetakuangmasuk', compact('retail', 'piutang', 'totalpiutang', 'totalretail', 'totaluangmasuk', 'update', 'startDate', 'endDate'));
        }

        if (auth()->user()->role === 'manager') {
            return view('manager.uangmasuk', compact('retail', 'piutang', 'totalpiutang', 'totalretail', 'totaluangmasuk', 'update'));
        } elseif (auth()->user()->role === 'owner') {
            return view('owner.uangmasuk', compact('retail', 'piutang', 'totalpiutang', 'totalretail', 'totaluangmasuk', 'update', 'startDate', 'endDate'));
        } else {
            abort(403, 'Unauthorized action.');
        }
        // dd($piutang);
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

        $data_total_uang_masuk = total_uang_masuk::first();

        if(!$data_total_uang_masuk){
            total_uang_masuk::create([
                'total_uang_masuk' => $request->input('total_piutang'),
                'update' => now()
            ]);
        }
        else{
            $totaluangmasuk = $request->input('total_piutang') + $data_total_uang_masuk->total_uang_masuk;
    
            total_uang_masuk::updateOrCreate(
                ['id'=>1],
                [
                    'total_uang_masuk'=>$totaluangmasuk,
                    'update'=>now()
                ]
            );
        }

        return redirect('user/manager/uang_masuk')->with('success', 'data berhasil ditambah');
    }

    public function tambahretail(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
            'nama_produk' => 'required',
            'qty' => 'required|numeric',
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

        $data_total_uang_masuk = total_uang_masuk::first();

        if(!$data_total_uang_masuk){
            total_uang_masuk::create([
                'total_uang_masuk' => $jumlah,
                'update' => now()
            ]);
        }
        else{
            $totaluangmasuk = $jumlah + $data_total_uang_masuk->total_uang_masuk;
    
            total_uang_masuk::updateOrCreate(
                ['id'=>1],
                [
                    'total_uang_masuk'=>$totaluangmasuk,
                    'update'=>now()
                ]
            );
        }

        return redirect('user/manager/uang_masuk')->with('success', 'data berhasil ditambah');
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

        return redirect('user/manager/uang_masuk')->with('succsess', 'data berhasil dihapus');
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

        return redirect('user/manager/uang_masuk')->with('succsess', 'data berhasil dihapus');
    }

    public function edituangmasukpiutang(Request $request, $id){
        $request->validate([
            'tanggal_nota' => 'required|date',
            'keterangan' => 'required|string',
            'total_piutang' => 'required|numeric|min:0',
        ]);

        $uangmasukpiutang = uangmasukpiutang::find($id);
        $total_uang_masuk = total_uang_masuk::first();

        $totaluangmasuk = $total_uang_masuk->total_uang_masuk - $uangmasukpiutang->total_piutang + $request->input('total_piutang'); 

        $uangmasukpiutang->update([
            'tanggal'=>$request->input('tanggal_nota'),
            'keterangan'=>$request->input('keterangan'),
            'total_piutang'=>$request->input('total_piutang'),
        ]);

        total_uang_masuk::updateOrCreate(
            ['id'=>1],
            [
                'total_uang_masuk'=>$totaluangmasuk,
                'update'=>now()
            ]
        );
        return redirect('user/manager/uang_masuk')->with('succsess', 'Data berhasil diedit');
    }

    public function edituangmasukretail(Request $request, $id){
        $request->validate([
            'qty' => 'required|numeric|min:1',
            'satuan' => 'required|string',
        ]);

        $produk = produk::where('nama_produk', $request->input('nama_produk'))->first();
        $jumlah = $request->input('qty') * $produk->harga_satuan;

        $total_uang_masuk = total_uang_masuk::first();
        $uangmasukretail = uangmasukretail::find($id);

        $totaluangmasuk = $total_uang_masuk->total_uang_masuk - $uangmasukretail->jumlah + $jumlah; 

        $uangmasukretail->update([
            'qty'=>$request->input('qty'),
            'satuan'=>$request->input('satuan'),
            'jumlah'=>$jumlah,
        ]);

        total_uang_masuk::updateOrCreate(
            ['id'=>1],
            [
                'total_uang_masuk'=>$totaluangmasuk,
                'update'=>now()
            ]
        );
        return redirect('user/manager/uang_masuk')->with('succsess', 'Data berhasil diedit');
    }

    public function indexowner($startDate, $endDate){
        // Validasi input startDate dan endDate
        if (!$startDate || !$endDate) {
            return redirect()->back()->withErrors(['error' => 'Tanggal mulai dan akhir harus diisi.']);
        }

        // Pastikan startDate tidak lebih besar dari endDate
        if (strtotime($startDate) > strtotime($endDate)) {
            return redirect()->back()->withErrors(['error' => 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.']);
        }

        // Ambil data retail dan piutang antara startDate dan endDate
        $retail = uangmasukretail::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();
        $piutang = uangmasukpiutang::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();

        $totaluangmasuk = total_uang_masuk::first();

        $jumlahpiutang = uangmasukpiutang::whereBetween('tanggal', [$startDate, $endDate])->sum('total_piutang'); // Jumlah piutang antara startDate dan endDate
        $jumlahretail = uangmasukretail::whereBetween('tanggal', [$startDate, $endDate])->sum('jumlah'); // Jumlah retail antara startDate dan endDate
        $piutangplusretail = $jumlahpiutang + $jumlahretail;

        return view('owner.uangmasuk', compact('retail', 'piutang', 'totaluangmasuk', 'jumlahpiutang', 'jumlahretail', 'startDate', 'endDate'));
    }

    public function filteruangmasuk(Request $request){
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        return redirect("/user/owner/uangmasuk/$startDate/$endDate");
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

        return view('cetak.cetakuangmasuk', compact('piutang', 'retail', 'jumlahpiutang', 'jumlahretail', 'totaluangmasuk', 'startDate', 'endDate', 'piutangplusretail'));
    }
}
