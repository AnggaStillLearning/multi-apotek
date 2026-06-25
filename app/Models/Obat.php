<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $fillable = [
        'apotek_id',
        'kategori_id',
        'nama_obat',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimum',
        'tanggal_kadaluarsa'
    ];
    public function kategori()
    {
    return $this->belongsTo(
        Kategori::class
    );
}

    public function apotek()
    {
        return $this->belongsTo(Apotek::class);
    }
}
