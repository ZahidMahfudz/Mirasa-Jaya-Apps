<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModalBankPermata;
use App\Models\ModalDisetor;

class ModalDisetorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modalDisetor = ModalDisetor::all();
        $modalBankPermata = ModalBankPermata::all();
        return view('Manager.ModalDisetor.index',compact ('modalBankPermata','modalDisetor'));
    }

    public function indexOwner(){
        $modalDisetor = ModalDisetor::all();
        $modalBankPermata = ModalBankPermata::all();
        return view('owner.ModalDisetor',compact ('modalBankPermata','modalDisetor'));
    }

    public function cetak(){
        $modalDisetor = ModalDisetor::all();
        $modalBankPermata = ModalBankPermata::all();
        return view('cetak.cetakModalDisetor',compact ('modalBankPermata','modalDisetor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeModalDisetor(Request $request)
    {
        //validasi input
        $request->validate([
            'jenis_modal' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required',
        ]);

        //Simpan data ke database
        ModalDisetor::create([
            'jenis_modal' => $request->input('jenis_modal'),
            'tanggal' => $request->input('tanggal'),
            'jumlah' => $request->input('jumlah'),
        ]);

        return redirect()->back();
    }

    public function storeModalBankPermata(Request $request)
    {
        //Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required',
        ]);

        //Simpan data ke database
        ModalBankPermata::create([
            'tanggal' => $request->input('tanggal'),
            'jumlah' => $request->input('jumlah'),
        ]);

        return redirect()->back();
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateModalDisetor(Request $request, string $id)
    {
        //Validasi input
        $request->validate([
            'jenis_modal' => 'required',
            'tanggal' => 'required|date',
            'jumlah' => 'required',
        ]);

        //Ambil data berdasarkan ID
        $modalDisetor = ModalDisetor::find($id);

        //Update data
        $modalDisetor->update([
            'jenis_modal' => $request->input('jenis_modal'),
            'tanggal' => $request->input('tanggal'),
            'jumlah' => $request->input('jumlah'),
        ]);

        return redirect()->back();
    }

    public function updateModalBankPermata(Request $request, string $id)
    {
        //Validasi input
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required',
        ]);

        //Ambil data berdasarkan ID
        $modalBankPermata = ModalBankPermata::find($id);

        //Update data
        $modalBankPermata->update([
            'tanggal' => $request->input('tanggal'),
            'jumlah' => $request->input('jumlah'),
        ]);

        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroyModalDisetor(string $id)
    {
        //Hapus data berdasarkan ID
        ModalDisetor::destroy($id);

        return redirect()->back();
    }

    public function destroyModalBankPermata(string $id)
    {
        //Hapus data berdasarkan ID
        ModalBankPermata::destroy($id);

        return redirect()->back();
    }
}
