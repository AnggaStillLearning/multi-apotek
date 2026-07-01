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

        'tanggal',

        'total_harga',

        'status'

    ];

    protected $casts = [

        'tanggal' => 'datetime',

    ];

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
