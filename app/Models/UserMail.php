<?php

namespace App\Models;

use App\Models\Mail;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserMail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mail_id',
        'status',
        'nomor',
        'isi',
        'tanda_tangan',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function mails()
    {
        return $this->belongsToMany(Mail::class);
    }
}
