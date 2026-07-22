<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'apotek_id',
        'user_id',
        'tanggal_penjualan',
        'jenis_penjualan',
        'subtotal',
        'grand_total',
        'metode_pembayaran',
        'status',
    ];

    protected $casts = [
        'tanggal_penjualan' => 'datetime',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}
