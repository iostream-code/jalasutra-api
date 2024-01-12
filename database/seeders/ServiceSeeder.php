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
                'type_id' => 3,
                'nama' => 'KAI',
                'deskripsi' => 'Layanan Tiket Kereta Api',
                'informasi' => 'Nisi et aliqua amet irure dolore dolor magna laboris.',
                'persyaratan' => 'Amet est esse et sit aute sunt.',
                'kontak' => 'Laborum nostrud ut deserunt Lorem et eiusmod labore in minim veniam proident excepteur occaecat eiusmod. Consequat et irure est ut Lorem velit laboris enim consequat voluptate in do. Elit et ut proident est laborum amet qui excepteur.',
            ],
            [
                'type_id' => 3,
                'nama' => 'BPJS Ketenagakerjaan',
                'deskripsi' => 'Layanan Pembayaran BPJS',
                'informasi' => 'Nisi et aliqua amet irure dolore dolor magna laboris.',
                'persyaratan' => 'Amet est esse et sit aute sunt.',
                'kontak' => 'Laborum nostrud ut deserunt Lorem et eiusmod labore in minim veniam proident excepteur occaecat eiusmod. Consequat et irure est ut Lorem velit laboris enim consequat voluptate in do. Elit et ut proident est laborum amet qui excepteur.',
            ],
            [
                'type_id' => 3,
                'nama' => 'PLN',
                'deskripsi' => 'Layanan Pembayaran dan Pengaduan PLN',
                'informasi' => 'Nisi et aliqua amet irure dolore dolor magna laboris.',
                'persyaratan' => 'Amet est esse et sit aute sunt.',
                'kontak' => 'Laborum nostrud ut deserunt Lorem et eiusmod labore in minim veniam proident excepteur occaecat eiusmod. Consequat et irure est ut Lorem velit laboris enim consequat voluptate in do. Elit et ut proident est laborum amet qui excepteur.',
            ],
            [
                'type_id' => 1,
                'nama' => 'PPDB',
                'deskripsi' => 'Layanan internal surat menyurat Kecamatan Wates',
                'informasi' => 'Nisi et aliqua amet irure dolore dolor magna laboris.',
                'persyaratan' => 'Amet est esse et sit aute sunt.',
                'kontak' => 'Laborum nostrud ut deserunt Lorem et eiusmod labore in minim veniam proident excepteur occaecat eiusmod. Consequat et irure est ut Lorem velit laboris enim consequat voluptate in do. Elit et ut proident est laborum amet qui excepteur.',
            ],
            [
                'type_id' => 4,
                'nama' => 'Gmail',
                'deskripsi' => 'Layanan internal surat menyurat Kecamatan Wates',
                'informasi' => 'Nisi et aliqua amet irure dolore dolor magna laboris.',
                'persyaratan' => 'Amet est esse et sit aute sunt.',
                'kontak' => 'Laborum nostrud ut deserunt Lorem et eiusmod labore in minim veniam proident excepteur occaecat eiusmod. Consequat et irure est ut Lorem velit laboris enim consequat voluptate in do. Elit et ut proident est laborum amet qui excepteur.',
            ],
        ];

        Service::insert($data);
    }
}
