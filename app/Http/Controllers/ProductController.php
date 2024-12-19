<?php

namespace App\Http\Controllers;

use App\Models\Coa;
use App\Models\Journal;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Umkm;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function Pest\Laravel\get;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        $products = Product::where('umkm_id', $umkm->id)->get();

        // dd($umkm, $products, $umkm->id);
        return view('umkm.products.index', compact('products', 'umkm'));
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        $uuidTransaction = Str::uuid();
        $date = today();
        // dd($request, $umkm);
        $request->validate([
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
        ]);

        $productId = 'PRD-' . date('Ymd') . substr(uniqid('', true), -4);

        $totalAmount = $request->purchase_price * $request->stock_quantity;

        Transaction::create([
            'id' => $uuidTransaction,
            'umkm_id' => $umkm->id,
            'transaction_id' => $productId,
            'transaction_date' => $date,
            'total_amount' => $totalAmount,
            'information' => 'Pembelian Produk Awal',
            'status' => true,
        ]);


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
            return redirect()->route('other.transactions.index')->with('error', 'COA terkait tidak ditemukan.');
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

        Product::create([
            'id' => $productId,
            'umkm_id' => $umkm->id,
            'name' => $request->name,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'stock_quantity' => $request->stock_quantity,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'Produk ' . $request->name . ' berhasil didaftarkan!');
    }

    // Memperbarui produk
    public function update(Request $request, $id)
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        $request->validate([
            'name' => 'required|string|max:255',
            'selling_price' => 'required|numeric',
        ]);

        $product = Product::where('id', $id)
            ->where('umkm_id', $umkm->id)
            ->firstOrFail();


        $product->update($request->all());

        return redirect()->back()->with('success', 'Produk ' . $request->name . ' berhasil diperbaharui!');
    }

    // Menghapus produk
    public function destroy($id)
    {
        try {
            // Mendapatkan data UMKM yang terkait dengan user
            $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
    
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
                return redirect()->back()->with('error', 'COA terkait tidak ditemukan.');
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
    
            return redirect()->back()->with('success', 'Produk ' . $productName . ' berhasil dihapus, transaksi dicatat, dan jurnal telah diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
    
}
