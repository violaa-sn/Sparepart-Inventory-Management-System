@extends('layouts.app')

@section('title', 'Manajemen kategori - Sparepart Manager')
@section('page-title', 'Daftar Kategori')

@section('content')

    <section class="card-surface">
        <div class="card-surface-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="section-title mb-0">Daftar Kategori</h3>
                <div class="d-flex align-items-center gap-2">
                    <a href="#" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 px-3">
                        <i class="bi bi-trash3"></i>
                        Trash Kategori
                    </a>
                    <a href="#" class="btn btn-brand btn-sm d-flex align-items-center gap-2 px-3">
                        <i class="bi bi-person-plus"></i>
                        Tambah Kategori
                    </a>
                </div>
            </div>
            <div class="row g-3 mt-3">
                <div class="col-md-8">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" class="form-control search-control-pill user-search-input ps-5"
                            placeholder="Cari kode kategori atau nama kategori...">
                    </div>
                </div>

                <div class="col-md-4">
                    <select class="form-select form-select-table-pill user-search-input">
                        <option>Semua status</option>
                        <option>Aktif</option>
                        <option>Nonaktif</option>
                    </select>
                </div>
            </div>
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
                    <tr>
                        <td>1</td>
                        <td class="table-code">KAT-0001</td>
                        <td class="fw-semibold">Filter</td>
                        <td class="text-muted">30</td>
                        <td>
                            <span class="d-flex align-items-center gap-2">
                                <span class="user-status-dot user-status-dot-active"></span>
                                <span class="user-status-text">Aktif</span>
                            </span>
                        </td>
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
                        <td>1</td>
                        <td class="table-code">KAT-0001</td>
                        <td class="fw-semibold">Filter</td>
                        <td class="text-muted">30</td>
                        <td>
                            <span class="d-flex align-items-center gap-2">
                                <span class="user-status-dot user-status-dot-active"></span>
                                <span class="user-status-text">Aktif</span>
                            </span>
                        </td>
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
