@extends('layouts.app')

@section('title', 'Detail Barang Masuk - Sparepart Manager')
@section('page-title', 'Detail Barang Masuk')

@section('content')

<div class="card-surface mb-4">

    <div class="card-surface-header">
        <div class="d-flex justify-content-between align-items-center">

            <h2 class="h5 mb-0">
                Detail Transaksi Barang Masuk
            </h2>

            <a href="{{ route('transaksi.barang-masuk') }}"
                class="btn btn-outline-secondary d-flex align-items-center gap-2 js-disable-link">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

        </div>
    </div>


    <div class="card-surface-body">

        {{-- INFORMASI TRANSAKSI --}}
        <h6 class="fw-semibold mb-3">
            Informasi Transaksi
        </h6>


        <div class="row g-4 mb-4">

            <div class="col-md-6">

                <label class="form-label text-muted">
                    Kode Transaksi
                </label>

                <div class="form-control form-control-pill bg-light">
                    {{ $transaksi->kode_transaksi }}
                </div>

            </div>


            <div class="col-md-6">

                <label class="form-label text-muted">
                    Tanggal Transaksi
                </label>

                <div class="form-control form-control-pill bg-light">
                    {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y H:i') }}
                </div>

            </div>


            <div class="col-md-6">

                <label class="form-label text-muted">
                    Supplier
                </label>

                <div class="form-control form-control-pill bg-light">
                    {{ $transaksi->supplier->nama_supplier ?? '-' }}
                </div>

            </div>


            <div class="col-md-6">

                <label class="form-label text-muted">
                    Dibuat Oleh
                </label>

                <div class="form-control form-control-pill bg-light">
                    {{ $transaksi->user->nama_user ?? '-' }}
                </div>

            </div>


            <div class="col-md-6">

                <label class="form-label text-muted">
                    Status
                </label>

                <div>

                    @if($transaksi->status_transaksi == 'selesai')

                        <span class="badge-status badge-status-success">
                            Selesai
                        </span>

                    @else

                        <span class="badge-status badge-status-danger">
                            Dibatalkan
                        </span>

                    @endif

                </div>

            </div>


            <div class="col-md-6">

                <label class="form-label text-muted">
                    Catatan
                </label>

                <div class="form-control form-control-pill bg-light">

                    {{ $transaksi->catatan ?? '-' }}

                </div>

            </div>

        </div>



        {{-- DETAIL ITEM --}}
        <h6 class="fw-semibold mb-3">
            Detail Sparepart
        </h6>


        <div class="table-responsive">

            <table class="table table-custom align-middle mb-0">

                <thead>

                    <tr>

                        <th class="text-center">
                            No
                        </th>

                        <th>
                            Kode Sparepart
                        </th>

                        <th>
                            Nama Sparepart
                        </th>

                        <th class="text-end">
                            Qty
                        </th>

                        <th class="text-end">
                            Harga
                        </th>

                        <th class="text-end">
                            Subtotal
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($transaksi->details as $detail)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>


                        <td class="fw-semibold text-brand">
                            {{ $detail->sparepart->kode_sparepart }}
                        </td>


                        <td>
                            {{ $detail->sparepart->nama_sparepart }}
                        </td>


                        <td class="text-end">
                            {{ number_format($detail->qty) }}
                        </td>


                        <td class="text-end">

                            Rp {{ number_format($detail->harga_perunit,0,',','.') }}

                        </td>


                        <td class="text-end fw-semibold">

                            Rp {{ number_format($detail->qty * $detail->harga_perunit,0,',','.') }}

                        </td>


                    </tr>

                    @endforeach


                </tbody>

            </table>

        </div>


    </div>



    {{-- SUMMARY --}}
    <div class="card-surface-footer d-flex justify-content-end">

        <div class="transaction-summary">


            <div class="d-flex justify-content-between mb-2">

                <span class="text-muted small">
                    Total Jenis Item
                </span>

                <span class="fw-medium">

                    {{ $transaksi->details->count() }}

                </span>

            </div>



            <div class="d-flex justify-content-between mb-2">

                <span class="text-muted small">
                    Total Qty
                </span>

                <span class="fw-medium">

                    {{ number_format($transaksi->details->sum('qty')) }}

                </span>

            </div>



            <div class="d-flex justify-content-between pt-2 border-top">

                <span class="text-muted small text-uppercase fw-semibold">

                    Grand Total

                </span>


                <span class="fw-bold text-brand">

                    Rp {{ number_format(
                        $transaksi->details->sum(fn($item)=>$item->qty*$item->harga_perunit),
                        0,
                        ',',
                        '.'
                    ) }}
                </span>
            </div>
        </div>
    </div>
</div>


@endsection