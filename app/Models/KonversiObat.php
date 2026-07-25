<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonversiObat extends Model
{
    use HasFactory;

    protected $fillable = [

        'obat_id',

        'satuan_id',

        'rasio_turun',

        'isi',

        'harga_jual',

        'is_default',

        'urutan'

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function penjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function pengadaanDetails()
    {
        return $this->hasMany(PengadaanDetail::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Auto-hitung isi (total ke satuan dasar) dari rasio_turun berjenjang
    |--------------------------------------------------------------------------
    |
    | Admin hanya perlu isi "rasio_turun" per baris (mis. 1 Box = 12 Pack),
    | kolom "isi" (total ke satuan dasar) dihitung otomatis di sini setiap
    | kali salah satu baris konversi obat ini disimpan atau dihapus.
    |
    | Contoh hasil untuk Box(12) -> Pack(12) -> Strip(10) -> Tablet(dasar):
    |   urutan 1 Box   -> isi 1440
    |   urutan 2 Pack  -> isi 120
    |   urutan 3 Strip -> isi 10
    |   urutan 4 Tablet-> isi 1   (baris satuan dasar, rasio_turun = null)
    |
    */

    protected static function booted(): void
    {
        static::saved(function (KonversiObat $konversi) {
            static::recalculateIsi($konversi->obat_id);
        });

        static::deleted(function (KonversiObat $konversi) {
            static::recalculateIsi($konversi->obat_id);
        });
    }

    public static function recalculateIsi(int $obatId): void
    {
        $rows = static::where('obat_id', $obatId)
            ->orderBy('urutan', 'desc')
            ->get();

        $isiSatuanDiBawahnya = 1; // satuan dasar selalu isi = 1

        foreach ($rows as $row) {

            $isiBaru = $row->rasio_turun
                ? $row->rasio_turun * $isiSatuanDiBawahnya
                : 1;

            if ((int) $row->isi !== (int) $isiBaru) {
                $row->updateQuietly(['isi' => $isiBaru]);
            }

            $isiSatuanDiBawahnya = $isiBaru;
        }
    }
}
