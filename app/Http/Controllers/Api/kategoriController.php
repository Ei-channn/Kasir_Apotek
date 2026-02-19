<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\kategori_obat;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class kategoriController extends Controller
{
    public function index() {
        $kategoriobat = kategori_obat::paginate(10);
        
        return new ApiResource($kategoriobat, true, 'Kategori Obat Berhasil diambil');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return new ApiResource(null, false, 'Validasi gagal', $validator->errors());
        }

        $kategoriobat = kategori_obat::create($request->all());
        
        return new ApiResource($kategoriobat, true, 'Kategori Obat Berhasil dibuat');
    }

    public function show($id) {
        $kategoriobat = kategori_obat::find($id);

        if (!$kategoriobat) {
            return new ApiResource(null, false, 'Kategori Obat tidak ditemukan');
        }

        return new ApiResource($kategoriobat, true, 'Kategori Obat Berhasil diambil');
    }

    public function update(Request $request, $id) {
        $kategoriobat = kategori_obat::find($id);

        if (!$kategoriobat) {
            return new ApiResource(null, false, 'Kategori Obat tidak ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return new ApiResource(null, false, 'Validasi gagal', $validator->errors());
        }

        $kategoriobat->update([
            'nama_kategori' => $request->nama_kategori ?? $kategoriobat->nama_kategori,    
        ]);

        return new ApiResource($kategoriobat, true, 'Kategori Obat Berhasil diupdate');
    }

    public function destroy($id) {
        $kategoriobat = kategori_obat::find($id);

        if (!$kategoriobat) {
            return new ApiResource(null, false, 'Kategori Obat tidak ditemukan');
        }

        $kategoriobat->delete();

        return new ApiResource(null, true, 'Kategori Obat Berhasil dihapus');
    }
}
