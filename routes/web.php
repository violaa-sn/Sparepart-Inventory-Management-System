<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', [AuthController::class,'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class,'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class,'logout'])
    ->name('logout');



//middleware
Route::middleware(['auth','check.status'])->group(function(){

    Route::get('/dashboard',
        [DashboardController::class,'index'])
        ->name('dashboard');

    Route::prefix('users')
        ->name('users.')
        ->group(function(){

            Route::get('/',[UserController::class,'index'])->name('index');

            Route::post('/',[UserController::class,'store'])->name('store');

            Route::patch('/{user}/toggle-status',
                [UserController::class,'toggleStatus'])
                ->name('toggle-status');

            Route::get('/{user}/show',
                [UserController::class,'show'])
                ->name('show');

            Route::get('/{user}/edit',
                [UserController::class,'edit'])
                ->name('edit');

            Route::put('/{user}',
                [UserController::class,'update'])
                ->name('update');

            Route::delete('/{user}',
                [UserController::class,'destroy'])
                ->name('destroy');

            Route::get('/trash',
                [UserController::class,'trash'])
                ->name('trash');

            Route::patch('/trash/{id}/restore',
                [UserController::class,'restore'])
                ->name('restore');

            Route::delete('/trash/{id}/force-delete',
                [UserController::class,'forceDelete'])
                ->name('force-delete');

        });

    Route::view('/kategori','kategori.index')
        ->name('kategori.index');

    Route::view('/brands','brands')
        ->name('brands.index');

    Route::view('/suppliers','suppliers')
        ->name('suppliers.index');

    Route::view('/spareparts','spareparts')
        ->name('spareparts.index');

    Route::view('/barang-masuk','transactions.in')
        ->name('transactions.in');

    Route::view('/barang-keluar','transactions.out')
        ->name('transactions.out');

    Route::view('/riwayat','transactions.history')
        ->name('transactions.history');

});