<?php

namespace App\Services;

use App\Models\BatchObat;
use App\Models\Obat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Titik masuk tunggal untuk semua perubahan stok (tambah maupun kurang).
 *
 * Kenapa disatukan di sini (bukan ditulis manual per controller):
 * - BatchObat.stok dan Obat.total_stok (kolom cache) harus selalu berubah
 *   bareng dalam satu transaction, kalau tidak Monitoring Stok Kritis jadi
 *   tidak akurat.
 * - lockForUpdate() dipakai supaya dua transaksi yang mengubah stok obat
 *   yang sama di waktu bersamaan (mis. 2 pembelian online rebutan batch
 *   terakhir) tidak saling menimpa (race condition).
 */
class StokService
{
    /**
     * Tambah stok ke sebuah batch (dipakai saat Pengadaan diselesaikan).
     *
     * Batch dicari berdasar kombinasi obat+gudang+ruangan+nomor_batch.
     * Kalau sudah ada, stoknya ditambah. Kalau belum, baris baru dibuat.
     *
     * @param array{
     *   obat_id: int,
     *   gudang_id: int,
     *   ruangan_id: int,
     *   nomor_batch: string,
     *   qty_dasar: int,
     *   tanggal_kadaluarsa?: string|null,
     *   harga_beli?: float|null,
     * } $data
     */
    public function tambahStok(array $data): BatchObat
    {
        return DB::transaction(function () use ($data) {

            $batch = BatchObat::where([
                'obat_id' => $data['obat_id'],
                'gudang_id' => $data['gudang_id'],
                'ruangan_id' => $data['ruangan_id'],
                'nomor_batch' => $data['nomor_batch'],
            ])
                ->lockForUpdate()
                ->first();

            if (!$batch) {
                $batch = new BatchObat([
                    'obat_id' => $data['obat_id'],
                    'gudang_id' => $data['gudang_id'],
                    'ruangan_id' => $data['ruangan_id'],
                    'nomor_batch' => $data['nomor_batch'],
                    'stok' => 0,
                ]);
            }

            if (array_key_exists('tanggal_kadaluarsa', $data)) {
                $batch->tanggal_kadaluarsa = $data['tanggal_kadaluarsa'];
            }

            if (array_key_exists('harga_beli', $data)) {
                $batch->harga_beli = $data['harga_beli'];
            }

            $batch->stok = ($batch->stok ?? 0) + $data['qty_dasar'];
            $batch->save();

            Obat::whereKey($data['obat_id'])
                ->lockForUpdate()
                ->increment('total_stok', $data['qty_dasar']);

            return $batch->fresh();
        });
    }

    /**
     * Kurangi stok sebuah obat sejumlah $qtyDasarDibutuhkan (satuan dasar),
     * memakai FEFO lintas batch kalau perlu. Dipakai saat Pembelian
     * berpindah status ke "diproses".
     *
     * @return Collection<int, array{batch: BatchObat, qty_diambil: int}>
     *
     * @throws \App\Exceptions\StokTidakCukupException
     */
    public function kurangiStok(
        int $obatId,
        int $qtyDasarDibutuhkan,
        ?int $gudangId = null
    ): Collection {

        return DB::transaction(function () use ($obatId, $qtyDasarDibutuhkan, $gudangId) {

            $diambilDari = BatchObat::fefoFor(
                $obatId,
                $qtyDasarDibutuhkan,
                $gudangId
            );

            foreach ($diambilDari as $item) {
                $item['batch']->decrement('stok', $item['qty_diambil']);
            }

            Obat::whereKey($obatId)
                ->lockForUpdate()
                ->decrement('total_stok', $qtyDasarDibutuhkan);

            return $diambilDari;
        });
    }
}
