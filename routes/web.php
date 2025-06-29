<?php

use App\Http\Controllers\BayiController;
use App\Http\Controllers\DasawismaController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GiziController;
use App\Http\Controllers\LHBPController;
use App\Http\Controllers\SIPController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\BayiBalitaController;
use App\Models\Penduduk;
use App\Http\Controllers\PendudukController;
use App\Models\User;
use App\Http\Controllers\RWController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SIP6Controller;
use App\Http\Controllers\SIP7Controller;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'getLogin'])->name('getLogin');
Route::post('/login', [LoginController::class, 'postLogin'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'data.filter']], function () {
    Route::get('/dashboard', [DashboardController::class, 'getDashboard'])->name('dashboard');
}); 

// Admin only routes
Route::group(['middleware' => ['auth', 'role.access:admin_desa', 'data.filter']], function () {
    // Master data routes
    Route::get('/gizi', [GiziController::class, 'index'])->name('gizi.index');
    Route::get('/gizi/create', [GiziController::class, 'create'])->name('gizi.create');
    Route::post('/gizi/store', [GiziController::class, 'store'])->name('gizi.store');
    Route::get('/gizi/edit/{id}', [GiziController::class, 'edit'])->name('gizi.edit');
    Route::post('/gizi/update/{id}', [GiziController::class, 'update'])->name('gizi.update');
    Route::post('/gizi/delete/{id}', [GiziController::class, 'delete'])->name('gizi.delete');

    Route::get('/anak/bayi', [BayiBalitaController::class, 'showBayi'])->name('bayi.show');
    Route::get('/anak/balita', [BayiBalitaController::class, 'showBalita'])->name('balita.show');
    Route::post('/anak/store', [BayiBalitaController::class, 'store'])->name('anak.store');
    Route::put('/anak/update/{nik}', [BayiBalitaController::class, 'update'])->name('anak.update');
    Route::delete('/anak/delete/{nik}', [BayiBalitaController::class, 'destroy'])->name('anak.delete');
    Route::put('/bayi/update/{nik}', [BayiBalitaController::class, 'update'])->name('bayi.update');
    Route::delete('/bayi/delete/{nik}', [BayiBalitaController::class, 'destroy'])->name('bayi.delete');
    
    // Debug route
    Route::get('/debug/anak/{nik}', function($nik) {
        return 'NIK received: ' . $nik;
    });

    Route::get('/posyandu', [PosyanduController::class, 'index'])->name('posyandu.index');
    Route::post('/posyandu/store', [PosyanduController::class, 'store'])->name('posyandu.store');
    Route::post('/posyandu/update', [PosyanduController::class, 'update'])->name('posyandu.update');
    Route::post('/posyandu/delete', [PosyanduController::class, 'delete'])->name('posyandu.delete');

    Route::get('/penduduk' , [PendudukController::class, 'index'])->name('penduduk.index');
    Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
    Route::post('/penduduk/store', [PendudukController::class, 'store'])->name('penduduk.store');
    Route::get('/penduduk/edit/{id}', [PendudukController::class, 'edit'])->name('penduduk.edit');
    Route::post('/penduduk/update/{id}', [PendudukController::class, 'update'])->name('penduduk.update');
    Route::post('/penduduk/delete/{id}', [PendudukController::class, 'delete'])->name('penduduk.delete');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/delete', [UserController::class, 'delete'])->name('user.delete');

    Route::get('rw/', [RWController::class, 'index'])->name('rw.index');
    Route::post('rw/store', [RWController::class, 'store'])->name('rw.store');
    Route::post('rw/update', [RWController::class, 'update'])->name('rw.update');
    Route::post('rw/delete', [RWController::class, 'delete'])->name('rw.delete');

    Route::get('/dasawisma', [DasawismaController::class, 'index'])->name('dasawisma.index');
    Route::post('/dasawisma/store', [DasawismaController::class, 'storeMasterdata'])->name('dasawisma.store');
    Route::post('/dasawisma/update', [DasawismaController::class, 'updateMasterdata'])->name('dasawisma.update');
    Route::post('/dasawisma/delete', [DasawismaController::class, 'deleteMasterdata'])->name('dasawisma.delete');
});

