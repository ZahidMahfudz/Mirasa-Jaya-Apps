<?php

namespace App\Http\Controllers;

use App\Models\Data_Karyawan;
use App\Http\Requests\StoreData_KaryawanRequest;
use App\Http\Requests\UpdateData_KaryawanRequest;
use App\Models\dataKaryawanBorongan;
use App\Models\GajiKaryawan;
use App\Models\gajiKaryawanBorongan;
use App\Models\pengeluaranBebanUsaha;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;

class DataKaryawanController extends Controller
{
    public function showDataKaryawan(){
        $data_karyawan = Data_Karyawan::orderBy('bagian')->get();
        return view('admin.DataKaryawan', compact('data_karyawan'));
    }

    public function TambahKaryawan(Request $request){
        $request->validate([
            'nama_karyawan'=> 'required|string',
            'Bagian'=> 'required|string',
            'posisi'=> 'required|string',
            'Gaji_Pokok'=> 'required|numeric|min:0',
            'makan'=> 'required|numeric|min:0',
            'Bonus'=> 'required|numeric|min:0',
        ]);

        if (Data_Karyawan::whereRaw('LOWER(nama_karyawan) = ?', [strtolower($request->nama_karyawan)])
            ->whereRaw('LOWER(bagian) = ?', [strtolower($request->Bagian)])
            ->exists()) {
            return redirect()->back()->with('error', 'Data karyawan sudah ada.');
        }

        Data_Karyawan::create([
            'nama_karyawan' => $request->nama_karyawan,
            'bagian' => $request->Bagian,
            'posisi' => $request->posisi,
            'gaji_pokok' => $request->Gaji_Pokok,
            'makan' => $request->makan,
            'tunjangan' => $request->Bonus,
        ]);

        return redirect()->back()->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function editKaryawan(Request $request, $id){
        $request->validate([
            'nama_karyawan'=> 'required|string',
            'Bagian'=> 'required|string',
            'posisi'=> 'required|string',
            'Gaji_Pokok'=> 'required|numeric|min:0',
            'makan'=> 'required|numeric|min:0',
            'Bonus'=> 'required|numeric|min:0',
        ]);

        $data_karyawan = Data_Karyawan::find($id);
        $data_karyawan->nama_karyawan = $request->nama_karyawan;
        $data_karyawan->bagian = $request->Bagian;
        $data_karyawan->posisi = $request->posisi;
        $data_karyawan->gaji_pokok = $request->Gaji_Pokok;
        $data_karyawan->makan = $request->makan;
        $data_karyawan->tunjangan = $request->Bonus;
        $data_karyawan->save();

        return redirect()->back()->with('success', 'Data karyawan berhasil diubah.');
    }

    public function deleteKaryawan($id){
        $data_karyawan = Data_Karyawan::find($id);
        $data_karyawan->delete();

        return redirect()->back()->with('success', 'Data karyawan berhasil dihapus.');
    }
    
    public function showGajianKaryawan($tanggal){
        $karyawan = Data_Karyawan::all();
        $gajian_karyawan = GajiKaryawan::with('dataKaryawan')
            ->where('tanggal_gaji', $tanggal)
            ->get();

        if ($gajian_karyawan->isEmpty()) {
            $tanggalTerakhir = $tanggal;
        } else {
            $tanggalTerakhir = GajiKaryawan::orderBy('tanggal_gaji', 'desc')
            ->first()
            ->tanggal_gaji;
        }
        $gajian_karyawan = GajiKaryawan::with('dataKaryawan')
        ->where('tanggal_gaji', $tanggalTerakhir)
        ->get();
        return view('admin.GajianKaryawan', compact('gajian_karyawan', 'tanggalTerakhir','karyawan'));
        // dd($gajian_karyawan);
    }

    public function GenerateGajian(){
        $tanggalHariIni = now()->format('Y-m-d');

        if (GajiKaryawan::where('tanggal_gaji', $tanggalHariIni)->exists()) {
            return redirect()->back()->with('error', 'Data gaji karyawan untuk tanggal ini sudah digenerate.');
        }

        $data_karyawan = Data_Karyawan::orderBy('bagian')->get();

        if($data_karyawan){
            foreach($data_karyawan as $item){
                GajiKaryawan::create([
                    'id_karyawan' => $item->id_karyawan,
                    'tanggal_gaji' => $tanggalHariIni,
                    'jumlah_masuk' => 0,
                    'jumlah_bonus' => 0,
                    'total_gaji' => 0,
                ]);
            }
        }

        pengeluaranBebanUsaha::create([
            'jenis_pengeluaran' => 'gk',
            'tanggal_pengeluaran' => $tanggalHariIni,
            'keterangan' => 'Gaji Karyawan Harian ' . now()->format('d F Y'),
            'total_pengeluaran' => 0,
        ]);

        return redirect()->back()->with('success', 'Gaji karyawan berhasil digenerate.');
    }

    public function editGajian(Request $request, $id){
        $request->validate([
            'jumlah_masuk'=> 'required|numeric|min:0',
            'jumlah_bonus'=> 'required|numeric|min:0',
        ]);

        $gaji_karyawan = GajiKaryawan::find($id);
        $gaji_karyawan->jumlah_masuk = $request->jumlah_masuk;
        $gaji_karyawan->jumlah_bonus = $request->jumlah_bonus;
        $gaji_karyawan->total_gaji = ($request->jumlah_masuk * $gaji_karyawan->dataKaryawan->gaji_pokok) + ($request->jumlah_masuk * $gaji_karyawan->dataKaryawan->makan) + ($request->jumlah_bonus * $gaji_karyawan->dataKaryawan->tunjangan);
        $gaji_karyawan->save();

        $pengeluaran = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'gk')
            ->where('tanggal_pengeluaran', $gaji_karyawan->tanggal_gaji)
            ->where('keterangan', 'like', '%Gaji Karyawan Harian%')
            ->first();
        $pengeluaran->total_pengeluaran = $pengeluaran->total_pengeluaran + $gaji_karyawan->total_gaji;
        $pengeluaran->save();

        return redirect()->back()->with('success', 'Gaji karyawan berhasil diubah.');
    }

