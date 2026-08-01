@extends('layouts.app')

@section('title', 'Manajemen Sparepart - Sparepart Manager')
@section('page-title', 'Manajemen Sparepart')


@section('content')


    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

        </div>
    @endif

    {{-- HEADER DAFTAR SPAREPART --}}

    <section class="card-surface">

        <div class="card-surface-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="section-title mb-0">Daftar Sparepart</h3>
                <div class="d-flex align-items-center gap-2">

                    <a href="{{ route('spareparts.trash') }}"
                        class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 px-3">

                        <i class="bi bi-trash3"></i>

                        Trash Sparepart

                    </a>

                    <a href="{{ route('spareparts.create') }}"
                        class="btn btn-brand btn-sm d-flex align-items-center gap-2 px-3">

                        <i class="bi bi-plus-circle"></i>

                        Tambah Sparepart

                    </a>

                </div>
            </div>


            <form method="GET" action="{{ route('spareparts.index') }}">
                <div class="row g-3 mt-3">
                    <div class="col-md-8">
                        <div class="position-relative">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" class="form-control search-control-pill user-search-input ps-5"
                                name="search" value="{{ request('search') }}"
                                placeholder="Cari kode atau nama sparepart...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select form-select-table-pill user-search-input" name="status"
                            onchange="this.form.submit()">

                            <option value="">
                                Semua Sparepart
                            </option>

                            <option value="safe_stock" @selected(request('status') == 'safe_stock')>
                                Stok Aman
                            </option>

                            <option value="low_stock" @selected(request('status') == 'low_stock')>
                                Low Stock
                            </option>

                            <option value="out_stock" @selected(request('status') == 'out_stock')>
                                Stok Habis
                            </option>

                        </select>
                    </div>
                </div>
            </form>
        </div>
        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:4rem;">
                            No
                        </th>
                        <th style="width:140px;">
                            Kode Sparepart
                        </th>
                        <th>Nama Sparepart</th>
                        <th>Kategori</th>
                        <th>Brand</th>
                        <th>Unit</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th class="text-center">
                            Aksi
                        </th>
                    </tr>

                </thead>
                <tbody>
                    @forelse($spareparts as $sparepart)
                        <tr>
                            <td>
                                {{ $spareparts->firstItem() + $loop->index }}
                            </td>
                            <td class="table-code">
                                {{ $sparepart->kode_sparepart }}
                            </td>
                            <td class="fw-semibold">
                                {{ $sparepart->nama_sparepart }}
                            </td>
                            <td>
                                {{ $sparepart->kategori->nama_kategori ?? '-' }}
                            </td>
                            <td>
                                {{ $sparepart->brand->nama_brand ?? '-' }}
                            </td>
                            <td>
                                {{ $sparepart->unit->nama_unit ?? '-' }}
                            </td>
                            <td class="fw-semibold">
                                {{ $sparepart->stok }}
                            </td>
                            <td>
                                @if ($sparepart->stok == 0)
                                    <span class="badge-status badge-status-danger">
                                        Stok Habis
                                    </span>
                                @elseif ($sparepart->stok <= $sparepart->min_stok)
                                    <span class="badge-status badge-status-warning">
                                        Low Stock
                                    </span>
                                @else
                                    <span class="badge-status badge-status-success">
                                        Stok Aman
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <a href="{{ route('spareparts.show', $sparepart) }}"
                                        class="action-icon-btn action-icon-view" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('spareparts.edit', $sparepart) }}"
                                        class="action-icon-btn action-icon-edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('spareparts.destroy', $sparepart) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-icon-btn action-icon-delete" title="Delete"
                                            onclick="return confirm('Hapus sparepart ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                Belum ada data sparepart.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- PAGINATION --}}
        <div class="card-surface-header d-flex justify-content-between align-items-center border-top">
            <p class="small text-muted mb-0">
                Menampilkan
                {{ $spareparts->firstItem() ?? 0 }}
                -
                {{ $spareparts->lastItem() ?? 0 }}
                dari
                {{ $spareparts->total() }}
                entri
            </p>

            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item {{ $spareparts->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $spareparts->previousPageUrl() ?? '#' }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $spareparts->lastPage(); $i++)
                        <li class="page-item {{ $spareparts->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $spareparts->url($i) }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor
                    <li class="page-item {{ $spareparts->hasMorePages() ? '' : 'disabled' }}">

                        <a class="page-link" href="{{ $spareparts->nextPageUrl() ?? '#' }}">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </section>

@endsection
