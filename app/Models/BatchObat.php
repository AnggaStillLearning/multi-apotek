<?php

namespace App\Models;

use App\Exceptions\StokTidakCukupException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BatchObat extends Model
{
    use HasFactory;

    protected $fillable = [

        'obat_id',

        'gudang_id',

        'ruangan_id',

        'nomor_batch',

        'tanggal_kadaluarsa',

        'stok',

        'harga_beli'

    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
    public function PenjualanDetails()
    {
        return $this->hasMany(PenjualanDetail::class);
    }

    public function pembelianDetails()
    {
        return $this->hasMany(PembelianDetail::class, 'batch_obat_id');
    }

    /**
     * Pilih batch mana saja yang stoknya dipakai untuk memenuhi
     * $qtyDibutuhkan satuan dasar dari obat $obatId, memakai aturan
     * FEFO (First Expired, First Out) — batch dengan tanggal kadaluarsa
     * paling dekat diambil duluan, batch tanpa tanggal kadaluarsa
     * (mis. alat kesehatan) diambil paling akhir.
     *
     * Batch yang sudah kadaluarsa (tanggal_kadaluarsa < hari ini) TIDAK
     * ikut dipertimbangkan, karena tidak boleh dijual/dipakai lagi.
     *
     * Panggil method ini di dalam DB::transaction() supaya lockForUpdate()
     * di sini benar-benar mengunci baris dan aman dari race condition
     * (dua transaksi mengambil batch yang sama secara bersamaan).
     *
     * @return Collection<int, array{batch: BatchObat, qty_diambil: int}>
     *
     * @throws StokTidakCukupException jika total stok yang tersedia
     *         (setelah batch kadaluarsa disaring) kurang dari $qtyDibutuhkan
     */
    public static function fefoFor(
        int $obatId,
        int $qtyDibutuhkan,
        ?int $gudangId = null
    ): Collection {

        $query = static::where('obat_id', $obatId)
            ->where('stok', '>', 0)
            ->where(function ($q) {
                $q->whereNull('tanggal_kadaluarsa')
                    ->orWhere('tanggal_kadaluarsa', '>=', now()->toDateString());
            });

        if ($gudangId) {
            $query->where('gudang_id', $gudangId);
        }

        $batches = $query
            ->orderByRaw('tanggal_kadaluarsa IS NULL, tanggal_kadaluarsa ASC')
            ->lockForUpdate()
            ->get();

        $sisaDibutuhkan = $qtyDibutuhkan;
        $hasil = collect();

        foreach ($batches as $batch) {

            if ($sisaDibutuhkan <= 0) {
                break;
            }

            $qtyDiambil = min($batch->stok, $sisaDibutuhkan);

            $hasil->push([
                'batch' => $batch,
                'qty_diambil' => $qtyDiambil,
            ]);

            $sisaDibutuhkan -= $qtyDiambil;
        }

        if ($sisaDibutuhkan > 0) {
            throw new StokTidakCukupException($obatId, $sisaDibutuhkan);
        }

        return $hasil;
    }
}