// Admin and Kader RW routes (Dasawisma)
Route::group(['middleware' => ['auth', 'role.access:admin_desa,admin_rw', 'data.filter']], function () {
    Route::get('rekap/dasawisma', [DasawismaController::class, 'indexRekap'])->name('dasawisma.rekap');
    Route::get('rekap/dasawisma/create', [DasawismaController::class, 'createRekap'])->name('dasawisma.rekap.create');
    Route::post('rekap/dasawisma/store', [DasawismaController::class, 'storeRekap'])->name('dasawisma.rekap.store');
    Route::get('rekap/dasawisma/edit/{id}', [DasawismaController::class, 'editRekap'])->name('dasawisma.rekap.edit');
    Route::post('rekap/dasawisma/update/{id}', [DasawismaController::class, 'updateRekap'])->name('dasawisma.rekap.update');
    Route::post('rekap/dasawisma/delete/{id}', [DasawismaController::class, 'deleteRekap'])->name('dasawisma.rekap.delete');
});

// Admin and Kader Posyandu routes (SIP)
Route::group(['middleware' => ['auth', 'role.access:admin_desa,admin_kader', 'data.filter']], function () {
    Route::get('/sip/{posyandu_id}', [SIPController::class, 'index'])->name('sip.index');
    Route::get('/sip/create', [SIPController::class, 'create'])->name('sip.create');
    Route::post('/sip/store', [SIPController::class, 'store'])->name('sip.store');
    Route::get('/sip/edit/{id}', [SIPController::class, 'edit'])->name('sip.edit');
    Route::post('/sip/update/{id}', [SIPController::class, 'update'])->name('sip.update');
    Route::post('/sip/delete/{id}', [SIPController::class, 'delete'])->name('sip.delete');

    // SIP1 Routes
    Route::post('/sip1/store', [SIPController::class, 'storeSip1'])->name('sip1.store');
    Route::put('/sip1/update/{id}', [SIPController::class, 'updateSip1'])->name('sip1.update');
    Route::delete('/sip1/delete/{id}', [SIPController::class, 'deleteSip1'])->name('sip1.delete');

    // SIP2 Routes (Bayi)
    Route::post('/sip2/store', [SIPController::class, 'storeSip2'])->name('sip2.store');
    Route::put('/sip2/update/{id}', [SIPController::class, 'updateSip2'])->name('sip2.update');
    Route::delete('/sip2/delete/{id}', [SIPController::class, 'deleteSip2'])->name('sip2.delete');

    // SIP3 Routes (Balita)
    Route::post('/sip3/store', [SIPController::class, 'storeSip3'])->name('sip3.store');
    Route::put('/sip3/update/{id}', [SIPController::class, 'updateSip3'])->name('sip3.update');
    Route::delete('/sip3/delete/{id}', [SIPController::class, 'deleteSip3'])->name('sip3.delete');

    // SIP4 Routes (WUS PUS)
    Route::post('/sip4/store', [SIPController::class, 'storeSip4'])->name('sip4.store');
    Route::put('/sip4/update/{id}', [SIPController::class, 'updateSip4'])->name('sip4.update');
    Route::delete('/sip4/delete/{id}', [SIPController::class, 'deleteSip4'])->name('sip4.delete');

    // SIP5 Routes (Ibu Hamil)
    Route::post('/sip5/store', [SIPController::class, 'storeSip5'])->name('sip5.store');
    Route::put('/sip5/update/{id}', [SIPController::class, 'updateSip5'])->name('sip5.update');
    Route::delete('/sip5/delete/{id}', [SIPController::class, 'deleteSip5'])->name('sip5.delete');

    Route::get('/sip6', [SIP6Controller::class, 'index'])->name('sip6.index');
    Route::post('/sip6/store', [SIP6Controller::class, 'store'])->name('sip6.store');
    Route::put('/sip6/update/{id}', [SIP6Controller::class, 'update'])->name('sip6.update');
    Route::delete('/sip6/delete/{id}', [SIP6Controller::class, 'delete'])->name('sip6.delete');

    Route::get('/sip7', [SIP7Controller::class, 'index'])->name('sip7.index');
    Route::post('/sip7/store', [SIP7Controller::class, 'store'])->name('sip7.store');
    Route::put('/sip7/update/{id}', [SIP7Controller::class, 'update'])->name('sip7.update');
    Route::delete('/sip7/delete/{id}', [SIP7Controller::class, 'delete'])->name('sip7.delete');

    // Dokumentasi Routes
    Route::post('/dokumentasi/store', [SIPController::class, 'storeDokumentasi'])->name('dokumentasi.store');
    Route::put('/dokumentasi/update/{id}', [SIPController::class, 'updateDokumentasi'])->name('dokumentasi.update');
    Route::delete('/dokumentasi/delete/{id}', [SIPController::class, 'deleteDokumentasi'])->name('dokumentasi.delete');
});

