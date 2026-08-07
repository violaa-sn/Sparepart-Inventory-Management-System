    @extends('layouts.app')

    @section('title', 'Tambah Sparepart - Sparepart Manager')
    @section('page-title', 'Tambah Sparepart')

    @section('content')
        <form method="POST" action="{{ route('spareparts.store') }}">
            @csrf

            {{-- Satu card aja, info sparepart + supplier nyatu di dalamnya --}}
            <div class="card-surface mb-4">
                <div class="card-surface-header d-flex justify-content-between">
                    <h2 class="h5 mb-0">Tambah Sparepart</h2>

                    <a href="{{ route('spareparts.index') }}" class="btn btn-outline-secondary js-disable-link">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>

                <div class="card-surface-body">

                    {{-- ===================== BAGIAN INFORMASI SPAREPART (JANGAN DIUBAH) ===================== --}}
                    <div class="row g-4">

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Kode Sparepart</label>
                            <input type="text" class="form-control form-control-pill" value="{{ $kodeSparepart }}"
                                readonly>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Nama Sparepart <span class="text-danger">*</span></label>
                            <input type="text" name="nama_sparepart" placeholder="ex: Busi NGK" required
                                class="form-control form-control-pill @error('nama_sparepart') is-invalid @enderror"
                                value="{{ old('nama_sparepart') }}">
                            @error('nama_sparepart')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select form-select-pill" required>

                                <option value="">Pilih Kategori</option>

                                @forelse ($kategori as $item)
                                    <option value="{{ $item->id }}" @selected(old('kategori_id') == $item->id)>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @empty
                                    <option disabled>Belum ada kategori aktif</option>
                                @endforelse

                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Brand</label>
                            <select name="brand_id" class="form-select form-select-pill" required>

                                <option value="">Pilih Brand</option>

                                @forelse ($brand as $item)
                                    <option value="{{ $item->id }}" @selected(old('brand_id') == $item->id)>
                                        {{ $item->nama_brand }}
                                    </option>
                                @empty
                                    <option disabled>Belum ada brand aktif</option>
                                @endforelse

                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Unit Satuan <span class="text-danger">*</span></label>
                            <select name="unit_id" class="form-select form-select-pill" required>

                                <option value="">Pilih Unit</option>

                                @forelse ($unit as $item)
                                    <option value="{{ $item->id }}" @selected(old('unit_id') == $item->id)>
                                        {{ $item->nama_unit }}
                                    </option>
                                @empty
                                    <option disabled>Belum ada unit aktif</option>
                                @endforelse

                            </select>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <label class="form-label">Minimum Stok</label>
                            <input type="number" name="min_stok"
                                class="form-control form-control-pill @error('min_stok') is-invalid @enderror"
                                placeholder="0" min="0" value="{{ old('min_stok') }}">
                            @error('min_stok')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control form-control-pill @error('deskripsi') is-invalid @enderror"
                                rows="3" placeholder="Tambahkan deskripsi atau catatan mengenai sparepart ini">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                    {{-- ===================== BATAS BAGIAN INFORMASI SPAREPART ===================== --}}

                    <hr class="section-divider">

                    {{-- ===================== BAGIAN SUPPLIER SPAREPART (BARU) ===================== --}}
                    <h2 class="section-title">Supplier Sparepart</h2>

                    {{-- wadah semua baris supplier, JS bakal nambah/hapus baris di sini --}}
                    <div id="supplier-container" class="pt-4">

                        {{-- baris supplier pertama, index-nya 0 --}}
                        <div class="supplier-row">
                            {{-- untuk class js | biar pas tmbh supplier ada suplier 1, 2 dst --}}
                            <h6 class="fw-semibold mb-3 supplier-title">
                                Supplier 1
                            </h6>
                            <div class="row g-3 align-items-end">

                                <div class="col-12 col-md-5">
                                    <label class="form-label">Supplier</label>
                                    <select name="suppliers[0][supplier_id]"
                                        class="form-select form-select-pill select-supplier" required>

                                        <option value="">Pilih Supplier</option>

                                        @forelse ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" @selected(old('suppliers.0.supplier_id') == $supplier->id)>
                                                {{ $supplier->nama_supplier }}
                                            </option>
                                        @empty
                                            <option disabled>Belum ada supplier aktif</option>
                                        @endforelse

                                    </select>
                                </div>

                                <div class="col-12 col-md-5">
                                    <label class="form-label">Harga Beli (Rp)</label>
                                    <div class="input-group harga-beli-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="suppliers[0][harga_beli]"
                                            value="{{ old('suppliers.0.harga_beli') }}"
                                            class="form-control input-harga-beli" placeholder="0" min="0" required>
                                    </div>
                                </div>

                                <div class="col-12 col-md-2 d-flex justify-content-md-center">
                                    <button type="button" class="btn-hapus-supplier" disabled title="Hapus supplier">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>

                    {{-- tombol tambah baris supplier baru --}}
                    <div class="d-flex justify-content-end mt-3">

                        <button type="button" id="btn-tambah-supplier"
                            class="btn btn-primary d-flex align-items-center gap-2">

                            <i class="bi bi-plus-circle"></i>

                            Tambah Supplier

                        </button>

                    </div>
                    {{-- ===================== BATAS BAGIAN SUPPLIER SPAREPART ===================== --}}

                </div>
            </div>

            {{-- Tombol aksi bawah --}}
            <div class="d-flex justify-content-end gap-3">
                <button type="submit" class="btn btn-brand">Simpan Sparepart</button>
            </div>

        </form>

        {{-- sparepart.js udah otomatis kebawa lewat app.js, jadi ga perlu tag script manual di sini --}}

    @endsection
