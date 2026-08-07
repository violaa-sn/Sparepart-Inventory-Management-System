@extends('layouts.app')

@section('title', 'Manajemen Supplier - Sparepart Manager')
@section('page-title', 'Manajemen Supplier')

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
                <h3 class="section-title mb-0">Daftar Supplier</h3>
                <div class="d-flex align-items-center gap-2">

                    <a href="{{ route('supplier.trash') }}"
                        class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 px-3 js-disable-link">

                        <i class="bi bi-trash3"></i>

                        Trash Supplier

                    </a>

                    <a class="btn btn-brand" data-bs-toggle="offcanvas" href="#tambahSupplier">
                        Tambah Supplier
                    </a>
                </div>
            </div>
            <form method="GET" action="{{ route('supplier.index') }}">
                <div class="row g-3 mt-3">
                    <div class="col-md-8">
                        <div class="position-relative">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" class="form-control search-control-pill user-search-input ps-5"
                                name="search" value="{{ request('search') }}"
                                placeholder="Cari kode atau nama supplier...">
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

                                    <a href="{{ route('supplier.edit', $item) }}" type="button"
                                        class="action-icon-btn action-icon-edit js-disable-link" title="Edit">
                                        <i class="bi bi-pencil"></i></a>

                                    <form action="{{ route('supplier.destroy', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-icon-btn action-icon-delete" title="Delete"
                                            onclick="return confirm('Hapus supplier ini?')"><i
                                                class="bi bi-trash"></i></button>
                                    </form>
                                    <label class="toggle-switch-wrap toggle-sm">
                                        <input type="checkbox" class="js-supplier-status-toggle" onclick="return confirm('Yakin ingin mengubah status supplier?')"
                                            data-id="{{ $item->id }}"
                                            {{ $item->status_supplier == 'aktif' ? 'checked' : '' }}>

                                        <span class="toggle-switch-slider"></span>
                                    </label>
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

        <div class="offcanvas offcanvas-end" tabindex="-1" id="tambahSupplier">
            <div class="offcanvas-header">
                <div>
                    <h5 class="offcanvas-title">
                        Tambah Supplier
                    </h5>

                    <small class="text-muted">
                        Tambahkan supplier baru ke sistem.
                    </small>
                </div>

                <button class="btn-close" data-bs-dismiss="offcanvas">
                </button>

            </div>

            <div class="offcanvas-body">

                <form action="{{ route('supplier.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class=" mb-3">
                            <label class="form-label text-uppercase small fw-semibold">Kode Supplier</label>
                            <input type="text" class="form-control form-control-pill" value="{{ $kodeSupplier }}"
                                disabled>

                        </div>

                        <div class=" mb-3">
                            <label class="form-label">Nama Supplier</label>
                            <input type="text" placeholder="Sparepartbali"
                                class="form-control form-control-pill @error('nama_supplier') is-invalid @enderror"
                                name="nama_supplier" value="{{ old('nama_supplier') }}">

                            @error('nama_supplier')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class=" mb-3 col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email"
                                class="form-control form-control-pill @error('email') is-invalid @enderror" name="email"
                                placeholder="Sparepartbali@gmail.com" value="{{ old('email') }}">

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class=" mb-3 col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text"
                                class="form-control form-control-pill @error('email') is-invalid @enderror""
                                placeholder="maksimal 13 karakter" name="notlp" value="{{ old('notlp') }}">

                            @error('notlp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12 col-lg-12">
                            <label class="form-label text-uppercase small fw-semibold">Alamat</label>
                            <input type="text"
                                class="form-control form-control-pill  @error('alamat') is-invalid @enderror"
                                placeholder="Jl. Raya Kerobokan No. 88, Banjar Taman" name="alamat"
                                value="{{ old('alamat') }}">

                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                    </div>

                    <div class="mt-4 d-flex justify-content-between align-items-center">

                        {{-- Toggle --}}
                        <label class="d-flex align-items-center gap-3 mb-0">
                            <span class="text-uppercase small fw-semibold">
                                Status Aktif
                            </span>

                            <span class="toggle-switch-wrap">
                                <input type="checkbox" checked name="status_supplier" value="aktif">
                                <span class="toggle-switch-slider"></span>
                            </span>
                        </label>

                        {{-- Tombol --}}
                        <button type="submit" class="btn btn-brand d-flex align-items-center gap-2 px-4">
                            <i class="bi bi-person-plus"></i>
                            Tambah Supplier
                        </button>

                    </div>
                </form>

            </div>

        </div>
    </section>

@endsection
