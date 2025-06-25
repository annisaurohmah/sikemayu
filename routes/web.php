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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/login', [LoginController::class, 'getLogin'])->name('getLogin');
Route::post('/login', [LoginController::class, 'postLogin'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'getDashboard'])->name('dashboard');
}); 

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin', [DashboardController::class, 'getAdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [DashboardController::class, 'getUsers'])->name('admin.users');
    Route::post('/admin/users/create', [DashboardController::class, 'createUser'])->name('admin.users.create');
    Route::post('/admin/users/update/{id}', [DashboardController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/admin/users/delete/{id}', [DashboardController::class, 'deleteUser'])->name('admin.users.delete');

    Route::get('/sip/{posyandu_id}', [SIPController::class, 'index'])->name('sip.index');
    Route::get('/sip/create', [SIPController::class, 'create'])->name('sip.create');
    Route::post('/sip/store', [SIPController::class, 'store'])->name('sip.store');
    Route::get('/sip/edit/{id}', [SIPController::class, 'edit'])->name('sip.edit');
    Route::post('/sip/update/{id}', [SIPController::class, 'update'])->name('sip.update');
    Route::post('/sip/delete/{id}', [SIPController::class, 'delete'])->name('sip.delete');

    Route::get('/gizi', [GiziController::class, 'index'])->name('gizi.index');
    Route::get('/gizi/create', [GiziController::class, 'create'])->name('gizi.create');
    Route::post('/gizi/store', [GiziController::    class, 'store'])->name('gizi.store');
    Route::get('/gizi/edit/{id}', [GiziController::class, 'edit'])->name('gizi.edit');
    Route::post('/gizi/update/{id}', [GiziController::class, 'update'])->name('gizi.update');
    Route::post('/gizi/delete/{id}', [GiziController::class, 'delete'])->name('gizi.delete');

    Route::get('/dasawisma', [DasawismaController::class, 'index'])->name('dasawisma.index');
    Route::get('/dasawisma/create', [DasawismaController::class, 'create'])->name('dasawisma.create');
    Route::post('/dasawisma/store', [DasawismaController::class, 'store'])->name('dasawisma.store');
    Route::get('/dasawisma/edit/{id}', [DasawismaController::class, 'edit'])->name('dasawisma.edit');
    Route::post('/dasawisma/update/{id}', [DasawismaController::class, 'update'])->name('dasawisma.update');
    Route::post('/dasawisma/delete/{id}', [DasawismaController::class, 'delete'])->name('dasawisma.delete');
   
    Route::get('/anak/bayi', [BayiBalitaController::class, 'showBayi'])->name('bayi.show');
    Route::get('/anak/balita', [BayiBalitaController::class, 'showBalita'])->name('balita.show');
    Route::get('/anak/create', [BayiBalitaController::class, 'create'])->name('bayi.create');
    Route::post('/anak/store', [BayiBalitaController::class, 'store'])->name('bayi.store');
    Route::get('/anak/edit/{id}', [BayiBalitaController::class, 'edit'])->name('bayi.edit');
    Route::post('/anak/update/{id}', [BayiBalitaController::class, 'update'])->name('bayi.update');
    Route::post('/anak/delete/{id}', [BayiBalitaController::class, 'delete'])->name('bayi.delete');

    Route::get('/posyandu', [PosyanduController::class, 'index'])->name('posyandu.index');
    Route::get('/posyandu/create', [PosyanduController::class, 'create'])->name('posyandu.create');
    Route::post('/posyandu/store', [PosyanduController::class, 'store'])->name('posyandu.store');
    Route::get('/posyandu/edit/{id}', [PosyanduController::class, 'edit'])->name('posyandu.edit');
    Route::post('/posyandu/update/{id}', [PosyanduController::class, 'update'])->name('posyandu.update');
    Route::post('/posyandu/delete/{id}', [PosyanduController::class, 'delete'])->name('posyandu.delete');

    Route::get('/penduduk' , [PendudukController::class, 'index'])->name('penduduk.index');
    Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
    Route::post('/penduduk/store', [PendudukController::class, 'store'])->name('penduduk.store');
    Route::get('/penduduk/edit/{id}', [PendudukController::class, 'edit'])->name('penduduk.edit');
    Route::post('/penduduk/update/{id}', [PendudukController::class, 'update'])->name('penduduk.update');
    Route::post('/penduduk/delete/{id}', [PendudukController::class, 'delete'])->name('penduduk.delete');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');

    Route::get('rekap/dasawisma', [DasawismaController::class, 'rekap'])->name('dasawisma.rekap');
    Route::get('rekap/dasawisma/create', [DasawismaController::class, 'createRekap'])->name('dasawisma.rekap.create');
    Route::post('rekap/dasawisma/store', [DasawismaController::class, 'storeRekap'])->name('dasawisma.rekap.store');
    Route::get('rekap/dasawisma/edit/{id}', [DasawismaController::class, 'editRekap'])->name('dasawisma.rekap.edit');
    Route::post('rekap/dasawisma/update/{id}', [DasawismaController::class, 'updateRekap'])->name('dasawisma.rekap.update');
    Route::post('rekap/dasawisma/delete/{id}', [DasawismaController::class, 'deleteRekap'])->name('dasawisma.rekap.delete');

    Route::get('rw/', [RWController::class, 'index'])->name('rw.index');
    Route::get('rw/create', [RWController::class, 'create'])->name('rw.create');
    Route::post('rw/store', [RWController::class, 'store'])->name('rw.store');
    Route::get('rw/edit/{id}', [RWController::class, 'edit'])->name('rw.edit');
    Route::post('rw/update/{id}', [RWController::class, 'update'])->name('rw.update');
    Route::post('rw/delete/{id}', [RWController::class, 'delete'])->name('rw.delete');

});


