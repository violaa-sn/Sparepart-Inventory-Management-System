@extends('layouts.app')

@section('title', 'Barang Masuk')
@section('page-title', 'Barang Masuk')

@section('content')

    <div class="card-surface">
        <div class="card-surface-header">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="section-title mb-0">
                    Daftar Barang Masuk
                </h3>

                <a href="{{ route('transaksi.barang-masuk.create') }}"
                    class="btn btn-brand btn-sm d-flex align-items-center gap-2 px-3">

                    <i class="bi bi-plus-circle"></i>

                    Tambah Barang Masuk

                </a>

            </div>

            {{-- ===================== FILTER ===================== --}}
            <div class="card-surface-body pb-0">
                <form method="GET" action="{{ route('transaksi.barang-masuk') }}">

                    <div class="row g-3 mt-3">

                        <div class="col-md-4">

                            <div class="position-relative">

                                <i
                                    class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                                <input type="text" name="search"
                                    class="form-control search-control-pill user-search-input ps-5"
                                    placeholder="Cari kode transaksi, supplier..." value="{{ request('search') }}">

                            </div>

                        </div>

                        <div class="col-md-2">

                            <select class="form-select form-select-table-pill user-search-input" name="status">

                                <option value="">Semua Status</option>

                                <option value="selesai">
                                    Selesai
                                </option>

                                <option value="dibatalkan">
                                    Dibatalkan
                                </option>

                            </select>

                        </div>

                        <div class="col-md-2">

                            <input type="date" name="tanggal_awal" class="form-control form-control-pill">

                        </div>

                        <div class="col-md-2">

                            <input type="date" name="tanggal_akhir" class="form-control form-control-pill">

                        </div>

                        <div class="col-md-2 d-flex align-items-center gap-2">

                            <a href="{{ route('transaksi.barang-masuk') }}" class="btn btn-outline-secondary">Reset</a>

                            <button class="btn btn-warning w-100">

                                Terapkan

                            </button>

                        </div>

                    </div>

                </form>
            </div>

            {{-- ===================== TABEL ===================== --}}
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0 mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Supplier</th>
                            <th class="text-end">Total Item</th>
                            <th class="text-end">Total Qty</th>
                            <th>Tanggal</th>
                            <th>User</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $transaksi)
                            <tr>
                                <td>
                                    {{ $transaksis->firstItem() + $loop->index }}
                                </td>
                                <td class="fw-semibold text-brand">{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ $transaksi->supplier->nama_supplier ?? '-' }}</td>
                                <td class="text-end">{{ $transaksi->details->count() }}</td>
                                <td class="text-end">{{ number_format($transaksi->details->sum('qty')) }}</td>
                                <td class="text-muted">{{ $transaksi->tanggal_transaksi }}</td>
                                <td>{{ $transaksi->user->nama_user }}</td>
                                <td class="text-center">
                                    @if ($transaksi->status_transaksi == 'selesai')
                                        <span class="badge-status badge-status-success">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="badge-status badge-status-danger">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-3">

                                        <a href="{{ route('transaksi.barang-masuk.show', $transaksi) }}"
                                            class="action-icon-btn action-icon-view" title="Detail">

                                            <i class="bi bi-eye"></i>

                                        </a>
                                        @if ($transaksi->status_transaksi == 'selesai')
                                            <form action="{{ route('transaksi.barang-masuk.cancel', $transaksi) }}" method="POST"
                                                onsubmit="return confirm('Batalkan transaksi ini?')">

                                                @csrf
                                                @method('PATCH')

                                                <button class="btn btn-sm btn-danger">
                                                    Batalkan
                                                </button>

                                            </form>
                                        @endif
                                        </form>
                                    </div>
                                </td>

                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    Belum ada transaksi barang masuk.
                                </td>
                            </tr>

                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-surface-header d-flex justify-content-between align-items-center border-top">

                <p class="small text-muted mb-0">

                    Menampilkan

                    {{ $transaksis->firstItem() ?? 0 }}

                    -

                    {{ $transaksis->lastItem() ?? 0 }}

                    dari

                    {{ $transaksis->total() }}

                    transaksi

                </p>

                {{ $transaksis->links() }}

            </div>

        </div>

    @endsection
