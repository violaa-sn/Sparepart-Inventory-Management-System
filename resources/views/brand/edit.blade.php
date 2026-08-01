@extends('layouts.app')

@section('title', 'Edit Brand - Sparepart Manager')
@section('page-title', 'Edit Brand')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <section class="card-surface">
                <div class="card-surface-header d-flex justify-content-between align-items-center">
                    <h2 class="section-title mb-0">Edit Brand</h2>

                    <a href="{{ route('brand.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>

                <form class="card-surface-body" action="{{ route('brand.update', $brand) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-md-6 col-lg-4">
                            <label class="form-label text-uppercase small">
                                Kode Brand
                            </label>

                            <input type="text" class="form-control form-control-pill" value="{{ $brand->kode_brand }}"
                                disabled>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="form-label text-uppercase small fw-semibold">
                                Nama Brand
                            </label>

                            <input type="text" class="form-control form-control-pill" name="nama_brand"
                                value="{{ old('nama_brand', $brand->nama_brand) }}">
                        </div>

                        <div class="col-md-6 col-lg-4 d-flex align-items-end pb-1">
                            <label class="d-flex align-items-center gap-3 mb-0">

                                <span class="text-uppercase small fw-semibold">
                                    Status Aktif
                                </span>

                                <span class="toggle-switch-wrap">
                                    <input type="checkbox" name="status_brand" value="aktif"
                                        {{ old('status_brand', $brand->status_brand) == 'aktif' ? 'checked' : '' }}>

                                    <span class="toggle-switch-slider"></span>
                                </span>

                            </label>
                        </div>

                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">

                        <a href="{{ route('brand.index') }}" class="btn btn-outline-danger px-4">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-edit d-flex align-items-center gap-2 px-4">

                            <i class="bi bi-check-circle"></i>
                            Simpan Perubahan

                        </button>

                    </div>

                </form>
            </section>

        </div>
    </div>

@endsection
