<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    // Menampilkan detail transaksi berdasarkan ID transaksi
    public function index($transactionId)
    {
        $details = TransactionDetail::where('transaction_id', $transactionId)->get();

        return response()->json([
            'status' => 'success',
            'data' => $details,
            'message' => 'Detail transaksi berhasil diambil',
        ]);
    }

    // Menambahkan detail transaksi
    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,transaction_id',
            'product_id' => 'required|exists:products,id',
            'product_quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock_quantity < $request->product_quantity) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Stok produk tidak mencukupi',
                'errorCode' => 400,
            ]);
        }

        $subtotal = $product->selling_price * $request->product_quantity;

        $detail = TransactionDetail::create([
            'transaction_id' => $request->transaction_id,
            'product_id' => $request->product_id,
            'quantity' => $request->product_quantity,
            'price' => $product->selling_price,
            'subtotal' => $subtotal,
        ]);

        $product->decrement('stock_quantity', $request->product_quantity);

        return response()->json([
            'status' => 'success',
            'data' => $detail,
            'message' => 'Detail transaksi berhasil ditambahkan',
        ]);
    }

    public function getDetailTotalByTransactionID($transaction_id)
    {
        // Ambil seluruh data transaction_details berdasarkan transaction_id
        $transactionDetails = TransactionDetail::where('transaction_id', $transaction_id)->get();

        if ($transactionDetails->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Transaction ID not found or no details available.',
            ], 404);
        }

        // Hitung jumlah subtotal untuk transaction_id tertentu
        $totalSubtotal = $transactionDetails->sum('subtotal');

        return response()->json([
            'status' => 'success',
            'data' => [
                'transaction_id' => $transaction_id,
                'total_subtotal' => $totalSubtotal,
                'details_count' => $transactionDetails->count(),
            ],
            'message' => 'Transaction details fetched successfully.',
        ]);
    }

    // Menghapus detail transaksi
    public function destroy($id)
    {
        $detail = TransactionDetail::findOrFail($id);

        Product::where('id', $detail->product_id)
            ->increment('stock_quantity', $detail->quantity);

        $detail->delete();

        return response()->json([
            'status' => 'success',
            'data' => null,
            'message' => 'Detail transaksi berhasil dihapus',
        ]);
    }

}
