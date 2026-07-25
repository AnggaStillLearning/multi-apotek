<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    use HasFactory;

    protected $fillable = [

        'apotek_id',

        'nama_gudang',

        'alamat',

        'keterangan',

        'status'

    ];

    public function apotek()
    {
        return $this->belongsTo(Apotek::class);
    }

    public function ruangans()
    {
        return $this->hasMany(Ruangan::class);
    }
    public function batchObats()
    {
        return $this->hasMany(BatchObat::class);
    }
    public function pengadaanDetails()
    {
        return $this->hasMany(PengadaanDetail::class);
    }
}
