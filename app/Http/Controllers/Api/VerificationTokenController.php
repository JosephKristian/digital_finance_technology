<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VerificationTokenController extends Controller
{
    /**
     * Menampilkan seluruh data token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Ambil seluruh data token dari tabel Token
        $tokens = Token::all();

        // Cek apakah data token ditemukan
        if ($tokens->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada token yang ditemukan.',
            ], 404);
        }

        // Kirim respons dengan data token
        return response()->json([
            'status' => 'success',
            'data' => $tokens,
        ], 200);
    }

    /**
     * Verifikasi token dan perbarui status UMKM.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'token' => 'required|string', // Menyesuaikan ukuran token
        ]);

        // Logika untuk memverifikasi token
        $token = Token::where('token', $validated['token'])->first(); // Token yang valid, bisa diganti dengan pengecekan di database

        if (!$token) {
            // Token tidak ditemukan
            Log::error('Token tidak ditemukan');

            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid.',
            ], 400);
        }

        // Token ditemukan, cek apakah sudah kedaluwarsa
        if ($token->isExpired()) {
            // Token sudah kedaluwarsa
            Log::error('Token sudah kedaluwarsa');

            return response()->json([
                'status' => 'error',
                'message' => 'Token sudah kedaluwarsa.',
            ], 400);
        }

        // Token valid dan belum kedaluwarsa
        Log::info('Token valid, melanjutkan proses verifikasi');

        $user = Auth::user(); // Ambil user yang sedang login
        $umkmData = $user->umkm; // Ambil data UMKM terkait user

        // Update kolom 'approve' menjadi true
        $umkmData->name = $validated['name'];
        $umkmData->address = $validated['address'];
        $umkmData->phone = $validated['phone'];
        $umkmData->approve = true;
        $umkmData->save(); // Simpan perubahan

        // Simpan status approve ke session
        session(['umkm_approve' => $umkmData->approve]);

        // Kirim respons sukses dengan data
        return response()->json([
            'status' => 'success',
            'data' => [
                'umkm' => [
                    'id' => $umkmData->id,
                    'name' => $umkmData->name,
                    'address' => $umkmData->address,
                    'phone' => $umkmData->phone,
                    'approve' => $umkmData->approve,
                ],
            ],
            'message' => 'Token berhasil diverifikasi, UMKM telah disetujui.',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
