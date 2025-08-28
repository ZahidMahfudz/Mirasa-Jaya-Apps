<?php

use App\Models\R_D;
use App\Models\stokbb;
use App\Models\piutang;
use App\Models\hutangbahanbaku;
use Dflydev\DotAccessData\Data;
use App\Http\Controllers\Controller;
use App\Models\pengeluaranBebanUsaha;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasController;
use App\Http\Controllers\Rekappemasaran;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokbbController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PiutangController;
use App\Http\Controllers\BahanbakuController;
use App\Http\Controllers\BungaBankController;
use App\Http\Controllers\pemasaranController;
use App\Http\Controllers\UangmasukController;
use App\Http\Controllers\AssetMesinController;
use App\Http\Controllers\DataKaryawanController;
use App\Http\Controllers\ModalDisetorController;
use App\Http\Controllers\ResumeProduksiController;
use App\Http\Controllers\HutangbahanbakuController;
use App\Http\Controllers\PengeluaranBebanUsahaController;
use App\Http\Controllers\profitController;

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
    Route::get('/user/pemasaran', [UserController::class, 'pemasaran'])->middleware('userAkses:pemasaran');
    Route::get('/logout', [SesiController::class, 'logout']);

    //semua terkait admin taruh sini
    //Kelola Akun
    Route::get('/user/admin/KelolaAkun', [AdminController::class, 'showKelolaAkun'])->middleware('userAkses:admin');
    Route::post('/user/admin/tambahAkun', [AdminController::class, 'tambahAkun'])->middleware('userAkses:admin');
    Route::post('/user/admin/editAkun/{id}', [AdminController::class, 'editAkun'])->middleware('userAkses:admin');
    Route::get('/deleteAkun/{id}', [AdminController::class, 'deleteAkun'])->middleware('userAkses:admin');
    //Ganti Pembukuan
    Route::get('/user/admin/GantiPembukuan', [AdminController::class, 'showGantiPembukuan'])->middleware('userAkses:admin');
    Route::post('/GantiPembukuan', [AdminController::class, 'GantiPembukuan'])->middleware('userAkses:admin');
    //Kelola Data Karyawan
    Route::get('/user/admin/datakaryawan',[DataKaryawanController::class, 'showDataKaryawan'])->middleware('userAkses:admin');
    Route::post('/addKaryawan', [DataKaryawanController::class, 'TambahKaryawan'])->middleware('userAkses:admin');
    Route::post('/editKaryawan/{id}', [DataKaryawanController::class, 'editKaryawan'])->middleware('userAkses:admin');
    Route::get('/deleteKaryawan/{id}', [DataKaryawanController::class, 'deleteKaryawan'])->middleware('userAkses:admin');
    Route::get('/user/admin/datakaryawanborongan', [DataKaryawanController::class, 'showDataKaryawanBorongan'])->middleware('userAkses:admin');
    Route::post('/addKaryawanBorongan', [DataKaryawanController::class, 'TambahKaryawanBorongan'])->middleware('userAkses:admin');
    Route::get('/deleteKaryawanborongan/{id}', [DataKaryawanController::class, 'deleteKaryawanBorongan'])->middleware('userAkses:admin');
    Route::post('/editKaryawanBorongan/{id}', [DataKaryawanController::class, 'editKaryawanBorongan'])->middleware('userAkses:admin');
    //Gajian Karyawan Harian
    Route::get('/user/admin/gajiankaryawan/{tanggal}', [DataKaryawanController::class, 'showGajianKaryawan'])->middleware('userAkses:admin');
    Route::get('/GenerateGajian', [DataKaryawanController::class, 'GenerateGajian'])->middleware('userAkses:admin');
    Route::post('/editGajian/{id}', [DataKaryawanController::class, 'editGajian'])->middleware('userAkses:admin');
    Route::get('/cetakSlipGaji/{tanggal}', [DataKaryawanController::class, 'cetakSlipGaji'])->middleware('userAkses:admin');
    Route::post('/tambahGajian', [DataKaryawanController::class, 'tambahGajian'])->middleware('userAkses:admin');
    Route::get('//hapusGaji/{id}', [DataKaryawanController::class, 'deleteGajian'])->middleware('userAkses:admin');
    //Gaji Karyawan Borongan
    Route::get('/user/admin/gajiboronganspet/{tanggal}', [DataKaryawanController::class, 'showGajiBoronganSpet'])->middleware('userAkses:admin');
    Route::get('/GenerateGajianSpet', [DataKaryawanController::class, 'GenerateGajianSpet'])->middleware('userAkses:admin');
    Route::post('/editGajianBoronganSpet/{id}', [DataKaryawanController::class, 'editGajianSpet'])->middleware('userAkses:admin');
    Route::post('/tambahGajianBorongan', [DataKaryawanController::class, 'tambahGajianBorongan'])->middleware('userAkses:admin');
    Route::get('/hapusGajiSpet/{id}', [DataKaryawanController::class, 'deleteGajianSpet'])->middleware('userAkses:admin');
    Route::get('/cetakSlipGajiSpet/{tanggal}', [DataKaryawanController::class, 'cetakSlipGajiSpet'])->middleware('userAkses:admin');
    //Pengeluaran
    Route::get('/user/admin/pengeluaran/{tanggal}', [PengeluaranBebanUsahaController::class, 'showPengeluaran'])->middleware('userAkses:admin');
    Route::post('/tambahPengeluaran', [PengeluaranBebanUsahaController::class, 'tambahPengeluaran'])->middleware('userAkses:admin');
    Route::post('/editPengeluaran/{id}', [PengeluaranBebanUsahaController::class, 'editPengeluaran'])->middleware('userAkses:admin');
    Route::get('/hapusPengeluaran/{id}', [PengeluaranBebanUsahaController::class, 'deletePengeluaran'])->middleware('userAkses:admin');
    //nota
    Route::get('/user/admin/daftarNota', [Rekappemasaran::class, 'showDaftarNota'])->middleware('userAkses:admin');
    Route::post('/admin/TambahNotaHargaPabrik', [Rekappemasaran::class, 'tambahNotaHargaPabrik'])->middleware('userAkses:admin');
    Route::post('/admin/TambahNotaPemasaran', [Rekappemasaran::class, 'tambahNotaPemasaran'])->middleware('userAkses:admin');
    Route::get('/editNota/{id}', [Rekappemasaran::class, 'showEditNota'])->middleware('userAkses:admin');
    Route::post('/admin/EditItemNota/{id}', [Rekappemasaran::class, 'editItemNota'])->middleware('userAkses:admin');
    Route::get('/admin/HapusItemNota/{id}', [Rekappemasaran::class, 'deleteItemNota'])->middleware('userAkses:admin');
    Route::post('/editNotaRev/{id}', [Rekappemasaran::class, 'editNotaRev'])->middleware('userAkses:admin');
    Route::get('/admin/UbahStatusNota/{id}', [Rekappemasaran::class, 'ubahStatusNota'])->middleware('userAkses:admin');
    Route::get('/user/admin/daftarRetail', [Rekappemasaran::class, 'showDaftarRetail'])->middleware('userAkses:admin');
    Route::post('/user/admin/tambahretail', [Rekappemasaran::class, 'tambahretail'])->middleware('userAkses:admin');
    Route::get('/hapusRetail/{id}', [Rekappemasaran::class, 'hapusNota'])->middleware('userAkses:admin');
    Route::get('/hapusNota/{id}', [Rekappemasaran::class, 'hapusNota'])->middleware('userAkses:admin');
    //produk
    Route::get('user/admin/harga_produk', [ProdukController::class, 'index'])->middleware('userAkses:admin');
    Route::post('/editproduk/{id}', [ProdukController::class, 'edit'])->middleware('userAkses:admin');
    Route::post('user/admin/tambahproduk', [ProdukController::class, 'tambah'])->middleware('userAkses:admin');
    Route::get('/delete/{id}', [ProdukController::class, 'delete']);
    //bahan baku
    Route::get('user/admin/harga_bahan_baku', [BahanbakuController::class, 'index'])->middleware('userAkses:admin');
    Route::post('user/admin/tambahbahanbaku', [BahanbakuController::class, 'tambahbahanbaku'])->middleware('userAkses:admin');
    Route::post('user/admin/tambahbahanpenolong', [BahanbakuController::class, 'tambahbahanpenolong'])->middleware('userAkses:admin');
    Route::post('user/admin/tambahkardus', [BahanbakuController::class, 'tambahkardus'])->middleware('userAkses:admin');
    Route::post('user/admin/editbahanbaku/{id}', [BahanbakuController::class, 'editbahanbaku'])->middleware('userAkses:admin');
    Route::post('user/admin/editbahanpenolong/{id}', [BahanbakuController::class, 'editbahanbaku'])->middleware('userAkses:admin');
    Route::post('user/admin/editkardus/{id}', [BahanbakuController::class, 'editkardus'])->middleware('userAkses:admin');
    Route::get('/deletebahanbaku/{id}', [BahanbakuController::class, 'delete']);
    //resep wip
    Route::get('/user/admin/resepwip', [StokbbController::class, 'indexresep'])->middleware('userAkses:admin');
    Route::post('/resepstore', [StokbbController::class, 'resepstore'])->name('resepstore')->middleware('userAkses:admin');
    Route::post('/resepdestroy/{id}', [StokbbController::class, 'resepdestroy'])->name('resepdestroy')->middleware('userAkses:admin');
    Route::post('/resepupdate/{id}', [StokbbController::class, 'resepupdate'])->name('resepupdate')->middleware('userAkses:admin');
    Route::post('/bahan_resepstore', [StokbbController::class, 'bahan_resepstore'])->name('bahan_resepstore')->middleware('userAkses:admin');

    //semua terkait manager taruh sini
    //Dashboard utama
    Route::get('user/manager/dashboard', [ManagerController::class, 'index'])->middleware('userAkses:manager');
    Route::get('user/manager/dasboard/neraca', [ManagerController::class, 'dashboard'])->middleware('userAkses:manager');
    //hutang bahan baku
    Route::get('user/manager/hutang_bahan_baku', [HutangbahanbakuController::class, 'index'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahhutang', [HutangbahanbakuController::class, 'tambahhutangbahanbaku'])->middleware('userAkses:manager');
    Route::get('/lunasbahanbaku/{id}', [HutangbahanbakuController::class, 'lunas']);
    Route::get('/hapushutangbahanbaku/{id}', [HutangbahanbakuController::class, 'hapus']);
    Route::post('user/manager/edithutang/{id}', [HutangbahanbakuController::class, 'edit'])->middleware('userAkses:manager');
    //Uang Masuk
    Route::get('user/manager/uangmasuk/{startDate}/{endDate}', [UangmasukController::class, 'showUangMasuk'])->middleware('userAkses:manager');
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
    Route::get('piutanglunas/{id}', [Rekappemasaran::class, 'ubahStatusNota'])->middleware('userAkses:manager');
    Route::get('hapuspiutang/{id}', [PiutangController::class, 'hapuspiutang'])->middleware('userAkses:manager');
    //Rekapitulasi Pemasaran
    Route::get('/user/manager/rekapitulasipenjualan/{startDate}/{endDate}', [Rekappemasaran::class, 'indexRekapPemasaran'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahNota', [Rekappemasaran::class, 'tambahNota'])->middleware('userAkses:manager');
    Route::post('user/manager/editNota/{id}', [Rekappemasaran::class, 'editNota'])->middleware('userAkses:manager');
    Route::get('user/manager/deletenota/{id}', [Rekappemasaran::class, 'deleteNota'])->middleware('userAkses:manager');
    Route::get('user/manager/filterrekappemasaran', [Rekappemasaran::class, 'filter'])->middleware('userAkses:manager');
    //Pre order
    Route::get('user/manager/preorder', [ResumeProduksiController::class, 'showpreordermanager'])->middleware('userAkses:manager');
    Route::get('/prosesOrder/{id}', [ResumeProduksiController::class, 'prosesOrder'])->middleware('userAkses:manager');
    Route::get('/completeOrder/{id}', [ResumeProduksiController::class, 'completeOrder'])->middleware('userAkses:manager');
    //Drop Out
    Route::get('cariproduk', [ResumeProduksiController::class,'cariProduk'])->name('cariproduk')->middleware('userAkses:manager');
    Route::get('user/manager/dropOut', [ResumeProduksiController::class,'showDropOutManager'])->middleware('userAkses:manager');
    Route::post('user/manager/tambahDO', [ResumeProduksiController::class, 'tambahDropOut'])->middleware('userAkses:manager');
    Route::post('user/manager/editdropout/{id}', [ResumeProduksiController::class, 'editDropOut'])->middleware('userAkses:manager');
    Route::post('user/manager/addlistDO/{id}', [ResumeProduksiController::class, 'addListDO'])->middleware('userAkses:manager');
    Route::get('user/manager/hapusListDO/{id}', [ResumeProduksiController::class, 'hapusproduklistdo'])->middleware('userAkses:manager');
    Route::get('user/manager/cetakDropOut/{id}', [ResumeProduksiController::class, 'cetakDropOut'])->middleware('userAkses:manager');
    //Resume Produksi
    Route::get('user/manager/resumeproduksi', [ResumeProduksiController::class, 'index'])->middleware('userAkses:manager');
    Route::get('user/manager/tambahresumehariini', [ResumeProduksiController::class, 'generateResumerev'])->middleware('userAkses:manager');
    Route::post('/editresume/{id}', [ResumeProduksiController::class, 'editResumeRev'])->name('editresume')->middleware('userAkses:manager');
    //wip
    Route::put('/editwip/{id}', [StokbbController::class, 'editwip'])->name('editwip')->middleware('userAkses:manager');
    //stok bahan baku dan kardus
    Route::get('/user/manager/stokbb', [StokbbController::class, 'indexstok'])->middleware('userAkses:manager');
    Route::post('/editstokbb/{id}', [StokbbController::class, 'editstokbb'])->name('editstokbb')->middleware('userAkses:manager');
    Route::post('/editstokbp/{id}', [StokbbController::class, 'editstokbp'])->name('editstokbp')->middleware('userAkses:manager');
    Route::get('user/manager/generatestokbahanbaku', [StokbbController::class, 'generatestok'])->middleware('userAkses:manager');
    //stok kardus
    Route::get('/user/manager/kardus', [StokbbController::class, 'indexkardus'])->middleware('userAkses:manager');
    Route::post('/editstokkardus/{id}', [StokbbController::class, 'editStokKardus'])->name('editstokkardus')->middleware('userAkses:manager');
    Route::post('/tambahKardus/{id}', [StokbbController::class, 'tambahKardus'])->name('tambahKardus')->middleware('userAkses:manager');
    Route::get('user/manager/generatestokkardus', [StokbbController::class, 'generateStokKardus'])->middleware('userAkses:manager');
    //pengeluaran beban usaha
    Route::get('/user/manager/pengeluaran/{date}', [PengeluaranBebanUsahaController::class, 'showPengeluaranManager'])->middleware('userAkses:manager');
    Route::post('/manager/tambahPengeluaran', [PengeluaranBebanUsahaController::class, 'tambahPengeluaran'])->middleware('userAkses:manager');
    //Beban Usaha
    Route::get('/user/manager/bebanUsaha/{startOfWeek}/{endOfWeek}', [PengeluaranBebanUsahaController::class, 'ShowBebanUsaha'])->middleware('userAkses:manager');
    //Gaji Karyawan
    Route::get('user/manager/gajiKaryawan/{date}', [DataKaryawanController::class, 'showGajiKaryawanManager'])->middleware('userAkses:manager');
    
    
//     //Bunga Bank & Pajak
//     Route::get('user/manager/BungaBank', [BungaBankController::class, 'index'])->middleware('userAkses:manager');
//     Route::post('user/manager/BungaBank', [BungaBankController::class, 'index'])->middleware('userAkses:manager');
//     Route::post('BungaBank/store', [BungaBankController::class, 'store'])->middleware('userAkses:manager');
//     Route::get('BungaBank/edit/{id}', [BungaBankController::class, 'edit'])->middleware('userAkses:manager');
//     Route::post('BungaBank/update/{id}', [BungaBankController::class, 'update'])->middleware('userAkses:manager');
//     Route::get('BungaBank/delete/{id}', [BungaBankController::class, 'destroy'])->middleware('userAkses:manager');
    
//     //Asset Mesin & Peralatan Produksi
//     Route::get('user/manager/AssetMesin', [AssetMesinController::class, 'index'])->middleware('userAkses:manager');
//     Route::post('AssetMesin/store', [AssetMesinController::class, 'store'])->middleware('userAkses:manager');
//     Route::get('AssetMesin/edit/{id}', [AssetMesinController::class, 'edit'])->middleware('userAkses:manager');
//     Route::post('AssetMesin/update/{id}', [AssetMesinController::class, 'update'])->middleware('userAkses:manager');
//     Route::get('AssetMesin/delete/{id}', [AssetMesinController::class, 'destroy'])->middleware('userAkses:manager');

    
    //Kas --Belum FIX--
    Route::get('user/manager/Kas', [KasController::class, 'KasIndex'])->name('kas');
    Route::post('/Kas/store', [KasController::class, 'storeKas'])->name('store-kas');
    Route::get('/Kas/edit/{id}',[KasController::class, 'editKas'])->name('edit-kas');
    Route::post('/Kas/update/{id}',[KasController::class, 'updateKas'])->name('update-kas');
    Route::get('/Kas/delete/{id}',[KasController::class, 'destroyKas'])->name('delete-kas');

    //Kas Bank Permata
    Route::get('user/manager/Bank-Permata', [KasController::class, 'KasBankPermataindex'])->name('bank-permata');
    Route::post('Bank-Permata/store', [KasController::class, 'storeKasBankPermata'])->name('store-bank-permata');
    Route::get('Bank-Permata/edit/{id}', [KasController::class, 'editBankPermata'])->name('edit-bank-permata');
    Route::post('Bank-Permata/update/{id}', [KasController::class, 'updateBankPermata'])->name('update-bank-permata');
    Route::get('Bank-Permata/delete/{id}', [KasController::class, 'destroyBankPermata'])->name('delete-bank-permata');

//     //Neraca --Belum FIX--
//     Route::get('/Neraca', [ManagerController::class, 'showNeraca'])->name('neraca');
//     Route::get('user/manager/dashboard/neraca-saldo', [ManagerController::class, 'showNeracaSaldo'])->middleware('userAkses:manager');
//     Route::get('user/manager/dashboard/laporan-rugi-laba', [ManagerController::class, 'showLaporanRugiLaba'])->middleware('userAkses:manager');
//     Route::get('user/manager/dashboard/pengeluaran', [ManagerController::class, 'showPengeluaran'])->middleware('userAkses:manager');
//     Route::get('user/dashboard/profile', [ManagerController::class, 'index'])->name('profile');

//     //Modal Disetor
//    Route::get('/user/manager/ModalDisetor', [ModalDisetorController::class, 'index'])->middleware('userAkses:manager');
//    Route::post('ModalDisetor/store', [ModalDisetorController::class, 'storeModalDisetor'])->middleware('userAkses:manager');
//    Route::post('ModalDisetor/update/{id}', [ModalDisetorController::class, 'updateModalDisetor'])->middleware('userAkses:manager');
//    Route::get('ModalDisetor/delete/{id}', [ModalDisetorController::class, 'destroyModalDisetor'])->middleware('userAkses:manager');
//    Route::post('ModalBankPermata/store', [ModalDisetorController::class, 'storeModalBankPermata'])->middleware('userAkses:manager');
//    Route::post('ModalBankPermata/update/{id}', [ModalDisetorController::class, 'updateModalBankPermata'])->middleware('userAkses:manager');
//    Route::get('ModalBankPermata/delete/{id}', [ModalDisetorController::class, 'destroyModalBankPermata'])->middleware('userAkses:manager');




    //semua terkait owner taruh sini
    Route::get('/user/owner/dasboard/{tanggal}', [profitController::class, 'showProfit'])->middleware('userAkses:owner');
    Route::get('/user/owner/filterProfit', [profitController::class, 'filterProfit'])->middleware('userAkses:owner');
    Route::get('/user/owner/cetak-profit-mingguan/{tanggal}', [ManagerController::class, 'cetakprofitmingguan'])->middleware('userAkses:owner');
    //Neraca
    Route::get('/user/owner/Neraca', [ManagerController::class, 'ShowNeracaOwner'])->middleware('userAkses:owner');
    Route::post('/filterNeraca', [ManagerController::class, 'ShowNeracaOwner'])->middleware('userAkses:owner');
    Route::get('/cetak-Neraca/{tanggal}', [ManagerController::class, 'cetakNeraca'])->middleware('userAkses:owner');
    //hutangbahanbaku
    Route::get('user/owner/hutangbahanbaku', [HutangbahanbakuController::class, 'indexowner'])->middleware('userAkses:owner');
    Route::get('user/owner/cetakhutangbahanbaku', [HutangbahanbakuController::class, 'cetakhutangbahanbaku'])->middleware('userAkses:owner');
    //uang masuk
    Route::get('/user/owner/uangmasuk/{startDate}/{endDate}', [UangmasukController::class, 'showUangMasuk'])->middleware('userAkses:owner')->name('owner.index');
    Route::get('/user/owner/filteruangmasuk', [UangmasukController::class, 'filteruangmasuk'])->middleware('userAkses:owner');
    Route::get('/user/owner/cetak-uang-masuk/{startDate}/{endDate}', [UangmasukController::class, 'showUangMasuk'])->middleware('userAkses:owner');
    //piutang
    Route::get('/user/owner/piutang', [PiutangController::class, 'index'])->middleware('userAkses:owner');
    Route::get('user/owner/cetakpiutang', [PiutangController::class, 'index'])->middleware('userAkses:owner');
    //rekapitulasi Penjualan
    Route::get('/user/owner/rekapitulasipenjualan/{startDate}/{endDate}', [Rekappemasaran::class, 'indexRekapPemasaran'])->middleware('userAkses:owner');
    Route::get('/user/owner/filterRekapPemasaran', [Rekappemasaran::class, 'filterpemasaranowner'])->middleware('userAkses:owner');
    Route::get('/user/owner/cetak-rekap-pemasaran/{startDate}/{endDate}', [Rekappemasaran::class, 'indexRekapPemasaran'])->middleware('userAkses:owner');
    //laporan produksi
    Route::get('/user/owner/laporanproduksi', [ResumeProduksiController::class, 'indexlaporanproduksi'])->middleware('userAkses:owner');
    Route::post('user/owner/filterlaporanproduksi', [ResumeProduksiController::class, 'filterlaporanproduksi'])->middleware('userAkses:owner');
    Route::get('user/owner/cetak-laporan-produksi/{startDate}/{endDate}', [ResumeProduksiController::class, 'cetaklaporanproduksi'])->middleware('userAkses:owner');
    //stok roti jadi
    Route::get('/user/owner/stokrotijadi', [ResumeProduksiController::class, 'indexstokrotijadi'])->middleware('userAkses:owner');
    Route::get('user/owner/cetak_stok_roti_jadi/{endDate}', [ResumeProduksiController::class, 'cetakStokRotiJadi'])->middleware('userAkses:owner');
    Route::post('user/owner/filterstokrotijadi', [ResumeProduksiController::class, 'filterStokRotiJadi'])->middleware('userAkses:owner');
    //stok kardus
    Route::get('/user/owner/stokkardus',[StokbbController::class, 'indexownerkardus'])->middleware('userAkses:owner');
    Route::post('/user/owner/filterstokkardus',[StokbbController::class, 'filterstokkardus'])->middleware('userAkses:owner');
    Route::get('user/owner/cetak-stok-kardus-filter/{startDate}/{endDate}', [StokbbController::class, 'cetakstokkardus'])->middleware('userAkses:owner');
    //stok bahan baku, bahan penolong, dan wip
    Route::get('/user/owner/stokbb', [StokbbController::class, 'indexstokowner'])->middleware('userAkses:owner');
    Route::get('/user/owner/cetak-stok-filter/{startDate}', [StokbbController::class, 'cetakstok'])->middleware('userAkses:owner');
    Route::post('/user/owner/filterstokbb', [StokbbController::class, 'filterowner'])->middleware('userAkses:owner');
    //Kas
    Route::get('/user/owner/Kas', [KasController::class, 'indexOwner'])->middleware('userAkses:owner');
    Route::post('/filterkas', [KasController::class, 'indexOwner'])->middleware('userAkses:owner');
    Route::get('/cetak-kas/{tanggalAkhir}', [KasController::class, 'cetak'])->middleware('userAkses:owner');
    //Aset Mesin
    Route::get('/user/owner/AsetMesin', [AssetMesinController::class, 'indexOwner'])->middleware('userAkses:owner');
    //Modal Disetor
    Route::get('/user/owner/ModalDisetor', [ModalDisetorController::class, 'indexOwner'])->middleware('userAkses:owner');
    Route::get('/cetak-Modal', [ModalDisetorController::class, 'cetak'])->middleware('userAkses:owner');
    //Beban Usaha
    Route::get('/user/owner/bebanUsaha/{startOfWeek}/{endOfWeek}', [PengeluaranBebanUsahaController::class, 'ShowBebanUsaha'])->middleware('userAkses:owner');
    Route::get('/user/owner/filterbebanusaha', [PengeluaranBebanUsahaController::class, 'filterBebanUsaha'])->middleware('userAkses:owner');
    Route::get('/user/owner/cetak-beban-usaha/{startOfWeek}/{endOfWeek}', [PengeluaranBebanUsahaController::class, 'ShowBebanUsaha'])->middleware('userAkses:owner');

    


    //semua terkait pemasaran taruh sini
    Route::get('/user/pemasaran/dasboard', [pemasaranController::class, 'index'])->middleware('userAkses:pemasaran');
    //preOrder
    Route::get('/user/pemasaran/preorder/{name}', [pemasaranController::class, 'preorder'])->middleware('userAkses:pemasaran');
    Route::post('/user/pemasaran/preorder/addorder', [pemasaranController::class, 'SimpanPreOrder'])->middleware('userAkses:pemasaran');
});
