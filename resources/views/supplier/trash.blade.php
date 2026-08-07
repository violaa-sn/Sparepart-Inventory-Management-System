@extends('layouts.app')

@section('title', 'Trash Supplier - Sparepart Manager')
@section('page-title', 'Trash Supplier')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>

        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">

            <i class="bi bi-exclamation-circle-fill me-2"></i>

            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>

        </div>
    @endif

    {{-- DAFTAR SUPPLIER --}}
    <section class="card-surface">
        <div class="card-surface-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="section-title mb-0">Daftar Supplier Trash</h3>
                <div class="d-flex align-items-center gap-2">

                    <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary js-disable-link">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                </div>
            </div>
            <form method="GET" action="{{ route('supplier.trash') }}">
                <div class="row g-3 mt-3">
                    <div class="col-md-8">
                        <div class="position-relative">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" class="form-control search-control-pill user-search-input ps-5"
                                placeholder="Cari nama atau email..." name="search" value="{{ request('search') }}">
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

                                Non-Aktif

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
                        <th style="width: 140px;">Kode Supplier</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Nomor Telepon</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Dibuat Pada</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($supplier as $item)
                        <tr>
                            <td>{{ $supplier->firstItem() + $loop->index }}</td>
                            <td class="table-code">{{ $item->kode_supplier }}</td>
                            <td class="fw-semibold"> {{ $item->nama_supplier }}</td>
                            <td class="text-muted"> {{ $item->alamat }}</td>
                            <td> {{ $item->notlp }}</td>
                            <td> {{ $item->email }}</td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <span
                                        class="user-status-dot {{ $item->status_supplier == 'aktif' ? 'user-status-dot-active' : 'user-status-dot-inactive' }}"></span>
                                    <span class="user-status-text">
                                        {{ ucfirst($item->status_supplier) }}
                                    </span>
                                </span>
                            </td>
                            <td class="text-muted">{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-3">

                                    {{-- Restore --}}
                                    <form action="{{ route('supplier.restore', $item->id) }}" method="POST">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="btn btn-success btn-sm"
                                            onclick="return confirm('Pulihkan kategori ini?')">

                                            <i class="bi bi-arrow-counterclockwise"></i>

                                        </button>

                                    </form>

                                    {{-- Hapus Permanen --}}
                                    <form action="{{ route('supplier.force-delete', $item->id) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Kategori akan dihapus permanen. Lanjutkan?')">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty

                        <tr>

                            <td colspan="8" class="text-center">

                                Belum ada data supplier.

                            </td>

                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-surface-header d-flex justify-content-between align-items-center border-top">

            <p class="small text-muted mb-0">
                Menampilkan
                {{ $supplier->firstItem() ?? 0 }}
                -
                {{ $supplier->lastItem() ?? 0 }}
                dari
                {{ $supplier->total() }}
                entri
            </p>

            <nav aria-label="Pagination daftar supplier">
                <ul class="pagination pagination-sm mb-0">

                    {{-- Previous --}}
                    <li class="page-item {{ $supplier->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $supplier->previousPageUrl() ?? '#' }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>

                    {{-- Nomor halaman --}}
                    @for ($i = 1; $i <= $supplier->lastPage(); $i++)
                        <li class="page-item {{ $supplier->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $supplier->url($i) }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    {{-- Next --}}
                    <li class="page-item {{ $supplier->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $supplier->nextPageUrl() ?? '#' }}">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>

                </ul>
            </nav>

        </div>
    </section>

@endsection
