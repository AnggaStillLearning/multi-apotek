<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;

   protected $fillable = [

    'apotek_id',

    'kategori_id',

    'jenis_obat_id',

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

    public function konversis()
{
    return $this->hasMany(KonversiObat::class)
                ->orderBy('isi');
}

    public function batchObats()
    {
        return $this->hasMany(BatchObat::class);
    }

}
