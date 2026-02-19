<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\transaksi;
use App\Models\detail_transaksi;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\DB;
use App\Models\Obat;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('detailTransaksis')->paginate(10);
        return ApiResource::collection($transaksi);
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'bayar' => 'required|numeric|min:0',
            'detail' => 'required|array|min:1',
            'detail.*.obat_id' => 'required|integer',
            'detail.*.jumlah' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return new ApiResource(null, false, 'Validasi gagal', $validator->errors());
        }

        DB::beginTransaction();

        try {

            $transaksi = Transaksi::create([
                'no_transaksi' => 'TRX-' . time(),
                'user_id' => auth()->id(),
                'bayar' => $request->bayar,
                'total_harga' => 0,
                'kembalian' => 0
            ]);

            $total = 0;

            foreach ($request->detail as $item) {

                $obat = Obat::findOrFail($item['obat_id']);

                $harga = $obat->harga;
                $subtotal = $item['jumlah'] * $harga;

                $total += $subtotal;
                $kembalian = $request->bayar - $total;

                if ($kembalian < 0) {
                    return response()->json([
                        'message' => 'Uang tidak cukup'
                    ], 400);
                }

                detail_transaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'obat_id' => $obat->id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $harga,
                    'total_harga' => $subtotal
                ]);
            }

            $transaksi->update([
                'bayar' => $request->bayar,
                'kembalian' => $kembalian,
                'total_harga' => $total
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Transaksi berhasil',
                'data' => $transaksi->load('detailTransaksis')
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Gagal menyimpan transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan'
            ], 404);    
        }

        $transaksi->delete();
        return response()->json([
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }
}
