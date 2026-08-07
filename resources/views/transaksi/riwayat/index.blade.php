@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')

    <div class="card-surface">
        <div class="card-surface-header">

            {{-- ===== JUDUL ===== --}}
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="section-title mb-0">Riwayat Transaksi</h3>
            </div>

            {{-- ===== FILTER ===== --}}
            {{--
                Layout filter:
                - Desktop (lg+)  : semua dalam 1 baris   [Search][Status][Tgl Awal][Tgl Akhir][Aksi]
                - Tablet (md/768): baris 1 → Search + Status
                                   baris 2 → Tgl Awal + Tgl Akhir + Aksi
            --}}
            <div class="card-surface-body pb-0">
                <form method="GET" action="{{ route('transaksi.riwayat') }}">
                    <div class="row g-2 mt-3 align-items-center">

                        {{-- Search --}}
                        <div class="col-7 col-md-7 col-lg-4 mb-2">
                            <div class="position-relative">
                                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                <input type="text" name="search"
                                    class="form-control search-control-pill user-search-input ps-5"
                                    placeholder="Cari kode transaksi, supplier..."
                                    value="{{ request('search') }}">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-5 col-md-5 col-lg-2 mb-2">
                            <select class="form-select form-select-table-pill user-search-input"
                                name="status" onchange="this.form.submit()">
                                <option value=""            @selected(request('status') == '')>Semua Status</option>
                                <option value="selesai"    @selected(request('status') == 'selesai')>Selesai</option>
                                <option value="dibatalkan" @selected(request('status') == 'dibatalkan')>Dibatalkan</option>
                            </select>
                        </div>

                        {{-- Tanggal Awal --}}
                        <div class="col-5 col-md-4 col-lg-2">
                            <input type="date" name="tanggal_awal"
                                class="form-control form-control-pill"
                                value="{{ request('tanggal_awal') }}">
                        </div>

                        {{-- Tanggal Akhir --}}
                        <div class="col-5 col-md-4 col-lg-2">
                            <input type="date" name="tanggal_akhir"
                                class="form-control form-control-pill"
                                value="{{ request('tanggal_akhir') }}">
                        </div>

                        {{-- Aksi --}}
                        <div class="col-2 col-md-4 col-lg-2 d-flex gap-2">
                            <a href="{{ route('transaksi.riwayat') }}"
                                class="btn btn-outline-secondary flex-shrink-0 js-disable-link">
                                Reset
                            </a>
                            <button type="submit" class="btn btn-warning w-100 js-disable-link">
                                Terapkan
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            {{-- ===== TABEL ===== --}}
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0 mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Supplier</th>
                            <th class="text-center">Tipe</th>
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
                                <td>{{ $transaksis->firstItem() + $loop->index }}</td>
                                <td class="fw-semibold text-brand">{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ $transaksi->supplier->nama_supplier ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($transaksi->tipe == 'in')
                                        <span class="badge-status badge-status-success">In</span>
                                    @else
                                        <span class="badge-status badge-status-warning">Out</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ number_format($transaksi->details->sum('qty')) }}</td>
                                <td class="text-muted">{{ $transaksi->tanggal_transaksi }}</td>
                                <td>{{ $transaksi->user->nama_user ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($transaksi->status_transaksi == 'selesai')
                                        <span class="badge-status badge-status-success">Selesai</span>
                                    @else
                                        <span class="badge-status badge-status-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        @if ($transaksi->tipe == 'in')
                                            <a href="{{ route('transaksi.barang-masuk.show', $transaksi) }}"
                                                class="action-icon-btn action-icon-view js-disable-link" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('transaksi.barang-keluar.show', $transaksi) }}"
                                                class="action-icon-btn action-icon-view js-disable-link" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Belum ada riwayat transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===== PAGINATION ===== --}}
            <div class="card-surface-header d-flex justify-content-between align-items-center border-top">
                <p class="small text-muted mb-0">
                    Menampilkan {{ $transaksis->firstItem() ?? 0 }} - {{ $transaksis->lastItem() ?? 0 }}
                    dari {{ $transaksis->total() }} transaksi
                </p>
                {{ $transaksis->links() }}
            </div>

        </div>
    </div>

@endsection