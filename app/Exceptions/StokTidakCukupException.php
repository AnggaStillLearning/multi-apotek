<?php

namespace App\Exceptions;

use Exception;

/**
 * Dilempar saat total stok sebuah obat tidak cukup untuk memenuhi
 * jumlah yang diminta (dipakai oleh BatchObat::fefoFor()).
 */
class StokTidakCukupException extends Exception
{
    public int $obatId;

    public int $kurang;

    public function __construct(int $obatId, int $kurang)
    {
        $this->obatId = $obatId;
        $this->kurang = $kurang;

        parent::__construct(
            "Stok tidak mencukupi. Kurang {$kurang} satuan dasar."
        );
    }
}
