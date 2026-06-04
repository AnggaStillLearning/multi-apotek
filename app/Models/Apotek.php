<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apotek extends Model
{
    protected $fillable = [
        'nama_apotek',
        'alamat'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function obats()
    {
        return $this->hasMany(Obat::class);
    }
}
