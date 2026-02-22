<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\obat;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;
use App\Models\kategori_obat;

class obatController extends Controller
{
    public function index() {
        $obat = obat::with('kategoriObat')->paginate(10);

        if ($obat->isEmpty()) {
            return new ApiResource(null, false, 'Tidak ada data obat');
        }
        
        return new ApiResource($obat, true, 'Obat Berhasil diambil');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'kode_obat' => 'required|string|max:255|unique:obats,kode_obat',
            'kategori_obat_id' => 'required|exists:kategori_obats,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'tanggal_kadaluarsa' => 'required|date',
        ]);

        if ($validator->fails()) {
            return new ApiResource(null, false, 'Validasi gagal', $validator->errors());
        }

        $obat = obat::create($request->all());
        
        return new ApiResource($obat, true, 'Obat Berhasil dibuat');
    }

    public function show($id) {
        $obat = obat::with('kategoriObat')->find($id);

        if (!$obat) {
            return new ApiResource(null, false, 'Obat tidak ditemukan');
        }

        return new ApiResource($obat, true, 'Obat Berhasil diambil');
    }

    public function update(Request $request, $id) {
        $obat = obat::find($id);

        if (!$obat) {
            return new ApiResource(null, false, 'Obat tidak ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255',
            'kode_obat' => 'required|string|max:255|unique:obats,kode_obat,' . $id,
            'kategori_obat_id' => 'required|exists:kategori_obats,id',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'tanggal_kadaluarsa' => 'required|date',
        ]);

        if ($validator->fails()) {
            return new ApiResource(null, false, 'Validasi gagal', $validator->errors());
        }

        $obat->update([
            'nama_obat' => $request->nama_obat ?? $obat->nama_obat,
            'kode_obat' => $request->kode_obat ?? $obat->kode_obat,
            'kategori_obat_id' => $request->kategori_obat_id ?? $obat->kategori_obat_id,
            'harga' => $request->harga ?? $obat->harga,
            'stok' => $request->stok ?? $obat->stok,
            'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa ?? $obat->tanggal_kadaluarsa,
        ]);
        
        return new ApiResource($obat, true, 'Obat Berhasil diupdate');
    }

    public function destroy($id) {
        $obat = obat::find($id);

        if (!$obat) {
            return new ApiResource(null, false, 'Obat tidak ditemukan');
        }

        $obat->delete();

        return new ApiResource(null, true, 'Obat Berhasil dihapus');
    }
} 
