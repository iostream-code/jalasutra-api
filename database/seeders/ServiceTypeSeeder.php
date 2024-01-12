<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'PEMKAB',
            ],
            [
                'nama' => 'INTERN',
            ],
            [
                'nama' => 'UMUM',
            ],
            [
                'nama' => 'EMAIL',
            ],
        ];

        ServiceType::insert($data);
    }
}
