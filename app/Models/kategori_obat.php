<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori_obat extends Model
{
    protected $fillable = [
        'nama_kategori',
    ];

    public function obats()
    {
        return $this->hasMany(obat::class);
    }
}
