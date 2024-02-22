<?php

namespace App\Http\Controllers;

use App\Models\bahanbaku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class BahanbakuController extends Controller
{
    public function index()
    {
        // $bahanbaku = Bahanbaku::all();
        $bahanbaku = bahanbaku::where('jenis', 'bahan baku')->get();
        $bahanpenolong = bahanbaku::where('jenis', 'bahan penolong')->get();
        $kardus = bahanbaku::where('jenis', 'kardus')->get();
        return view('manager.bahanbaku', compact('bahanbaku', 'bahanpenolong', 'kardus'));
    }

    public function delete($id){
        $data = bahanbaku::find($id);
        $data->delete();
        return redirect('user/manager/harga_bahan_baku')->with('success', 'data berhasil dihapus');
    }

    public function tambahbahanbaku(Request $request){
        // Validasi form
        $request->validate([
            'nama_bahan_baku' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'harga_persatuan' => 'required|numeric|min:0',
        ]);

        // Mendapatkan nilai input dari formulir
        $harga_persatuan = $request->input('harga_persatuan');
        $banyaknya_satuan = $request->input('banyaknya_satuan');

        // Hitung harga per kilo
        $hargaperkilo = $harga_persatuan / $banyaknya_satuan;

        $simpan = bahanbaku::create([
            'nama_bahan'=>$request->input('nama_bahan_baku'),
            'jenis'=>'bahan baku',
            'satuan'=>$request->input('satuan'),
            'banyak_satuan'=>$request->input('banyaknya_satuan'),
            'jenis_satuan'=>$request->input('jenis_satuan'),
            'harga_persatuan'=>$request->input('harga_persatuan'),
            'harga_perkilo'=>$hargaperkilo
        ]);
        return redirect('user/manager/harga_bahan_baku')->with('success', 'data berhasil di input');
    }

    public function tambahbahanpenolong(Request $request){
        $request->validate([
            'nama_bahan_penolong' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'harga_persatuan' => 'required|numeric|min:0',
        ]);

        // Mendapatkan nilai input dari formulir
        $harga_persatuan = $request->input('harga_persatuan');
        $banyaknya_satuan = $request->input('banyaknya_satuan');

        // Hitung harga per kilo
        $hargaperkilo = $harga_persatuan / $banyaknya_satuan;

        $simpan = bahanbaku::create([
            'nama_bahan'=>$request->input('nama_bahan_penolong'),
            'jenis'=>'bahan penolong',
            'satuan'=>$request->input('satuan'),
            'banyak_satuan'=>$request->input('banyaknya_satuan'),
            'jenis_satuan'=>$request->input('jenis_satuan'),
            'harga_persatuan'=>$request->input('harga_persatuan'),
            'harga_perkilo'=>$hargaperkilo
        ]);
        return redirect('user/manager/harga_bahan_baku')->with('success', 'data berhasil di input');
    }

    public function tambahkardus(Request $request){
        $request->validate([
            'nama_kardus'=>'required|string|max:255',
            'harga_persatuan' => 'required|numeric|min:0'
        ]);
        $simpan = bahanbaku::create([
            'nama_bahan'=>$request->input('nama_kardus'),
            'jenis'=>'kardus',
            'satuan'=>$request->input('satuan'),
            'harga_persatuan'=>$request->input('harga_persatuan'),
        ]);
        return redirect('user/manager/harga_bahan_baku')->with('success', 'data berhasil di input');
    }

    public function editbahanbaku(Request $request, $id){
        $request->validate([
            'satuan' => 'required',
            'banyaknya_satuan' => 'required|numeric|min:1',
            'jenis_satuan' => ['required', Rule::in(['Kg', 'Gr', 'Biji'])],
            'harga_persatuan' => 'required|numeric|min:0',
        ]);

        $bahanbaku = bahanbaku::find($id);

        $hargaperkilo = $request->input('harga_persatuan') / $request->input('banyaknya_satuan');

        $bahanbaku->update([
            "satuan"=>$request->input('satuan'),
            "banyak_satuan"=>$request->input('banyaknya_satuan'),
            "jenis_satuan"=>$request->input('jenis_satuan'),
            "harga_persatuan"=>$request->input('harga_persatuan'),
            "harga_perkilo"=>$hargaperkilo
        ]);

        return redirect('user/manager/harga_bahan_baku')->with('success', 'data berhasil diedit');
    }

    public function editkardus(Request $request, $id){
        $request->validate([
            'satuan' => 'required',
            'harga_persatuan' => 'required|numeric|min:0',
        ]);

        $kardus = bahanbaku::find($id);

        $kardus->update([
            'satuan'=>$request->input('satuan'),
            'harga_persatuan'=>$request->input('harga_persatuan')
        ]);

        return redirect('user/manager/harga_bahan_baku')->with('success', 'data berhasil diedit');
    }

}
