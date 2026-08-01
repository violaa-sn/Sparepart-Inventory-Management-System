@extends('layouts.app')

@section('title', 'Detail Trash Sparepart - Sparepart Manager')

@section('content')


    {{-- ===================== SECTION: RINGKASAN STATISTIK ===================== --}}
    <section class="row g-3 mb-4">

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div>
                    <p class="stat-card-label">Total Supplier</p>
                    <p class="stat-card-value">
                        {{ $sparepart->suppliers->count() }}
                    </p>
                </div>

                <div class="stat-card-icon">
                    <i class="bi bi-shop"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div>
                    <p class="stat-card-label">Barang Masuk</p>
                    <p class="stat-card-value">0</p>
                </div>

                <div class="stat-card-icon stat-card-icon-accent">
                    <i class="bi bi-box-arrow-in-down"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div>
                    <p class="stat-card-label">Barang Keluar</p>
                    <p class="stat-card-value">0</p>
                </div>

                <div class="stat-card-icon stat-card-icon-warning">
                    <i class="bi bi-box-arrow-up"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div>
                    <p class="stat-card-label">Stok Saat Ini</p>
                    <p class="stat-card-value">
                        {{ $sparepart->stok }}
                    </p>
                </div>

                <div class="stat-card-icon stat-card-icon-error">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
        </div>

    </section>

    {{-- ===================== SECTION: DETAIL + SUPPLIER ===================== --}}
    <div class="row g-4 mb-4">

        <div class="col-lg-8">
            <article class="card-surface h-100 d-flex flex-column">

                <div class="card-surface-header d-flex justify-content-between align-items-start">

                    <div>

                        <div class="d-flex align-items-center gap-2 mb-1">

                            <h2 class="h5 mb-0">
                                Informasi Detail
                            </h2>

                            @if ($sparepart->stok <= $sparepart->min_stok)
                                <span class="badge-status badge-status-danger">
                                    Minimum
                                </span>
                            @else
                                <span class="badge-status badge-status-success">
                                    Aman
                                </span>
                            @endif

                        </div>

                        <p class="page-subtitle mb-0 pt-2">
                            Informasi lengkap sparepart.
                        </p>

                    </div>

                   <a href="{{ route('spareparts.trash') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                </div>

                <div class="card-surface-body flex-grow-1">

                    <dl class="detail-list row">

                        <div class="col-md-6">
                            <dt>Kode Sparepart</dt>
                            <dd>{{ $sparepart->kode_sparepart }}</dd>
                        </div>

                        <div class="col-md-6">
                            <dt>Nama Sparepart</dt>
                            <dd>{{ $sparepart->nama_sparepart }}</dd>
                        </div>

                        <div class="col-md-6">
                            <dt>Kategori</dt>
                            <dd>{{ $sparepart->kategori->nama_kategori }}</dd>
                        </div>

                        <div class="col-md-6">
                            <dt>Brand</dt>
                            <dd>{{ $sparepart->brand->nama_brand }}</dd>
                        </div>

                        <div class="col-md-6">
                            <dt>Unit</dt>
                            <dd>{{ $sparepart->unit->nama_unit }}</dd>
                        </div>

                        <div class="col-md-6">
                            <dt>Minimum Stok</dt>
                            <dd>{{ $sparepart->min_stok }}</dd>
                        </div>

                        <div class="col-md-6">
                            <dt>Stok Saat Ini</dt>
                            <dd>{{ $sparepart->stok }}</dd>
                        </div>

                        <div class="col-12 detail-list-divider">
                            <dt>Deskripsi</dt>
                            <dd>{{ $sparepart->deskripsi ?: '-' }}</dd>
                        </div>

                    </dl>

                </div>

                <div class="card-surface-footer d-flex justify-content-end gap-3">

                    {{-- Restore --}}
                    <form action="{{ route('spareparts.restore', $sparepart->id) }}" method="POST">

                        @csrf
                        @method('PATCH')

                        <button class="btn btn-success" onclick="return confirm('Pulihkan sparepart ini?')">

                            <i class="bi bi-arrow-counterclockwise"></i>
                            Restore

                        </button>

                    </form>


                    {{-- Hapus Permanen --}}
                    <form action="{{ route('spareparts.force-delete', $sparepart->id) }}" method="POST">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger" onclick="return confirm('Hapus permanen sparepart ini?')">

                            <i class="bi bi-trash"></i>
                            Hapus Permanen

                        </button>

                    </form>


                </div>

            </article>
        </div>

        {{-- Supplier --}}
        <div class="col-lg-4">

            <article class="card-surface h-100 d-flex flex-column">

                <div class="card-surface-header">
                    <h2 class="h5 mb-0">
                        Supplier
                    </h2>
                </div>

                <ul class="list-group list-group-flush flex-grow-1">

                    @forelse($sparepart->suppliers as $index => $supplier)
                        <li class="list-group-item d-flex justify-content-between align-items-center">

                            <div class="d-flex gap-3 align-items-center">

                                <span class="supplier-avatar">
                                    {{ $index + 1 }}
                                </span>

                                <div>

                                    <p class="mb-0 fw-semibold">
                                        {{ $supplier->nama_supplier }}
                                    </p>

                                </div>

                            </div>

                            <span class="fw-semibold">
                                Rp {{ number_format($supplier->pivot->harga_beli, 0, ',', '.') }}
                            </span>

                        </li>

                    @empty

                        <li class="list-group-item text-center text-muted py-4">
                            Belum ada supplier.
                        </li>
                    @endforelse

                </ul>

            </article>

        </div>

    </div>

    {{-- ===================== RIWAYAT ===================== --}}

    <section class="card-surface">

        <div class="card-surface-header">

            <h2 class="h5 mb-0">
                Riwayat Transaksi
            </h2>

        </div>

        <div class="table-responsive">

            <table class="table table-sparepart align-middle mb-0">

                <thead>

                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th class="text-end">Qty</th>
                        <th>User</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td colspan="5" class="text-center text-muted py-5">

                            Belum ada transaksi untuk sparepart ini.

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </section>

@endsection
