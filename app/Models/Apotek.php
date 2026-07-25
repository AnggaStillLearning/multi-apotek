<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apotek extends Model
{
    use HasFactory;

    protected $fillable = [

        'nama_apotek',

        'alamat',

        'latitude',

        'longitude'

    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function obats()
    {
        return $this->hasMany(Obat::class);
    }

    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
    public function gudangs()
    {
        return $this->hasMany(Gudang::class);
    }
    public function pengadaans()
    {
        return $this->hasMany(Pengadaan::class);
    }
}
