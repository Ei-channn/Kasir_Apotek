<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\transaksi;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;
use App\Models\obat;
use App\Models\User;
use App\Models\detail_transaksi;

class transaksiController extends Controller
{
    public function index() {

        $transaksi = transaksi::with('user', 'detailTransaksis.obat')->paginate(10);
        return new ApiResource($transaksi, true, 'Transaksi Berhasil diambil');
        
    }

}
