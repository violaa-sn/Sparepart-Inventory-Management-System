@extends('layouts.app')

@section('title', 'Detail Barang Keluar - Sparepart Manager')

@section('content')


    <div class="row g-4">

        {{-- ===================== KOLOM KIRI (~70%) ===================== --}}
        <div class="col-12 col-lg-8 d-flex flex-column gap-4">

            {{-- Card 1: Informasi Transaksi --}}
            <article class="card-surface card-surface-accent">
                <div class="card-surface-header">
                    <h2 class="h5 mb-0 d-flex align-items-center gap-2"> Informasi Transaksi
                    </h2>
                </div>
                <div class="card-surface-body">
                    <dl class="detail-list row">
                        <div class="col-12 col-md-6">
                            <dt>Kode Transaksi</dt>
                            <dd>{{ $transaksi->kode_transaksi }}</dd>
                        </div>
                        <div class="col-12 col-md-6">
                            <dt>Jenis Transaksi</dt>
                            <dd><span class="badge-status badge-status-danger">
                                    <i class="bi bi-box-arrow-up-right"></i>
                                    Barang Keluar
                                </span></dd>
                        </div>
                        <div class="col-12 col-md-6">
                            <dt>Tanggal Transaksi</dt>
                            <dd>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y H:i') }}</dd>
                        </div>
                        <div class="col-12 col-md-6">
                            <dt>Petugas</dt>
                            <dd>{{ $transaksi->user->nama_user }}</dd>
                        </div>
                        <div class="col-12">
                            <dt>Catatan</dt>
                            <dd class="mb-0">
                                <div class="bg-light border rounded-3 p-3">
                                    <p class="fst-italic text-muted mb-0">{{ $transaksi->catatan ?: '-' }}</p>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </article>

            {{-- Card 2: Daftar Item --}}
            <article class="card-surface">
                <div class="card-surface-header">
                    <h2 class="h5 mb-0 d-flex align-items-center gap-2"> Daftar Item Sparepart
                    </h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 4rem;">No</th>
                                <th style="width: 140px;">Kode Transaksi</th>
                                <th>Nama Sparepart</th>
                                <th>Brand</th>
                                <th>Kategori</th>
                                <th>Unit</th>
                                <th class="text-end">Qty Keluar</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($transaksi->details as $detail)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $detail->sparepart->kode_sparepart }}
                                    </td>

                                    <td>
                                        {{ $detail->sparepart->nama_sparepart }}
                                    </td>

                                    <td>
                                        {{ $detail->sparepart->brand->nama_brand }}
                                    </td>

                                    <td>
                                        {{ $detail->sparepart->kategori->nama_kategori }}
                                    </td>

                                    <td>
                                        {{ $detail->sparepart->unit->nama_unit }}
                                    </td>

                                    <td class="text-end fw-semibold text-danger">
                                        {{ $detail->qty }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Tidak ada item.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </article>

        </div>

        {{-- ===================== KOLOM KANAN (~30%) ===================== --}}
        <div class="col-12 col-lg-4">
            <div class="d-flex flex-column gap-4 sticky-top" style="top: 1.5rem;">

                {{-- Card: Ringkasan Transaksi --}}
                <article class="card-surface">
                    <div class="card-surface-header">
                        <h2 class="h6 mb-0">Ringkasan Transaksi</h2>
                    </div>
                    <div class="card-surface-body d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Status</span>
                            @if ($transaksi->status_transaksi == 'selesai')
                                <span class="badge-status badge-status-success">
                                    <i class="bi bi-check-circle"></i>
                                    Selesai
                                </span>
                            @else
                                <span class="badge-status badge-status-danger">
                                    <i class="bi bi-x-circle"></i>
                                    Dibatalkan
                                </span>
                            @endif
                        </div>

                        <hr class="my-0">

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Jenis Sparepart</span>
                            <span class="fs-5 fw-semibold">{{ $transaksi->details->count() }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Total Qty Keluar</span>
                            <span class="fs-2 fw-bold text-brand">{{ $transaksi->details->sum('qty') }}</span>
                        </div>
                    </div>
                </article>

                {{-- Tombol aksi --}}
                <div class="d-grid gap-2">
                    <a href="{{ route('transaksi.barang-keluar') }}"
                        class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2 mt-2 js-disable-link">
                        <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>

            </div>
        </div>

    </div>

@endsection
