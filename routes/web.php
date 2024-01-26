<?php

use App\Http\Controllers\BahanbakuController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\UserController;
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
    Route::get('user/manager/harga_produk', [ProdukController::class, 'index'])->middleware('userAkses:manager');
    // Route::put('/editproduk/{id}', [ProdukController::class, 'edit']);
    Route::post('user/manager/tambahproduk', [ProdukController::class, 'tambah'])->middleware('userAkses:manager');
    Route::get('user/manager/harga_bahan_baku', [BahanbakuController::class, 'index'])->middleware('userAkses:manager');

    //semua terkait owner taruh sini
    Route::get('user/owner/dasboard', [OwnerController::class, 'dashboard'])->middleware('userAkses:owner');

});
