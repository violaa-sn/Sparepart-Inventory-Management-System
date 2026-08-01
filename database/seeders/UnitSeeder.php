<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [

            ['kode_unit' => 'UNT0001', 'nama_unit' => 'PCS',    'status_unit' => 'aktif'],
            ['kode_unit' => 'UNT0002', 'nama_unit' => 'SET',    'status_unit' => 'aktif'],
            ['kode_unit' => 'UNT0003', 'nama_unit' => 'BOX',    'status_unit' => 'aktif'],
            ['kode_unit' => 'UNT0004', 'nama_unit' => 'PACK',   'status_unit' => 'aktif'],
            ['kode_unit' => 'UNT0005', 'nama_unit' => 'ROLL',   'status_unit' => 'aktif'],
            ['kode_unit' => 'UNT0006', 'nama_unit' => 'METER',  'status_unit' => 'aktif'],
            ['kode_unit' => 'UNT0007', 'nama_unit' => 'CM',     'status_unit' => 'aktif'],
            ['kode_unit' => 'UNT0008', 'nama_unit' => 'LITER',  'status_unit' => 'aktif'],
            ['kode_unit' => 'UNT0009', 'nama_unit' => 'ML',     'status_unit' => 'aktif'],
            ['kode_unit' => 'UNT0010', 'nama_unit' => 'BOTOL',  'status_unit' => 'aktif'],
        ];

        foreach ($units as $unit) {
            Unit::updateOrCreate(
                ['kode_unit' => $unit['kode_unit']],
                $unit
            );
        }
    }
}