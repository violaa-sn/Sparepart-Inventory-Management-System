<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UnitController;

Route::get('/', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');


//middleware
Route::middleware(['auth', 'check.status'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('users')
        ->name('users.')
        ->group(function () {

            Route::get('/', [UserController::class, 'index'])
                ->name('index');

            Route::post('/', [UserController::class, 'store'])
                ->name('store');

            Route::patch(
                '/{user}/toggle-status',
                [UserController::class, 'toggleStatus']
            )->name('toggle-status');

            Route::get('/{user}/show', [UserController::class, 'show'])
                ->name('show');

            Route::get('/{user}/edit', [UserController::class, 'edit'])
                ->name('edit');

            Route::put('/{user}', [UserController::class, 'update'])
                ->name('update');

            Route::delete('/{user}', [UserController::class, 'destroy'])
                ->name('destroy');

            Route::get('/trash', [UserController::class, 'trash'])
                ->name('trash');

            Route::patch('/trash/{id}/restore', [UserController::class, 'restore'])
                ->name('restore');

            Route::delete('/trash/{id}/force-delete', [UserController::class, 'forceDelete'])
                ->name('force-delete');
        });

    Route::prefix('kategori')
        ->name('kategori.')
        ->group(function () {

            Route::get('/', [KategoriController::class, 'index'])
                ->name('index');

            Route::get('/create', [KategoriController::class, 'create'])
                ->name('create');

            Route::post('/', [KategoriController::class, 'store'])
                ->name('store');

            Route::patch(
                '/{kategori}/toggle-status',
                [KategoriController::class, 'toggleStatus']
            )->name('toggle-status');

            Route::get(
                '/{kategori}/edit',
                [KategoriController::class, 'edit']
            )->name('edit');

            Route::put(
                '/{kategori}',
                [KategoriController::class, 'update']
            )->name('update');

            Route::delete(
                '/{kategori}',
                [KategoriController::class, 'destroy']
            )->name('destroy');

            Route::get(
                '/trash',
                [KategoriController::class, 'trash']
            )->name('trash');

            Route::patch(
                '/trash/{id}/restore',
                [KategoriController::class, 'restore']
            )->name('restore');

            Route::delete(
                '/trash/{id}/force-delete',
                [KategoriController::class, 'forceDelete']
            )->name('force-delete');
        });

    Route::prefix('brand')
        ->name('brand.')
        ->group(function () {

            Route::get('/', [BrandController::class, 'index'])
                ->name('index');

            Route::get('/create', [BrandController::class, 'create'])
                ->name('create');

            Route::post('/', [BrandController::class, 'store'])
                ->name('store');

            Route::patch(
                '/{brand}/toggle-status',
                [BrandController::class, 'toggleStatus']
            )->name('toggle-status');

            Route::get('/{brand}/show', [BrandController::class, 'show'])
                ->name('show');

            Route::get('/{brand}/edit', [BrandController::class, 'edit'])
                ->name('edit');

            Route::put('/{brand}', [BrandController::class, 'update'])
                ->name('update');

            Route::delete('/{brand}', [BrandController::class, 'destroy'])
                ->name('destroy');

            Route::get('/trash', [brandController::class, 'trash'])
                ->name('trash');

            Route::patch('/trash/{id}/restore', [BrandController::class, 'restore'])
                ->name('restore');

            Route::delete('/trash/{id}/force-delete', [BrandController::class, 'forceDelete'])
                ->name('force-delete');
        });

    Route::view('/suppliers', 'suppliers')
        ->name('suppliers.index');

    Route::prefix('spareparts')
        ->name('spareparts.')
        ->group(function () {

            Route::get('/', [SparepartController::class, 'index'])
                ->name('index');

            Route::get('/create', [SparepartController::class, 'create'])
                ->name('create');

            Route::post('/', [SparepartController::class, 'store'])
                ->name('store');

            Route::get('/trash', [SparepartController::class, 'trash'])
                ->name('trash');

            Route::get('/{sparepart}', [SparepartController::class, 'show'])
                ->name('show');

            Route::get(
                '/{sparepart}/edit',
                [SparepartController::class, 'edit']
            )->name('edit');

            Route::put('/{sparepart}', [SparepartController::class, 'update'])
                ->name('update');

            Route::delete('/{sparepart}', [SparepartController::class, 'destroy'])
                ->name('destroy');

            Route::patch('/trash/{id}/restore', [SparepartController::class, 'restore'])
                ->name('restore');

            Route::delete('/trash/{id}/force-delete', [SparepartController::class, 'forceDelete'])
                ->name('force-delete');
        });

    Route::prefix('unit')
        ->name('unit.')
        ->group(function () {

            Route::get('/', [UnitController::class, 'index'])
                ->name('index');

            Route::patch(
                '/{unit}/toggle-status',
                [UnitController::class, 'toggleStatus']
            )->name('toggle-status');
        });

    Route::view('/barang-masuk', 'transactions.in')
        ->name('transactions.in');

    Route::view('/barang-keluar', 'transactions.out')
        ->name('transactions.out');

    Route::view('/riwayat', 'transactions.history')
        ->name('transactions.history');
});
