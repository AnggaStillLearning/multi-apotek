<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'penjualan_id',
        'batch_obat_id',
        'konversi_obat_id',
        'qty',
        'isi',
        'harga_beli',
        'harga_jual',
        'subtotal',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function batchObat()
    {
        return $this->belongsTo(BatchObat::class);
    }

    public function konversi()
    {
        return $this->belongsTo(KonversiObat::class, 'konversi_obat_id');
    }
}
