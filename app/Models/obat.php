<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class obat extends Model
{
    protected $fillable = [
        'nama_obat',
        'kode_obat',
        'kategori_obat_id',
        'harga',
        'stok',
        'tanggal_kadaluarsa',
    ];

    public function kategoriObat()
    {
        return $this->belongsTo(kategori_obat::class);
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
