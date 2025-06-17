<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
        'harga',
        'jumlah_peserta',
        'dewasa',
        'anak',
        'status',
        'jersei',
        'kapal',
        'naik_kapal',
        'qr_code',
        'qr_token',
        'tanggal_lunas',
        'invoice'
    ];

    public function jakets()
    {
        return $this->hasMany(Jaket::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($user) {
            if ($user->isDirty('jersei') && $user->jersei) {
                $user->status = 'lunas';
                $jaket = Jaket::where('email', $user->email)->first();
                if ($jaket) {
                    $jaket->status = true;
                    $jaket->save();
                }
            }
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
        ];
    }
}
