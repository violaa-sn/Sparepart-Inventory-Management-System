@extends('layouts.app')

@section('title', 'Tambah Kategori - Sparepart Manager')
@section('page-title', 'Tambah Kategori')

@section('content')

    <section class="card-surface">

        <div class="card-surface-header">
            <h2 class="section-title">
                Tambah Kategori Baru
            </h2>
        </div>


        <form class="card-surface-body" action="{{ route('kategori.store') }}" method="POST">

            @csrf

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">
                        Kode Kategori
                    </label>
                    <input type="text" class="form-control form-control-pill" value="{{ $kodeKategori }}" disabled>

                </div>

                <div class="col-md-6 col-lg-4">
                    <label class="form-label text-uppercase small fw-semibold">
                        Nama Kategori
                    </label>

                    <input type="text" class="form-control form-control-pill" name="nama_kategori"
                        placeholder="Filter Udara" value="{{ old('nama_kategori') }}">

                </div>

                <div class="col-md-6 col-lg-4 d-flex align-items-end pb-1">
                    <label class="d-flex align-items-center gap-3 mb-0">
                        <span class="text-uppercase small fw-semibold">Status Aktif</span>
                        <span class="toggle-switch-wrap">
                            <input type="checkbox" checked name="status_kategori" value="aktif">
                            <span class="toggle-switch-slider"></span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-brand d-flex align-items-center gap-2 px-4">
                    <i class="bi bi-tags"></i>
                    Tambah Kategori
                </button>
            </div>
        </form>
    </section>


@endsection
