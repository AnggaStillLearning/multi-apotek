<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
