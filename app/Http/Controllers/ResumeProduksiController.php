<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\sss;
use App\Models\produk;
use App\Models\stok_kardus;
use App\Models\drop_out;
use App\Models\preorder;
use App\Models\bahanbaku;
use App\Models\ListDropOut;
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
        $endDate = resume_produksi::max('tanggal');
        $startDate = date('Y-m-d', strtotime('-5 days', strtotime($endDate)));


        $data_resume = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();
        $groupedData = $data_resume->groupBy('nama_produk');
        $uniqueDates = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->distinct('tanggal')->pluck('tanggal')->toArray();

        return view('manager.resumeproduksi', compact('groupedData', 'uniqueDates'));
    }


    public function generateResumerev(){
        // Ambil tanggal hari ini
        $tanggalHariIni = Carbon::now()->toDateString();

        // Periksa apakah tanggal hari ini sudah ada dalam tabel resume_produksi
        $resumeHariIni = resume_produksi::where('tanggal', $tanggalHariIni)->first();

        // Jika tanggal hari ini sudah ada, redirect kembali
        if ($resumeHariIni) {
            return redirect()->back()->with('error', 'Resume untuk hari ini sudah ada.');
        }
        else{
            $produk = Produk::all();
            if($produk){
                foreach($produk as $item){
                    resume_produksi::create([
                        'tanggal' => $tanggalHariIni,
                        'nama_produk' => $item->nama_produk,
                        'in' => 0,
                        'out' => 0,
                        'sisa' => 0
                    ]);

                    $ssskemarin = sss::where('nama_produk', $item->nama_produk)
                        ->where('tanggal', '<', $tanggalHariIni)
                        ->orderBy('tanggal', 'desc')
                        ->first();

                    if (!$ssskemarin) {
                        $ssskemarin = sss::where('nama_produk', $item->nama_produk)
                            ->orderBy('tanggal', 'desc')
                            ->first();
                    }

                    $sss = $ssskemarin ? $ssskemarin->sss : 0;

                    sss::create([
                        'tanggal' => $tanggalHariIni,
                        'nama_produk' => $item->nama_produk,
                        'sss' => $sss
                    ]);
                }
                $kardus = bahanbaku::where('jenis', 'kardus')->get();

                $stokkemaren = stok_kardus::where('tanggal', '<', $tanggalHariIni)->orderBy('tanggal', 'desc')->first();

                if (!$stokkemaren) {
                    foreach ($kardus as $kardusItem) {
                        stok_kardus::create([
                            'tanggal' => $tanggalHariIni,
                            'nama_kardus' => $kardusItem->nama_bahan,
                            'pakai' => 0,
                            'sisa' => 0
                        ]);
                    }
                } else {
                    foreach ($kardus as $item) {
                        $sisaKemarin = stok_kardus::where('nama_kardus', $item->nama_bahan)
                            ->where('tanggal', '<', $tanggalHariIni)
                            ->orderBy('tanggal', 'desc')
                            ->first();

                        $sisa = $sisaKemarin ? $sisaKemarin->sisa : 0;

                        stok_kardus::create([
                            'tanggal' => $tanggalHariIni,
                            'nama_kardus' => $item->nama_bahan,
                            'pakai' => 0,
                            'sisa' => $sisa
                        ]);
                    }
                }
                // Setelah menambahkan data baru, perbarui variabel $groupedData dan $uniqueDates
                $endDate = resume_produksi::max('tanggal');
                $startDate = date('Y-m-d', strtotime('-5 days', strtotime($endDate)));
                $data_resume = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();
                $groupedData = $data_resume->groupBy('nama_produk');
                $uniqueDates = resume_produksi::distinct('tanggal')->pluck('tanggal')->toArray();

                // Redirect kembali ke halaman resumeproduksi dengan variabel yang diperbarui
                return redirect('user/manager/resumeproduksi')->with(compact('groupedData', 'uniqueDates'))->with('success', 'Data berhasil ditambah.');
            }
            else{
                return redirect()->back()->with('error', 'Silahkan tambahkan produk terlebih dahulu');
            }
        }
    }

    public function editResumeRev(Request $request, $id){
        $request->validate([
            'sisa' => 'required|integer|min:0'
        ]);

        $resume = resume_produksi::findOrFail($id);

        if($resume){
            $resume_sebelumnya = resume_produksi::where('nama_produk', $resume->nama_produk)
                ->where('tanggal', '<', $resume->tanggal)
                ->orderBy('tanggal', 'desc')
                ->first();
    
            if($resume_sebelumnya){
                $sisa_sebelumnya = $resume_sebelumnya->sisa;
            }
            else{
                $sisa_sebelumnya = 0;
            }


            $jumlahIn = $request->input('sisa') - $sisa_sebelumnya + $resume->out;
    

            // Dapatkan jenis kardus yang digunakan oleh produk
            $produk = produk::where('nama_produk', $resume->nama_produk)->first();

            if ($produk && $produk->jenis_kardus) {
                $jenisKardus = $produk->jenis_kardus;

                // Dapatkan stok kardus dari hari sebelumnya
                $tanggalSebelumnya = date('Y-m-d', strtotime('-1 day', strtotime($resume->tanggal)));
                $stokKardusSebelumnya = stok_kardus::where('tanggal', $tanggalSebelumnya)
                    ->where('nama_kardus', $jenisKardus)
                    ->first();

                if (!$stokKardusSebelumnya || $stokKardusSebelumnya->sisa === null || $stokKardusSebelumnya->sisa == 0) {
                    return redirect()->back()->with('error', 'Silahkan tambahkan kardus ' . $jenisKardus . ' terlebih dahulu');
                }

                $sisaSebelumnya = $stokKardusSebelumnya->sisa;

                // Dapatkan stok kardus untuk jenis kardus ini pada tanggal yang sama
                $stokKardus = stok_kardus::where('tanggal', $resume->tanggal)
                    ->where('nama_kardus', $jenisKardus)
                    ->first();

                if ($stokKardus && $stokKardus->pakai > 0) {
                    // Jika sudah ada jumlah pakai, tambahkan jumlahIn ke pakai dan hitung ulang sisa
                    $pakaiHariIni = $stokKardus->pakai + $jumlahIn;
                    $sisaKardus = $sisaSebelumnya - $pakaiHariIni;

                    if ($sisaKardus < 0) {
                        return redirect()->back()->with('error', 'Jumlah produksi terlalu banyak, silahkan tambah jumlah kardus terlebih.');
                    }

                    $stokKardus->update([
                        'pakai' => $pakaiHariIni,
                        'sisa' => $sisaKardus
                    ]);
                } else {
                    // Jika pakai untuk tanggal hari ini = 0 atau null, jalankan seperti biasa
                    $sisaKardus = $sisaSebelumnya - $jumlahIn;

                    if ($sisaKardus < 0) {
                        return redirect()->back()->with('error', 'Jumlah produksi terlalu banyak, silahkan tambah jumlah kardus terlebih.');
                    }

                    if ($stokKardus) {
                        // Update stok kardus yang ada
                        $stokKardus->update([
                            'pakai' => $jumlahIn,
                            'sisa' => $sisaKardus
                        ]);
                    } else {
                        // Buat stok kardus baru jika belum ada
                        stok_kardus::create([
                            'tanggal' => $resume->tanggal,
                            'nama_kardus' => $jenisKardus,
                            'pakai' => $jumlahIn,
                            'sisa' => $sisaKardus
                        ]);
                    }
                }
            }

            $resume->update([
                'in' => $jumlahIn,
                'sisa' => $request->input('sisa')
            ]);

            return redirect('user/manager/resumeproduksi')->with('success', 'Data berhasil diperbarui');
        }
        else{
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function indexlaporanproduksi()
    {
        $endDate = resume_produksi::max('tanggal');
        $startDate = date('Y-m-d', strtotime('-5 days', strtotime($endDate)));

        // Ambil data resume produksi antara rentang tanggal yang diberikan
        $data_resume = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $groupedData = $data_resume->groupBy('nama_produk');
        $uniqueDates = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])
            ->distinct('tanggal')
            ->pluck('tanggal')
            ->toArray();
        $produk = produk::pluck('harga_satuan', 'nama_produk');

        return view('owner.laporanproduksi', compact('groupedData', 'uniqueDates', 'produk', 'startDate', 'endDate'));
    }


    public function filterlaporanproduksi(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // if($endDate < $startDate){
        //     return redirect()->back()->with('error', 'tanggal tidak valid');
        // }

        // Ambil data resume produksi antara rentang tanggal yang diberikan
        $data_resume = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->orderBy('tanggal', 'desc')->get();

        // Lakukan pengelompokan data berdasarkan nama produk
        $groupedData = $data_resume->groupBy('nama_produk');

        // Ambil tanggal-tanggal unik dalam rentang yang dipilih
        $uniqueDates = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])->distinct('tanggal')->pluck('tanggal')->toArray();

        // Ambil produk dengan harga satuan yang diperbarui
        $produk = produk::pluck('harga_satuan', 'nama_produk');

        // Kembalikan view dengan data yang diperbarui
        return view('owner.laporanproduksi', compact('groupedData', 'uniqueDates', 'produk', 'startDate', 'endDate'));
    }

    public function cetaklaporanproduksi($startDate, $endDate)
    {
        $startDate = $startDate;
        $endDate = $endDate;

        $data_resume = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $groupedData = $data_resume->groupBy('nama_produk');
        $uniqueDates = resume_produksi::whereBetween('tanggal', [$startDate, $endDate])
            ->distinct('tanggal')
            ->pluck('tanggal')
            ->toArray();
        $produk = produk::pluck('harga_satuan', 'nama_produk');

        return view('cetak.cetaklaporanproduksi', compact('groupedData', 'uniqueDates', 'produk', 'startDate', 'endDate'));
    }

    public function indexstokrotijadi()
    {
        $endDate = resume_produksi::max('tanggal');

        $dataStokRotiJadi = resume_produksi::select('resume_produksis.tanggal', 'resume_produksis.nama_produk', 'resume_produksis.sisa', 'ssses.sss','produks.harga_satuan')
            ->leftJoin('ssses', function ($join) {
                $join->on('resume_produksis.tanggal', '=', 'ssses.tanggal')
                    ->on('resume_produksis.nama_produk', '=', 'ssses.nama_produk');
            })
            ->leftJoin('produks', function($join){
                $join->on('resume_produksis.nama_produk', '=', 'produks.nama_produk');
            })
            ->where('resume_produksis.tanggal', $endDate)
            ->orderBy('resume_produksis.tanggal', 'desc')
            ->get();

        return view('owner.stokrotijadi', compact('endDate', 'dataStokRotiJadi'));
        // dd($dataStokRotiJadi);
    }

    public function filterStokRotiJadi(Request $request){
        $request->validate([
            'endDate' => 'required|date'
        ]);

        $endDate = $request->input('endDate');

        $dataStokRotiJadi = resume_produksi::select('resume_produksis.tanggal', 'resume_produksis.nama_produk', 'resume_produksis.sisa', 'ssses.sss','produks.harga_satuan')
            ->leftJoin('ssses', function ($join) {
                $join->on('resume_produksis.tanggal', '=', 'ssses.tanggal')
                    ->on('resume_produksis.nama_produk', '=', 'ssses.nama_produk');
            })
            ->leftJoin('produks', function($join){
                $join->on('resume_produksis.nama_produk', '=', 'produks.nama_produk');
            })
            ->where('resume_produksis.tanggal', $endDate)
            ->orderBy('resume_produksis.tanggal', 'desc')
            ->get();

        return view('owner.stokrotijadi', compact('endDate', 'dataStokRotiJadi'));
    }

    public function cetakStokRotiJadi($endDate){
        $endDate = $endDate;

        $dataStokRotiJadi = resume_produksi::select('resume_produksis.tanggal', 'resume_produksis.nama_produk', 'resume_produksis.sisa', 'ssses.sss','produks.harga_satuan')
            ->leftJoin('ssses', function ($join) {
                $join->on('resume_produksis.tanggal', '=', 'ssses.tanggal')
                    ->on('resume_produksis.nama_produk', '=', 'ssses.nama_produk');
            })
            ->leftJoin('produks', function($join){
                $join->on('resume_produksis.nama_produk', '=', 'produks.nama_produk');
            })
            ->where('resume_produksis.tanggal', $endDate)
            ->orderBy('resume_produksis.tanggal', 'desc')
            ->get();

        return view('cetak.cetakstokrotijadi', compact('endDate', 'dataStokRotiJadi'));
    }

    public function cariproduk(){
        $produk = produk::where('nama_produk', 'LIKE', '%'.request('q').'%')->get();
        return response()->json($produk);
    }

    public function showDropOutManager(){
        $produk = produk::all();
        $dropoutproses = drop_out::where('status', 'proses')->with('ListDropOut')->get();
        $dropoutdiambil = drop_out::where('status', 'diambil')->with('ListDropOut')->orderBy('created_at', 'desc')->get();
        return view('manager.dropOut', compact('produk', 'dropoutproses', 'dropoutdiambil'));
    }

    public function addListDO(Request $request, $id){
        $request->validate([
            'product_name' => 'required|string',
            'qty' => 'required|integer|min:1'
        ]);

        $dropOut = drop_out::findOrFail($id);

        // Check if the product already exists in the list
        $existingProduct = ListDropOut::where('drop_out_id', $dropOut->id)
            ->where('nama_barang', $request->product_name)
            ->first();

        if ($existingProduct) {
            return redirect()->back()->with('error', $request->product_name.' sudah ditambahkan silahkan ubah jumlahnya pada menu edit');
        }

        ListDropOut::create([
            'drop_out_id' => $dropOut->id,
            'nama_barang' => $request->product_name,
            'jumlah_barang' => $request->qty
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }

    public function hapusproduklistdo($id){
        $listDO = ListDropOut::findOrFail($id);
        $listDO->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus');
    }

    public function tambahDropOut(Request $request){
        $request->validate([
            'nama_seller' => 'required|string',
            'nama_produk.*' => 'required|string',
            'jumlah.*' => 'required|integer|min:1'
        ]);

        $tanggalHariIni = Carbon::now()->toDateString();
        $resumeHariIni = resume_produksi::where('tanggal', $tanggalHariIni)->first();

        if (!$resumeHariIni) {
            return redirect()->back()->with('error', 'Resume hari ini belum di generate, silahkan generate resume produksi hari ini pada menu resume produksi');
        }

        $dropOut = new drop_out();
        $dropOut->tanggal = Carbon::now()->toDateString();
        $dropOut->nama_pengambil = $request->nama_seller;
        $dropOut->status = 'proses';
        $dropOut->save();

        $ListDropOut = [];
        for($i=0; $i < count($request->nama_produk); $i++){
            $ListDropOut[] = [
                'drop_out_id' => $dropOut->id,
                'nama_barang' => $request->nama_produk[$i],
                'jumlah_barang' => $request->jumlah[$i]
            ];
        }


        ListDropOut::insert($ListDropOut);

        return redirect()->back()->with('success', 'Drop Out berhasil ditambahkan');
    }

    public function editDropOut(Request $request, $id){
        $request->validate([
            'nama_seller' => 'required|string',
            'nama_produk.*' => 'required|string',
            'jumlah.*' => 'required|integer|min:1'
        ]);

        $dropOut = drop_out::findOrFail($id);
        $dropOut->update([
            'nama_pengambil' => $request->nama_seller
        ]);

        $listDO = ListDropOut::where('drop_out_id', $id)->get();
        $listDO->each->delete();

        $ListDropOut = [];
        for($i=0; $i < count($request->nama_produk); $i++){
            $ListDropOut[] = [
                'drop_out_id' => $dropOut->id,
                'nama_barang' => $request->nama_produk[$i],
                'jumlah_barang' => $request->jumlah[$i]
            ];
        }

        ListDropOut::insert($ListDropOut);

        return redirect()->back()->with('success', 'Drop Out berhasil diperbarui');
    }

    public function cetakDropOut($id){
        $dropOut = drop_out::find($id);
        $listDO = ListDropOut::where('drop_out_id', $id)->get();

        foreach($listDO as $item){
            //resume
            $resumeOut = resume_produksi::where('nama_produk', $item->nama_barang)
                ->where('tanggal', $dropOut->tanggal)
                ->first();
            
            $resumeOut->update([
                'out' => $resumeOut->out + $item->jumlah_barang,
            ]);

            //sss
            $sss = sss::where('nama_produk', $item->nama_barang)
                ->where('tanggal', $dropOut->tanggal)
                ->first();

            $sss->update([
                'sss' => $sss->sss + $item->jumlah_barang
            ]);
        }

        $dropOut->update([
            'status' => 'diambil'
        ]);

        return view('cetak.cetakdropout', compact('dropOut', 'listDO'));
    }

    public function showpreordermanager(){
        $orderpending = preorder::where('status', 'pending')->with('detailOrder')->get();
        $orderproses = preorder::where('status', 'proses')->with('detailOrder')->get();
        $orderselesai = preorder::where('status', 'selesai')->with('detailOrder')->get();
        // $order = preorder::whereIn('status', ['pending', 'proses'])
        //     ->orderByRaw("FIELD(status, 'proses', 'pending')")
        //     ->with('detailOrder')
        //     ->get();
        return view('manager.preorder', compact('orderpending','orderproses', 'orderselesai'));
    }

    public function prosesOrder($id){
        $order = preorder::findOrFail($id);
        $order->update([
            'status' => 'proses'
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil diproses');
    }

    public function completeOrder($id){
        $order = preorder::findOrFail($id);
        $order->update([
            'status' => 'selesai'
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil diselesaikan');
    }

}
