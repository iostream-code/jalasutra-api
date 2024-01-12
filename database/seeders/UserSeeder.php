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
                'email_verified_at' => now(),
                'password' => Hash::make('kecamatan123'),
                'role_id' => 1,
            ],
            [
                'username' => 'Desa',
                'email' => 'desa@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('desa123'),
                'role_id' => 2,
            ],
            [
                'username' => 'Warga',
                'email' => 'warga@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('warga123'),
                'role_id' => 3,
            ],
            [
                'username' => 'User01',
                'email' => 'user01@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
                'role_id' => 3,
            ],
            [
                'username' => 'User02',
                'email' => 'user02@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
                'role_id' => 3,
            ],
            [
                'username' => 'User03',
                'email' => 'user03@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
                'role_id' => 3,
            ],
        ];

        User::insert($data);
    }
}
