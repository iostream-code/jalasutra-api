<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mail_id',
        'isi',
        'nomor',
        'status',
        'tanda_tangan',
    ];
}
