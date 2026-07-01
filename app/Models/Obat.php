<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [

        'apotek_id',

        'jenis_obat_id',

        'kategori_id',

        'nama_obat',

        'batch',

        'harga_beli',

        'harga_jual',

        'stok',

        'stok_minimum',

        'tanggal_kadaluarsa'

    ];

    public function apotek()
    {
        return $this->belongsTo(Apotek::class);
    }

    public function jenisObat()
    {
        return $this->belongsTo(JenisObat::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
