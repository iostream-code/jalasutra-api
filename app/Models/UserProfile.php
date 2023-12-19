<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, date, enum>
     */
    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'tanggal_lahir',
        'gender',
        'alamat',
        'pekerjaan',
        'status',
        'foto',
    ];

    /**
     * Relasi dengan User
     *
     * @method public
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
