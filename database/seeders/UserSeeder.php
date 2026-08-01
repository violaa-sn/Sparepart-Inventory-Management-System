<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_user' => 'Admin',
            'email' => 'admin@gmail.com',
            'nomor_telepon' => '081234567890',
            'password' => 'admin123',
        ]);
    }
}
