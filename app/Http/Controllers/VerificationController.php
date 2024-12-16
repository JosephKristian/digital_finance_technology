<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Journal;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class VerificationController extends Controller
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
    public function umkm(Request $request)
    {
        return redirect()->route('dashboard-umkm');
    }

    // Method untuk memverifikasi UMKM dengan token
    public function verifyWithToken(Request $request)
    {

        // Validasi input
        $validated = $request->validate([
            'nameToken' => 'required|string|max:255',
            'addressToken' => 'required|string|max:255',
            'phoneToken' => 'required|string|max:15',
            'token' => 'required|string', // Menyesuaikan ukuran token
        ]);

        // Logika untuk memverifikasi token
        $token = Token::where('token', $validated['token'])->first();; // Token yang valid, bisa diganti dengan pengecekan di database
        if ($token && !$token->isExpired()) {
            // Token valid dan belum kedaluwarsa
            Log::info('Token valid, melanjutkan proses verifikasi');
            $user = Auth::user(); // Ambil user yang sedang login
            $umkmData = $user->umkm; // Ambil data UMKM terkait user

            // Update kolom 'approve' menjadi true
            $umkmData->name = $validated['nameToken'];
            $umkmData->address = $validated['addressToken'];
            $umkmData->phone = $validated['phoneToken'];
            $umkmData->approve = true;
            $umkmData->save(); // Simpan perubahan

            // Simpan status approve ke session
            session(['umkm_approve' => $umkmData->approve]);

            // Kirim data UMKM ke view
            return redirect()->route('dashboard-umkm');
        } else {
            // Token tidak valid atau sudah kedaluwarsa
            Log::error('Token tidak valid atau sudah kedaluwarsa');
            return redirect()->back()->with('error', 'Token tidak valid atau sudah kedaluwarsa!');
        }
    }


    public function verifyWithPDF(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string',
            'pdf_path' => 'required|file|mimes:pdf|max:2048', // Maks 2MB
        ]);

        try {
            // Simpan file PDF
            $filePath = $request->file('pdf_path')->store('umkm_pdfs', 'public');

            // Simpan data UMKM ke database
            $user = Auth::user();
            $umkm = $user->umkm; // Asumsi: relasi UMKM telah didefinisikan
            $umkm->name = $validated['name'];
            $umkm->address = $validated['address'];
            $umkm->phone = $validated['phone'];
            $umkm->pdf_path = $filePath;
            $umkm->approve = -1;
            $umkm->save(); // Simpan perubahan

            // Log proses berhasil
            Log::info('UMKM berhasil diverifikasi melalui PDF', [
                'user_id' => $user->id,
                'umkm_data' => $umkm,
            ]);
            // Simpan status approve ke session
            session(['umkm_approve' => $umkm->approve]);

            // Kirim data UMKM ke view
            return redirect()->route('dashboard-umkm');
        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal memproses verifikasi UMKM', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses verifikasi. Silakan coba lagi.');
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
