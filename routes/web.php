<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TiketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\ScanUserController;
use App\Http\Controllers\Admin\ScanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\JaketController;
use App\Http\Controllers\Admin\KuotaController;
use App\Http\Controllers\PopController;

Route::get('/', function () {
    return redirect()->route('register');
});

Route::get('/register', [MainController::class, 'register'])->name('register');
Route::post('/register/store', [MainController::class, 'store'])->name('register.store');

Route::get('/register/tshirt', [MainController::class, 'tshirt'])->name('tshirt');
Route::post('/register/tshirt/store', [MainController::class, 'tshirtStore'])->name('tshirt.store');

Route::middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login/admin', [AuthController::class, 'login'])->name('login.admin');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::put('/dashboard/register/update/{id}', [AdminController::class, 'registerUpdate'])->name(
    'dashboard.register.update'
);
Route::delete('/dashboard/register/delete/{id}', [AdminController::class, 'registerDestroy'])->name(
    'dashboard.register.destroy'
);
Route::post('/dashboard/register/qrcode/{id}', [AdminController::class, 'generateQrCodeAndSendEmail'])->name(
    'dashboard.register.qrcode'
);
Route::get('/dashboard/register/table', [AdminController::class, 'registerTable'])->name(
    'dashboard.register.table'
);

Route::get('/dashboard/kuota', [KuotaController::class, 'kuota'])->name('dashboard.kuota');
Route::post('/dashboard/kuota/store', [KuotaController::class, 'kuotaStore'])->name('dashboard.kuota.store');
Route::put('/dashboard/kuota/update/{id}', [KuotaController::class, 'kuotaUpdate'])->name('dashboard.kuota.update');
Route::delete('/dashboard/kuota/delete/{id}', [KuotaController::class, 'kuotaDestroy'])->name(
    'dashboard.kuota.destroy'
);

Route::get('/dashboard/jaket', [JaketController::class, 'jaket'])->name('dashboard.jaket');
Route::post('/dashboard/jaket/store', [JaketController::class, 'jaketStore'])->name('dashboard.jaket.store');
Route::put('/dashboard/jaket/update/{id}', [JaketController::class, 'jaketUpdate'])->name('dashboard.jaket.update');
Route::delete('/dashboard/jaket/delete/{id}', [JaketController::class, 'jaketDestroy'])->name(
    'dashboard.jaket.destroy'
);
Route::post('/dashboard/jaket/update-status/{id}', [JaketController::class, 'updateStatus']);
Route::get('/dashboard/jaket/table', [JaketController::class, 'jaketTable'])->name('dashboard.jaket.table');

Route::get('/dashboard/tiket', [TiketController::class, 'tiket'])->name('dashboard.tiket');
Route::get('/dashboard/tiket/table', [TiketController::class, 'tiketTable'])->name('dashboard.tiket.table');

Route::get('/dashboard/scanner/1', [ScanController::class, 'scanner1'])->name('dashboard.scanner1');
Route::get('/dashboard/scanner/2', [ScanController::class, 'scanner2'])->name('dashboard.scanner2');
Route::post('/dashboard/scanner/1/qr', [ScanController::class, 'scanQR1'])->name('dashboard.scanner1.qr');
Route::post('/dashboard/scanner/2/qr', [ScanController::class, 'scanQR2'])->name('dashboard.scanner2.qr');
Route::post('/dashboard/scanner/2/naik_kapal', [ScanController::class, 'updateNaikKapal'])->name(
    'dashboard.scanner2.naik_kapal'
);


Route::get('/dashboard/export-excel', [AdminController::class, 'exportExcel'])->name('dashboard.export');

Route::get('/scanner', [ScanUserController::class, 'scanner'])->name('scanner');
Route::get('/scanner/1', [ScanUserController::class, 'scanner1'])->name('scanner1');
Route::get('/scanner/2', [ScanUserController::class, 'scanner2'])->name('scanner2');
Route::post('/scanner/1/qr', [ScanUserController::class, 'scanQR1'])->name('scanner1.qr');
Route::post('/scanner/2/qr', [ScanUserController::class, 'scanQR2'])->name('scanner2.qr');

Route::fallback(function () {
    return view('404');
});
