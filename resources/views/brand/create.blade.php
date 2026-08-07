@extends('layouts.app')

@section('title', 'Tambah Brand - Sparepart Manager')
@section('page-title', 'Tambah Brand')

@section('content')

    <section class="card-surface">

        <div class="card-surface-header d-flex justify-content-between align-items-center">
            <h2 class="section-title mb-0">Tambah Kategori</h2>

            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
        </div>


        <form class="card-surface-body" action="{{ route('brand.store') }}" method="POST">

            @csrf

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">
                        Kode Brand
                    </label>
                    <input type="text" class="form-control form-control-pill" value="{{ $kodeBrand }}" disabled>

                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">
                        Nama Brand
                    </label>

                    <input type="text" class="form-control form-control-pill" name="nama_brand" placeholder="Aspira"
                        value="{{ old('nama_brand') }}">

                </div>

                <div class="col-md-6 col-lg-4 d-flex align-items-end pb-1">
                    <label class="d-flex align-items-center gap-3 mb-0">
                        <span class="text-uppercase small fw-semibold">Status Aktif</span>
                        <span class="toggle-switch-wrap">
                            <input type="checkbox" checked name="status_brand" value="aktif">
                            <span class="toggle-switch-slider"></span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-brand d-flex align-items-center gap-2 px-4">
                    <i class="bi bi-tags"></i>
                    Tambah Brand
                </button>
            </div>
        </form>
    </section>


@endsection
