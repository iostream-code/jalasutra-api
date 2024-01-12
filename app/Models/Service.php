<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, enum>
     */
    protected $fillable = [
        'type_id',
        'nama',
        'gambar',
        'deskripsi',
        'informasi',
        'persyaratan',
        'kontak',
    ];

    /**
     * gambar
     *
     * @return Attribute
     */
    protected function gambar(): Attribute
    {
        return Attribute::make(
            get: fn ($gambar) => asset('/storage/service/' . $gambar),
        );
    }

    public function mail()
    {
        return $this->hasOne(Mail::class);
    }

    public function type()
    {
        return $this->belongsTo(ServiceType::class);
    }
}
