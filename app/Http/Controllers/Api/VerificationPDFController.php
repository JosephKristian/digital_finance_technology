<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VerificationPDFController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string',
            'pdf_path' => 'required|file|mimes:pdf|max:2048', // Maksimal 2MB
        ]);

        try {
            // Simpan file PDF
            $filePath = $request->file('pdf_path')->store('umkm_pdfs', 'public');

            // Simpan data UMKM ke database
            $user = Auth::user();
            $umkm = $user->umkm; // Asumsi: relasi UMKM telah didefinisikan di model User
            $umkm->name = $validated['name'];
            $umkm->address = $validated['address'];
            $umkm->phone = $validated['phone'];
            $umkm->pdf_path = $filePath;
            $umkm->approve = -1; // Status verifikasi dalam proses
            $umkm->save(); // Simpan perubahan

            // Log proses berhasil
            Log::info('UMKM berhasil diverifikasi melalui PDF', [
                'user_id' => $user->id,
                'umkm_data' => $umkm,
            ]);

            // Respons sukses
            return response()->json([
                'status' => 'success',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                    'umkm' => [
                        'id' => $umkm->id,
                        'name' => $umkm->name,
                        'address' => $umkm->address,
                        'phone' => $umkm->phone,
                        'pdf_url' => Storage::url($filePath),
                        'approve' => $umkm->approve,
                    ],
                ],
                'message' => 'UMKM berhasil diverifikasi. Verifikasi sedang dalam proses, harap tunggu persetujuan.',
            ], 201);
        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal memproses verifikasi UMKM', [
                'error' => $e->getMessage(),
            ]);

            // Respons error
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Gagal memproses verifikasi UMKM. Silakan coba lagi.',
                'errorCode' => 500,
                'errors' => $e->getMessage(),
            ], 500);
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
