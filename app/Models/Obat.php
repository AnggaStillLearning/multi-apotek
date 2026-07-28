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

    public function pemesananDetails()
    {
        return $this->hasMany(PemesananDetail::class);
    }

    public function pembelianDetails()
    {
        return $this->hasMany(PembelianDetail::class);
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

    /*
    |--------------------------------------------------------------------------
    | Stok
    |--------------------------------------------------------------------------
    */

    /**
     * Pecah total_stok (dalam satuan dasar) jadi kombinasi satuan besar
     * ke kecil untuk ditampilkan, mis. total_stok 1445 -> "1 Box, 2 Pack,
     * 5 Tablet" (kalau Box=1440, Pack=120... dst tergantung konversi).
     *
     * Rakus (greedy): mulai dari satuan dengan isi terbesar, ambil
     * sebanyak mungkin, sisanya dilempar ke satuan di bawahnya.
     *
     * @return array<int, array{satuan: string, jumlah: int}>
     */
    public function breakdownStok(): array
    {
        $sisaStok = $this->total_stok;

        $breakdown = [];

        $konversis = $this->konversis()
            ->with('satuan')
            ->orderByDesc('isi')
            ->get();

        foreach ($konversis as $konversi) {

            if ($sisaStok <= 0) {
                break;
            }

            $jumlah = intdiv($sisaStok, $konversi->isi);

            if ($jumlah > 0) {

                $breakdown[] = [
                    'satuan' => $konversi->satuan->nama_satuan,
                    'jumlah' => $jumlah,
                ];

                $sisaStok -= $jumlah * $konversi->isi;
            }
        }

        return $breakdown;
    }

    /**
     * Versi teks dari breakdownStok(), siap tampil di blade.
     * Mis. "1 Box, 2 Pack, 5 Tablet". Kosong -> "0" + satuan dasar.
     */
    public function breakdownStokText(): string
    {
        $breakdown = $this->breakdownStok();

        if (empty($breakdown)) {
            return '0 ' . ($this->satuanDasar->nama_satuan ?? '');
        }

        return collect($breakdown)
            ->map(fn($b) => "{$b['jumlah']} {$b['satuan']}")
            ->implode(', ');
    }

    /**
     * Cek apakah stok obat ini cukup untuk memenuhi $qty dalam satuan
     * konversi tertentu (mis. cek apakah stok cukup untuk 5 Box).
     */
    public function cukupStok(int $konversiObatId, int $qty): bool
    {
        $konversi = $this->konversis()->find($konversiObatId);

        if (!$konversi) {
            return false;
        }

        return $this->total_stok >= $konversi->qtyDasar($qty);
    }
}
