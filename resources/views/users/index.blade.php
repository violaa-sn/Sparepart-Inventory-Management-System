@extends('layouts.app')

@section('title', 'Manajemen User - Sparepart Manager')
@section('page-title', 'Manajemen User')

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



    {{-- DAFTAR USER --}}
    <section class="card-surface">
        <div class="card-surface-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="section-title mb-0">Daftar Kategori</h3>
                <div class="d-flex align-items-center gap-2">

                    <a href="{{ route('users.trash') }}"
                        class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 px-3 js-disable-link">

                        <i class="bi bi-trash3"></i>

                        Trash User

                    </a>

                    <a class="btn btn-brand" data-bs-toggle="offcanvas" href="#tambahUser">
                        Tambah User
                    </a>
                </div>
            </div>
            <form method="GET" action="{{ route('users.index') }}">
                <div class="row g-3 mt-3">
                    <div class="col-md-8">
                        <div class="position-relative">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" class="form-control search-control-pill user-search-input ps-5"
                                name="search" value="{{ request('search') }}" placeholder="Cari kode atau nama user...">
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
                        <th style="width: 140px;">Kode User</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Dibuat Pada</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td class="table-code">{{ $user->kode_user }}</td>
                            <td class="fw-semibold"> {{ $user->nama_user }}</td>
                            <td class="text-muted"> {{ $user->email }}</td>
                            <td>
                                @if ($user->role == 'manager')
                                    <span class="badge-status badge-status-success">
                                        Manager
                                    </span>
                                @elseif($user->role == 'admin')
                                    <span class="badge-status badge-status-info">
                                        Admin
                                    </span>
                                @else
                                    <span class="badge-status badge-status-warning">
                                        Staff
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="d-flex align-items-center gap-2">
                                    <span
                                        class="user-status-dot {{ $user->status_user == 'aktif' ? 'user-status-dot-active' : 'user-status-dot-inactive' }}"></span>
                                    <span class="user-status-text">
                                        {{ ucfirst($user->status_user) }}
                                    </span>
                                </span>
                            </td>
                            <td class="text-muted">{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <a href="{{ route('users.show', $user) }}" type="button"
                                        class="action-icon-btn action-icon-view js-disable-link" title="Detail"><i
                                            class="bi bi-eye"></i></a>

                                    <a href="{{ route('users.edit', $user) }}" type="button"
                                        class="action-icon-btn action-icon-edit js-disable-link" title="Edit">
                                        <i class="bi bi-pencil"></i></a>

                                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-icon-btn action-icon-delete" title="Delete"
                                            onclick="return confirm('Hapus user ini?')"><i class="bi bi-trash"></i></button>
                                    </form>
                                    @if (auth()->id() != $user->id)
                                        <label class="toggle-switch-wrap toggle-sm">
                                            <input type="checkbox" class="js-user-status-toggle"
                                                data-id="{{ $user->id }}"
                                                onclick="return confirm('Yakin ingin mengubah status user ini?')"
                                                {{ $user->status_user == 'aktif' ? 'checked' : '' }}>

                                            <span class="toggle-switch-slider"></span>
                                        </label>
                                    @else
                                        <span class="badge bg-secondary">
                                            Akun Saya
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty

                        <tr>

                            <td colspan="8" class="text-center">

                                Belum ada data user.

                            </td>

                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-surface-header d-flex justify-content-between align-items-center border-top">

            <p class="small text-muted mb-0">
                Menampilkan
                {{ $users->firstItem() ?? 0 }}
                -
                {{ $users->lastItem() ?? 0 }}
                dari
                {{ $users->total() }}
                entri
            </p>

            <nav aria-label="Pagination daftar user">
                <ul class="pagination pagination-sm mb-0">

                    {{-- Previous --}}
                    <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $users->previousPageUrl() ?? '#' }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>

                    {{-- Nomor halaman --}}
                    @for ($i = 1; $i <= $users->lastPage(); $i++)
                        <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $users->url($i) }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    {{-- Next --}}
                    <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $users->nextPageUrl() ?? '#' }}">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>

                </ul>
            </nav>

        </div>

        {{-- off canvas tambah user --}}
        {{-- off canvas tambah user --}}
        {{-- off canvas tambah user --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="tambahUser">
            <div class="offcanvas-header">
                <div>
                    <h5 class="offcanvas-title">
                        Tambah User
                    </h5>

                    <small class="text-muted">
                        Tambahkan akun baru ke sistem.
                    </small>
                </div>

                <button class="btn-close" data-bs-dismiss="offcanvas">
                </button>

            </div>

            <div class="offcanvas-body">

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class=" mb-3">
                            <label class="form-label text-uppercase small fw-semibold">Kode User</label>
                            <input type="text" class="form-control form-control-pill" value="{{ $kodeUser }}"
                                disabled>

                        </div>

                        <div class=" mb-3">
                            <label class="form-label">Nama User</label>
                            <input type="text"
                                class="form-control form-control-pill @error('nama_user') is-invalid @enderror"
                                name="nama_user" value="{{ old('nama_user') }}">

                            @error('nama_user')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class=" mb-3 col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email"
                                class="form-control form-control-pill @error('email') is-invalid @enderror" name="email"
                                placeholder="nama@example.com" value="{{ old('email') }}">

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class=" mb-3 col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control form-control-pill" placeholder="0812345678"
                                name="nomor_telepon" value="{{ old('nomor_telepon') }}">
                        </div>

                        <div class="col-md-8 mb-4">
                            <label class="form-labely">Role Akses</label>
                            <select class="form-select form-select-pill" name="role">
                                <option value="manager">Manager</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="d-flex flex-column gap-2 pt-2">
                                <span class="text-uppercase small ">
                                    Status Aktif
                                </span>
                                <span class="toggle-switch-wrap">
                                    <input type="checkbox" checked name="status_user" value="aktif">
                                    <span class="toggle-switch-slider"></span>
                                </span>
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-uppercase small fw-semibold">
                                Password
                            </label>

                            <div class="input-icon-group">
                                <span class="material-symbols-outlined input-icon">
                                    lock
                                </span>

                                <input type="password"
                                    class="form-control form-control-pill input-with-icon input-with-icon-right"
                                    id="password" name="password" placeholder="Min. 8 karakter">

                                <button type="button" class="btn-toggle-password" data-target="password">

                                    <span class="material-symbols-outlined">
                                        visibility
                                    </span>

                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-uppercase small fw-semibold">
                                Konfirmasi Password
                            </label>

                            <div class="input-icon-group">

                                <span class="material-symbols-outlined input-icon">
                                    lock
                                </span>

                                <input type="password"
                                    class="form-control form-control-pill input-with-icon input-with-icon-right"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Ulangi password">

                                <button type="button" class="btn-toggle-password" data-target="password_confirmation">

                                    <span class="material-symbols-outlined">
                                        visibility
                                    </span>

                                </button>

                            </div>
                        </div>

                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-brand d-flex align-items-center gap-2 px-4">
                            <i class="bi bi-person-plus"></i>
                            Tambah User
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </section>

@endsection
