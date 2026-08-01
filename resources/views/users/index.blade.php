@extends('layouts.app')

@section('title', 'Manajemen User - Sparepart Manager')
@section('page-title', 'Manajemen User')

@section('content')

    {{-- FORM TAMBAH USER --}}
    <section class="card-surface">
        <div class="card-surface-header">
            <h2 class="section-title">Tambah User Baru</h2>
        </div>

        <form class="card-surface-body" action="#" method="POST">
            {{-- @csrf, nanti aktifin lagi kalau form udah diarahin ke controller --}}
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">Kode User</label>
                    <input type="text" class="form-control form-control-pill" placeholder="Contoh: Budi Santoso">
                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">Nama User</label>
                    <input type="text" class="form-control form-control-pill" placeholder="Contoh: Budi Santoso">
                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">Email</label>
                    <input type="email" class="form-control form-control-pill" placeholder="budi@example.com">
                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">Role Akses</label>
                    <select class="form-select form-select-pill">
                        <option value="manager">Manager</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">Password</label>
                    <input type="password" class="form-control form-control-pill" placeholder="Min. 8 karakter">
                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">Konfirmasi Password</label>
                    <input type="password" class="form-control form-control-pill" placeholder="Ulangi password">
                </div>

                <div class="col-md-6 col-lg-4 d-flex align-items-end pb-1">
                    <label class="d-flex align-items-center gap-3 mb-0">
                        <span class="text-uppercase small fw-semibold">Status Aktif</span>
                        <span class="toggle-switch-wrap">
                            <input type="checkbox" checked>
                            <span class="toggle-switch-slider"></span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <a type="submit" class="btn btn-brand d-flex align-items-center gap-2 px-4">
                    <i class="bi bi-person-plus"></i>
                    Tambah User
                </a>
            </div>
        </form>
    </section>

    {{-- DAFTAR USER --}}
    <section class="card-surface">
        <div class="card-surface-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="section-title mb-0">Daftar User</h3>
                <a href="#" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 px-3">
                    <i class="bi bi-trash3"></i>
                    Trash User
                </a>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-8">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" class="form-control search-control-pill user-search-input ps-5"
                            placeholder="Cari nama atau email...">
                    </div>
                </div>

                <div class="col-md-4">
                    <select class="form-select form-select-table-pill user-search-input">
                        <option>Semua Role</option>
                        <option>Manager</option>
                        <option>Admin</option>
                        <option>Staff</option>
                    </select>
                </div>
            </div>
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
                    <tr>
                        <td>1</td>
                        <td class="table-code">USR-2024-001</td>
                        <td class="fw-semibold">Alex Thompson</td>
                        <td class="text-muted">alex.t@sparepart.id</td>
                        <td><span class="badge-status badge-status-success">Manager</span></td>
                        <td>
                            <span class="d-flex align-items-center gap-2">
                                <span class="user-status-dot user-status-dot-active"></span>
                                <span class="user-status-text">Aktif</span>
                            </span>
                        </td>
                        <td class="text-muted">12 Jan 2024</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <button type="button" class="action-icon-btn action-icon-view" title="Detail"><i
                                        class="bi bi-eye"></i></button>
                                <button type="button" class="action-icon-btn action-icon-edit" title="Edit"><i
                                        class="bi bi-pencil"></i></button>
                                <button type="button" class="action-icon-btn action-icon-delete" title="Delete"><i
                                        class="bi bi-trash"></i></button>
                                <span class="toggle-switch-wrap toggle-sm">
                                    <input type="checkbox" class="js-user-status-toggle" checked>
                                    <span class="toggle-switch-slider"></span>
                                </span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td class="user-code">USR-2024-002</td>
                        <td class="fw-semibold">Sarah Connor</td>
                        <td class="text-muted">sarah.c@sparepart.id</td>
                        <td><span class="badge-status badge-status-info">Admin</span></td>
                        <td>
                            <span class="d-flex align-items-center gap-2">
                                <span class="user-status-dot user-status-dot-active"></span>
                                <span class="user-status-text">Aktif</span>
                            </span>
                        </td>
                        <td class="text-muted">15 Jan 2024</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <button type="button" class="action-icon-btn action-icon-view" title="Detail"><i
                                        class="bi bi-eye"></i></button>
                                <button type="button" class="action-icon-btn action-icon-edit" title="Edit"><i
                                        class="bi bi-pencil"></i></button>
                                <button type="button" class="action-icon-btn action-icon-delete" title="Delete"><i
                                        class="bi bi-trash"></i></button>
                                <span class="toggle-switch-wrap toggle-sm">
                                    <input type="checkbox" class="js-user-status-toggle" checked>
                                    <span class="toggle-switch-slider"></span>
                                </span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td class="user-code">USR-2024-003</td>
                        <td class="fw-semibold">Michael Scott</td>
                        <td class="text-muted">michael.s@sparepart.id</td>
                        <td><span class="badge-status badge-status-warning">Staff</span></td>
                        <td>
                            <span class="d-flex align-items-center gap-2">
                                <span class="user-status-dot user-status-dot-inactive"></span>
                                <span class="user-status-text">Nonaktif</span>
                            </span>
                        </td>
                        <td class="text-muted">20 Jan 2024</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <button type="button" class="action-icon-btn action-icon-view" title="Detail"><i
                                        class="bi bi-eye"></i></button>
                                <button type="button" class="action-icon-btn action-icon-edit" title="Edit"><i
                                        class="bi bi-pencil"></i></button>
                                <button type="button" class="action-icon-btn action-icon-delete" title="Delete"><i
                                        class="bi bi-trash"></i></button>
                                <span class="toggle-switch-wrap toggle-sm">
                                    <input type="checkbox" class="js-user-status-toggle">
                                    <span class="toggle-switch-slider"></span>
                                </span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-surface-header d-flex justify-content-between align-items-center border-top">
            <p class="small text-muted mb-0">Menampilkan 1 - 3 dari 4 entri</p>
            <nav aria-label="Pagination daftar user">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>

@endsection
