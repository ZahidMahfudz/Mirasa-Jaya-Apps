<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kas;
use App\Models\KasBankPermata;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class KasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Kasindex(Request $request)
    {   
    // Ambil parameter filter dari request
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    
    if ($startDate && $endDate) {
        // Parse tanggal dari input dan hitung total saldo dalam rentang tanggal tersebut
        $startOfWeek = Carbon::parse($startDate)->startOfDay();
        $endOfWeek = Carbon::parse($endDate)->endOfDay();
    } else {
        // Jika tidak ada filter tanggal, gunakan rentang default (minggu ini)
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Set nilai default untuk view
        $startDate = $startOfWeek->toDateString();  // Untuk menampilkan di form
        $endDate = $endOfWeek->toDateString();      // Untuk menampilkan di form
    }

    // Ambil data kas dalam rentang tanggal
    $kas = Kas::whereBetween('tanggal', [$startOfWeek, $endOfWeek])->get();
    
    // Hitung total saldo dalam rentang tanggal
    $totalSaldo = $kas->sum('jumlah');

    // Mengambil saldo terkini dari transaksi terakhir pada tabel KasBankPermata
    $totalKasBankPermataSaldo = KasBankPermata::latest()->value('saldo') ?? 0;

    // Menggabungkan total saldo dari tabel Kas dan KasBankPermata
    $totalSaldo += $totalKasBankPermataSaldo;

    // Mengirim data ke view
    return view('manager.Kas.kas', compact('kas', 'totalSaldo', 'totalKasBankPermataSaldo', 'startDate', 'endDate'));
    }

    public function createKas()
    {
        return view('manager.Kas.create-kas');
    }

    public function storeKas(Request $request)
    {
        // Validasi data input dari form
        $request->validate([
            'tanggal' => 'required|date',
            'kas' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        Kas::create($request->all());
        return redirect()->back();
    }

    public function editKas(string $id)
    {
        $kas = Kas::find($id);
        return view('manager.Kas.edit-kas', ['kas' => $kas]);
    }

    public function updateKas(Request $request, string $id)
    {
        // Validasi data input dari form
        $request->validate([
            'tanggal' => 'required|date',
            'kas' => 'required',
            'jumlah' => 'required|numeric',
        ]);
        Kas::find($id)->update($request->all());
        return redirect()->back();
    }

    public function destroyKas(string $id)
    {
        Kas::destroy($id);
        return redirect()->back();

    }

    public function indexOwner(Request $request){
        $tanggalAkhir = $request->input('tanggalAkhir');

        if(!$request->input('tanggalAkhir')){
            $tanggalAkhir = Kas::max('tanggal');
        }

        $kas = kas::where('tanggal', $tanggalAkhir)->get();
        $kas_bank_permata = KasBankPermata::where('tanggal', '<=', $tanggalAkhir)->get();
        $totalKasBankPermataSaldo = KasBankPermata::where('tanggal', '<=', $tanggalAkhir)->latest()->value('saldo') ?? 0;


        return view('owner.kas', compact('kas', 'kas_bank_permata', 'totalKasBankPermataSaldo', 'tanggalAkhir'));
    }

    public function cetak($tanggalAkhir){
        $kas = kas::where('tanggal', $tanggalAkhir)->get();
        $kas_bank_permata = KasBankPermata::where('tanggal', '<=', $tanggalAkhir)->get();
        $totalKasBankPermataSaldo = KasBankPermata::where('tanggal', '<=', $tanggalAkhir)->latest()->value('saldo') ?? 0;


        return view('cetak.cetakkas', compact('kas', 'kas_bank_permata', 'totalKasBankPermataSaldo', 'tanggalAkhir'));
    }

/*************************************************************************************/

    public function KasBankPermataindex(){
        $kas_bank_permata = KasBankPermata::all();
        $totalSaldo = KasBankPermata::latest()->value('saldo'); // Mengambil saldo terkini dari transaksi terakhir
        return view('manager.Kas.bank-permata',['kas_bank_permata' => $kas_bank_permata],['totalSaldo' => $totalSaldo]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createKasBankPermata()
    {
        //
        return view('manager.Kas.create-bank-permata');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeKasBankPermata(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'hal' => 'required|string',
            'mutasi' => 'required|in:debit,kredit',
            'debit' => 'nullable|numeric',
            'kredit' => 'nullable|numeric',
        ]);
        
        Log::info('Data yang divalidasi:', $validatedData);

        // Mengambil transaksi terakhir dan saldo terakhir
        $lastTransaction = KasBankPermata::latest()->first();
        $lastBalance = $lastTransaction ? $lastTransaction->saldo : 0;
    
        // Calculate the new balance
        $newBalance = $lastBalance;
        if ($request->mutasi === 'debit') {
            $newBalance -= $request->debit ?? 0;
            $validatedData['debit'] = $request->debit ?? 0;
            $validatedData['kredit'] = null; // Set kredit to null
        } elseif ($request->mutasi === 'kredit') {
            $newBalance += $request->kredit ?? 0;
            $validatedData['debit'] = null; // Set debit to null
            $validatedData['kredit'] = $request->kredit ?? 0;
        }
        
        $validatedData['saldo'] = $newBalance;

        Log::info('Data yang akan disimpan:', $validatedData);
    
        // Membuat transaksi baru dengan data yang divalidasi
        KasBankPermata::create($validatedData);
    
        return redirect()->back()->with('success', 'Data berhasil disimpan dengan saldo terupdate.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editBankPermata(string $id)
    {
        $kas_bank_permata = KasBankPermata::find($id);
        return view('manager.Kas.edit-bank-permata', ['kas_bank_permata' => $kas_bank_permata]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateBankPermata(Request $request, string $id)
    {
    // Validasi data
    $validatedData = $request->validate([
        'tanggal' => 'required|date',
        'hal' => 'required|string',
        'mutasi' => 'required|in:debit,kredit',
        'debit' => 'nullable|numeric',
        'kredit' => 'nullable|numeric',
    ]);

    // Ambil transaksi yang sedang diedit
    $currentTransaction = KasBankPermata::find($id);
    $oldDebit = $currentTransaction->debit;
    $oldKredit = $currentTransaction->kredit;

    // Ambil saldo transaksi sebelum yang diedit
    $previousTransaction = KasBankPermata::where('id', '<', $id)->latest()->first();
    $previousBalance = $previousTransaction ? $previousTransaction->saldo : 0;

    // Hitung saldo baru untuk transaksi yang sedang diedit
    $newBalance = $previousBalance;

    if ($request->mutasi === 'debit') {
        $newBalance -= $request->debit ?? 0;
        $validatedData['debit'] = $request->debit ?? 0;
        $validatedData['kredit'] = null; // Set kredit to null
    } elseif ($request->mutasi === 'kredit') {
        $newBalance += $request->kredit ?? 0;
        $validatedData['debit'] = null; // Set debit to null
        $validatedData['kredit'] = $request->kredit ?? 0;
    }

    $validatedData['saldo'] = $newBalance;

    // Update transaksi yang sedang diedit
    $currentTransaction->update($validatedData);

    // Ambil semua transaksi setelah transaksi yang sedang diedit
    $followingTransactions = KasBankPermata::where('id', '>', $id)->orderBy('tanggal', 'asc')->get();
    
    // Update saldo untuk transaksi-transaksi berikutnya
    foreach ($followingTransactions as $transaction) {
        if ($transaction->mutasi === 'debit') {
            $newBalance -= $transaction->debit;
        } elseif ($transaction->mutasi === 'kredit') {
            $newBalance += $transaction->kredit;
        }

        // Update saldo transaksi
        $transaction->saldo = $newBalance;
        $transaction->save();
    }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyBankPermata(string $id)
    {
    // Hapus transaksi
    KasBankPermata::destroy($id);

    // Ambil semua transaksi dan hitung ulang saldo
    $transactions = KasBankPermata::orderBy('tanggal', 'asc')->get();
    $saldo = 0;

    foreach ($transactions as $transaction) {
        if ($transaction->mutasi === 'debit') {
            $saldo -= $transaction->debit;
        } elseif ($transaction->mutasi === 'kredit') {
            $saldo += $transaction->kredit;
        }

        // Update saldo untuk setiap transaksi
        $transaction->saldo = $saldo;
        $transaction->save();
    }

    return redirect()->back();
    }
}
