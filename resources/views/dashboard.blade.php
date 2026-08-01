@extends('layouts.app')

@section('title', 'Dashboard - Sparepart Manager')
@section('page-title', 'Dashboard Inventory')

{{-- css khusus dashboard, cuma dimuat pas buka halaman ini --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')

    <div class="row g-4">
        {{-- KOLOM KIRI: total data + chart --}}
        <div class="col-lg-8 d-flex flex-column gap-4">

            {{-- TOTAL DATA --}}
            <section class="card-surface card-surface-body">
                <h4 class="section-title mb-4">Total Data</h4>

                <div class="row row-cols-1 row-cols-md-3 g-0 stat-grid">
                    {{-- ulangi block ini buat tiap statistik, tinggal ganti icon & label --}}
                    <div class="col stat-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box"><i class="bi bi-people"></i></div>
                            <div>
                                <p class="stat-label">User</p>
                                <p class="stat-value">
                                    {{ $totalUser }}
                                </p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>

                    <div class="col stat-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box"><i class="bi bi-tools"></i></div>
                            <div>
                                <p class="stat-label">Sparepart</p>
                                <p class="stat-value">
                                    {{ $totalSparepart }}
                                </p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>

                    <div class="col stat-item stat-border-right">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box"><i class="bi bi-building"></i></div>
                            <div>
                                <p class="stat-label">Supplier</p>
                                <p class="stat-value">
                                    {{ $totalSupplier }}
                                </p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>

                    <div class="col stat-item stat-border">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box"><i class="bi bi-arrow-left-right"></i></div>
                            <div>
                                <p class="stat-label">Transaksi</p>
                                <p class="stat-value">
                                    {{ $totalTransaksi }}
                                </p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>

                    <div class="col stat-item stat-border">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box"><i class="bi bi-box-arrow-in-down"></i></div>
                            <div>
                                <p class="stat-label">Transaksi In</p>
                                <p class="stat-value">
                                    {{ $totalBarangMasuk }}
                                </p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>

                    <div class="col stat-item stat-border stat-border-right">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box"><i class="bi bi-box-arrow-up"></i></div>
                            <div>
                                <p class="stat-label">Transaksi Out</p>
                                <p class="stat-value">
                                    {{ $totalBarangKeluar }}
                                </p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>
                </div>
            </section>

            {{-- CHART TRANSAKSI IN VS OUT --}}
            <section class="card-surface card-surface-body flex-grow-1">

                @php
                    $maxChart = max(max($chartIn ?: [0]), max($chartOut ?: [0]));

                    $maxChart = $maxChart > 0 ? $maxChart : 5;

                    $step = ceil($maxChart / 5);
                @endphp
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="section-title">Transaksi Out vs In</h4>
                    <div class="d-flex align-items-center gap-3">
                        <span class="d-flex align-items-center gap-2">
                            <span class="chart-legend-dot chart-legend-dot-in"></span>
                            <span class="small">In</span>
                        </span>
                        <span class="d-flex align-items-center gap-2">
                            <span class="chart-legend-dot chart-legend-dot-out"></span>
                            <span class="small">Out</span>
                        </span>
                    </div>
                </div>

                <div class="chart-area">
                    <div class="chart-y-axis">

                        @for ($i = 5; $i >= 0; $i--)
                            <span>
                                {{ $i * $step }}
                            </span>
                        @endfor

                    </div>

                    <div class="chart-plot">
                        {{-- tiap chart-bar-group = 1 hari, isinya bar out & in --}}
                        @foreach ($chartLabels as $index => $label)
                            <div class="chart-bar-group">

                                <div class="chart-bar chart-bar-out"
                                    style="
        height: {{ ($chartOut[$index] / $maxChart) * 100 }}%
    ">
                                </div>


                                <div class="chart-bar chart-bar-in"
                                    style="
        height: {{ ($chartIn[$index] / $maxChart) * 100 }}%
    ">
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="chart-x-axis">
                    @foreach ($chartLabels as $label)
                        <span>{{ $label }}</span>
                    @endforeach
                </div>
            </section>
        </div>

        {{-- KOLOM KANAN: low stock alert --}}
        <div class="col-lg-4">
            <section class="card-surface card-surface-body h-100">
                <h4 class="section-title mb-4">Low Stock Alert</h4>

                <div class="d-flex flex-column gap-3">

                    @forelse($lowStock as $item)
                        <div class="stock-alert-card">

                            <div class="d-flex justify-content-between align-items-start mb-3">

                                <div>

                                    <p class="stock-alert-name">
                                        {{ $item->nama_sparepart }}
                                    </p>

                                    <p class="stock-alert-id">
                                        {{ $item->kode_sparepart }}
                                    </p>

                                </div>


                                <span class="stock-alert-count">

                                    Stock: {{ $item->stok }}

                                </span>

                            </div>


                            <div class="stock-progress">

                                <div class="stock-progress-bar"
                                    style="
            width: {{ $item->min_stok > 0 ? ($item->stok / $item->min_stok) * 100 : 0 }}%">
                                </div>

                            </div>

                        </div>


                    @empty

                        <p class="text-muted">
                            Semua stok aman
                        </p>
                    @endforelse


                </div>
            </section>
        </div>
    </div>

    {{-- RECENT ACTIVITY --}}
    <section class="card-surface">
        <div class="card-surface-header d-flex justify-content-between align-items-center">
            <h4 class="section-title">Recent Activity</h4>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-accent d-flex align-items-center gap-2 px-3">
                    <i class="bi bi-plus-lg"></i> Transaksi In
                </button>
                <button type="button" class="btn btn-brand d-flex align-items-center gap-2 px-3">
                    <i class="bi bi-plus-lg"></i> Transaksi Out
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th class="text-center">Total Item</th>
                        <th>User</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($recentActivity as $index => $transaksi)
                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>


                            <td class="fw-bold">
                                {{ $transaksi->kode_transaksi }}
                            </td>


                            <td>
                                {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}
                            </td>


                            <td>

                                @if ($transaksi->tipe == 'in')
                                    <span>
                                        In
                                    </span>
                                @else
                                    <span>
                                        Out
                                    </span>
                                @endif

                            </td>


                            <td class="text-center">

                                {{ $transaksi->details->count() }}

                            </td>


                            <td>

                                {{ $transaksi->user->name ?? '-' }}

                            </td>


                            <td>

                                @if ($transaksi->status_transaksi == 'selesai')
                                    <span class="badge-status badge-status-success">
                                        Selesai
                                    </span>
                                @elseif($transaksi->status_transaksi == 'dibatalkan')
                                    <span class="badge-status badge-status-danger">
                                        Dibatalkan
                                    </span>
                                @else
                                    <span class="badge-status">
                                        {{ ucfirst($transaksi->status_transaksi) }}
                                    </span>
                                @endif


                            </td>


                            <td class="text-center">


                                <button type="button" class="action-icon-btn action-icon-view">

                                    <i class="bi bi-eye"></i>

                                </button>


                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td colspan="8" class="text-center text-muted py-4">

                                Belum ada transaksi

                            </td>

                        </tr>
                    @endforelse


                </tbody>
            </table>
        </div>

        <div class="card-surface-header d-flex justify-content-between align-items-center border-top">
            <p class="small text-muted mb-0">Showing 1 to 5 of 24 entries</p>
            <nav aria-label="Pagination recent activity">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </section>

@endsection
