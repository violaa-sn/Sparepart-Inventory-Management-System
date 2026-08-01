<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        // ==========================
        // Dummy Total Data
        // ==========================
        $stats = [

            [
                'label' => 'Total Sparepart',
                'value' => 120,
                'icon' => 'inventory_2',
                'href' => '#'
            ],

            [
                'label' => 'Kategori',
                'value' => 15,
                'icon' => 'category',
                'href' => '#'
            ],

            [
                'label' => 'Supplier',
                'value' => 20,
                'icon' => 'local_shipping',
                'href' => '#'
            ],

            [
                'label' => 'Barang Masuk',
                'value' => 350,
                'icon' => 'move_to_inbox',
                'href' => '#'
            ],

            [
                'label' => 'Barang Keluar',
                'value' => 280,
                'icon' => 'outbox',
                'href' => '#'
            ],

            [
                'label' => 'User',
                'value' => 8,
                'icon' => 'group',
                'href' => '#'
            ],

        ];



        // ==========================
        // Dummy Chart Mingguan
        // ==========================
        $weeklyChart = [

            [
                'label' => 'Sen',
                'in_pct' => 80,
                'out_pct' => 50
            ],

            [
                'label' => 'Sel',
                'in_pct' => 60,
                'out_pct' => 70
            ],

            [
                'label' => 'Rab',
                'in_pct' => 90,
                'out_pct' => 40
            ],

            [
                'label' => 'Kam',
                'in_pct' => 50,
                'out_pct' => 80
            ],

            [
                'label' => 'Jum',
                'in_pct' => 70,
                'out_pct' => 60
            ],

            [
                'label' => 'Sab',
                'in_pct' => 40,
                'out_pct' => 30
            ],

            [
                'label' => 'Min',
                'in_pct' => 85,
                'out_pct' => 55
            ],

        ];



        // ==========================
        // Dummy Low Stock
        // ==========================

        $lowStockItems = collect([

            (object)[
                'name' => 'Kampas Rem',
                'code' => 'SPR-001',
                'current_stock' => 5,
                'min_stock' => 20,
                'percent' => 25
            ],


            (object)[
                'name' => 'Filter Oli',
                'code' => 'SPR-002',
                'current_stock' => 8,
                'min_stock' => 30,
                'percent' => 27
            ],


            (object)[
                'name' => 'Busi Motor',
                'code' => 'SPR-003',
                'current_stock' => 3,
                'min_stock' => 15,
                'percent' => 20
            ],


        ]);



        // ==========================
        // Dummy Recent Transaction
        // ==========================

        $recentTransactions = collect([

            (object)[
                'code' => 'TRX-IN-001',
                'date' => now(),
                'type' => 'in',
                'total_items' => 25,
                'status' => 'success',

                'user' => (object)[
                    'name' => 'Admin Gudang'
                ]
            ],


            (object)[
                'code' => 'TRX-OUT-002',
                'date' => now()->subDay(),
                'type' => 'out',
                'total_items' => 10,
                'status' => 'success',

                'user' => (object)[
                    'name' => 'Manager'
                ]
            ],


            (object)[
                'code' => 'TRX-IN-003',
                'date' => now()->subDays(2),
                'type' => 'in',
                'total_items' => 40,
                'status' => 'pending',

                'user' => (object)[
                    'name' => 'Staff Gudang'
                ]
            ],


        ]);



        return view('dashboard', compact(
            'stats',
            'weeklyChart',
            'lowStockItems',
            'recentTransactions'
        ));
    }
}
