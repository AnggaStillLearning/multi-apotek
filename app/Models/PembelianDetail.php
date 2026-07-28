<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    protected $fillable = [
        'pembelian_id',
        'obat_id',
        'konversi_obat_id',
        'batch_obat_id',
        'qty',
        'isi',
        'harga_beli',
        'harga_jual',
        'subtotal',
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function konversi()
    {
        return $this->belongsTo(KonversiObat::class, 'konversi_obat_id');
    }

    public function batch()
    {
        return $this->belongsTo(BatchObat::class, 'batch_obat_id');
    }
}
