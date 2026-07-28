<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemesananDetail extends Model
{
    protected $fillable = [
        'pemesanan_id',
        'obat_id',
        'konversi_obat_id',
        'qty',
        'harga_jual',
        'subtotal',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function konversi()
    {
        return $this->belongsTo(KonversiObat::class, 'konversi_obat_id');
    }
}
