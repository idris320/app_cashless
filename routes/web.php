<?php

use App\Models\Auth;
use App\Models\allUser;
use App\Models\WaliSantri;
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KartuController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\DashboardWaliController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\WaliSantriController;

// Public Routes
Route::get('/', function () {
    return view('Auth.login');
});



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    // Route::post('/register', [AuthController::class, 'register']);
});
// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin Routes
    Route::middleware(['auth','check.role:admin'])->group(function () {
        Route::get('dashboard',[Dashboard::class, 'index'])->name('dashboard');

        Route::get('/santri.index', [SantriController::class, 'index'])->name('santri.index');
        Route::post('/santri.store', [SantriController::class, 'store'])->name('santri.store');
        Route::get('/santri.{id}.edit', [SantriController::class, 'edit'])->name('santri.edit');
        Route::put('/santri.{id}.update', [SantriController::class, 'update'])->name('santri.update');
        Route::delete('/santri.{id}', [SantriController::class, 'destroy'])->name('santri.destroy');


        Route::get('/walisantri.index', [WaliSantriController::class, 'index'])->name('walisantri.index');
        Route::post('/walisantri.store', [WaliSantriController::class, 'store'])->name('walisantri.store');
        Route::get('/walisantri.{id}.edit', [WaliSantriController::class, 'edit'])->name('walisantri.edit');
        Route::put('/walisantri.{id}.update', [WaliSantriController::class, 'update'])->name('walisantri.update');
        Route::delete('/walisantri.{id}', [WaliSantriController::class, 'destroy'])->name('walisantri.destroy');

        Route::get('/pegawai.index', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::post('/pegawai.store', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai.{id}.edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai.{id}.update', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::delete('/pegawai.{id}.', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

        Route::get('/kartu.index', [KartuController::class, 'index'])->name('kartu.index');
        Route::post('/kartu.store', [KartuController::class, 'store'])->name('kartu.store');
        Route::post('/kartu.gantikartu', [KartuController::class, 'gantikartu'])->name('kartu.gantikartu');
        Route::post('/kartu.topup', [KartuController::class, 'topup'])->name('kartu.topup');
        Route::post('/kartu.update-status', [KartuController::class, 'updateStatus'])->name('kartu.update-status');
        Route::post('/kartu.{id}.update-password', [KartuController::class, 'updatePassword'])->name('kartu.update-password');
        

        Route::get('/barang.index', [BarangController::class, 'index'])->name('barang.index');
    });

    Route::middleware(['auth','check.role:wali_santri'])->group(function () {
        Route::get('/dashboardwali', [DashboardWaliController::class, 'index'])->name('dashboardwali');
        Route::get('/dashboardwali.{id}.edit', [DashboardWaliController::class, 'edit'])->name('dashboardwali.edit');
        Route::put('/dashboardwali.{id}.update', [DashboardWaliController::class, 'update'])->name('dashboardwali.update');

        Route::get('/transaksi.index', [TransaksiController::class, 'index'])->name('transaksi.index');
    });


});