    public function cetakSlipGaji($tanggal){
        $data_gajian = GajiKaryawan::with('dataKaryawan')
            ->where('tanggal_gaji', $tanggal)
            ->get();

        return view('cetak.CetakSlipGaji', compact('data_gajian', 'tanggal'));
    }

    public function tambahGajian(Request $request){
        $request->validate([
            'nama_karyawan.*'=> 'required|string',
            'jumlah_masuk.*'=> 'required|numeric|min:0',
            'jumlah_bonus.*'=> 'required|numeric|min:0',
        ]);

        $tanggal = now()->format('Y-m-d');

        foreach ($request->nama_karyawan as $index => $nama_karyawan) {
            if (GajiKaryawan::where('id_karyawan', $nama_karyawan)->where('tanggal_gaji', $tanggal)->exists()) {
                $karyawan = Data_Karyawan::find($nama_karyawan);
                return redirect()->back()->with('error', 'Gaji untuk karyawan dengan nama ' . $karyawan->nama_karyawan . ' sudah ditambahkan untuk tanggal ini.');
            }
        }

        $total_pengeluaran = 0;

        foreach ($request->nama_karyawan as $index => $nama_karyawan) {
            $data_karyawan = Data_Karyawan::where('id_karyawan', $nama_karyawan)->first();

            if ($data_karyawan) {
            $jumlah_masuk = $request->jumlah_masuk[$index];
            $jumlah_bonus = $request->jumlah_bonus[$index];
            $total_gaji = ($jumlah_masuk * $data_karyawan->gaji_pokok) + ($jumlah_masuk * $data_karyawan->makan) + ($jumlah_bonus * $data_karyawan->tunjangan);

            GajiKaryawan::create([
                'id_karyawan' => $data_karyawan->id_karyawan,
                'tanggal_gaji' => $tanggal,
                'jumlah_masuk' => $jumlah_masuk,
                'jumlah_bonus' => $jumlah_bonus,
                'total_gaji' => $total_gaji,
            ]);
            }

            $total_pengeluaran += $total_gaji;
        }

        $pengeluaran = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'gk')
            ->where('tanggal_pengeluaran', $tanggal)
            ->where('keterangan', 'like', '%Gaji Karyawan Harian%')
            ->first();

