<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin SmartSchool',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Guru Demo',
            'email' => 'guru@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Siswa Demo',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        User::create([
            'name' => 'Orang Tua Demo',
            'email' => 'ortu@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'orang_tua',
        ]);

        User::create([
            'name' => 'Guru Piket Demo',
            'email' => 'piket@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'guru_piket',
        ]);
    }
}