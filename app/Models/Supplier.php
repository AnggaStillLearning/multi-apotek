<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'nama_supplier',
        'kontak',
        'email',
        'alamat',
        'keterangan',
        'status',
    ];

    /**
     * Relasi ke Pengadaan
     */
    public function pengadaans()
    {
        return $this->hasMany(Pengadaan::class);
    }
}
