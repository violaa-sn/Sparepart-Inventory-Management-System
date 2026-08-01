@extends('layouts.app')

@section('title', 'Manajemen kategori - Sparepart Manager')
@section('page-title', 'Tambah Kategori')

@section('content')

    <section class="card-surface">
        <div class="card-surface-header">
            <h2 class="section-title">Tambah Kategori Baru</h2>
        </div>

        <form class="card-surface-body" action="#" method="POST">
            {{-- @csrf, nanti aktifin lagi kalau form udah diarahin ke controller --}}
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">Nama Kategori</label>
                    <input type="text" class="form-control form-control-pill" placeholder="Filter Udara">
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
                    Tambah Kategori
                </a>
            </div>
        </form>
    </section>

@endsection