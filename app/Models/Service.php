<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, enum>
     */
    protected $fillable = [
        'nama',
        'jenis',
        'gambar',
        'deskripsi',
        'informasi',
        'persyaratan',
        'kontak',
    ];
}