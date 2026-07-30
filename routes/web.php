<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/Login', [AuthController::class, 'login'])->name('login.process');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/kategori/create', function () {
    return view('kategori.create'); 
});

// Master Data
Route::view('/users', 'users.index')->name('users.index');
Route::view('/kategori', 'kategori.index')->name('kategori.index');
Route::view('/brands', 'brands')->name('brands.index');
Route::view('/suppliers', 'suppliers')->name('suppliers.index');
Route::view('/spareparts', 'spareparts')->name('spareparts.index');

// Transaksi
Route::view('/barang-masuk', 'transactions.in')->name('transactions.in');
Route::view('/barang-keluar', 'transactions.out')->name('transactions.out');
Route::view('/riwayat', 'transactions.history')->name('transactions.history');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
