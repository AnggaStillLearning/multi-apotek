<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengadaanDetail extends Model
{
    protected $fillable = [
        'pengadaan_id',
        'obat_id',
        'konversi_obat_id',
        'gudang_id',
        'ruangan_id',
        'nomor_batch',
        'tanggal_kadaluarsa',
        'qty',
        'qty_dasar',
        'harga_beli',
        'subtotal',
    ];

    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function konversi()
    {
        return $this->belongsTo(KonversiObat::class, 'konversi_obat_id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
