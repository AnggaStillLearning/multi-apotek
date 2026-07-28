<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $fillable = [
        'apotek_id',
        'user_id',
        'nomor_pemesanan',
        'tanggal_pemesanan',
        'subtotal',
        'grand_total',
        'status',
        'keterangan',
    ];

    public function apotek()
    {
        return $this->belongsTo(Apotek::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PemesananDetail::class);
    }

    public function pembelian()
    {
        return $this->hasOne(Pembelian::class);
    }
}
