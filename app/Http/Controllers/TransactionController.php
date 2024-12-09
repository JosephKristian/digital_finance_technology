<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\UMKM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    // Menampilkan daftar transaksi untuk UMKM berdasarkan user login
    public function index(Request $request)
    {
        // Ambil UMKM yang terkait dengan pengguna yang sedang login
        $umkm = UMKM::with(['transactions.details', 'products', 'customers'])
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        // Ambil transaction_id dari session
        $transactionId = session('transactionId');
        $paymentMethods = PaymentMethod::all();
        // Jika ada transaction_id, ambil detail transaksi yang sesuai
        $detailTransactions = null;
        if ($transactionId) {
            // Cari transaksi berdasarkan transaction_id
            $transactions = TransactionDetail::where('transaction_id', $transactionId)->get();

            // Jika transaksi ditemukan, ambil detailnya
            if ($transactions) {
                $detailTransactions = $transactions; // Ambil relasi 'details' dari transaksi
            }
        }

        return view('umkm.transaction.sale.index', [
            'umkm' => $umkm,
            'transactions' => $umkm->transactions,
            'products' => $umkm->products,
            'customers' => $umkm->customers,
            'detailTransactions' => $detailTransactions, // Kirim detail transaksi ke view
            'paymentMethods' => $paymentMethods, // Kirim detail transaksi ke view
        ]);
    }



    // Menyimpan transaksi baru
    public function create(Request $request)
    {
        $umkm = UMKM::where('user_id', Auth::user()->id)->firstOrFail(); // Ambil UMKM milik user yang login
        $transactionId = 'PSN-' . date('Ymd') . substr(uniqid('', true), -4);

        // Validasi request
        $request->validate([
            'customer_id' => 'required|exists:customers,id',  // Pastikan ID pelanggan ada di tabel customers
            'sale_date' => 'required|date',  // Pastikan sale_date adalah tanggal yang valid
        ]);

        $customer = Customer::where('id', $request->customer_id)->firstOrFail(); // Ambil data pelanggan berdasarkan ID

        // Simpan Transaksi
        $transaction = Transaction::create([
            'transaction_id' => $transactionId,
            'umkm_id' => $umkm->id,
            'customer_id' => $request->customer_id,
            'transaction_date' => $request->sale_date,  // Gunakan sale_date dari form
            'total_amount' => 0,
        ]);


        // Menyimpan data transaksi di session
        session()->put('transactionId', $transaction->transaction_id);
        session()->put('transactionDate', $transaction->transaction_date);
        session()->put('customerName', $customer->name);

        session()->put('session_start_time', now());

        return redirect()->route('transactions.index')
            ->with('success', 'Penjualan dengan ID ' . $transaction->transaction_id . ' berhasil dibuat!');
    }


    // Menampilkan form untuk membuat transaksi baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,transaction_id',
            'product_id' => 'required|exists:products,id',
            'product_quantity' => 'required|integer|min:1',
        ]);

        // Ambil harga produk dari database
        $product = DB::table('products')->where('id', $validated['product_id'])->first();

        if (!$product) {
            return back()->withErrors(['product_id' => 'Produk tidak ditemukan.']);
        }

        // Cek apakah stok mencukupi
        if ($product->stock_quantity < $validated['product_quantity']) {
            return back()->withErrors(['product_quantity' => 'Stok produk tidak mencukupi.']);
        }

        // Hitung harga dan subtotal
        $price = $product->selling_price; // Pastikan kolom 'price' ada di tabel 'products'
        $quantity = $validated['product_quantity'];
        $subtotal = $price * $quantity;

        // Simpan data ke tabel 'transaction_details'
        DB::table('transaction_details')->insert([
            'transaction_id' => $validated['transaction_id'],
            'product_id' => $validated['product_id'],
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // Kurangi jumlah stok di tabel 'products'
        DB::table('products')->where('id', $validated['product_id'])->decrement('stock_quantity', $quantity);


        return redirect()->route('transactions.index');
    }

    // Menghapus detail transaksi
    public function destroyDetail($id)
    {
        // Cari detail transaksi berdasarkan ID
        $detail = TransactionDetail::findOrFail($id);

        // Mengupdate stok produk, menambahkannya sesuai dengan quantity yang ada di detail transaksi
        Product::where('id', $detail->product_id)
            ->update(['stock_quantity' => DB::raw('stock_quantity + ' . $detail->quantity)]);

        // Hapus detail transaksi
        $detail->delete();

        // Kembalikan response
        return back()->with('success', 'Detail transaksi berhasil dihapus dan stok dikembalikan.');
    }


    public function markAsCompleted($transactionId, Request $request)
    {
        // Cari transaksi berdasarkan transaction_id
        $transaction = Transaction::where('transaction_id', $transactionId)->firstOrFail();


        // Update total_amount dengan nilai yang dikirimkan
        $transaction->total_amount = preg_replace('/[^0-9.]/', '', $request->total_sales); // Menghilangkan karakter selain angka dan titik

        // Update metode pembayaran yang dipilih
        $transaction->payment_method_id = $request->payment_method_id;

        // Ubah status transaksi menjadi selesai (misalnya, 'true' atau 'completed')
        $transaction->status = true;

        // Simpan perubahan
        $transaction->save();
        // Hapus session
        session()->forget('transactionId');
        session()->forget('transactionDate');
        session()->forget('customerName');
        session()->forget('session_start_time');
        // Kembalikan response
        return redirect()->route('transactions.index')->with('success', 'Asyik!! Penjualan berhasil diselesaikan.');
    }
}
