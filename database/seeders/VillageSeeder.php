<?php

namespace Database\Seeders;

use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Mojorejo',
            ],
            [
                'nama' => 'Purworejo',
            ],
            [
                'nama' => 'Ringin Rejo',
            ],
            [
                'nama' => 'Sukorejo',
            ],
            [
                'nama' => 'Sumberarum',
            ],
            [
                'nama' => 'Tugu Rejo',
            ],
            [
                'nama' => 'Tulungrejo',
            ],
            [
                'nama' => 'Wates',
            ],
        ];

        Village::insert($data);
    }
}
