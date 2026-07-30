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
                                <p class="stat-value">0</p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>

                    <div class="col stat-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box"><i class="bi bi-tools"></i></div>
                            <div>
                                <p class="stat-label">Sparepart</p>
                                <p class="stat-value">0</p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>

                    <div class="col stat-item stat-border-right">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box"><i class="bi bi-building"></i></div>
                            <div>
                                <p class="stat-label">Supplier</p>
                                <p class="stat-value">0</p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>

                    <div class="col stat-item stat-border">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box"><i class="bi bi-arrow-left-right"></i></div>
                            <div>
                                <p class="stat-label">Transaksi</p>
                                <p class="stat-value">0</p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>

                    <div class="col stat-item stat-border">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box"><i class="bi bi-box-arrow-in-down"></i></div>
                            <div>
                                <p class="stat-label">Transaksi In</p>
                                <p class="stat-value">0</p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>

                    <div class="col stat-item stat-border stat-border-right">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box"><i class="bi bi-box-arrow-up"></i></div>
                            <div>
                                <p class="stat-label">Transaksi Out</p>
                                <p class="stat-value">0</p>
                            </div>
                        </div>
                        <i class="bi bi-arrow-right stat-arrow"></i>
                    </div>
                </div>
            </section>

            {{-- CHART TRANSAKSI IN VS OUT --}}
            <section class="card-surface card-surface-body flex-grow-1">
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
                        <span>25</span>
                        <span>20</span>
                        <span>15</span>
                        <span>10</span>
                        <span>5</span>
                        <span>0</span>
                    </div>

                    <div class="chart-plot">
                        {{-- tiap chart-bar-group = 1 hari, isinya bar out & in --}}
                        <div class="chart-bar-group">
                            <div class="chart-bar chart-bar-out" style="height: 60%"></div>
                            <div class="chart-bar chart-bar-in" style="height: 85%"></div>
                        </div>
                        <div class="chart-bar-group">
                            <div class="chart-bar chart-bar-out" style="height: 45%"></div>
                            <div class="chart-bar chart-bar-in" style="height: 55%"></div>
                        </div>
                        <div class="chart-bar-group">
                            <div class="chart-bar chart-bar-out" style="height: 70%"></div>
                            <div class="chart-bar chart-bar-in" style="height: 40%"></div>
                        </div>
                        <div class="chart-bar-group">
                            <div class="chart-bar chart-bar-out" style="height: 65%"></div>
                            <div class="chart-bar chart-bar-in" style="height: 75%"></div>
                        </div>
                        <div class="chart-bar-group">
                            <div class="chart-bar chart-bar-out" style="height: 50%"></div>
                            <div class="chart-bar chart-bar-in" style="height: 70%"></div>
                        </div>
                        <div class="chart-bar-group">
                            <div class="chart-bar chart-bar-out" style="height: 35%"></div>
                            <div class="chart-bar chart-bar-in" style="height: 90%"></div>
                        </div>
                        <div class="chart-bar-group">
                            <div class="chart-bar chart-bar-out" style="height: 55%"></div>
                            <div class="chart-bar chart-bar-in" style="height: 65%"></div>
                        </div>
                    </div>
                </div>

                <div class="chart-x-axis">
                    <span>17 Sun</span>
                    <span>18 Mon</span>
                    <span>19 Tue</span>
                    <span>20 Wed</span>
                    <span>21 Thu</span>
                    <span>22 Fri</span>
                    <span>23 Sat</span>
                </div>
            </section>
        </div>

        {{-- KOLOM KANAN: low stock alert --}}
        <div class="col-lg-4">
            <section class="card-surface card-surface-body h-100">
                <h4 class="section-title mb-4">Low Stock Alert</h4>

                <div class="d-flex flex-column gap-3">
                    {{-- ulangi block ini per barang yg stoknya menipis --}}
                    <div class="stock-alert-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="stock-alert-name">Aki</p>
                                <p class="stock-alert-id">ID SPAREPART</p>
                            </div>
                            <span class="stock-alert-count">Stock: 5</span>
                        </div>
                        <div class="stock-progress">
                            <div class="stock-progress-bar" style="width: 100%"></div>
                        </div>
                    </div>

                    <div class="stock-alert-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="stock-alert-name">Filter Udara</p>
                                <p class="stock-alert-id">ID SPAREPART</p>
                            </div>
                            <span class="stock-alert-count">Stock: 3</span>
                        </div>
                        <div class="stock-progress">
                            <div class="stock-progress-bar" style="width: 60%"></div>
                        </div>
                    </div>

                    <div class="stock-alert-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="stock-alert-name">Shock Absorber</p>
                                <p class="stock-alert-id">ID SPAREPART</p>
                            </div>
                            <span class="stock-alert-count">Stock: 2</span>
                        </div>
                        <div class="stock-progress">
                            <div class="stock-progress-bar" style="width: 30%"></div>
                        </div>
                    </div>
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
                    <tr>
                        <td>1</td>
                        <td class="fw-bold">TRX-000278323</td>
                        <td>27 Jul 2026</td>
                        <td>In</td>
                        <td class="text-center">5</td>
                        <td>Admin</td>
                        <td><span class="badge-status badge-status-success">Selesai</span></td>
                        <td class="text-center">
                            <button type="button" class="action-icon-btn action-icon-view"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="fw-bold">TRX-000278323</td>
                        <td>27 Jul 2026</td>
                        <td>Out</td>
                        <td class="text-center">10</td>
                        <td>Staff</td>
                        <td><span class="badge-status badge-status-success">Selesai</span></td>
                        <td class="text-center">
                            <button type="button" class="action-icon-btn action-icon-view"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td class="fw-bold">TRX-000278323</td>
                        <td>27 Jul 2026</td>
                        <td>In</td>
                        <td class="text-center">40</td>
                        <td>Staff</td>
                        <td><span class="badge-status badge-status-success">Selesai</span></td>
                        <td class="text-center">
                            <button type="button" class="action-icon-btn action-icon-view"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td class="fw-bold">TRX-000278323</td>
                        <td>26 Jul 2026</td>
                        <td>In</td>
                        <td class="text-center">60</td>
                        <td>Manager</td>
                        <td><span class="badge-status badge-status-danger">Dibatalkan</span></td>
                        <td class="text-center">
                            <button type="button" class="action-icon-btn action-icon-view"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td class="fw-bold">TRX-000278323</td>
                        <td>26 Jul 2026</td>
                        <td>In</td>
                        <td class="text-center">60</td>
                        <td>Manager</td>
                        <td><span class="badge-status badge-status-danger">Dibatalkan</span></td>
                        <td class="text-center">
                            <button type="button" class="action-icon-btn action-icon-view"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>
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
