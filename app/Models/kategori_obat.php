<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AuditLog;

class kategori_obat extends Model
{
    use AuditLog;

    protected $fillable = [
        'nama_kategori',
    ];

    public function obats()
    {
        return $this->hasMany(obat::class);
    }
}
