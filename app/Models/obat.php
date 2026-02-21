<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditLog;

class obat extends Model
{
    use AuditLog;

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
