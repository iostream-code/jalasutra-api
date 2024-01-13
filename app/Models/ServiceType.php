<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'logo',
    ];

    /**
     * logo
     *
     * @return Attribute
     */
    protected function logo(): Attribute
    {
        return Attribute::make(
            get: fn ($logo) => asset('/storage/service/' . $logo),
        );
    }

    public function service()
    {
        return $this->hasOne(Service::class);
    }
}
