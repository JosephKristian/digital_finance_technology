<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\CheckTransactionStatusJob;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionSaleController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        $umkm = Umkm::where('user_id', Auth::id())->firstOrFail();

        return response()->json([
            'status' => 'success',
            'data' => $umkm->transactions,
            'message' => 'Daftar transaksi berhasil diambil',
        ]);
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sale_date' => 'required|date',
        ]);

        $umkm = UMKM::where('user_id', Auth::id())->firstOrFail();
        $transactionId = 'PSN-' . date('Ymd') . substr(uniqid('', true), -4);

        $transaction = Transaction::create([
            'transaction_id' => $transactionId,
            'umkm_id' => $umkm->id,
            'customer_id' => $request->customer_id,
            'transaction_date' => $request->sale_date,
            'total_amount' => 0,
            'information' => 'Transaksi Penjualan',
            'status' => false,
            'payment_method_id' => null,
        ]);

        // Dispatch job untuk cek status setelah 5 detik
        CheckTransactionStatusJob::dispatch($transaction->id)->delay(now()->addSeconds(5));

        return response()->json([
            'status' => 'success',
            'data' => $transaction,
            'message' => 'Transaksi berhasil dibuat',
            'valid_period' => true,
        ]);
    }


    public function checkTransactionIdValidPeriod($transaction_id)
    {
        // Cari transaksi berdasarkan transaction_id
        $transaction = Transaction::where('transaction_id', $transaction_id)->first();

        if ($transaction) {
            // Jika status transaksi 0, hapus transaksi dan kirimkan pesan kadaluarsa dengan data
            if ($transaction->status == 0) {
                $transaction->delete();
                return response()->json([
                    'status' => 'error',
                    'data' => [
                        'transaction_id' => $transaction->transaction_id,
                        'status' => $transaction->status,
                    ],
                    'message' => 'Transaction ID expired and deleted.',
                ], 410); // 410 Gone status untuk transaksi yang kadaluarsa
            }

            // Jika transaksi ditemukan dan status bukan 0, kirimkan data transaksi
            return response()->json([
                'status' => 'success',
                'data' => [
                    'transaction_id' => $transaction->transaction_id,
                    'status' => $transaction->status,
                ],
                'message' => 'Transaction ID exists.',
            ]);
        } else {
            // Jika transaksi tidak ditemukan
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Transaction ID not found.',
            ], 404);
        }
    }



    // Menyelesaikan transaksi
    public function getPaymentMethod()
    {

        $paymenMethod = PaymentMethod::get();
        return response()->json([
            'status' => 'success',
            'data' => $paymenMethod,
            'message' => 'Transaksi berhasil diselesaikan',
        ]);
    }

    public function markAsCompleted(Request $request, $transactionId)
    {
        $request->validate([
            'total_sales' => 'required|numeric',
            'payment_method_id' => 'required|uuid',
        ]);

        $transaction = Transaction::where('transaction_id', $transactionId)->firstOrFail();
        $transaction->total_amount = $request->total_sales;
        $transaction->payment_method_id = $request->payment_method_id;
        $transaction->status = true;
        $transaction->save();

        return response()->json([
            'status' => 'success',
            'data' => $transaction,
            'message' => 'Transaksi berhasil diselesaikan',
        ]);
    }
}
