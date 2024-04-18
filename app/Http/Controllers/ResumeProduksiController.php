<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;
use App\Models\resume_produksi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Storeresume_produksiRequest;
use App\Http\Requests\Updateresume_produksiRequest;
use Carbon\Carbon;

class ResumeProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // // Temukan tanggal paling terbaru dalam data resume
        // $tanggalTerbaru = resume_produksi::max('tanggal');

        // // Kurangkan tanggal paling terbaru dengan 6 hari untuk mendapatkan tanggal mulai
        // $tanggalMulai = Carbon::parse($tanggalTerbaru)->subDays(6)->toDateString();

        // // Ambil data resume hanya 6 hari terakhir sejak tanggal mulai
        // $data_resume = resume_produksi::whereDate('tanggal', '>=', $tanggalMulai)
        //                                 ->orderBy('tanggal', 'desc')
        //                                 ->get();

        $data_resume = resume_produksi::orderBy('tanggal', 'desc')->get();
        $groupedData = $data_resume->groupBy('nama_produk');
        $uniqueDates = resume_produksi::distinct('tanggal')->pluck('tanggal')->toArray();

        return view('manager.resumeproduksi', compact('groupedData', 'uniqueDates'));
    }

    public function generateResumeProduksi()
    {
        // Ambil tanggal hari ini
        $tanggalHariIni = Carbon::now()->toDateString();

        // Periksa apakah tanggal hari ini sudah ada dalam tabel resume_produksi
        $resumeHariIni = resume_produksi::where('tanggal', $tanggalHariIni)->first();

        // Jika tanggal hari ini sudah ada, redirect kembali
        if ($resumeHariIni) {
            return redirect()->back()->with('error', 'Resume untuk hari ini sudah ada.');
        }

        // Ambil semua produk dari tabel produk
        $produk = Produk::all();

        // Iterasi setiap produk dan masukkan ke dalam tabel resume_produksi
        foreach ($produk as $item) {
            // Cari sisa dari tanggal sebelumnya
            $sisaKemarin = resume_produksi::where('nama_produk', $item->nama_produk)
                ->where('tanggal', '<', $tanggalHariIni)
                ->orderBy('tanggal', 'desc')
                ->first();

            // Hitung sisa berdasarkan data kemarin atau set ke 0 jika tidak ada data kemarin
            $sisa = $sisaKemarin ? $sisaKemarin->sisa : 0;

            // Masukkan data baru ke dalam tabel resume_produksi
            resume_produksi::create([
                'tanggal' => $tanggalHariIni,
                'nama_produk' => $item->nama_produk,
                'in' => 0,
                'out' => 0,
                'sisa' => $sisa
            ]);
        }

        return redirect('user/manager/resumeproduksi')->with('success', 'Data berhasil ditambah.');
    }


    public function editResume(Request $request, $id)
    {
        $request->validate([
            'in' => 'required|integer|min:0',
            'out' => 'required|integer|min:0',
        ]);

        // Temukan data resume sesuai ID
        $resume = resume_produksi::findOrFail($id);

        // Hitung sisa sesuai kondisi
        if ($resume->sisa === null) {
            $sisa = $request->input('in') - $request->input('out');
        } elseif ($resume->sisa == 0) {
            $sisa = $request->input('in') - $request->input('out');
        } else {
            $sisa = $resume->sisa + $request->input('in') - $request->input('out');
        }

        // Pastikan sisa tidak negatif
        $sisa = max(0, $sisa);

        // Lakukan update data resume
        $resume->update([
            'in' => $request->input('in'),
            'out' => $request->input('out'),
            'sisa' => $sisa,
        ]);

        return redirect('user/manager/resumeproduksi')->with('success', 'Data berhasil diperbarui');
    }

    public function indexlaporanproduksi(){
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


    public function filterlaporanproduksi(Request $request){
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

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

    public function cetaklaporanproduksi($startDate, $endDate){
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

        return view('owner.cetaklaporanproduksi', compact('groupedData', 'uniqueDates', 'produk', 'startDate', 'endDate'));

    }

    public function indexstokrotijadi(){
        $endDate = resume_produksi::max('tanggal');
        $data_resume = resume_produksi::where('tanggal', $endDate)->orderBy('tanggal', 'desc')->get();
        $groupedData = $data_resume->groupBy('nama_produk');
        $uniqueDates = [$endDate];
        $produk = produk::pluck('harga_satuan', 'nama_produk');

        return view('owner.stokrotijadi', compact('groupedData', 'uniqueDates', 'produk', 'endDate'));
    }


    //silahkan buat fungsi jika diperlukan untuk ajax

}
