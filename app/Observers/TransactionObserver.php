<?php

namespace App\Observers;

use App\Models\Coa;
use App\Models\CoaType;
use App\Models\Journal;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        //
        // dd('testing observer CREATED');
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {

        $details = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.transaction_id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->where('transaction_details.transaction_id', $transaction->transaction_id)
            ->select(
                'transaction_details.*',  // Ambil semua kolom dari transaction_details
                'transactions.*',         // Ambil semua kolom dari transactions
                'products.*',  // Ambil nama produk

            )
            ->get();
        // dd($transaction, $transaction->transaction_id, $details);

        $coaCredit = Coa::where('umkm_id', $transaction->umkm->id)
            ->where('is_active', true)
            ->where('account_name', 'LIKE', '%Barang%')
            ->whereHas('coaSub', function ($query) use ($transaction) {
                $query->where('coa_type_id', 1)
                    ->where('sub_name', 'PERSEDIAAN')
                    ->where('umkm_id', $transaction->umkm->id);
            })
            ->first();

        $coaDebit = Coa::where('umkm_id', $transaction->umkm->id)
            ->where('is_active', true)
            ->where('account_name', 'LIKE', '%Semua%')
            ->whereHas('coaSub', function ($query) use ($transaction) {
                $query->where('coa_type_id', 5)
                    ->where('sub_name', 'PEMBELIAN')
                    ->where('umkm_id', $transaction->umkm->id);
            })
            ->first();


        if (!$coaDebit || !$coaCredit) {
            redirect()->with('error', 'COA terkait tidak ditemukan.');
        }

        foreach ($details as $detail) {

            // Membuat jurnal pembalikan berdasarkan transaksi
            Journal::create([
                'umkm_id' => $transaction->umkm->id,
                'transaction_id' => $transaction->id,
                'coa_id' => $coaDebit->id,
                'description' => 'HPP - ' . $detail->name,
                'amount' => $detail->purchase_price * $detail->quantity,
                'type' => 'debit',
            ]);


            Journal::create([
                'umkm_id' => $transaction->umkm->id,
                'transaction_id' => $transaction->id,
                'coa_id' => $coaCredit->id,
                'description' => 'Persediaan -' . $detail->name,
                'amount' => $detail->purchase_price * $detail->quantity,
                'type' => 'credit',
            ]);
        }



        try {
            // Log awal observer berjalan
            Log::info('Observer UPDATED triggered for Transaction.', [
                'transaction_id' => $transaction->id,
                'umkm_id' => $transaction->umkm_id,
                'total_amount' => $transaction->total_amount,
            ]);
            // Cari tipe akun 'Asset' pada tabel coa_types
            $assetCoaType = CoaType::where('type_name', 'Asset')->first();
            // Cari tipe akun 'Revenue' pada tabel coa_types
            $revenueCoaType = CoaType::where('type_name', 'Revenue')->first();
            if (!$assetCoaType) {
                Log::error('COA Type "Asset" not found.');
            }
            if (!$revenueCoaType) {
                Log::error('COA Type "Revenue" not found.');
            }


            // Log untuk memastikan tipe akun Asset dan Revenue ditemukan
            Log::info('Fetching COA Types for Asset and Revenue.', [
                'asset_coa_type_id' => $assetCoaType->coa_type_id ?? null,
                'revenue_coa_type_id' => $revenueCoaType->coa_type_id ?? null,
            ]);

            // Cari Cash COA
            try {
                // $cashCoa = Coa::where('umkm_id', $transaction->umkm_id)
                //     ->where('is_default_receipt', true) // Default penerimaan
                //     ->whereHas('coaSub', function ($query) use ($assetCoaType, $transaction) {
                //         $query->where('coa_type_id', $assetCoaType->coa_type_id)
                //             ->where('umkm_id', $transaction->umkm_id);
                //     })
                //     ->first();

                $cashCoa = Coa::where('umkm_id', $transaction->umkm->id)
                    ->where('is_active', true)
                    ->where('is_default_receipt', true)
                    ->whereHas('coaSub', function ($query) use ($transaction) {
                        $query->where('coa_type_id', 1)
                            ->where('sub_name', 'AKTIVA')
                            ->where('umkm_id', $transaction->umkm->id);
                    })
                    ->first();



                // Log hasil query Cash COA
                Log::info('Cash COA fetched successfully.', [
                    'umkm_id' => $transaction->umkm_id,
                    'cash_coa_id' => $cashCoa->id ?? null,
                    'cash_coa_account_code' => $cashCoa->account_code ?? null,
                    'cash_coa_account_name' => $cashCoa->account_name ?? null,
                ]);
            } catch (\Exception $e) {
                // Log jika terjadi error saat mencari Cash COA
                Log::error('Error fetching Cash COA.', [
                    'umkm_id' => $transaction->umkm_id,
                    'error_message' => $e->getMessage(),
                ]);
            }

            // Cari Income COA
            try {

                // $incomeCoa = Coa::where('umkm_id', $transaction->umkm_id)
                //     ->where('is_default_receipt', true) // Default penerimaan
                //     ->where('account_code', '40101') // Default penerimaan
                //     ->whereHas('coaSub', function ($query) use ($revenueCoaType, $transaction) {
                //         $query->where('coa_type_id', $revenueCoaType->coa_type_id)
                //             ->where('umkm_id', $transaction->umkm_id);
                //     })
                //     ->first();

                $incomeCoa = Coa::where('umkm_id', $transaction->umkm->id)
                    ->where('is_active', true)
                    ->where('account_code', 4110)
                    ->whereHas('coaSub', function ($query) use ($transaction) {
                        $query->where('coa_type_id', 4)
                            ->where('sub_name', 'PENDAPATAN')
                            ->where('umkm_id', $transaction->umkm->id);
                    })
                    ->first();



                // Log hasil query Income COA
                Log::info('Income COA fetched successfully.', [
                    'umkm_id' => $transaction->umkm_id,
                    'income_coa_id' => $incomeCoa->id ?? null,
                    'income_coa_account_code' => $incomeCoa->account_code ?? null,
                    'income_coa_account_name' => $incomeCoa->account_name ?? null,
                ]);
            } catch (\Exception $e) {
                // Log jika terjadi error saat mencari Income COA
                Log::error('Error fetching Income COA.', [
                    'umkm_id' => $transaction->umkm_id,
                    'error_message' => $e->getMessage(),
                ]);
                dd('ERROR incomeCoa');
            }


            if (!$cashCoa) {
                Log::warning('Default Cash COA not found.', ['umkm_id' => $transaction->umkm_id]);
                dd('ERROR cashCOA');
            }
            if (!$incomeCoa) {
                Log::warning('Default income COA not found.', ['umkm_id' => $transaction->umkm_id]);
                dd('ERROR incomeCoa');
            }


            // Cari COA untuk pendapatan


            // Periksa apakah kedua COA ditemukan
            if ($cashCoa && $incomeCoa) {
                // Log sebelum insert ke journal untuk debit
                Log::info('Inserting debit journal.', [
                    'transaction_id' => $transaction->id,
                    'coa_id' => $cashCoa->id,
                    'description' => 'Kas',
                    'amount' => $transaction->total_amount,
                    'type' => 'debit',
                ]);

                // Debit ke kas/bank
                DB::table('journals')->insert([
                    'id' => (string) \Illuminate\Support\Str::uuid(),
                    'transaction_id' => $transaction->id,
                    'coa_id' => $cashCoa->id,
                    'umkm_id' => $transaction->umkm_id,
                    'description' => 'Kas',
                    'amount' => $transaction->total_amount,
                    'type' => 'debit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Log sebelum insert ke journal untuk kredit
                Log::info('Inserting credit journal.', [
                    'transaction_id' => $transaction->id,
                    'coa_id' => $incomeCoa->id,
                    'amount' => $transaction->total_amount,
                    'type' => 'credit',
                ]);

                // Kredit ke pendapatan
                DB::table('journals')->insert([
                    'id' => (string) \Illuminate\Support\Str::uuid(),
                    'transaction_id' => $transaction->id,
                    'coa_id' => $incomeCoa->id,
                    'umkm_id' => $transaction->umkm_id,
                    'description' => 'Pendapatan penjualan',
                    'amount' => $transaction->total_amount,
                    'type' => 'credit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                Log::info('Journals inserted successfully.', [
                    'transaction_id' => $transaction->id,
                    'debit_coa_id' => $cashCoa->id,
                    'credit_coa_id' => $incomeCoa->id,
                ]);
            } else {
                // Log jika salah satu COA tidak ditemukan
                Log::warning('One or both COAs not found.', [
                    'transaction_id' => $transaction->id,
                    'umkm_id' => $transaction->umkm_id,
                    'cash_coa_found' => $cashCoa ? true : false,
                    'income_coa_found' => $incomeCoa ? true : false,
                ]);
            }
        } catch (\Exception $e) {
            // Log error jika terjadi exception
            Log::error('Error occurred during journal creation in TransactionObserver.', [
                'transaction_id' => $transaction->id,
                'umkm_id' => $transaction->umkm_id,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            dd('Error occurred during journal creation in TransactionObserver.', [
                'transaction_id' => $transaction->id,
                'umkm_id' => $transaction->umkm_id,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
        }
    }


    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
