@extends('layouts.app')

@section('title', 'Tambah Barang Masuk - Sparepart Manager')
@section('page-title', 'Tambah Barang Masuk')

@section('content')


    <form method="POST" action="{{ route('transaksi.barang-masuk.store') }}" id="form-barang-masuk">
        @csrf

        {{-- ===================== CARD 1: INFORMASI TRANSAKSI ===================== --}}
        <div class="card-surface mb-4">
            <div class="card-surface-header">
                <div class="d-flex justify-content-between align-items-center">

                    <h2 class="h5 mb-0">Transaksi Barang Masuk</h2>
                    <a href="{{ route('transaksi.barang-masuk') }}"
                        class="btn btn-outline-secondary d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-surface-body">
                <div class="row g-4">

                    <div class="col-12 col-md-6">
                        <label class="form-label">Kode Transaksi</label>
                        <input type="text" class="form-control form-control-pill" value="Otomatis oleh sistem" readonly>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="tanggal_transaksi" class="form-control form-control-pill"
                            required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Supplier <span class="text-danger">*</span></label>
                        <select name="supplier_id" id="supplier-select" class="form-select form-select-pill" required>
                            <option value="">Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Catatan <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="text" name="catatan" class="form-control form-control-pill"
                            placeholder="Tambahkan catatan...">
                    </div>

                </div>
            </div>
        </div>

        {{-- ===================== CARD 2: TAMBAH SPAREPART ===================== --}}
        <div class="card-surface mb-4">
            <div class="card-surface-header">
                <h2 class="h5 mb-0">Tambah Sparepart</h2>
            </div>
            <div class="card-surface-body">

                {{-- pesan validasi kecil, dipakai JS, defaultnya disembunyikan --}}
                <div class="alert alert-danger d-none" id="pesan-error-item" role="alert"></div>

                <div class="mb-4">
                    <label class="form-label">Cari Sparepart</label>
                    <select id="sparepart-select" class="form-select form-select-pill" disabled>
                        <option value="">Pilih supplier dulu...</option>
                    </select>
                </div>

                <div class="row g-4 align-items-end">
                    <div class="col-6 col-md-3">
                        <label class="form-label">Stok Saat Ini</label>
                        <input type="text" id="stok-saat-ini" class="form-control form-control-pill text-end" readonly
                            placeholder="-">
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label">Harga Supplier</label>
                        <input type="text" id="harga-supplier" class="form-control form-control-pill text-end" readonly
                            placeholder="-">
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label">Harga Perunit</label>
                        <input type="number" id="harga-perunit" class="form-control form-control-pill text-end"
                            placeholder="-">
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label">Qty Masuk</label>
                        <input type="number" id="qty-masuk" class="form-control form-control-pill text-end" min="1"
                            placeholder="0">
                    </div>

                    <div class="col-6 col-md-3">
                        <label class="form-label d-block text-end">Subtotal</label>
                        <p class="fs-5 fw-semibold text-end mb-0" id="subtotal-preview">Rp 0</p>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" id="btn-tambah-item" class="btn btn-brand d-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg"></i> Tambah Item
                    </button>
                </div>

            </div>
        </div>

        {{-- ===================== CARD 3: DAFTAR ITEM ===================== --}}
        <div class="card-surface mb-4">
            <div class="card-surface-header">
                <h2 class="h5 mb-0">Daftar Item</h2>
            </div>

            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 56px;">No</th>
                            <th>Kode Sparepart</th>
                            <th>Nama Sparepart</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-center" style="width: 64px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-daftar-item">
                        {{-- baris item ditambahin lewat JS, awalnya kosong --}}
                        <tr id="baris-kosong">
                            <td colspan="7" class="text-center text-muted py-4">Belum ada item ditambahkan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- wadah hidden input, bakal diisi JS tiap ada item baru --}}
            <div id="hidden-input-item"></div>

            {{-- Ringkasan total --}}
            <div class="card-surface-footer d-flex justify-content-end">
                <div class="transaction-summary">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Total Item</span>
                        <span class="fw-medium" id="ringkasan-total-item">0 Jenis</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Total Qty</span>
                        <span class="fw-medium" id="ringkasan-total-qty">0 pcs</span>
                    </div>
                    <div class="d-flex justify-content-between pt-2 border-top">
                        <span class="text-muted small text-uppercase fw-semibold">Grand Total</span>
                        <span class="fw-bold text-brand" id="ringkasan-grand-total">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol aksi bawah --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('transaksi.barang-masuk') }}" class="btn btn-outline-secondary">
                Batal
            </a>

            <button type="submit" class="btn btn-brand">
                Simpan Transaksi
            </button>
        </div>

    </form>

@endsection
