<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StokTransaksiController;


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
        ->middleware('role:manager')
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
            // VIEW (SEMUA ROLE)

            Route::middleware('role:manager,admin,staff')
                ->group(function () {

                    Route::get('/', [KategoriController::class, 'index'])
                        ->name('index');
                });

            // CRUD (MANAGER + ADMIN)

            Route::middleware('role:manager,admin')
                ->group(function () {

                    Route::get('/create', [KategoriController::class, 'create'])
                        ->name('create');

                    Route::post('/', [KategoriController::class, 'store'])
                        ->name('store');

                    Route::get('/{kategori}/edit', [KategoriController::class, 'edit'])
                        ->name('edit');

                    Route::put('/{kategori}', [KategoriController::class, 'update'])
                        ->name('update');

                    Route::delete('/{kategori}', [KategoriController::class, 'destroy'])
                        ->name('destroy');

                    Route::patch(
                        '/{kategori}/toggle-status',
                        [KategoriController::class, 'toggleStatus']
                    )
                        ->name('toggle-status');

                    Route::get(
                        '/trash',
                        [KategoriController::class, 'trash']
                    )
                        ->name('trash');

                    Route::patch(
                        '/trash/{id}/restore',
                        [KategoriController::class, 'restore']
                    )
                        ->name('restore');

                    Route::delete(
                        '/trash/{id}/force-delete',
                        [KategoriController::class, 'forceDelete']
                    )
                        ->name('force-delete');
                });
        });

    Route::prefix('brand')
        ->name('brand.')
        ->group(function () {

            // VIEW (SEMUA ROLE)

            Route::middleware('role:manager,admin,staff')
                ->group(function () {

                    Route::get('/', [BrandController::class, 'index'])
                        ->name('index');

                    Route::get('/{brand}/show', [BrandController::class, 'show'])
                        ->name('show');
                });

            // CRUD (MANAGER + ADMIN)

            Route::middleware('role:manager,admin')
                ->group(function () {

                    Route::get('/create', [BrandController::class, 'create'])
                        ->name('create');

                    Route::post('/', [BrandController::class, 'store'])
                        ->name('store');

                    Route::get('/{brand}/edit', [BrandController::class, 'edit'])
                        ->name('edit');

                    Route::put('/{brand}', [BrandController::class, 'update'])
                        ->name('update');

                    Route::delete('/{brand}', [BrandController::class, 'destroy'])
                        ->name('destroy');

                    Route::patch(
                        '/{brand}/toggle-status',
                        [BrandController::class, 'toggleStatus']
                    )
                        ->name('toggle-status');

                    Route::get('/trash', [BrandController::class, 'trash'])
                        ->name('trash');

                    Route::patch(
                        '/trash/{id}/restore',
                        [BrandController::class, 'restore']
                    )
                        ->name('restore');

                    Route::delete(
                        '/trash/{id}/force-delete',
                        [BrandController::class, 'forceDelete']
                    )
                        ->name('force-delete');
                });
        });

    Route::prefix('supplier')
        ->name('supplier.')
        ->group(function () {

            // VIEW (SEMUA ROLE)
            Route::middleware('role:manager,admin,staff')
                ->group(function () {

                    Route::get('/', [SupplierController::class, 'index'])
                        ->name('index');

                    Route::get('/trash', [SupplierController::class, 'trash'])
                        ->name('trash');

                    Route::get('/{supplier}', [SupplierController::class, 'show'])
                        ->name('show');
                });

            // CRUD (MANAGER + ADMIN)
            Route::middleware('role:manager,admin')
                ->group(function () {

                    Route::get('/create', [SupplierController::class, 'create'])
                        ->name('create');

                    Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])
                        ->name('edit');

                    Route::post('/', [SupplierController::class, 'store'])
                        ->name('store');

                    Route::put('/{supplier}', [SupplierController::class, 'update'])
                        ->name('update');

                    Route::delete('/{supplier}', [SupplierController::class, 'destroy'])
                        ->name('destroy');

                    Route::patch(
                        '/{supplier}/toggle-status',
                        [SupplierController::class, 'toggleStatus']
                    )
                        ->name('toggle-status');

                    Route::patch(
                        '/trash/{id}/restore',
                        [SupplierController::class, 'restore']
                    )
                        ->name('restore');

                    Route::delete(
                        '/trash/{id}/force-delete',
                        [SupplierController::class, 'forceDelete']
                    )
                        ->name('force-delete');
                });
        });

    Route::prefix('spareparts')
        ->name('spareparts.')
        ->group(function () {

            // VIEW (SEMUA ROLE)
            Route::middleware('role:manager,admin,staff')
                ->group(function () {

                    Route::get('/', [SparepartController::class, 'index'])
                        ->name('index');

                    // CRUD (MANAGER + ADMIN)
                    Route::middleware('role:manager,admin')
                        ->group(function () {

                            Route::get('/create', [SparepartController::class, 'create'])
                                ->name('create');

                            Route::post('/', [SparepartController::class, 'store'])
                                ->name('store');

                            Route::get('/trash', [SparepartController::class, 'trash'])
                                ->name('trash');

                            Route::get('/{sparepart}/edit', [SparepartController::class, 'edit'])
                                ->name('edit');

                            Route::put('/{sparepart}', [SparepartController::class, 'update'])
                                ->name('update');

                            Route::delete('/{sparepart}', [SparepartController::class, 'destroy'])
                                ->name('destroy');

                            Route::get('/{sparepart}', [SparepartController::class, 'show'])
                                ->name('show');

                            Route::get('/trash/{id}', [SparepartController::class, 'showTrash'])
                                ->name('trash.show');
                        });

                    Route::patch(
                        '/trash/{id}/restore',
                        [SparepartController::class, 'restore']
                    )
                        ->name('restore');

                    Route::delete(
                        '/trash/{id}/force-delete',
                        [SparepartController::class, 'forceDelete']
                    )
                        ->name('force-delete');
                });
        });

    Route::prefix('unit')
        ->name('unit.')
        ->group(function () {
            // VIEW (SEMUA ROLE)
            Route::middleware('role:manager,admin,staff')
                ->group(function () {

                    Route::get('/', [UnitController::class, 'index'])
                        ->name('index');
                });

            Route::middleware('role:manager,admin')
                ->group(function () {

                    Route::patch(
                        '/{unit}/toggle-status',
                        [UnitController::class, 'toggleStatus']
                    )
                        ->name('toggle-status');
                });
        });

    Route::prefix('transaksi')
        ->name('transaksi.')
        ->middleware('role:manager,admin,staff')
        ->group(function () {

            // ======================
            // Barang Masuk
            // ======================
            Route::get('/barang-masuk', [StokTransaksiController::class, 'barangMasuk'])
                ->name('barang-masuk');

            Route::get('/barang-masuk/create', [StokTransaksiController::class, 'createBarangMasuk'])
                ->name('barang-masuk.create');

            Route::post('/barang-masuk', [StokTransaksiController::class, 'storeBarangMasuk'])
                ->name('barang-masuk.store');

            Route::get('/barang-masuk/{transaksi}', [StokTransaksiController::class, 'showBarangMasuk'])
                ->name('barang-masuk.show');

            Route::patch('/barang-masuk/{transaksi}/cancel', [StokTransaksiController::class, 'cancel'])
                ->name('barang-masuk.cancel');

            Route::get(
                '/barang-masuk/supplier/{supplier}/spareparts',
                [StokTransaksiController::class, 'getSparepartsBySupplier']
            )->name('barang-masuk.supplier.spareparts');


            // ======================
            // Barang Keluar
            // ======================
            Route::get('/barang-keluar', [StokTransaksiController::class, 'barangKeluar'])
                ->name('barang-keluar');

            Route::get('/barang-keluar/create', [StokTransaksiController::class, 'createBarangKeluar'])
                ->name('barang-keluar.create');

            Route::post('/barang-keluar', [StokTransaksiController::class, 'storeBarangKeluar'])
                ->name('barang-keluar.store');

            Route::get('/barang-keluar/{transaksi}', [StokTransaksiController::class, 'showBarangKeluar'])
                ->name('barang-keluar.show');

            Route::patch('/barang-keluar/{transaksi}/cancel', [StokTransaksiController::class, 'cancel'])
                ->name('barang-keluar.cancel');


            // ======================
            // Riwayat
            // ======================
            Route::get('/riwayat', [StokTransaksiController::class, 'riwayat'])
                ->name('riwayat');
        });
});