        if ($pengeluaran) {
            $pengeluaran->total_pengeluaran += $total_pengeluaran;
            $pengeluaran->save();
        } else {
            pengeluaranBebanUsaha::create([
            'jenis_pengeluaran' => 'gk',
            'tanggal_pengeluaran' => $tanggal,
            'keterangan' => 'Gaji Karyawan Harian ' . now()->format('d F Y'),
            'total_pengeluaran' => $total_pengeluaran,
            ]);
        }

        return redirect()->back()->with('success', 'Gaji karyawan berhasil ditambahkan.');
    }

    public function deleteGajian($id){
        $gaji_karyawan = GajiKaryawan::find($id);

        $pengeluaran = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'gk')
            ->where('tanggal_pengeluaran', $gaji_karyawan->tanggal_gaji)
            ->where('keterangan', 'like', '%Gaji Karyawan Harian%')
            ->first();

        if ($pengeluaran) {
            $pengeluaran->total_pengeluaran -= $gaji_karyawan->total_gaji;
            $pengeluaran->save();
        }

        $gaji_karyawan->delete();

        return redirect()->back()->with('success', 'Gaji karyawan berhasil dihapus.');
    }

    public function showDataKaryawanBorongan(){
        $data_karyawan_borongan = dataKaryawanBorongan::orderBy('bagian')->get();
        return view('admin.DataKaryawanBorongan', compact('data_karyawan_borongan'));
    }

    public function TambahKaryawanBorongan(Request $request){
        $request->validate([
            'nama_karyawan'=> 'required|string',
            'bagian'=> 'required|string',
            'harga_s'=> 'required|numeric|min:0',
            'harga_o'=> 'required|numeric|min:0',
            'makan'=> 'required|numeric|min:0',
            'tunjangan'=> 'required|numeric|min:0',
        ]);

        if (dataKaryawanBorongan::whereRaw('LOWER(nama_karyawan) = ?', [strtolower($request->nama_karyawan)])
            ->whereRaw('LOWER(bagian) = ?', [strtolower($request->Bagian)])
            ->exists()) {
            return redirect()->back()->with('error', 'Data karyawan borongan sudah ada.');
        }

        dataKaryawanBorongan::create([
            'nama_karyawan' => $request->nama_karyawan,
            'bagian' => $request->bagian,
            'harga_s' => $request->harga_s,
            'harga_o' => $request->harga_o,
            'makan' => $request->makan,
            'tunjangan' => $request->tunjangan,
        ]);

        return redirect()->back()->with('success', 'Data karyawan borongan berhasil ditambahkan.');
    }

    public function deleteKaryawanBorongan($id){
        $data_karyawan_borongan = dataKaryawanBorongan::find($id);
        $data_karyawan_borongan->delete();

        return redirect()->back()->with('success', 'Data karyawan borongan berhasil dihapus.');
    }

    public function editKaryawanBorongan(Request $request, $id){
        $request->validate([
            'nama_karyawan'=> 'required|string',
            'bagian'=> 'required|string',
            'harga_s'=> 'required|numeric|min:0',
            'harga_o'=> 'required|numeric|min:0',
            'makan'=> 'required|numeric|min:0',
            'tunjangan'=> 'required|numeric|min:0',
        ]);

        $data_karyawan_borongan = dataKaryawanBorongan::find($id);
        $data_karyawan_borongan->nama_karyawan = $request->nama_karyawan;
        $data_karyawan_borongan->bagian = $request->bagian;
        $data_karyawan_borongan->harga_s = $request->harga_s;
        $data_karyawan_borongan->harga_o = $request->harga_o;
        $data_karyawan_borongan->makan = $request->makan;
        $data_karyawan_borongan->tunjangan = $request->tunjangan;
        $data_karyawan_borongan->save();

        return redirect()->back()->with('success', 'Data karyawan borongan berhasil diubah.');
    }

    public function showGajiBoronganSpet($tanggal){
        $karyawan_spet = dataKaryawanBorongan::all();
        $gajian_karyawan_borongan = gajiKaryawanBorongan::with('dataKaryawanBorongan')
            ->where('tanggal_gaji', $tanggal)
            ->get();

        if ($gajian_karyawan_borongan->isEmpty()) {
            $tanggalTerakhir = $tanggal;
        } else {
            $tanggalTerakhir = gajiKaryawanBorongan::orderBy('tanggal_gaji', 'desc')
            ->first()
            ->tanggal_gaji;
        }
        $gajian_karyawan_borongan = gajiKaryawanBorongan::with('dataKaryawanBorongan')
        ->where('tanggal_gaji', $tanggalTerakhir)
        ->get();
        return view('admin.GajianKaryawanborongan', compact('gajian_karyawan_borongan', 'tanggalTerakhir','karyawan_spet'));
        // return dd($gajian_karyawan_borongan);
    }

    public function GenerateGajianSpet(){
        $tanggalHariIni = now()->format('Y-m-d');

        if (gajiKaryawanBorongan::where('tanggal_gaji', $tanggalHariIni)->exists()) {
            return redirect()->back()->with('error', 'Data gaji karyawan borongan untuk tanggal ini sudah digenerate.');
        }

        $data_karyawan_borongan = dataKaryawanBorongan::orderBy('bagian')->get();

        if($data_karyawan_borongan){
            foreach($data_karyawan_borongan as $item){
                gajiKaryawanBorongan::create([
                    'id_karyawan_borongan' => $item->id_karyawan_borongan,
                    'tanggal_gaji' => $tanggalHariIni,
                    'jumlah_s' => 0,
                    'jumlah_o' => 0,
                    'jumlah_masuk'=> 0,
                    'jumlah_bonus'=> 0,
                    'total_gaji' => 0,
                ]);
            }
        }

        pengeluaranBebanUsaha::create([
            'jenis_pengeluaran' => 'gk',
            'tanggal_pengeluaran' => $tanggalHariIni,
            'keterangan' => 'Gaji Karyawan Borongan ' . now()->format('d F Y'),
            'total_pengeluaran' => 0,
        ]);

        return redirect()->back()->with('success', 'Gaji karyawan borongan berhasil digenerate.');
    }

    public function editGajianSpet(Request $request, $id){
        $request->validate([
            'jumlah_s' => 'required|numeric|min:0',
            'jumlah_o' => 'required|numeric|min:0',
            'jumlah_masuk' => 'required|numeric|min:0',
            'jumlah_bonus' => 'required|numeric|min:0',
        ]);

        
        $data_gajian_borongan = gajiKaryawanBorongan::find($id);
        $data_gajian_borongan->jumlah_s = $request->jumlah_s;
        $data_gajian_borongan->jumlah_o = $request->jumlah_o;
        $data_gajian_borongan->jumlah_masuk = $request->jumlah_masuk;
        $data_gajian_borongan->jumlah_bonus = $request->jumlah_bonus;
        $data_gajian_borongan->total_gaji = ($request->jumlah_s * $data_gajian_borongan->dataKaryawanBorongan->harga_s) + ($request->jumlah_o * $data_gajian_borongan->dataKaryawanBorongan->harga_o) + ($request->jumlah_masuk * $data_gajian_borongan->dataKaryawanBorongan->makan) + ($request->jumlah_bonus * $data_gajian_borongan->dataKaryawanBorongan->tunjangan);
        $data_gajian_borongan->save();
        
        $pengeluaran = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'gk')
            ->where('tanggal_pengeluaran', $data_gajian_borongan->tanggal_gaji)
            ->where('keterangan', 'like', '%Gaji Karyawan Borongan%')
            ->first();
        $pengeluaran->total_pengeluaran = $pengeluaran->total_pengeluaran + $data_gajian_borongan->total_gaji;
        $pengeluaran->save();

        return redirect()->back()->with('success', 'Data gajian '. $data_gajian_borongan->dataKaryawanBorongan->nama_karyawan .' berhasil diubah');
        // dd($data_gajian_borongan->total_gaji);
    }

    public function tambahGajianBorongan(Request $request){
        $request->validate([
            'nama_karyawan.*'=> 'required|string',
            'jumlah_s.*'=> 'required|numeric|min:0',
            'jumlah_o.*'=> 'required|numeric|min:0',
            'jumlah_masuk.*'=> 'required|numeric|min:0',
            'jumlah_bonus.*'=> 'required|numeric|min:0',
        ]);

        $tanggal = now()->format('Y-m-d');

        foreach ($request->nama_karyawan as $index => $nama_karyawan) {
            if (gajiKaryawanBorongan::where('id_karyawan_borongan', $nama_karyawan)->where('tanggal_gaji', $tanggal)->exists()) {
                return redirect()->back()->with('error', 'Gaji untuk karyawan borongan dengan ID ' . $nama_karyawan . ' sudah ditambahkan untuk tanggal ini.');
            }
        }

        foreach($request->nama_karyawan as $index => $nama_karyawan){
            $data_karyawan_borongan = dataKaryawanBorongan::where('id_karyawan_borongan', $nama_karyawan)->first();

            if($data_karyawan_borongan){
                $jumlah_s = $request->jumlah_s[$index];
                $jumlah_o = $request->jumlah_o[$index];
                $jumlah_masuk = $request->jumlah_masuk[$index];
                $jumlah_bonus = $request->jumlah_bonus[$index];
                $total_gaji = ($jumlah_s * $data_karyawan_borongan->harga_s) + ($jumlah_o * $data_karyawan_borongan->harga_o) + ($jumlah_masuk * $data_karyawan_borongan->makan) + ($jumlah_bonus * $data_karyawan_borongan->tunjangan);

                gajiKaryawanBorongan::create([
                    'id_karyawan_borongan' => $data_karyawan_borongan->id_karyawan_borongan,
                    'tanggal_gaji' => $tanggal,
                    'jumlah_s' => $jumlah_s,
                    'jumlah_o' => $jumlah_o,
                    'jumlah_masuk' => $jumlah_masuk,
                    'jumlah_bonus' => $jumlah_bonus,
                    'total_gaji' => $total_gaji,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Gaji karyawan borongan berhasil ditambahkan.');
    }

    public function deleteGajianSpet($id){
        $gaji_karyawan_borongan = gajiKaryawanBorongan::find($id);

        $pengeluaran = pengeluaranBebanUsaha::where('jenis_pengeluaran', 'gk')
            ->where('tanggal_pengeluaran', $gaji_karyawan_borongan->tanggal_gaji)
            ->where('keterangan', 'like', '%Gaji Karyawan Borongan%')
            ->first();
        if ($pengeluaran) {
            $pengeluaran->total_pengeluaran -= $gaji_karyawan_borongan->total_gaji;
            $pengeluaran->save();
        }

        $gaji_karyawan_borongan->delete();

        return redirect()->back()->with('success', 'Gaji karyawan '.$gaji_karyawan_borongan->dataKaryawanBorongan->nama_karyawan.' berhasil dihapus.');
    }

    public function cetakSlipGajiSpet($tanggal){
        $data_gajian_borongan = gajiKaryawanBorongan::with('dataKaryawanBorongan')
            ->where('tanggal_gaji', $tanggal)
            ->get();

        return view('cetak.CetakSlipGajiBorongan', compact('data_gajian_borongan', 'tanggal'));
    }

    public function showGajiKaryawanManager($date){
        //date karyawan biasa
        $gajian_karyawan = GajiKaryawan::with('dataKaryawan')
            ->where('tanggal_gaji', $date)
            ->get();

        if ($gajian_karyawan->isEmpty()) {
            $tanggalTerakhir = GajiKaryawan::where('tanggal_gaji', '<=', $date)
            ->orderBy('tanggal_gaji', 'desc')
            ->first()
            ->tanggal_gaji ?? $date;
        } else {
            $tanggalTerakhir = $date;
        }

        $gajian_karyawan = GajiKaryawan::with('dataKaryawan')
            ->where('tanggal_gaji', $tanggalTerakhir)
            ->get();

        //data karyawan borongan spet
        $gajian_karyawan_borongan = gajiKaryawanBorongan::with('dataKaryawanBorongan')
            ->where('tanggal_gaji', $tanggalTerakhir)
            ->get();

        return view('manager.gajiKaryawan', compact('gajian_karyawan', 'gajian_karyawan_borongan', 'tanggalTerakhir'));
    }
}
