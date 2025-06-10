<?php

use App\Models\Auth;
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\TataUsahaController;
use App\Http\Controllers\WaliSantriController;
use App\Http\Controllers\PetugasKantinController;

Route::get('/', function () {
    return view('Auth.login');
});

// route::get('/Auth.login', [Authss::class, 'login'])->name('login');

Route::get('dashboard',[Dashboard::class, 'index'])->name('dashboard');

route::get('/santri.index', [SantriController::class, 'index'])->name('santri.index');
route::post('/santri.store', [SantriController::class, 'store'])->name('santri.store');
route::get('/santri.edit.{id}', [SantriController::class, 'edit'])->name('santri.edit');


route::get('/walisantri.index', [WaliSantriController::class, 'index'])->name('walisantri.index');
Route::post('/walisantri.store', [WaliSantriController::class, 'store'])->name('walisantri.store');
route::get('/walisantri.edit.{id}', [WaliSantriController::class, 'edit'])->name('walisantri.edit');

route::get('/topup.index', [TopupController::class, 'index'])->name('topup.index');

route::get('/petugaskantin.index', [PetugasKantinController::class, 'index'])->name('petugaskantin.index');

route::get('/tatausaha.index', [TataUsahaController::class, 'index'])->name('tatausaha.index');