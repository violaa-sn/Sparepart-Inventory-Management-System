@extends('layouts.app')

@section('title', 'Edit Supplier - Sparepart Manager')
@section('page-title', 'Edit Supplier')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <section class="card-surface">

        <div class="card-surface-header">

            <div class="d-flex justify-content-between align-items-center">

                <h2 class="section-title mb-0">
                    Edit Supplier
                </h2>

                <a href="{{ route('supplier.index') }}"
                    class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2 js-disable-link">

                    <i class="bi bi-arrow-left"></i>

                    Kembali

                </a>

            </div>

        </div>

        <form
            class="card-surface-body"
            action="{{ route('supplier.update', $supplier) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- Kode Supplier --}}
                <div class="col-md-6 col-lg-4">

                    <label class="form-label text-uppercase small fw-semibold">
                        Kode Supplier
                    </label>

                    <input
                        type="text"
                        class="form-control form-control-pill"
                        value="{{ $supplier->kode_supplier }}"
                        disabled>

                </div>

                {{-- Nama --}}
                <div class="col-md-6 col-lg-4">

                    <label class="form-label text-uppercase small fw-semibold">
                        Nama Supplier
                    </label>

                    <input
                        type="text"
                        name="nama_supplier"
                        class="form-control form-control-pill @error('nama_supplier') is-invalid @enderror"
                        value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                        placeholder="Nama Supplier">

                    @error('nama_supplier')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Alamat --}}
                <div class="col-md-6 col-lg-4">

                    <label class="form-label text-uppercase small fw-semibold">
                        Alamat
                    </label>

                    <input
                        type="text"
                        name="alamat"
                        class="form-control form-control-pill @error('alamat') is-invalid @enderror"
                        value="{{ old('alamat', $supplier->alamat) }}"
                        placeholder="Alamat">

                    @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- No Telp --}}
                <div class="col-md-6 col-lg-4">

                    <label class="form-label text-uppercase small fw-semibold">
                        Nomor Telepon
                    </label>

                    <input
                        type="text"
                        name="notlp"
                        class="form-control form-control-pill @error('notlp') is-invalid @enderror"
                        value="{{ old('notlp', $supplier->notlp) }}"
                        placeholder="08123456789">

                    @error('notlp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Email --}}
                <div class="col-md-6 col-lg-4">

                    <label class="form-label text-uppercase small fw-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control form-control-pill @error('email') is-invalid @enderror"
                        value="{{ old('email', $supplier->email) }}"
                        placeholder="supplier@email.com">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- Status --}}
                <div class="col-md-6 col-lg-4 d-flex align-items-end pb-1">

                    <label class="d-flex align-items-center gap-3 mb-0">

                        <span class="text-uppercase small fw-semibold">
                            Status Aktif
                        </span>

                        <span class="toggle-switch-wrap">

                            <input
                                type="checkbox"
                                name="status_supplier"
                                value="aktif"
                                {{ old('status_supplier', $supplier->status_supplier) == 'aktif' ? 'checked' : '' }}>

                            <span class="toggle-switch-slider"></span>

                        </span>

                    </label>

                </div>

            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">

                <a
                    href="{{ route('supplier.index') }}"
                    class="btn btn-outline-secondary js-disable-link">

                    Batal

                </a>

                <button
                    type="submit"
                    class="btn btn-warning d-flex align-items-center gap-2 px-4">

                    <i class="bi bi-check-circle"></i>

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </section>

@endsection