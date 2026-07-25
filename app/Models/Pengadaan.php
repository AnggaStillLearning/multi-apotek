<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    protected $fillable = [
        'supplier_id',
        'apotek_id',
        'user_id',
        'nomor_pengadaan',
        'tanggal_pengadaan',
        'subtotal',
        'grand_total',
        'status',
        'keterangan',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function apotek()
    {
        return $this->belongsTo(Apotek::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PengadaanDetail::class);
    }
}
