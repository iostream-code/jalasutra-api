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
        'user_id',
        'blanko',
        'nomor',
        'status',
        'tanda_tangan',
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

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
