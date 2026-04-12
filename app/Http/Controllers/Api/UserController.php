<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        $users = User::paginate(10);

        if($users->isEmpty()) {
            return new ApiResource(null, false, "Data Tidak Ditemukan", 404);
        }

        return new ApiResource($users, true, "Data Berhasil Ditemukan", 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'alamat' => 'nullable|string|max:255',
            'role' => 'required|in:admin,kasir',
        ]);

        if ($validator->fails()) {
            return new ApiResource(null, false, $validator->errors(), 422);
        }

        $user = User::create($request->all());

        return new ApiResource($user, true, "Data User Berhasil Dibuat", 201);
    }

    public function show($id) {
        $user = User::find($id);

        if (!$user) {
            return new ApiResource(null, false, "Data User Tidak Ditemukan", 404);
        }

        return new ApiResource($user, true, "Data User Berhasil Ditemukan", 200);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);

        if (!$user) {
            return new ApiResource(null, false, "Data User Tidak Ditemukan", 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'alamat' => 'nullable|string|max:255',
            'role' => 'required|in:admin,kasir',
        ]);

        if ($validator->fails()) {
            return new ApiResource(null, false, $validator->errors(), 422);
        }

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'alamat' => $request->alamat ?? $user->alamat,
            'role' => $request->role ?? $user->role,
        ]);

        return new ApiResource($user, true, "Data User Berhasil Diperbarui", 200);
    }

    public function destroy($id) {
        $user = User::find($id);

        if (!$user) {
            return new ApiResource(null, false, "Data User Tidak Ditemukan", 404);
        }

        $user->delete();

        return new ApiResource(null, true, "Data User Berhasil Dihapus", 200);
    }

    public function getUser(Request $request) {
        $user = $request->user();

        return response()->json($user);
    }
}
