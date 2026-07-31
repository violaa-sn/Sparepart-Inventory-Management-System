@extends('layouts.app')

@section('title', 'Tambah Sparepart - Sparepart Manager')
@section('page-title', 'Tambah Sparepart')

@section('content')

<section class="card-surface">

    <div class="card-surface-header">
        <h2 class="section-title">Tambah Sparepart Baru</h2>
    </div>

    <form class="card-surface-body" action="{{ route('spareparts.store') }}" method="POST">

        @csrf

        <div class="row g-4">

            <div class="col-md-6 col-lg-4">
                <label class="form-label text-uppercase small fw-semibold">
                    Kode Sparepart
                </label>

                <input type="text"
                    class="form-control form-control-pill"
                    value="{{ $kodeSparepart }}"
                    disabled>
            </div>


            <div class="col-md-6 col-lg-4">
                <label class="form-label text-uppercase small fw-semibold">
                    Nama Sparepart
                </label>

                <input type="text"
                    class="form-control form-control-pill"
                    name="nama_sparepart"
                    placeholder="Contoh: Filter Udara"
                    value="{{ old('nama_sparepart') }}">
            </div>


            <div class="col-md-6 col-lg-4">
                <label class="form-label text-uppercase small fw-semibold">
                    Kategori
                </label>

                <select class="form-select form-select-pill"
                    name="kategori_id">

                    <option value="">
                        Pilih Kategori
                    </option>

                    @foreach($kategori as $item)

                    <option value="{{ $item->id }}"
                        @selected(old('kategori_id') == $item->id)>

                        {{ $item->nama_kategori }}

                    </option>

                    @endforeach

                </select>
            </div>


            <div class="col-md-6 col-lg-4">
                <label class="form-label text-uppercase small fw-semibold">
                    Brand
                </label>

                <select class="form-select form-select-pill"
                    name="brand_id">

                    <option value="">
                        Pilih Brand
                    </option>

                    @foreach($brand as $item)

                    <option value="{{ $item->id }}"
                        @selected(old('brand_id') == $item->id)>

                        {{ $item->nama_brand }}

                    </option>

                    @endforeach

                </select>
            </div>


            <div class="col-md-6 col-lg-4">
                <label class="form-label text-uppercase small fw-semibold">
                    Unit
                </label>

                <select class="form-select form-select-pill"
                    name="unit_id">

                    <option value="">
                        Pilih Unit
                    </option>

                    @foreach($unit as $item)

                    <option value="{{ $item->id }}"
                        @selected(old('unit_id') == $item->id)>

                        {{ $item->nama_unit }}

                    </option>

                    @endforeach

                </select>
            </div>


            <div class="col-md-6 col-lg-4">
                <label class="form-label text-uppercase small fw-semibold">
                    Minimum Stok
                </label>

                <input type="number"
                    class="form-control form-control-pill"
                    name="min_stok"
                    placeholder="Contoh: 10"
                    value="{{ old('min_stok') }}">
            </div>


            <div class="col-12">

                <label class="form-label text-uppercase small fw-semibold">
                    Deskripsi
                </label>

                <textarea class="form-control form-control-pill"
                    name="deskripsi"
                    rows="3"
                    placeholder="Tambahkan deskripsi sparepart (opsional)">{{ old('deskripsi') }}</textarea>

            </div>

        </div>


        <div class="mt-4 d-flex justify-content-end">

            <button type="submit"
                class="btn btn-brand d-flex align-items-center gap-2 px-4">

                <i class="bi bi-box-seam"></i>

                Tambah Sparepart

            </button>

        </div>

    </form>

</section>

@endsection