<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pest\ArchPresets\Custom;

class MasterDataCustomerController extends Controller
{
    /**
     * Menampilkan daftar pelanggan dalam format JSON.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Mendapatkan data UMKM terkait dengan user yang sedang login
            $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();

            // Mendapatkan daftar pelanggan yang terkait dengan UMKM
            $customers = Customer::where('umkm_id', $umkm->id)->get();

            // Mengembalikan response JSON
            return response()->json([
                'success' => true,
                'message' => 'Daftar pelanggan berhasil diambil.',
                'data' => $customers,
            ], 200);
        } catch (\Exception $e) {
            // Menangani error jika terjadi
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil daftar pelanggan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Menyimpan pelanggan baru dalam format JSON.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:15',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string|max:255',
                'preferred_contact_method' => 'nullable|in:phone,email',
            ]);

            // Mendapatkan UMKM yang terkait dengan user yang sedang login
            $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();

            // Menyimpan data pelanggan baru
            $customer = Customer::create([
                'umkm_id' => $umkm->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'preferred_contact_method' => $request->preferred_contact_method,
            ]);

            // Mengembalikan respons JSON jika berhasil
            return response()->json([
                'success' => true,
                'message' => 'Pelanggan berhasil ditambahkan.',
                'data' => $customer,
            ], 201);
        } catch (\Exception $e) {
            // Menangani error jika terjadi
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan pelanggan.',
                'error' => $e->getMessage(),
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
     * Memperbarui data pelanggan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:15',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string|max:255',
                'preferred_contact_method' => 'nullable|in:phone,email',
            ]);

            // Mendapatkan UMKM yang terkait dengan user yang sedang login
            $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();

            // Debugging: Cek apakah UMKM ditemukan
            if (!$umkm) {
                return response()->json([
                    'success' => false,
                    'message' => 'UMKM tidak ditemukan.',
                ], 404);
            }

            // Mendapatkan pelanggan yang ingin diperbarui
            $customer = Customer::where('id', $id)
                ->where('umkm_id', $umkm->id)
                ->first();

            // Debugging: Cek apakah pelanggan ditemukan
            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pelanggan tidak ditemukan.',
                ], 404);
            }

            // Memperbarui data pelanggan
            $customer->update($request->all());

            // Mengembalikan respons JSON jika berhasil
            return response()->json([
                'success' => true,
                'message' => 'Pelanggan berhasil diperbarui.',
                'data' => $customer,
            ], 200);
        } catch (\Exception $e) {
            // Menangani error jika terjadi
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui pelanggan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Menghapus pelanggan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Mendapatkan pelanggan yang ingin dihapus
            $customer = Customer::where('id', $id)
                ->whereHas('umkm', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->firstOrFail();

            $customerName = $customer->name;

            // Menghapus pelanggan
            $customer->delete();

            // Mengembalikan respons JSON jika berhasil
            return response()->json([
                'success' => true,
                'message' => 'Pelanggan ' . $customerName . ' berhasil dihapus!',
            ], 200);
        } catch (\Exception $e) {
            // Menangani error jika terjadi
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus pelanggan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
