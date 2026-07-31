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


    {{-- FORM TAMBAH USER --}}
    <section class="card-surface">
        <div class="card-surface-header">
            <h2 class="section-title">Tambah User Baru</h2>
        </div>

        <form class="card-surface-body" action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small">Kode User</label>
                    <input type="text" class="form-control form-control-pill" value="{{ $kodeUser }}" disabled>

                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">Nama User</label>
                    <input type="text" class="form-control form-control-pill" placeholder="nama" name="nama_user @error('nama_user') is-invalid @enderror"
                        value="{{ old('nama_user') }}">

                        @error('nama_user')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">Email</label>
                    <input type="email" class="form-control form-control-pill" placeholder="nama@example.com @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}">

                @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">Nomor Telepon</label>
                    <input type="text" class="form-control form-control-pill" placeholder="0812345678"
                        name="nomor_telepon" value="{{ old('nomor_telepon') }}">
                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">Role Akses</label>
                    <select class="form-select form-select-pill" name="role">
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">
                        Password
                    </label>

                    <div class="input-icon-group">
                        <span class="material-symbols-outlined input-icon">
                            lock
                        </span>

                        <input type="password" class="form-control form-control-pill input-with-icon input-with-icon-right"
                            id="password" name="password" placeholder="Min. 8 karakter">

                        <button type="button" class="btn-toggle-password" data-target="password">

                            <span class="material-symbols-outlined">
                                visibility
                            </span>

                        </button>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">
                        Konfirmasi Password
                    </label>

                    <div class="input-icon-group">

                        <span class="material-symbols-outlined input-icon">
                            lock
                        </span>

                        <input type="password" class="form-control form-control-pill input-with-icon input-with-icon-right"
                            id="password_confirmation" name="password_confirmation" placeholder="Ulangi password">

                        <button type="button" class="btn-toggle-password" data-target="password_confirmation">

                            <span class="material-symbols-outlined">
                                visibility
                            </span>

                        </button>

                    </div>
                </div>

                <div class="col-md-6 col-lg-4 d-flex align-items-end pb-1">
                    <label class="d-flex align-items-center gap-3 mb-0">
                        <span class="text-uppercase small fw-semibold">Status Aktif</span>
                        <span class="toggle-switch-wrap">
                            <input type="checkbox" checked name="status_user" value="aktif">
                            <span class="toggle-switch-slider"></span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-brand d-flex align-items-center gap-2 px-4">
                    <i class="bi bi-person-plus"></i>
                    Tambah User
                </button>
            </div>
        </form>
    </section>

    {{-- DAFTAR USER --}}
    <section class="card-surface">
        <div class="card-surface-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="section-title mb-0">Daftar User</h3>
                <button href="{{ route('users.trash') }}"
                    class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 px-3">
                    <i class="bi bi-trash3"></i>
                    Trash User
                </button>
            </div>
            <form method="GET" action="{{ route('users.index') }}">
                <div class="row g-3 mt-3">
                    <div class="col-md-8">
                        <div class="position-relative">
                            <i
                                class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" class="form-control search-control-pill user-search-input ps-5"
                                placeholder="Cari nama atau email..." name="search" value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <select class="form-select form-select-table-pill user-search-input" name="role"
                            onchange="this.form.submit()">

                            <option value="">Semua Role</option>

                            <option value="manager" @selected(request('role') == 'manager')>

                                Manager

                            </option>

                            <option value="admin" @selected(request('role') == 'admin')>

                                Admin

                            </option>

                            <option value="staff" @selected(request('role') == 'staff')>

                                Staff

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
                                        class="action-icon-btn action-icon-view" title="Detail"><i
                                            class="bi bi-eye"></i></a>

                                    <a href="{{ route('users.edit', $user) }}" type="button"
                                        class="action-icon-btn action-icon-edit" title="Edit">
                                        <i class="bi bi-pencil"></i></a>

                                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="action-icon-btn action-icon-delete" title="Delete"
                                            onclick="return confirm('Hapus user ini?')"><i
                                                class="bi bi-trash"></i></button>
                                    </form>
                                    <label class="toggle-switch-wrap toggle-sm">
                                        <input type="checkbox" class="js-user-status-toggle"
                                            data-id="{{ $user->id }}"
                                            {{ $user->status_user == 'aktif' ? 'checked' : '' }}>

                                        <span class="toggle-switch-slider"></span>
                                    </label>
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
    </section>

@endsection
