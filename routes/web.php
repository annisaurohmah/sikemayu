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


});


