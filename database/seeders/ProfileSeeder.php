<?php

namespace Database\Seeders;

use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake('id_ID');
        $gender = $faker->randomElement(['pria', 'wanita']);

        $data = [
            [
                'user_id' => 1,
                'nik' => random_int(3570000000000000, 3579999999999999),
                'nama_lengkap' => $faker->name($gender),
                'tanggal_lahir' => $faker->date(),
                'gender' => $faker->randomElement(['pria', 'wanita']),
                'alamat' => $faker->address(),
                'pekerjaan' => $faker->jobTitle(),
                'kawin' => $faker->randomElement([0, 1]),
            ],
            [
                'user_id' => 2,
                'nik' => random_int(3570000000000000, 3579999999999999),
                'nama_lengkap' => $faker->name($gender),
                'tanggal_lahir' => $faker->date(),
                'gender' => $faker->randomElement(['pria', 'wanita']),
                'alamat' => $faker->address(),
                'pekerjaan' => $faker->jobTitle(),
                'kawin' => $faker->randomElement([0, 1]),
            ],
            [
                'user_id' => 3,
                'nik' => random_int(3570000000000000, 3579999999999999),
                'nama_lengkap' => $faker->name($gender),
                'tanggal_lahir' => $faker->date(),
                'gender' => $faker->randomElement(['pria', 'wanita']),
                'alamat' => $faker->address(),
                'pekerjaan' => $faker->jobTitle(),
                'kawin' => $faker->randomElement([0, 1]),
            ],
            [
                'user_id' => 4,
                'nik' => random_int(3570000000000000, 3579999999999999),
                'nama_lengkap' => $faker->name($gender),
                'tanggal_lahir' => $faker->date(),
                'gender' => $faker->randomElement(['pria', 'wanita']),
                'alamat' => $faker->address(),
                'pekerjaan' => $faker->jobTitle(),
                'kawin' => $faker->randomElement([0, 1]),
            ],
            [
                'user_id' => 5,
                'nik' => random_int(3570000000000000, 3579999999999999),
                'nama_lengkap' => $faker->name($gender),
                'tanggal_lahir' => $faker->date(),
                'gender' => $faker->randomElement(['pria', 'wanita']),
                'alamat' => $faker->address(),
                'pekerjaan' => $faker->jobTitle(),
                'kawin' => $faker->randomElement([0, 1]),
            ],
            [
                'user_id' => 6,
                'nik' => random_int(3570000000000000, 3579999999999999),
                'nama_lengkap' => $faker->name($gender),
                'tanggal_lahir' => $faker->date(),
                'gender' => $faker->randomElement(['pria', 'wanita']),
                'alamat' => $faker->address(),
                'pekerjaan' => $faker->jobTitle(),
                'kawin' => $faker->randomElement([0, 1]),
            ],
        ];

        UserProfile::insert($data);
    }
}
