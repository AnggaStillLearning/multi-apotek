<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [

        'apotek_id',

        'tipe_produk',

        'kategori_id',

        'jenis_obat_id',

        'satuan_dasar_id',

        'nama_obat',

        'harga_beli_default',

        'stok_minimum',

        'total_stok',

        'deskripsi',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */

    public function apotek()
    {
        return $this->belongsTo(Apotek::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class,'kategori_id');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisObat::class,'jenis_obat_id');
    }

    public function satuanDasar()
    {
        return $this->belongsTo(Satuan::class, 'satuan_dasar_id');
    }

    public function konversis()
    {
        return $this->hasMany(KonversiObat::class)
                    ->orderBy('urutan');
    }

    public function batchObats()
    {
        return $this->hasMany(BatchObat::class);
    }

    public function pengadaanDetails()
    {
        return $this->hasMany(PengadaanDetail::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scope
    |--------------------------------------------------------------------------
    */

    public function scopeObat($query)
    {
        return $query->where('tipe_produk', 'obat');
    }

    public function scopeAlatKesehatan($query)
    {
        return $query->where('tipe_produk', 'alat_kesehatan');
    }

    public function isObat(): bool
    {
        return $this->tipe_produk === 'obat';
    }

    public function isAlatKesehatan(): bool
    {
        return $this->tipe_produk === 'alat_kesehatan';
    }
}
