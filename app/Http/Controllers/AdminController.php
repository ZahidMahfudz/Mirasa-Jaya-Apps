<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function showKelolaAkun(){
        $user = User::all();
        return view('admin.kelolaAkun', compact('user'));
    }

    public function tambahAkun(Request $request){
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'password_tambah' => 'required|string|min:6',
            'role' => 'required|in:admin,manager,owner,pemasaran',
        ]);

        // Membuat user baru
        User::create([
            'name' => $request->input('nama'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password_tambah')), // Enkripsi password dengan bcrypt
            'role' => $request->input('role'),
        ]);

        // Redirect atau respon sukses
        return redirect()->back()->with('success', 'Akun berhasil ditambahkan.');
    }

    public function editAkun(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role' => 'required|string|in:admin,manager,owner',
            'password_edit' => 'nullable|string|min:8' // password tidak wajib diisi
        ]);

        // Cari akun berdasarkan id
        $user = User::findOrFail($id);

        // Update field yang diisi
        $user->name = $request->input('nama');
        $user->username = $request->input('username');
        $user->role = $request->input('role');

        // Jika password baru diisi, maka lakukan hashing dan update
        if ($request->filled('password_edit')) {
            $user->password = Hash::make($request->input('password_edit'));
        }

        // Simpan perubahan ke database
        $user->save();

        // Redirect atau kembalikan respons sesuai kebutuhan
        return redirect()->back()->with('success', 'Akun berhasil diedit!');
    }

    public function deleteAkun($id){
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->back()->with('success', 'Akun berhasil dihapus!');
    }

    public function showGantiPembukuan(){
        return view('admin.GantiPembukuan');
    }

    public function GantiPembukuan(){
        DB::table('akomodasi_pemasaran')->truncate();
        DB::table('akomodasi_produksi')->truncate();
        DB::table('bunga_bank')->truncate();
        DB::table('detail_pembagian_profit')->truncate();
        DB::table('gaji_direksi')->truncate();
        DB::table('gaji_karyawan')->truncate();
        DB::table('hutangbahanbakus')->truncate();
        DB::table('kas')->truncate();
        DB::table('kas_bank_permata')->truncate();
        DB::table('listrik')->truncate();
        DB::table('makan_dan_minum')->truncate();
        DB::table('nota_pemasarans')->truncate();
        DB::table('pembelian_bahan_baku')->truncate();
        DB::table('pembelian_mesin_dan_alat')->truncate();
        DB::table('perawatan_alat_produksi')->truncate();
        DB::table('piutangs')->truncate();
        DB::table('profit_dibagi')->truncate();
        DB::table('profit_owner')->truncate();
        DB::table('project')->truncate();
        DB::table('rekap_reseps')->truncate();
        DB::table('resume_produksis')->truncate();
        DB::table('r__d')->truncate();
        DB::table('sewa_tempat')->truncate();
        DB::table('sosial')->truncate();
        DB::table('spare_part')->truncate();
        DB::table('ssses')->truncate();
        DB::table('stokbbs')->truncate();
        DB::table('stokbps')->truncate();
        DB::table('stok_karduses')->truncate();
        DB::table('total_hutang_bahan_bakus')->truncate();
        DB::table('total_piutangs')->truncate();
        DB::table('total_uang_masuks')->truncate();
        DB::table('t_h_r')->truncate();
        DB::table('uangmasukpiutangs')->truncate();
        DB::table('uangmasukretails')->truncate();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

}
