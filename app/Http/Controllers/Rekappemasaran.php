<?php

namespace App\Http\Controllers;

use App\Models\sss;
use App\Models\produk;
use App\Models\drop_out;
use Illuminate\Http\Request;
use App\Models\nota_pemasaran;
use App\Models\resume_produksi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Rekappemasaran extends Controller
{
    //tolong carikan kueri yang memunculkan data sss dan data do, serta sum untuk nota cash dan nota noncash untuk setiap produk kemudian compact sesuai rujukan
    public function index()
    {
        $endDate = resume_produksi::max('tanggal');
        $startDate = date('Y-m-d', strtotime('-5 days', strtotime($endDate)));

        $produks = produk::all();
        $notacash = nota_pemasaran::where('jenis_nota', 'nota_cash')->whereBetween('tanggal', [$startDate, $endDate])->get();
        $notanoncash = nota_pemasaran::where('jenis_nota', 'nota_noncash')->whereBetween('tanggal', [$startDate, $endDate])->get();


        // Ambil data resume produksi antara rentang tanggal yang diberikan
        $data_resume = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();

        // Lakukan pengelompokan data berdasarkan nama produk
        $groupedData = $data_resume->groupBy('nama_produk');

        // Ambil tanggal-tanggal unik dalam rentang yang dipilih
        $uniqueDates = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->distinct('tanggal')->pluck('tanggal')->toArray();

        $sumnotapemasaran = DB::select("SELECT
                nama_barang,
                SUM(CASE WHEN jenis_nota = 'nota_cash' THEN qty ELSE 0 END) AS jumlah_nota_cash,
                SUM(CASE WHEN jenis_nota = 'nota_noncash' THEN qty ELSE 0 END) AS jumlah_nota_non_cash
            FROM
                nota_pemasarans
            WHERE
                tanggal BETWEEN '$startDate' AND '$endDate'
            GROUP BY
                nama_barang");
        $sssstart = sss::where('tanggal', $startDate)->get();
        $sssend = sss::where('tanggal', $endDate)->get();
        return view('manager.rekappemasaran', compact('produks', 'notacash', 'notanoncash', 'startDate', 'endDate', 'groupedData', 'uniqueDates', 'sumnotapemasaran', 'sssstart', 'sssend'));
    }

    public function filter(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $produks = produk::all();
        $notacash = nota_pemasaran::where('jenis_nota', 'nota_cash')->whereBetween('tanggal', [$startDate, $endDate])->get();
        $notanoncash = nota_pemasaran::where('jenis_nota', 'nota_noncash')->whereBetween('tanggal', [$startDate, $endDate])->get();

        // Ambil data resume produksi antara rentang tanggal yang diberikan
        $data_resume = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();

        // Lakukan pengelompokan data berdasarkan nama produk
        $groupedData = $data_resume->groupBy('nama_produk');

        // Ambil tanggal-tanggal unik dalam rentang yang dipilih
        $uniqueDates = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->distinct('tanggal')->pluck('tanggal')->toArray();

        $sumnotapemasaran = DB::select("SELECT
                nama_barang,
                SUM(CASE WHEN jenis_nota = 'nota_cash' THEN qty ELSE 0 END) AS jumlah_nota_cash,
                SUM(CASE WHEN jenis_nota = 'nota_noncash' THEN qty ELSE 0 END) AS jumlah_nota_non_cash
            FROM
                nota_pemasarans
            WHERE
                tanggal BETWEEN '$startDate' AND '$endDate'
            GROUP BY
                nama_barang");
        $sssstart = sss::where('tanggal', $startDate)->get();
        $sssend = sss::where('tanggal', $endDate)->get();
        return view('manager.rekappemasaran', compact('produks', 'notacash', 'notanoncash', 'startDate', 'endDate', 'groupedData', 'uniqueDates', 'sumnotapemasaran', 'sssstart', 'sssend'));
    }

    // public function tambahNota(Request  $request){
    //     $request->validate([
    //         'jenis_nota' => 'required|in:nota_cash,nota_noncash',
    //         'tanggal_Nota' => 'required|date',
    //         'nama_toko' => 'required|string',
    //         'QTY' => 'required|integer|min:1',
    //         'nama_produk_nota' => 'required|string',
    //     ]);

    //     $simpan = nota_pemasaran::create([
    //         'jenis_nota'=>$request->input('jenis_nota'),
    //         'tanggal'=>$request->input('tanggal_Nota'),
    //         'nama_toko'=>$request->input('nama_toko'),
    //         'qty'=>$request->input('QTY'),
    //         'nama_barang'=>$request->input('nama_produk_nota'),
    //     ]);

    //     $datasss = sss::where('tanggal', $request->input('tanggal_nota'))
    //         ->where('nama_produk', $request->input('nama_produk_nota'))
    //         ->first();

    //     if ($datasss) {
    //         $newsss = $datasss->sss + $request->input('QTY');

    //         $datasss->update([
    //             'sss' => $newsss
    //         ]);
    //     }


    //     return redirect('user/manager/rekappemasaran')->with('success', 'nota berhasil ditambahkan');
    // }

    public function tambahNota(Request $request)
    {
        $request->validate([
            'jenis_nota' => 'required|in:nota_cash,nota_noncash',
            'tanggal_Nota' => 'required|date',
            'nama_toko' => 'required|string',
            'QTY' => 'required|integer|min:1',
            'nama_produk_nota' => 'required|string',
        ]);

        // Cek apakah tanggal_Nota sudah ada di tabel sss
        $datasss = sss::where('tanggal', $request->input('tanggal_Nota'))
            ->where('nama_produk', $request->input('nama_produk_nota'))
            ->first();

        if ($datasss) {
            // Jika sudah ada, update data tersebut
            $newsss = $datasss->sss - $request->input('QTY');
            $datasss->update([
                'sss' => $newsss
            ]);
        } else {

            // Inisialisasi variabel tanggal pencarian
            $searchDate = $request->input('tanggal_Nota');

            // Loop hingga menemukan data sss yang tersedia atau mencapai batas pencarian
            while (true) {
                // Mencari data sss dengan tanggal sebelumnya yang sesuai
                $datalastsss = sss::where('tanggal', '<', $searchDate)
                    ->where('nama_produk', $request->input('nama_produk_nota'))
                    ->orderBy('tanggal', 'desc')
                    ->first();

                // Jika data sss ditemukan, keluar dari loop
                if ($datalastsss) {
                    break;
                }

                // Kurangi satu hari dari tanggal pencarian
                $searchDate = date('Y-m-d', strtotime($searchDate . ' -1 day'));

                // Jika mencapai batas pencarian (misal: 30 hari sebelumnya), keluar dari loop
                // Jika tidak ingin menggunakan batas pencarian, Anda dapat menghapus kondisi ini
                if ($searchDate <= date('Y-m-d', strtotime('-30 days'))) {
                    break;
                }
            }

            $drop_out = resume_produksi::where('tanggal', $request->input('tanggal_Nota'))
                ->where('nama_produk', $request->input('nama_produk_nota'))
                ->first();

            // Menghitung nilai sss baru
            $newSss = ($datalastsss) ? $datalastsss->sss + $drop_out->out - $request->input('QTY') : -$request->input('QTY');

            // Membuat atau memperbarui data sss
            $simpan = sss::create(
                [
                    'tanggal' => $request->input('tanggal_Nota'),
                    'nama_produk' => $request->input('nama_produk_nota'),
                    'sss' => $newSss
                ]
            );
        }

        // Simpan data nota_pemasaran
        $simpan = nota_pemasaran::create([
            'jenis_nota' => $request->input('jenis_nota'),
            'tanggal' => $request->input('tanggal_Nota'),
            'nama_toko' => $request->input('nama_toko'),
            'qty' => $request->input('QTY'),
            'nama_barang' => $request->input('nama_produk_nota'),
        ]);

        return redirect('user/manager/rekappemasaran')->with('success', 'Nota berhasil ditambahkan');
    }


    public function editNota(Request $request, $id)
    {
        $request->validate([
            'QTY' => 'required|numeric|min:1',
            'nama_produk_nota' => 'required|exists:produks,nama_produk',
        ], [
            'QTY.required' => 'Kolom QTY harus diisi.',
            'QTY.numeric' => 'Kolom QTY harus berupa angka.',
            'QTY.min' => 'Kolom QTY harus bernilai minimal 1.',
            'nama_produk_nota.required' => 'Kolom Nama Produk harus diisi.',
            'nama_produk_nota.exists' => 'Nama Produk tidak valid.',
        ]);

        $nota = nota_pemasaran::find($id);

        $nota->update([
            'qty' => $request->input('QTY'),
            'nama_barang' => $request->input('nama_produk_nota')
        ]);

        return redirect('user/manager/rekappemasaran')->with('success', 'nota berhasil diedit');
    }

    public function deleteNota($id)
    {
        $data = nota_pemasaran::find($id);
        $data->delete();
        return redirect('user/manager/rekappemasaran')->with('success', 'nota berhasil dihapus');
    }

    public function indexowner()
    {
        $endDate = resume_produksi::max('tanggal');
        $startDate = date('Y-m-d', strtotime('-5 days', strtotime($endDate)));

        $notacash = nota_pemasaran::where('jenis_nota', 'nota_cash')->whereBetween('tanggal', [$startDate, $endDate])->get();
        $notanoncash = nota_pemasaran::where('jenis_nota', 'nota_noncash')->whereBetween('tanggal', [$startDate, $endDate])->get();
        return view('owner.rekappemasaran', compact('notacash', 'notanoncash'));
    }
}
