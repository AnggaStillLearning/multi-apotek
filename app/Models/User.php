<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'apotek_id'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    /**
 * Cek apakah user Super Admin
 */
public function isSuperAdmin(): bool
{
    return $this->role === 'super_admin';
}

/**
 * Cek apakah user Admin Apotek
 */
public function isAdminApotek(): bool
{
    return $this->role === 'admin';
}

/**
 * Cek apakah user Kasir
 */
public function isKasir(): bool
{
    return $this->role === 'kasir';
}
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function apotek()
    {
        return $this->belongsTo(Apotek::class);
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
    public function pengadaans()
    {
        return $this->hasMany(Pengadaan::class);
    }
}
