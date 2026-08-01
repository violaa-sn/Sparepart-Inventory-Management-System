@extends('layouts.app')

@section('title', 'Manajemen kategori - Sparepart Manager')
@section('page-title', 'Daftar Kategori')

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


    <section class="card-surface">
        <div class="card-surface-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="section-title mb-0">Daftar Kategori</h3>
                <div class="d-flex align-items-center gap-2">

                    <a href="{{ route('kategori.trash') }}"
                        class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 px-3">

                        <i class="bi bi-trash3"></i>

                        Trash Kategori

                    </a>

                    <a href="{{ route('kategori.create') }}"
                        class="btn btn-brand btn-sm d-flex align-items-center gap-2 px-3">

                        <i class="bi bi-plus-circle"></i>

                        Tambah Kategori

                    </a>

                </div>
            </div>
            <form method="GET" action="{{ route('kategori.index') }}">
                <div class="row g-3 mt-3">
                    <div class="col-md-8">
                        <div class="position-relative">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" class="form-control search-control-pill user-search-input ps-5"
                                name="search" value="{{ request('search') }}"
                                placeholder="Cari kode atau nama kategori...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select form-select-table-pill user-search-input" name="status"
                            onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="aktif" @selected(request('status') == 'aktif')>
                                Aktif
                            </option>
                            <option value="nonaktif" @selected(request('status') == 'nonaktif')>
                                Nonaktif
                            </option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 4rem;">No</th>
                        <th style="width: 140px;">Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Sparepart</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $item)
                        <tr>
                            <td>
                                {{ $kategori->firstItem() + $loop->index }}
                            </td>
                            <td class="table-code">
                                {{ $item->kode_kategori }}
                            </td>
                            <td class="fw-semibold">
                                {{ $item->nama_kategori }}
                            </td>
                            <td class="text-muted">
                                {{ $item->spareparts_count }}
                            </td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <span
                                        class="user-status-dot {{ $item->status_kategori == 'aktif' ? 'user-status-dot-active' : 'user-status-dot-inactive' }}"></span>
                                    <span class="user-status-text">
                                        {{ ucfirst($item->status_kategori) }}
                                    </span>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <a href="{{ route('kategori.edit', $item) }}" class="action-icon-btn action-icon-edit"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('kategori.destroy', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-icon-btn action-icon-delete"
                                            onclick="return confirm('Hapus kategori ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    <label class="toggle-switch-wrap toggle-sm">
                                        <input type="checkbox" class="js-kategori-status-toggle"
                                            data-id="{{ $item->id }}"
                                            {{ $item->status_kategori == 'aktif' ? 'checked' : '' }}>

                                        <span class="toggle-switch-slider"></span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Belum ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-surface-header d-flex justify-content-between align-items-center border-top">

            <p class="small text-muted mb-0">

                Menampilkan

                {{ $kategori->firstItem() ?? 0 }}

                -

                {{ $kategori->lastItem() ?? 0 }}

                dari

                {{ $kategori->total() }}

                entri

            </p>

            <nav>

                <ul class="pagination pagination-sm mb-0">

                    <li class="page-item {{ $kategori->onFirstPage() ? 'disabled' : '' }}">

                        <a class="page-link" href="{{ $kategori->previousPageUrl() ?? '#' }}">

                            <i class="bi bi-chevron-left"></i>

                        </a>

                    </li>

                    @for ($i = 1; $i <= $kategori->lastPage(); $i++)
                        <li class="page-item {{ $kategori->currentPage() == $i ? 'active' : '' }}">

                            <a class="page-link" href="{{ $kategori->url($i) }}">

                                {{ $i }}

                            </a>

                        </li>
                    @endfor

                    <li class="page-item {{ $kategori->hasMorePages() ? '' : 'disabled' }}">

                        <a class="page-link" href="{{ $kategori->nextPageUrl() ?? '#' }}">

                            <i class="bi bi-chevron-right"></i>

                        </a>

                    </li>

                </ul>

            </nav>
        </div>
    </section>

@endsection
