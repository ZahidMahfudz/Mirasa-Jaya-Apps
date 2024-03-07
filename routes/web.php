<?php

use App\Http\Controllers\BahanbakuController;
use App\Http\Controllers\HutangbahanbakuController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\Rekappemasaran;
use App\Http\Controllers\ResumeProduksiController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\UangmasukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\wipController;
use App\Models\hutangbahanbaku;
use App\Policies\ResumeProduksiPolicy;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function(){
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});
Route::get('/home', function(){ return redirect('/user'); });

Route::middleware(['auth'])->group(function(){
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/admin', [UserController::class, 'admin'])->middleware('userAkses:admin');
    Route::get('/user/manager', [UserController::class, 'manager'])->middleware('userAkses:manager');
    Route::get('/user/owner', [UserController::class, 'owner'])->middleware('userAkses:owner');
    Route::get('/logout', [SesiController::class, 'logout']);

    //semua terkait manager taruh sini
    Route::get('user/manager/dasboard', [ManagerController::class, 'dashboard'])->middleware('userAkses:manager');
    //produk
    Route::get('user/manager/harga_produk', [ProdukController::class, 'index'])->middleware('userAkses:manager');
    Route::post('/editproduk/{id}', [ProdukController::class, 'edit']);
    Route::post('user/manager/tambahproduk', [ProdukController::class, 'tambah'])->middleware('userAkses:manager');
    Route::get('/delete/{id}', [ProdukController::class, 'delete']);
    //bahan baku
    Route::get('user/manager/harga_bahan_baku', [BahanbakuController::class, 'index'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahbahanbaku', [BahanbakuController::class, 'tambahbahanbaku'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahbahanpenolong', [BahanbakuController::class, 'tambahbahanpenolong'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahkardus', [BahanbakuController::class, 'tambahkardus'])->middleware('userAkses:manager');
    Route::post('user/manager/editbahanbaku/{id}', [BahanbakuController::class, 'editbahanbaku'])->middleware('userAkses:manager');
    Route::post('user/manager/editbahanpenolong/{id}', [BahanbakuController::class, 'editbahanbaku'])->middleware('userAkses:manager');
    Route::post('user/manager/editkardus/{id}', [BahanbakuController::class, 'editkardus'])->middleware('userAkses:manager');
    Route::get('/deletebahanbaku/{id}', [BahanbakuController::class, 'delete']);
    //hutang bahan baku
    Route::get('user/manager/hutang_bahan_baku', [HutangbahanbakuController::class, 'index'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahhutang', [HutangbahanbakuController::class, 'tambahhutangbahanbaku'])->middleware('userAkses:manager');
    Route::get('/lunas/{id}', [HutangbahanbakuController::class, 'lunas']);
    Route::post('user/manager/edithutang/{id}', [HutangbahanbakuController::class, 'edit'])->middleware('userAkses:manager');
    //Uang Masuk
    Route::get('user/manager/uang_masuk', [UangmasukController::class, 'index'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahuangmasukpiutang', [UangmasukController::class, 'tambahuangmasukpiutang'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahretail', [UangmasukController::class, 'tambahretail'])->middleware('userAkses:manager');
    Route::get('deleteuangmasukpiutang/{id}', [UangmasukController::class, 'deleteuangmasukpiutang']);
    Route::get('deleteuangmasukretail/{id}', [UangmasukController::class, 'deleteuangmasukretail']);
    Route::post('user/manager/edituangmasukpiutang/{id}', [UangmasukController::class, 'edituangmasukpiutang'])->middleware('userAkses:manager');
    Route::post('user/manager/edituangmasukretail/{id}', [UangmasukController::class, 'edituangmasukretail'])->middleware('userAkses:manager');
    //piutang
    Route::get('user/manager/piutang', [PiutangController::class, 'index'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahpiutang', [PiutangController::class, 'tambahpiutang'])->middleware('userAkses:manager');
    Route::post('user/manager/editPiutang/{id}', [PiutangController::class, 'editpiutang'])->middleware(('userAkses:manager'));
    Route::get('piutanglunas/{id}', [PiutangController::class, 'piutanglunas'])->middleware('userAkses:manager');
    //Rekapitulasi Pemasaran
    Route::get('user/manager/rekappemasaran', [Rekappemasaran::class, 'index'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahNota', [Rekappemasaran::class, 'tambahNota'])->middleware('userAkses:manager');
    Route::post('user/manager/editNota/{id}', [Rekappemasaran::class, 'editNota'])->middleware('userAkses:manager');
    Route::get('deletenota/{id}', [Rekappemasaran::class, 'deleteNota'])->middleware('userAkses:manager');
    //Resume Produksi
    Route::get('user/manager/resumeproduksi', [ResumeProduksiController::class, 'index'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahResume', [ResumeProduksiController::class, 'tambahResume'])->middleware('userAkses:manager');
    Route::get('/getInOutData', [ResumeProduksiController::class, 'getInOutData']);

    //wip
    Route::get('/user/manager/wip', [wipController::class, 'index'])->middleware('userAkses:manager');


    //semua terkait owner taruh sini
    Route::get('user/owner/dasboard', [OwnerController::class, 'dashboard'])->middleware('userAkses:owner');
    //hutangbahanbaku
    Route::get('user/owner/hutangbahanbaku', [HutangbahanbakuController::class, 'indexowner'])->middleware('userAkses:owner');
    Route::get('user/owner/cetakhutangbahanbaku', [HutangbahanbakuController::class, 'cetakhutangbahanbaku'])->middleware('userAkses:owner');
    //uang masuk
    Route::get('user/owner/uangmasuk', [UangmasukController::class, 'filter'])->middleware('userAkses:owner')->name('owner.index');
    Route::get('user/owner/filter', [UangmasukController::class, 'filter'])->middleware('userAkses:owner');
    Route::get('user/owner/cetak-uang-masuk-filter/{startDate}/{endDate}', [UangmasukController::class, 'cetakuangmasuk'])->middleware('userAkses:owner');
    //piutang
    Route::get('/user/owner/piutang', [PiutangController::class, 'indexowner'])->middleware('userAkses:owner');
    Route::get('user/owner/cetakpiutang', [PiutangController::class, 'cetakpiutang'])->middleware('userAkses:owner');
    //rekapitulasi Penjualan
    Route::get('user/owner/rekapitulasipenjualan', [Rekappemasaran::class, 'indexowner'])->middleware('userAkses:owner');

});
