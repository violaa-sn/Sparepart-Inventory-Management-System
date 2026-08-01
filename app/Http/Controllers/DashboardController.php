<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sparepart;
use App\Models\Supplier;
use App\Models\StokTransaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

        // ==========================
        // TOTAL DATA CARD
        // ==========================
        

        $totalUser = User::count();

        $totalSparepart = Sparepart::count();

        $totalSupplier = Supplier::count();

        $totalTransaksi = StokTransaksi::count();


        $totalBarangMasuk = StokTransaksi::where('tipe', 'in')
            ->count();


        $totalBarangKeluar = StokTransaksi::where('tipe', 'out')
            ->count();



        // ==========================
        // LOW STOCK ALERT
        // stok <= minimal stok
        // ==========================

        $lowStock = Sparepart::whereColumn(
                'stok',
                '<=',
                'min_stok'
            )
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();



        // ==========================
        // RECENT ACTIVITY
        // ==========================

        $recentActivity = StokTransaksi::with([
                'user',
                'details'
            ])
            ->latest('tanggal_transaksi')
            ->limit(5)
            ->get();



        // ==========================
        // CHART TRANSAKSI 7 HARI
        // ==========================

        $chartLabels = [];

        $chartIn = [];

        $chartOut = [];


        for ($i = 6; $i >= 0; $i--) {


            $tanggal = Carbon::now()
                ->subDays($i);



            // label tanggal
            // contoh: 27 Jul
            $chartLabels[] = $tanggal->format('d M');



            // jumlah transaksi masuk hari tersebut

            $chartIn[] = StokTransaksi::where('tipe', 'in')
                ->whereDate(
                    'tanggal_transaksi',
                    $tanggal->format('Y-m-d')
                )
                ->count();



            // jumlah transaksi keluar hari tersebut

            $chartOut[] = StokTransaksi::where('tipe', 'out')
                ->whereDate(
                    'tanggal_transaksi',
                    $tanggal->format('Y-m-d')
                )
                ->count();

        }



        return view(
            'dashboard',
            compact(

                'totalUser',

                'totalSparepart',

                'totalSupplier',

                'totalTransaksi',

                'totalBarangMasuk',

                'totalBarangKeluar',

                'lowStock',

                'recentActivity',

                'chartLabels',

                'chartIn',

                'chartOut'

            )
        );
    }
}