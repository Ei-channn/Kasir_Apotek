<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class laporanController extends Controller
{
    public function index()
    {
        $today = now();

        return response()->json([
            'total_harian' => Transaksi::whereDate('created_at', $today)
                ->sum('total_harga'),

            'jumlah_transaksi_harian' => Transaksi::whereDate('created_at', $today)
                ->count(),

            'total_bulanan' => Transaksi::whereMonth('created_at', $today->month)
                ->whereYear('created_at', $today->year)
                ->sum('total_harga'),

            'jumlah_transaksi_bulanan' => Transaksi::whereMonth('created_at', $today->month)
                ->whereYear('created_at', $today->year)
                ->count(),
        ]);
    }

}
