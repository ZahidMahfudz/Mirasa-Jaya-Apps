<?php

namespace App\Http\Controllers;

use App\Models\sss;
use App\Models\produk;
use App\Models\drop_out;
use App\Models\itemNota;
use Carbon\CarbonPeriod;
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
        // $data_resume = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();
        $data_resume = resume_produksi::select('resume_produksis.*', 'ssses.sss')
            ->leftJoin('ssses', function ($join) {
                $join->on('resume_produksis.tanggal', '=', 'ssses.tanggal')
                    ->on('resume_produksis.nama_produk', '=', 'ssses.nama_produk'); // sesuaikan nama_produk jika ada
            })
            ->whereBetween('resume_produksis.tanggal', [$startDate, $endDate])
            ->orderBy('resume_produksis.tanggal', 'desc')
            ->get();

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

        $sss = sss::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();
        $sssGrouped = $sss->groupBy('nama_produk');
        return view('manager.rekappemasaran', compact('produks', 'notacash', 'notanoncash', 'startDate', 'endDate', 'groupedData', 'uniqueDates', 'sumnotapemasaran', 'sssstart', 'sssend', 'sss'));
        // dd($sssGrouped);
    }
    
    public function indexRekapPemasaran($startDate, $endDate)
    {
        $endDate = $endDate; // Tanggal hari ini yang dikirimkan melalui $date
        $startDate = $startDate; // 7 hari sebelumnya

        $tanggalPeriode = CarbonPeriod::create($startDate, $endDate);

        // Ambil semua nama produk unik
        $produkList = DB::table('ssses')
            ->select('nama_produk')
            ->union(DB::table('list_drop_outs')->select('nama_barang as nama_produk'))
            ->union(DB::table('item_notas')->select('nama_produk'))
            ->distinct()
            ->pluck('nama_produk');

        $data = [];

        foreach ($produkList as $produk) {
            $sssAwal = DB::table('ssses')
                ->where('nama_produk', $produk)
                ->where('tanggal', $startDate)
                ->sum('sss');

            $dropoutPerTanggal = [];
            $totalDropout = 0;

            foreach ($tanggalPeriode as $tanggal) {
                $jumlah = DB::table('list_drop_outs')
                    ->join('drop_outs', 'list_drop_outs.drop_out_id', '=', 'drop_outs.id')
                    ->where('list_drop_outs.nama_barang', $produk)
                    ->whereDate('drop_outs.tanggal', $tanggal->toDateString())
                    ->sum('list_drop_outs.jumlah_barang');

                $dropoutPerTanggal[$tanggal->toDateString()] = $jumlah;
                $totalDropout += $jumlah;
            }

            // Nota Cash
            $notaCashQty = DB::table('item_notas')
                ->join('nota_pemasarans', 'item_notas.id_nota', '=', 'nota_pemasarans.id_nota')
                ->where('item_notas.nama_produk', $produk)
                ->where('nota_pemasarans.jenis_nota', 'nota_cash')
                ->where(function ($query) {
                    $query->whereNull('nota_pemasarans.keterangan')
                          ->orWhere('nota_pemasarans.keterangan', 'not like', '%retail%');
                })
                ->whereBetween('nota_pemasarans.tanggal', [$startDate, $endDate])
                ->sum('item_notas.qty');

            // Nota Non Cash
            $notaNonCashQty = DB::table('item_notas')
                ->join('nota_pemasarans', 'item_notas.id_nota', '=', 'nota_pemasarans.id_nota')
                ->where('item_notas.nama_produk', $produk)
                ->where('nota_pemasarans.jenis_nota', 'nota_noncash')
                ->whereBetween('nota_pemasarans.tanggal', [$startDate, $endDate])
                ->sum('item_notas.qty');

            $sssAkhir = $sssAwal + $totalDropout - ($notaCashQty + $notaNonCashQty);

            $data[] = [
                'nama_produk' => $produk,
                'sss_awal' => $sssAwal,
                'dropout_per_tanggal' => $dropoutPerTanggal,
                'total_dropout' => $totalDropout,
                'nota_cash' => $notaCashQty,
                'nota_noncash' => $notaNonCashQty,
                'sss_akhir' => $sssAkhir,
            ];
        }

        // Data nota keseluruhan untuk ditampilkan jika perlu
        $notaCash = nota_pemasaran::where('jenis_nota', 'nota_cash')
            ->where(function ($query) {
            $query->whereNull('keterangan')
                  ->orWhere('keterangan', 'not like', '%retail%');
            })
            ->whereBetween('tanggal', [$startDate, $endDate])->get();

        $notaNonCash = nota_pemasaran::where('jenis_nota', 'nota_noncash')
            ->whereBetween('tanggal', [$startDate, $endDate])->get();

        if(request()->is("user/owner/cetak-rekap-pemasaran/$startDate/$endDate")){
            return view('cetak.cetakrekappemasaran', compact(
                'startDate',
                'endDate',
                'notaCash',
                'notaNonCash',
                'data',
                'tanggalPeriode'
            ));
        }

        if (auth()->user()->role === 'manager') {
            return view('manager.rekappemasaran', compact(
            'startDate',
            'endDate',
            'notaCash',
            'notaNonCash',
            'data',
            'tanggalPeriode'
            ));
        } elseif (auth()->user()->role === 'owner') {
            return view('owner.rekappemasaran', compact(
            'startDate',
            'endDate',
            'notaCash',
            'notaNonCash',
            'data',
            'tanggalPeriode'
            ));
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melihat halaman ini.');
        }
    }

    public function filter(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $produks = produk::all();
        $notacash = nota_pemasaran::where('jenis_nota', 'nota_cash')->whereBetween('tanggal', [$startDate, $endDate])->with('item_nota')->get();
        $notanoncash = nota_pemasaran::where('jenis_nota', 'nota_noncash')->whereBetween('tanggal', [$startDate, $endDate])->with('item_nota')->get();

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
        // Validasi input
        $request->validate([
            'jenis_nota' => 'required|in:nota_cash,nota_noncash',
            'tanggal_Nota' => 'required|date',
            'nama_toko' => 'required|string',
            'QTY' => 'required|integer|min:1',
            'nama_produk_nota' => 'required|string',
        ]);

        // Simpan data nota_pemasaran
        $nota = nota_pemasaran::create([
            'jenis_nota' => $request->input('jenis_nota'),
            'tanggal' => $request->input('tanggal_Nota'),
            'nama_toko' => $request->input('nama_toko'),
            'qty' => $request->input('QTY'),
            'nama_barang' => $request->input('nama_produk_nota'),
        ]);

        // Ambil stok sss dari tanggal yang dimasukkan pengguna sampai tanggal terakhir yang tersedia di database
        $sssData = sss::where('nama_produk', $request->input('nama_produk_nota'))
            ->where('tanggal', '>=', $request->input('tanggal_Nota')) // Ambil dari tanggal user
            ->orderBy('tanggal', 'asc')
            ->get();

         // Jumlah penjualan yang harus dikurangi dari stok
        $jumlahPenjualan = $request->input('QTY');

        if(!$sssData){
            return redirect()->back()->with('error', 'Data sss tanggal '.$request->input('tanggal_nota').' tidak ditemukan');
        }
        else{
            foreach($sssData as $sss){
                $data = sss::find($sss->id);

                $data->update([
                    'sss' => $sss->sss - $jumlahPenjualan
                ]);
            }
        }

        return redirect('user/manager/rekappemasaran')->with('success', 'Nota berhasil ditambahkan dan stok sss diperbarui.');
    }



    public function editNota(Request $request, $id)
    {
        $request->validate([
            'nama_toko' => 'required|string',
            'QTY' => 'required|integer|min:1',
        ]);

        $nota = nota_pemasaran::find($id);

        $sssData = sss::where('nama_produk', $nota->nama_barang)
            ->where('tanggal', '>=', $nota->tanggal) // Ambil dari tanggal user
            ->orderBy('tanggal', 'asc')
            ->get();

        //yang harus dikembalikan
        $jumlahKembalian = $nota->qty;
        //ambil data yang baru
        $jumlahPenjualan = $request->input('QTY');

        if(!$sssData){
            return redirect()->back()->with('error', 'Data sss tanggal '.$nota->tanggal.' tidak ditemukan');
        }
        else{
            foreach($sssData as $sss){
                $data = sss::find($sss->id);

                $data->update([
                    'sss' => $sss->sss + $jumlahKembalian - $jumlahPenjualan
                ]);
            }
        }
        
        $nota->update([
            'qty' => $request->input('QTY'),
            'nama_toko' => $request->input('nama_toko')
        ]);

        return redirect('user/manager/rekappemasaran')->with('success', 'nota berhasil diedit dan sss diperbarui');
    }

    public function deleteNota($id)
    {
        $data = nota_pemasaran::find($id);

        //jumlah yang harus pulihkan
        $jumlahKembalian = $data->qty;

        $sssData = sss::where('nama_produk', $data->nama_barang)
            ->where('tanggal', '>=', $data->tanggal)
            ->orderBy('tanggal', 'asc')
            ->get();

        if(!$sssData){
            return redirect()->back()->with('error', 'Data sss tanggal '.$data->tanggal.' tidak ditemukan');
        }
        else{
            foreach($sssData as $sss){
                $sssUpdate = sss::find($sss->id);

                $sssUpdate->update([
                    'sss' => $sss->sss + $jumlahKembalian
                ]);
            }
        }

        $data->delete();

        return redirect('user/manager/rekappemasaran')->with('success', 'Nota berhasil dihapus dan data sss dipulihkan');
    }

    public function indexowner()
    {
        $endDate = resume_produksi::max('tanggal');
        $startDate = date('Y-m-d', strtotime('-5 days', strtotime($endDate)));
        $dateSSSStart = date('Y-m-d', strtotime('-6 days', strtotime($endDate)));

        $sssStart = sss::where('tanggal', $dateSSSStart)->get();
        $sssEnd = sss::where('tanggal', $endDate)->get();

        $dropOut = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();
        $groupedData = $dropOut->groupBy('nama_produk');

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

        $notacash = nota_pemasaran::where('jenis_nota', 'nota_cash')->whereBetween('tanggal', [$startDate, $endDate])->get();
        $notanoncash = nota_pemasaran::where('jenis_nota', 'nota_noncash')->whereBetween('tanggal', [$startDate, $endDate])->get();
        return view('owner.rekappemasaran', compact('notacash', 'notanoncash', 'sumnotapemasaran', 'endDate', 'startDate', 'dateSSSStart', 'sssStart', 'sssEnd', 'groupedData', 'uniqueDates'));
    }

    public function filterpemasaranowner(Request $request){
        $request->validate([
            'startDate' => 'required|date|before_or_equal:endDate',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        return redirect("/user/owner/rekapitulasipenjualan/$startDate/$endDate");
    }

    public function cetakrekappemasaran($startDate, $endDate){
        $startDate = $startDate;
        $endDate = $endDate;
        $dateSSSStart = date('Y-m-d', strtotime('-1 days', strtotime($startDate)));

        $sssStart = sss::where('tanggal', $dateSSSStart)->get();
        $sssEnd = sss::where('tanggal', $endDate)->get();

        $dropOut = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();
        $groupedData = $dropOut->groupBy('nama_produk');

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

        $notacash = nota_pemasaran::where('jenis_nota', 'nota_cash')->whereBetween('tanggal', [$startDate, $endDate])->get();
        $notanoncash = nota_pemasaran::where('jenis_nota', 'nota_noncash')->whereBetween('tanggal', [$startDate, $endDate])->get();

        return view('cetak.cetakrekappemasaran', compact('notacash', 'notanoncash', 'sumnotapemasaran', 'endDate', 'startDate', 'dateSSSStart', 'sssStart', 'sssEnd', 'groupedData', 'uniqueDates'));
    }

    public function showDaftarNota(){
        $produks = produk::all();
        $notabelumlunas = nota_pemasaran::where('status', 'belum_lunas')->where('jenis_nota', 'nota_noncash')->with('item_nota')->get();
        $notalunas = nota_pemasaran::where('status', 'lunas')
            ->whereDoesntHave('item_nota', function ($query) {
            $query->where('keterangan', 'like', '%retail%');
            })
            ->with('item_nota')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.daftarNota', compact('produks', 'notabelumlunas', 'notalunas'));
    }

    public function tambahNotaHargaPabrik(Request $request){
        $request->validate([
            'tanggalNota' => 'required|date',
            'jenisNota' => 'required|in:nota_cash,nota_noncash',
            'namaPelanggan' => 'required|string|max:255',
            'oleh' => 'required|string|max:255',
            'produk' => 'required|array|min:1',
            'produk.*' => 'required|exists:produks,id_produk',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        $total_nota = 0;

        // Loop pertama untuk menghitung total nota
        for ($i = 0; $i < count($request->produk); $i++) {
            $produk = produk::find($request->produk[$i]);
            $jumlah = $request->jumlah[$i];
            $total_harga = $produk->harga_satuan * $jumlah;
            $total_nota += $total_harga;
        }

        // Cek apakah data sss dan resume produksi ada pada tanggal nota
        $tanggalNota = $request->tanggalNota;
        $sssData = sss::where('tanggal', $tanggalNota)->exists();
        $resumeProduksiData = resume_produksi::where('tanggal', $tanggalNota)->exists();

        if (!$sssData || !$resumeProduksiData) {
            return redirect()->back()->with('error', 'Data sss atau resume produksi pada tanggal ' . $tanggalNota . ' tidak ditemukan, silahkan menghubungi manager untuk informasi lebih lanjut');
        }

        // Buat nota pemasaran setelah total nota dihitung
        $nota = new nota_pemasaran();
        $nota->jenis_nota = $request->jenisNota;
        $nota->tanggal = $request->tanggalNota;
        $nota->nama_toko = $request->namaPelanggan;
        $nota->oleh = $request->oleh;
        $nota->status = $request->jenisNota === 'nota_cash' ? 'lunas' : 'belum_lunas';
        $nota->total_nota = $total_nota;
        $nota->save();

        $item_notas = [];

        // Loop untuk menambahkan item ke dalam database satu per satu
        for ($i = 0; $i < count($request->produk); $i++) {
            $produk = produk::find($request->produk[$i]);
            $jumlah = $request->jumlah[$i];

            // Buat item nota dan simpan ke database
            itemNota::create([
            'id_nota' => $nota->id_nota,
            'nama_produk' => $produk->nama_produk,
            'qty' => $jumlah,
            'harga_satuan' => $produk->harga_satuan,
            ]);

            // Loop untuk mengupdate jumlah sss pada rentang tanggal dari tanggal nota hingga hari ini
            $currentDate = date('Y-m-d');
            $startDate = $request->tanggalNota;

            while (strtotime($startDate) <= strtotime($currentDate)) {
                $sssData = sss::where('nama_produk', $produk->nama_produk)
                    ->where('tanggal', $startDate)
                    ->first();

                if ($sssData) {
                    $sssData->update([
                        'sss' => $sssData->sss - $jumlah,
                    ]);
                }

                $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
            }
        }

        return redirect()->back()->with('success', 'Nota berhasil ditambahkan');
    }

    public function tambahNotaPemasaran(Request $request){
        $request->validate([
            'tanggalNotaPemasaran' => 'required|date',
            'jenisNotaPemasaran' => 'required|in:nota_cash,nota_noncash',
            'namaPelangganPemasaran' => 'required|string|max:255',
            'oleh' => 'required|string|max:255',
            'produk' => 'required|array|min:1',
            'produk.*' => 'required|exists:produks,id_produk',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
        ]);

        $total_nota = 0;

        // Loop pertama untuk menghitung total nota berdasarkan input harga satuan dari user
        for ($i = 0; $i < count($request->produk); $i++) {
            $jumlah = $request->jumlah[$i];
            $harga_satuan = $request->harga_satuan[$i];
            $total_harga = $harga_satuan * $jumlah;
            $total_nota += $total_harga;
        }

        // Cek apakah data sss dan resume produksi ada pada tanggal nota
        $tanggalNota = $request->tanggalNotaPemasaran;
        $sssData = sss::where('tanggal', $tanggalNota)->exists();
        $resumeProduksiData = resume_produksi::where('tanggal', $tanggalNota)->exists();

        if (!$sssData || !$resumeProduksiData) {
            return redirect()->back()->with('error', 'Data sss atau resume produksi pada tanggal ' . $tanggalNota . ' tidak ditemukan, silahkan menghubungi manager untuk informasi lebih lanjut');
        }

        // Buat nota pemasaran setelah total nota dihitung
        $nota = new nota_pemasaran();
        $nota->jenis_nota = $request->jenisNotaPemasaran;
        $nota->tanggal = $request->tanggalNotaPemasaran;
        $nota->nama_toko = $request->namaPelangganPemasaran;
        $nota->oleh = $request->oleh;
        $nota->status = $request->jenisNotaPemasaran === 'nota_cash' ? 'lunas' : 'belum_lunas';
        $nota->total_nota = $total_nota;
        $nota->save();

        // Loop untuk menambahkan item ke dalam database satu per satu
        for ($i = 0; $i < count($request->produk); $i++) {
            $produk = produk::find($request->produk[$i]);
            $jumlah = $request->jumlah[$i];
            $harga_satuan = $request->harga_satuan[$i];

            // Buat item nota dan simpan ke database
            itemNota::create([
            'id_nota' => $nota->id_nota,
            'nama_produk' => $produk->nama_produk,
            'qty' => $jumlah,
            'harga_satuan' => $harga_satuan,
            ]);

            // Loop untuk mengupdate jumlah sss pada rentang tanggal dari tanggal nota hingga hari ini
            $currentDate = date('Y-m-d');
            $startDate = $request->tanggalNotaPemasaran;

            while (strtotime($startDate) <= strtotime($currentDate)) {
            $sssData = sss::where('nama_produk', $produk->nama_produk)
                ->where('tanggal', $startDate)
                ->first();

            if ($sssData) {
                $sssData->update([
                'sss' => $sssData->sss - $jumlah,
                ]);
            }

            $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
            }
        }

        return redirect()->back()->with('success', 'Nota berhasil ditambahkan');
    }

    public function showEditNota($id){
        $produks = produk::all();
        $nota = nota_pemasaran::where('id_nota', $id)->with('item_nota')->first();

        return view('admin.editNota', compact('produks', 'nota'));
    }

    public function editItemNota(Request $request, $id){
            // Validasi input
            $request->validate([
                'nama_produk' => 'required|exists:produks,nama_produk',
                'qty' => 'required|integer|min:1',
                'harga_satuan' => 'required|numeric|min:0',
            ]);

            // Cari item nota berdasarkan ID
            $itemNota = itemNota::find($id);

            if (!$itemNota) {
                return redirect()->back()->with('error', 'Item Nota tidak ditemukan.');
            }

            // Ambil data sss berdasarkan nama produk dan tanggal
            $sssData = sss::where('nama_produk', $itemNota->nama_produk)
                ->where('tanggal', '>=', $itemNota->nota_pemasaran->tanggal)
                ->orderBy('tanggal', 'asc')
                ->get();

            // Hitung perubahan stok
            $stokKembalian = $itemNota->qty;
            $stokBaru = $request->input('qty');

            // Update stok sss
            foreach ($sssData as $sss) {
                $stokUpdate = $sss->sss + $stokKembalian - $stokBaru;
                $sss->update(['sss' => $stokUpdate]);
            }

            // Update data item nota
            $itemNota->update([
                'nama_produk' => $request->input('nama_produk'),
                'qty' => $request->input('qty'),
                'harga_satuan' => $request->input('harga_satuan'),
            ]);

            // Update total_nota pada nota_pemasaran terkait
            $nota = nota_pemasaran::find($itemNota->id_nota);

            if ($nota) {
                $totalNota = itemNota::where('id_nota', $nota->id_nota)
                    ->sum(DB::raw('qty * harga_satuan'));

                $nota->update([
                    'total_nota' => $totalNota,
                ]);
            }

            return redirect()->back()->with('success', 'Item Nota berhasil diperbarui.');
            // dd($itemNota);
    }

    public function deleteItemNota($id){
        $itemNota = itemNota::find($id);

        if (!$itemNota) {
            return redirect()->back()->with('error', 'Item Nota tidak ditemukan.');
        }

        // Cari nota_pemasaran terkait
        $nota = nota_pemasaran::find($itemNota->id_nota);

        // Update stok sss sebelum item nota dihapus
        $sssData = sss::where('nama_produk', $itemNota->nama_produk)
            ->where('tanggal', '>=', $nota->tanggal)
            ->orderBy('tanggal', 'asc')
            ->get();

        foreach ($sssData as $sss) {
            $sss->update([
            'sss' => $sss->sss + $itemNota->qty,
            ]);
        }

        // Hapus item nota
        $itemNota->delete();

        // Update total_nota pada nota_pemasaran terkait
        if ($nota) {
            $totalNota = itemNota::where('id_nota', $nota->id_nota)
                ->sum(DB::raw('qty * harga_satuan'));

            $nota->update([
                'total_nota' => $totalNota,
            ]);
        }

        // Jika item nota terakhir dihapus, hapus juga nota_pemasaran terkait
        if ($nota && $nota->item_nota()->count() === 0) {
            $nota->delete();

            return redirect('user/admin/daftarNota')->with('success', 'Nota berhasil dihapus.');
        }

        return redirect()->back()->with('success', 'Item Nota berhasil dihapus.');
    }

    public function editNotaRev(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tanggalNotaPemasaran' => 'nullable|date',
            'jenisNotaPemasaran' => 'nullable|in:nota_cash,nota_noncash',
            'namaPelangganPemasaran' => 'nullable|string|max:255',
            'keteranganNotaPemasaran' => 'nullable|string',
            'produk' => 'nullable|array|min:1',
            'produk.*' => 'nullable|exists:produks,id_produk',
            'jumlah' => 'nullable|array|min:1',
            'jumlah.*' => 'nullable|integer|min:1',
            'harga_satuan' => 'nullable|array|min:1',
            'harga_satuan.*' => 'nullable|numeric|min:0',
        ]);

        // Cari nota berdasarkan ID
        $nota = nota_pemasaran::find($id);

        if (!$nota) {
            return redirect()->back()->with('error', 'Nota tidak ditemukan.');
        }

        // Update data nota
        $nota->update([
            'tanggal' => $request->input('tanggalNotaPemasaran'),
            'jenis_nota' => $request->input('jenisNotaPemasaran'),
            'nama_toko' => $request->input('namaPelangganPemasaran'),
            'keterangan' => $request->input('keteranganNotaPemasaran'),
        ]);

        $totalNota = $nota->total_nota;

        // Tambahkan item nota baru jika ada
        if ($request->has('produk') && is_array($request->produk) && count($request->produk) > 0) {
            for ($i = 0; $i < count($request->produk); $i++) {
                $produk = produk::find($request->produk[$i]);
                $jumlah = $request->jumlah[$i];
                $hargaSatuan = $request->harga_satuan[$i];
                $subtotal = $jumlah * $hargaSatuan;

                itemNota::create([
                    'id_nota' => $nota->id_nota,
                    'nama_produk' => $produk->nama_produk,
                    'qty' => $jumlah,
                    'harga_satuan' => $hargaSatuan,
                ]);

                $totalNota += $subtotal;
            }
        }

        // Update total nota
        $nota->update(['total_nota' => $totalNota]);

        if ($nota->keterangan === 'retail') {
            return redirect('/user/admin/daftarRetail')->with('success', 'Nota berhasil diperbarui.');
        } else {
            return redirect('/user/admin/daftarNota')->with('success', 'Nota berhasil diperbarui.');
        }
    }

    public function ubahStatusNota($id){
        $nota = nota_pemasaran::find($id);

        if (!$nota) {
            return redirect()->back()->with('error', 'Nota tidak ditemukan.');
        }

        // Toggle status antara 'lunas' dan 'belum_lunas'
        $nota->status = $nota->status === 'lunas' ? 'belum_lunas' : 'lunas';
        $nota->tanggal_lunas = now();
        $nota->save();

        if (auth()->user()->role === 'admin') {
            return redirect('/user/admin/daftarNota')->with('success', 'Status Nota berhasil diperbarui.');
        } elseif (auth()->user()->role === 'manager') {
            return redirect()->back()->with('success', 'Status Nota berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melakukan tindakan ini.');
        }
    }

    public function showDaftarRetail(){
        $produks = produk::all();
        $notaretail = nota_pemasaran::where('keterangan', 'retail')->with('item_nota')->get();

        return view('admin.daftarRetail', compact('produks', 'notaretail'));
    }

    public function tambahretail(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
            'namaPelanggan' => 'required|string|max:255',
            'itemProduk' => 'required|array|min:1',
            'itemProduk.*' => 'required|string|exists:produks,id_produk',
            'jumlahProduk' => 'required|array|min:1',
            'jumlahProduk.*' => 'required|numeric|min:0.01',
            'hargaSatuan' => 'required|array|min:1',
            'hargaSatuan.*' => 'required|numeric|min:0.01',
        ]);

        $total_nota = 0;
        // Loop pertama untuk menghitung total nota
        for ($i = 0; $i < count($request->itemProduk); $i++) {
            $jumlah = $request->jumlahProduk[$i];
            $harga_satuan = $request->hargaSatuan[$i];
            $total_harga = $harga_satuan * $jumlah;
            $total_nota += $total_harga;
        }
        // Buat nota pemasaran setelah total nota dihitung
        $nota = new nota_pemasaran();
        $nota->jenis_nota = 'nota_cash';
        $nota->tanggal = $request->tanggal;
        $nota->nama_toko = $request->namaPelanggan;
        $nota->status = 'lunas';
        $nota->total_nota = $total_nota;
        $nota->keterangan = 'retail';
        $nota->tanggal_lunas = $request->tanggal;
        $nota->save();

        // Loop untuk menambahkan item ke dalam database satu per satu
        for ($i = 0; $i < count($request->itemProduk); $i++) {
            $produk = produk::find($request->itemProduk[$i]);
            $jumlah = $request->jumlahProduk[$i];
            $harga_satuan = $request->hargaSatuan[$i];

            // Buat item nota dan simpan ke database
            itemNota::create([
                'id_nota' => $nota->id_nota,
                'nama_produk' => $produk->nama_produk,
                'qty' => $jumlah,
                'harga_satuan' => $harga_satuan,
            ]);
        }
        // dd($total_nota);
        return redirect()->back()->with('success', 'Nota retail berhasil ditambahkan.');
    }

    public function hapusNota($id){
        $nota = nota_pemasaran::find($id);

        if (!$nota) {
            return redirect()->back()->with('error', 'Nota tidak ditemukan.');
        }

        // Update stok sss sebelum item nota dihapus
        $itemNotas = itemNota::where('id_nota', $nota->id_nota)->get();
        foreach ($itemNotas as $itemNota) {
            $sssData = sss::where('nama_produk', $itemNota->nama_produk)
            ->where('tanggal', '>=', $nota->tanggal)
            ->orderBy('tanggal', 'asc')
            ->get();

            foreach ($sssData as $sss) {
            $sss->update([
                'sss' => $sss->sss + $itemNota->qty,
            ]);
            }

            // Hapus item nota
            $itemNota->delete();
        }

        // Hapus nota pemasaran
        $nota->delete();

        return redirect()->back()->with('success', 'Nota berhasil dihapus.');
    }
}
