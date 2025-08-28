<?php

namespace App\Http\Controllers;

use App\Models\listorder;
use App\Models\produk;
use App\Models\preorder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class pemasaranController extends Controller
{
    function index(){
        return view('pemasaran.dashboard');
    }

    public function preorder($name){
        $produk = produk::all();
        $orderpending = preorder::where('nama_pemesan', $name)->where('status', 'pending')->with('detailOrder')->get();
        $orderproses = preorder::where('nama_pemesan', $name)->where('status', 'proses')->with('detailOrder')->get();
        $orderselesai = preorder::where('nama_pemesan', $name)->where('status', 'selesai')->with('detailOrder')->get();
        return view('pemasaran.preorder', compact('orderpending','orderproses', 'orderselesai', 'produk'));
    }

    public function SimpanPreOrder(Request $request){
        $request->validate([
            'nama_pemesan' => 'required|string',
            'tanggal' => 'required|date',
            'nama_produk.*' => 'required|string'
        ]);

        $preorder = new preorder();
        $preorder->tanggal_order = Carbon::now()->toDateString();
        $preorder->tanggal_selesai = $request->tanggal;
        $preorder->nama_pemesan = $request->nama_pemesan;
        $preorder->status = 'pending';
        $preorder->save();

        $listOrder = [];
        for($i=0; $i < count($request->nama_produk); $i++){
            $listOrder[] = [
                'preorder_id' => $preorder->id,
                'nama_barang' => $request->nama_produk[$i],
                'jumlah_barang' => $request->jumlah_barang[$i]
            ];
        }
        listorder::insert($listOrder);

        return redirect()->back()->with('success', 'Pesanan berhasil ditambahkan');
    }
}
