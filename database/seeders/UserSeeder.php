<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'username' => 'Kecamatan',
                'email' => 'kecamatan@gmail.com',
                'password' => Hash::make('kecamatan123'),
                'role' => 'KECAMATAN',
            ],
            [
                'username' => 'Desa',
                'email' => 'desa@gmail.com',
                'password' => Hash::make('desa123'),
                'role' => 'DESA',
            ],
            [
                'username' => 'Warga',
                'email' => 'warga@gmail.com',
                'password' => Hash::make('warga123'),
                'role' => 'WARGA',
            ],
            [
                'username' => 'User01',
                'email' => 'user01@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'WARGA',
            ],
            [
                'username' => 'User02',
                'email' => 'user02@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'WARGA',
            ],
            [
                'username' => 'User03',
                'email' => 'user03@gmail.com',
                'password' => Hash::make('user123'),
                'role' => 'WARGA',
            ],
        ];

        User::insert($data);
    }
}