// Dasawisma routes - Admin and Kader RW
Route::group(['middleware' => ['auth', 'role.access:admin_desa,admin_rw', 'data.filter']], function () {
    Route::get('/dasawisma', [DasawismaController::class, 'index'])->name('dasawisma.index');
    Route::post('/dasawisma/store', [DasawismaController::class, 'storeMasterdata'])->name('dasawisma.store');
    Route::post('/dasawisma/update', [DasawismaController::class, 'updateMasterdata'])->name('dasawisma.update');
    Route::post('/dasawisma/delete', [DasawismaController::class, 'deleteMasterdata'])->name('dasawisma.delete');

    Route::get('rekap/dasawisma', [DasawismaController::class, 'indexRekap'])->name('dasawisma.rekap');
    Route::get('rekap/dasawisma/create', [DasawismaController::class, 'createRekap'])->name('dasawisma.rekap.create');
    Route::post('rekap/dasawisma/store', [DasawismaController::class, 'storeRekap'])->name('dasawisma.rekap.store');
    Route::get('rekap/dasawisma/edit/{id}', [DasawismaController::class, 'editRekap'])->name('dasawisma.rekap.edit');
    Route::post('rekap/dasawisma/update/{id}', [DasawismaController::class, 'updateRekap'])->name('dasawisma.rekap.update');
    Route::post('rekap/dasawisma/delete/{id}', [DasawismaController::class, 'deleteRekap'])->name('dasawisma.rekap.delete');
});

// Master data routes - Admin only
Route::group(['middleware' => ['auth', 'role.access:admin_desa', 'data.filter']], function () {
    Route::get('/gizi', [GiziController::class, 'index'])->name('gizi.index');
    Route::get('/gizi/create', [GiziController::class, 'create'])->name('gizi.create');
    Route::post('/gizi/store', [GiziController::class, 'store'])->name('gizi.store');
    Route::get('/gizi/edit/{id}', [GiziController::class, 'edit'])->name('gizi.edit');
    Route::post('/gizi/update/{id}', [GiziController::class, 'update'])->name('gizi.update');
    Route::post('/gizi/delete/{id}', [GiziController::class, 'delete'])->name('gizi.delete');

    Route::get('/anak/bayi', [BayiBalitaController::class, 'showBayi'])->name('bayi.show');
    Route::get('/anak/balita', [BayiBalitaController::class, 'showBalita'])->name('balita.show');
    Route::post('/anak/store', [BayiBalitaController::class, 'store'])->name('anak.store');
    Route::put('/anak/update/{nik}', [BayiBalitaController::class, 'update'])->name('anak.update');
    Route::delete('/anak/delete/{nik}', [BayiBalitaController::class, 'destroy'])->name('anak.delete');
    Route::put('/bayi/update/{nik}', [BayiBalitaController::class, 'update'])->name('bayi.update');
    Route::delete('/bayi/delete/{nik}', [BayiBalitaController::class, 'destroy'])->name('bayi.delete');
    
    // Debug route
    Route::get('/debug/anak/{nik}', function($nik) {
        return 'NIK received: ' . $nik;
    });

    Route::get('/posyandu', [PosyanduController::class, 'index'])->name('posyandu.index');
    Route::post('/posyandu/store', [PosyanduController::class, 'store'])->name('posyandu.store');
    Route::post('/posyandu/update', [PosyanduController::class, 'update'])->name('posyandu.update');
    Route::post('/posyandu/delete', [PosyanduController::class, 'delete'])->name('posyandu.delete');

    Route::get('/penduduk' , [PendudukController::class, 'index'])->name('penduduk.index');
    Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
    Route::post('/penduduk/store', [PendudukController::class, 'store'])->name('penduduk.store');
    Route::get('/penduduk/edit/{id}', [PendudukController::class, 'edit'])->name('penduduk.edit');
    Route::post('/penduduk/update/{id}', [PendudukController::class, 'update'])->name('penduduk.update');
    Route::post('/penduduk/delete/{id}', [PendudukController::class, 'delete'])->name('penduduk.delete');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/delete', [UserController::class, 'delete'])->name('user.delete');

    Route::get('rw/', [RWController::class, 'index'])->name('rw.index');
    Route::post('rw/store', [RWController::class, 'store'])->name('rw.store');
    Route::post('rw/update', [RWController::class, 'update'])->name('rw.update');
    Route::post('rw/delete', [RWController::class, 'delete'])->name('rw.delete');

});


