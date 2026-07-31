@extends('layouts.app')

@section('title', 'Manajemen Unit - Sparepart Manager')
@section('page-title', 'Daftar Unit')

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
            <form method="GET" action="{{ route('unit.index') }}">
                <div class="row g-3 mt-3">
                    <div class="col-md-8">
                        <div class="position-relative">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" class="form-control search-control-pill user-search-input ps-5"
                                name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama unit...">
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
                        <th style="width: 140px;">Kode Unit</th>
                        <th>Nama Unit</th>
                        <th>Jumlah Sparepart</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($unit as $item)
                        <tr>
                            <td>
                                {{ $unit->firstItem() + $loop->index }}
                            </td>
                            <td class="table-code">
                                {{ $item->kode_unit }}
                            </td>
                            <td class="fw-semibold">
                                {{ $item->nama_unit }}
                            </td>
                            <td class="text-muted">
                                {{ $item->spareparts_count }}
                            </td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <label
                                        class="user-status-dot {{ $item->status_unit == 'aktif' ? 'user-status-dot-active' : 'user-status-dot-inactive' }}"></label>
                                    <span class="user-status-text">
                                        {{ ucfirst($item->status_unit) }}
                                    </span>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <label class="toggle-switch-wrap toggle-sm">
                                        <input type="checkbox" class="js-unit-status-toggle" data-id="{{ $item->id }}"
                                            {{ $item->status_unit == 'aktif' ? 'checked' : '' }}>

                                        <span class="toggle-switch-slider"></span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                Belum ada data unit.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="card-surface-header d-flex justify-content-between align-items-center border-top">

                <p class="small text-muted mb-0">
                    Menampilkan
                    {{ $unit->firstItem() ?? 0 }}
                    -
                    {{ $unit->lastItem() ?? 0 }}
                    dari
                    {{ $unit->total() }}
                    entri
                </p>

                <nav aria-label="Pagination daftar unit">
                    <ul class="pagination pagination-sm mb-0">

                        {{-- Previous --}}
                        <li class="page-item {{ $unit->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $unit->previousPageUrl() ?? '#' }}">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>

                        {{-- Nomor halaman --}}
                        @for ($i = 1; $i <= $unit->lastPage(); $i++)
                            <li class="page-item {{ $unit->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ $unit->url($i) }}">
                                    {{ $i }}
                                </a>
                            </li>
                        @endfor

                        {{-- Next --}}
                        <li class="page-item {{ $unit->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $unit->nextPageUrl() ?? '#' }}">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>

                    </ul>
                </nav>

            </div>

        </div>


    </section>

@endsection
