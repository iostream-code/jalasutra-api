<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mail extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'nama',
        'blanko',
    ];

    /**
     * blanko
     *
     * @return Attribute
     */
    protected function blanko(): Attribute
    {
        return Attribute::make(
            get: fn ($blanko) => asset('/storage/mail/blanko/' . $blanko),
        );
    }

    /**
     * tanda tangan
     *
     * @return Attribute
     */
    protected function tandaTangan(): Attribute
    {
        return Attribute::make(
            get: fn ($tanda_tangan) => asset('/storage/mail/tanda_tangan/' . $tanda_tangan),
        );
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
