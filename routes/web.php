<?php

use App\Http\Controllers\AllUserController;
use App\Models\Auth;
use App\Models\allUser;
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\KartuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\WaliSantriController;
use App\Models\WaliSantri;

// Public routes
Route::get('/', function () {
    return view('Auth.login');
});



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    // Route::post('/register', [AuthController::class, 'register']);
});
// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin routes
    Route::middleware('check.role:admin')->group(function () {
        Route::get('dashboard',[Dashboard::class, 'index'])->name('dashboard');

        route::get('/santri.index', [SantriController::class, 'index'])->name('santri.index');
        route::post('/santri.store', [SantriController::class, 'store'])->name('santri.store');
        route::get('/santri.{id}.edit', [SantriController::class, 'edit'])->name('santri.edit');
        route::put('/santri.{id}.update', [SantriController::class, 'update'])->name('santri.update');
        route::delete('/santri.{id}', [SantriController::class, 'destroy'])->name('santri.destroy');


        route::get('/walisantri.index', [WaliSantriController::class, 'index'])->name('walisantri.index');
        Route::post('/walisantri.store', [WaliSantriController::class, 'store'])->name('walisantri.store');
        route::get('/walisantri.{id}.edit', [WaliSantriController::class, 'edit'])->name('walisantri.edit');
        route::put('/walisantri.{id}.update', [WaliSantriController::class, 'update'])->name('walisantri.update');
        route::delete('/walisantri.{id}', [WaliSantriController::class, 'destroy'])->name('walisantri.destroy');

        route::get('/pegawai.index', [PegawaiController::class, 'index'])->name('pegawai.index');
        route::post('/pegawai.store', [PegawaiController::class, 'store'])->name('pegawai.store');
        route::get('/pegawai.{id}.edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        route::put('/pegawai.{id}.update', [PegawaiController::class, 'update'])->name('pegawai.update');
        route::delete('/pegawai.{id}.', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

        route::get('/kartu.index', [KartuController::class, 'index'])->name('kartu.index');


        route::get('/topup.index', [TopupController::class, 'index'])->name('topup.index');


        route::get('/alluser.index', [AllUserController::class, 'index'])->name('alluser.index');
    });


});

