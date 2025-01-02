<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Membuat validator manual
        $validator = Validator::make($request->all(), [
            'expires_at' => 'required|date|after:now', // Harus tanggal valid dan setelah waktu saat ini
        ], [
            'expires_at.required' => 'Masa berlaku harus diisi.',
            'expires_at.date' => 'Masa berlaku harus berupa tanggal yang valid.',
            'expires_at.after' => 'Masa berlaku harus lebih dari waktu saat ini.',
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            // Mendapatkan semua pesan kesalahan
            $errors = $validator->errors()->all();

            // Redirect kembali dengan pesan kesalahan dan input lama
            return redirect()->back()
                ->withErrors($errors)
                ->withInput();
        }

        try {
            // Simpan data token ke database
            $token = new Token();
            $token->token = bin2hex(random_bytes(2)); // Membuat token unik
            $token->expires_at = Carbon::parse($request->input('expires_at'));
            $token->save();

            // Redirect kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Token berhasil dibuat.');
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error saat menyimpan token: ' . $e->getMessage());

            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat token. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
        
        // Cari token berdasarkan ID
        $token = Token::find($id);

        // Validasi jika token tidak ditemukan
        if (!$token) {
            return redirect()->back()->with('error', 'Token tidak ditemukan.');
        }

        try {
            // Hapus token
            $token->delete();

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Token berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani error saat penghapusan
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus token.');
        }
    }
}
