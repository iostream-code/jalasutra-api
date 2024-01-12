<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Jalasutra',
                'jenis' => 'kecamatan',
                'deskripsi' => 'Layanan internal surat menyurat Kecamatan Wates',
                'informasi' => 'Nisi et aliqua amet irure dolore dolor magna laboris.',
                'persyaratan' => 'Amet est esse et sit aute sunt.',
                'kontak' => 'Laborum nostrud ut deserunt Lorem et eiusmod labore in minim veniam proident excepteur occaecat eiusmod. Consequat et irure est ut Lorem velit laboris enim consequat voluptate in do. Elit et ut proident est laborum amet qui excepteur.',
            ],
            [
                'nama' => 'Jalasutra',
                'jenis' => 'kota',
                'deskripsi' => 'Layanan internal surat menyurat Kecamatan Wates',
                'informasi' => 'Nisi et aliqua amet irure dolore dolor magna laboris.',
                'persyaratan' => 'Amet est esse et sit aute sunt.',
                'kontak' => 'Laborum nostrud ut deserunt Lorem et eiusmod labore in minim veniam proident excepteur occaecat eiusmod. Consequat et irure est ut Lorem velit laboris enim consequat voluptate in do. Elit et ut proident est laborum amet qui excepteur.',
            ],
            [
                'nama' => 'Jalasutra',
                'jenis' => 'pusat',
                'deskripsi' => 'Layanan internal surat menyurat Kecamatan Wates',
                'informasi' => 'Nisi et aliqua amet irure dolore dolor magna laboris.',
                'persyaratan' => 'Amet est esse et sit aute sunt.',
                'kontak' => 'Laborum nostrud ut deserunt Lorem et eiusmod labore in minim veniam proident excepteur occaecat eiusmod. Consequat et irure est ut Lorem velit laboris enim consequat voluptate in do. Elit et ut proident est laborum amet qui excepteur.',
            ],
            [
                'nama' => 'Jalasutra',
                'jenis' => 'Umum',
                'deskripsi' => 'Layanan internal surat menyurat Kecamatan Wates',
                'informasi' => 'Nisi et aliqua amet irure dolore dolor magna laboris.',
                'persyaratan' => 'Amet est esse et sit aute sunt.',
                'kontak' => 'Laborum nostrud ut deserunt Lorem et eiusmod labore in minim veniam proident excepteur occaecat eiusmod. Consequat et irure est ut Lorem velit laboris enim consequat voluptate in do. Elit et ut proident est laborum amet qui excepteur.',
            ],
            [
                'nama' => 'Jalasutra',
                'jenis' => 'email',
                'deskripsi' => 'Layanan internal surat menyurat Kecamatan Wates',
                'informasi' => 'Nisi et aliqua amet irure dolore dolor magna laboris.',
                'persyaratan' => 'Amet est esse et sit aute sunt.',
                'kontak' => 'Laborum nostrud ut deserunt Lorem et eiusmod labore in minim veniam proident excepteur occaecat eiusmod. Consequat et irure est ut Lorem velit laboris enim consequat voluptate in do. Elit et ut proident est laborum amet qui excepteur.',
            ],
        ];

        Service::insert($data);
    }
}
