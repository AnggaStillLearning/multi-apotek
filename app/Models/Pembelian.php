<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = [
        'apotek_id',
        'pemesanan_id',
        'user_id',
        'kasir_id',
        'nomor_pembelian',
        'jenis',
        'tanggal_pembelian',
        'subtotal',
        'grand_total',
        'metode_pembayaran',
        'status',
        'keterangan',
    ];

    public function apotek()
    {
        return $this->belongsTo(Apotek::class);
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id');
    }

    public function details()
    {
        return $this->hasMany(PembelianDetail::class);
    }

    public function isOnline(): bool
    {
        return $this->jenis === 'online';
    }

    public function isOffline(): bool
    {
        return $this->jenis === 'offline';
    }
}
