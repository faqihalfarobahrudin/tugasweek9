<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Akademik',
            'email' => 'admin@kampus.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Dosen Pengampu',
            'email' => 'dosen@kampus.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        User::create([
            'name' => 'Mahasiswa Aktif',
            'email' => 'mahasiswa@kampus.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);
    }
}