<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'kode_user'    => User::generateKode(),
                'nama_user'    => 'Administrator',
                'email'        => 'admin@gmail.com',
                'password'     => Hash::make('admin123'),
                'role'         => 'manager',
                'nomor_telepon'         => '081234567890',
                'status_user'  => 'aktif',
            ]
        );
    }
}
