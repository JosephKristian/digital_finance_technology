<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coa;
use App\Models\Journal;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Umkm;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class MasterDataProductController extends Controller
{
    /**
     * Menampilkan data UMKM dan produk terkait.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            // Ambil data UMKM berdasarkan user yang sedang login
            $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();

            // Ambil produk terkait dengan UMKM
            $products = Product::where('umkm_id', $umkm->id)->get();

            // Kirim respons dengan data UMKM dan produk
            return response()->json([
                'status' => 'success',
                'data' => [
                    'umkm' => [
                        'id' => $umkm->id,
                        'name' => $umkm->name,
                        'address' => $umkm->address,
                        'phone' => $umkm->phone,
                    ],
                    'products' => $products->map(function ($product) {
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => $product->selling_price,
                            'stock' => $product->stock_quantity,
                            'status' => $product->status,
                        ];
                    }),
                ],
                'message' => 'Data UMKM dan produk berhasil diambil.',
            ], 200);
        } catch (ModelNotFoundException $e) {
            // Menangani jika UMKM atau produk tidak ditemukan
            return response()->json([
                'status' => 'error',
                'message' => 'Data UMKM atau produk tidak ditemukan.',
            ], 404);
        } catch (Exception $e) {
            // Menangani kesalahan umum lainnya
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan, silakan coba lagi.',
            ], 500);
        }
    }

    /**
     * Menyimpan produk baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
            $uuidTransaction = Str::uuid();
            $date = today();

            // Validasi input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'purchase_price' => 'required|numeric',
                'selling_price' => 'required|numeric',
                'stock_quantity' => 'required|integer',
            ]);

            $productId = 'PRD-' . date('Ymd') . substr(uniqid('', true), -4);
            $totalAmount = $validated['purchase_price'] * $validated['stock_quantity'];

            // Buat transaksi
            Transaction::create([
                'id' => $uuidTransaction,
                'umkm_id' => $umkm->id,
                'transaction_id' => $productId,
                'transaction_date' => $date,
                'total_amount' => $totalAmount,
                'information' => 'Pembelian Produk Awal',
                'status' => true,
            ]);

            // Cari COA debit dan kredit
            $coaDebit = Coa::where('umkm_id', $umkm->id)
                ->where('is_active', true)
                ->where('account_code', '10103')
                ->where('is_default_receipt', false)
                ->where('is_default_expense', false)
                ->first();

            $coaCredit = Coa::where('umkm_id', $umkm->id)
                ->where('is_active', true)
                ->where('account_code', '10101')
                ->where('is_default_receipt', true)
                ->first();

            if (!$coaDebit || !$coaCredit) {
                Log::error("COA terkait tidak ditemukan untuk transaksi ID: {$productId}", ['request' => $request->all()]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'COA terkait tidak ditemukan.',
                ], 400);
            }

            // Simpan jurnal
            Journal::create([
                'umkm_id' => $umkm->id,
                'transaction_id' => $uuidTransaction,
                'coa_id' => $coaDebit->id,
                'description' => $coaDebit->account_name,
                'amount' => $totalAmount,
                'type' => 'debit',
            ]);

            Journal::create([
                'umkm_id' => $umkm->id,
                'transaction_id' => $uuidTransaction,
                'coa_id' => $coaCredit->id,
                'description' => $coaCredit->account_name,
                'amount' => $totalAmount,
                'type' => 'credit',
            ]);

            // Simpan produk
            $product = Product::create([
                'id' => $productId,
                'umkm_id' => $umkm->id,
                'name' => $validated['name'],
                'purchase_price' => $validated['purchase_price'],
                'selling_price' => $validated['selling_price'],
                'stock_quantity' => $validated['stock_quantity'],
                'status' => 'active',
            ]);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'product' => $product,
                ],
                'message' => 'Produk berhasil didaftarkan!',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Menangani error validasi
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Menangani jika UMKM tidak ditemukan
            return response()->json([
                'status' => 'error',
                'message' => 'UMKM tidak ditemukan.',
            ], 404);
        } catch (\Exception $e) {
            // Menangani error umum lainnya
            Log::error('Terjadi kesalahan saat menyimpan produk.', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan, silakan coba lagi.',
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
    public function update(Request $request, $id)
    {
        try {
            // Mendapatkan data UMKM terkait user
            $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();

            // Validasi input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'selling_price' => 'required|numeric',
            ]);

            // Mendapatkan produk berdasarkan ID
            $product = Product::where('id', $id)
                ->where('umkm_id', $umkm->id)
                ->firstOrFail();

            // Update produk
            $product->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbaharui!',
                'data' => $product,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan atau Anda tidak memiliki akses.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbaharui produk.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            // Mendapatkan data UMKM yang terkait dengan user
            $umkm = Umkm::where('user_id', $request->user()->id)->firstOrFail();

            // Mendapatkan produk yang ingin dihapus
            $product = Product::where('id', $id)
                ->where('umkm_id', $umkm->id)
                ->firstOrFail();

            $productName = $product->name;

            // Kalkulasi total nilai persediaan yang akan dihapus
            $totalValue = $product->purchase_price * $product->stock_quantity;

            // Membuat ID transaksi baru
            $transactionId = Str::uuid();
            $transactionDate = now();

            // Membuat transaksi
            Transaction::create([
                'id' => $transactionId,
                'transaction_id' => 'TRX-' . date('YmdHis'),
                'umkm_id' => $umkm->id,
                'transaction_date' => $transactionDate,
                'total_amount' => $totalValue,
                'information' => 'Penghapusan Produk: ' . $productName,
                'status' => 0, // Status diatur ke 0 untuk menunjukkan transaksi pembalikan
            ]);

            // Mendapatkan akun COA terkait
            $coaDebit = Coa::where('umkm_id', $umkm->id)
                ->where('account_code', '10101') // Kas atau rekening pengeluaran
                ->first();

            $coaCredit = Coa::where('umkm_id', $umkm->id)
                ->where('account_code', '10103') // Persediaan
                ->first();

            if (!$coaDebit || !$coaCredit) {
                return response()->json([
                    'success' => false,
                    'message' => 'COA terkait tidak ditemukan.',
                ], 404);
            }

            // Membuat jurnal pembalikan berdasarkan transaksi
            Journal::create([
                'umkm_id' => $umkm->id,
                'transaction_id' => $transactionId,
                'coa_id' => $coaDebit->id,
                'description' => 'Pembalikan Persediaan - ' . $productName,
                'amount' => $totalValue,
                'type' => 'debit',
            ]);

            Journal::create([
                'umkm_id' => $umkm->id,
                'transaction_id' => $transactionId,
                'coa_id' => $coaCredit->id,
                'description' => 'Pembalikan Persediaan - ' . $productName,
                'amount' => $totalValue,
                'type' => 'credit',
            ]);

            // Menghapus produk
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus, transaksi dicatat, dan jurnal telah diperbarui.',
                'data' => [
                    'transaction_id' => $transactionId,
                    'product_name' => $productName,
                    'total_value' => $totalValue,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus produk.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
