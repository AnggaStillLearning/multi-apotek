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

        'isi',

        'harga_jual',

        'is_default'

    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
}
