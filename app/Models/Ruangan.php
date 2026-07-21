<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $fillable = [

        'gudang_id',

        'nama_ruangan',

        'keterangan'

    ];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }
    public function batchObats()
    {
        return $this->hasMany(BatchObat::class);
    }
}
