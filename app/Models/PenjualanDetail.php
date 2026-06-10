<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $fillable = [
        'penjualan_id',
        'obat_id',
        'qty',
        'harga',
        'subtotal'
    ];

    public function obat()
    {
        return $this->belongsTo(
            Obat::class
        );
    }
    public function penjualan()
{
    return $this->belongsTo(
        Penjualan::class
    );
}
}
