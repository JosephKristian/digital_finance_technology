<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Http\Requests\StoreUmkmRequest;
use App\Http\Requests\UpdateUmkmRequest;
use App\Models\Token;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Ambil data umkms dengan relasi user
        $umkms = Umkm::with('user')->get();
        $tokens = Token::get();

        // Modifikasi data untuk menambahkan email ke dalam array
        $data = $umkms->map(function ($umkm) {
            return [
                'id' => $umkm->id,
                'name' => $umkm->name,
                'address' => $umkm->address,
                'phone' => $umkm->phone,
                'business_type' => $umkm->business_type,
                'approve' => $umkm->approve,
                'pdf' => $umkm->pdf_path,
                'user_name' => $umkm->user->name, // Nama user dari tabel users
                'email' => $umkm->user->email, // Email user dari tabel users
            ];
        });

        // Modifikasi data token jika ada
        $dataToken = $tokens ? collect($tokens)->map(function ($t) {
            return [
                'id' => $t->id ?? null,
                'token' => $t->token ?? null,
                'expires_at' => $t->expires_at ?? null,
            ];
        }) : [];

        $contents = Storage::get('w2vOuPq2RwTDU9iRlPkbXmgKE7tJMxlWHBVxl8Hk.pdf');

        // Kirim data ke view
        return view('admin.umkms.index', [
            'data' => $data,
            'tokens' => $dataToken,
        ]);
    }

    public function showPDF($filename)
    {
        // Decode nama file agar sesuai dengan path asli
        $decodedFilename = urldecode($filename);

        // Path file PDF di dalam storage
        $filePath = "public/{$decodedFilename}";

        // Cek apakah file ada di storage
        if (!Storage::exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Path lengkap file
        $fullPath = storage_path("app/{$filePath}");

        // Streaming file menggunakan response()->file
        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($decodedFilename) . '"'
        ]);
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
    public function store(StoreUmkmRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Umkm $umkm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Umkm $umkm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'name'    => 'required|string|max:255',
                'phone'   => 'required|string|max:15',
                'email'   => 'required|email|max:255',
                'address' => 'nullable|string|max:500',
            ]);

            // Cari UMKM berdasarkan ID
            $umkm = Umkm::findOrFail($id);

            // Update hanya kolom yang diizinkan
            $umkm->update([
                'name'    => $validatedData['name'],
                'phone'   => $validatedData['phone'],
                'email'   => $validatedData['email'],
                'address' => $validatedData['address'] ?? $umkm->address, // Jaga agar alamat tidak terhapus
            ]);

            // Kembali ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with('success', 'Data ' . $umkm->name . ' berhasil diperbarui.');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (ModelNotFoundException $e) {
            // Tangani error jika UMKM tidak ditemukan
            return redirect()->back()->with('error', 'UMKM tidak ditemukan.');
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function approve(Request $request, $id)
    {

        // Validasi input
        $validatedData = $request->validate([
            'password'    => 'required|string',
        ]);

        // Verifikasi password
        if (!Hash::check($validatedData['password'], Auth::user()->password)) {
            // Jika password tidak valid, kembalikan ke halaman dengan error
            return redirect()->back()->with('error', 'password anda salah !!!');
        }
        
        // Cari UMKM berdasarkan ID
        $umkm = Umkm::findOrFail($id);

        // Logika untuk mengubah status approval
        $umkm->approve = 1; // 1 berarti sudah disetujui
        $umkm->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('super-admin.umkm.index')->with('success', 'UMKM ' . $umkm->name . ' telah disetujui.');
    }

    // Method untuk menghapus data UMKM
    public function destroy(Request $request, $id)
    {
        try {

            // Validasi input
            $validatedData = $request->validate([
                'password'    => 'required|string',
            ]);

            // Verifikasi password
            if (!Hash::check($validatedData['password'], Auth::user()->password)) {
                // Jika password tidak valid, kembalikan ke halaman dengan error
                return redirect()->back()->with('error', 'password anda salah !!!');
            }

            // Cari UMKM berdasarkan ID
            $umkm = Umkm::findOrFail($id);

            $userId = $umkm->user_id;

            $user = User::findOrFail($userId);

            // Hapus UMKM
            $user->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('super-admin.umkm.index')->with('success', 'UMKM ' . $umkm->name . ' berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan (misalnya gagal mencari UMKM atau menghapusnya)
            return redirect()->route('super-admin.umkm.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
