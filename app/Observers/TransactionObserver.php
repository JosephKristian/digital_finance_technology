<?php

namespace App\Observers;

use App\Models\Coa;
use App\Models\Transaction;
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
        try {
            // Log awal observer berjalan
            Log::info('Observer UPDATED triggered for Transaction.', [
                'transaction_id' => $transaction->id,
                'umkm_id' => $transaction->umkm_id,
                'total_amount' => $transaction->total_amount,
            ]);

            // Cari COA untuk kas/bank
            $cashCoa = Coa::where('umkm_id', $transaction->umkm_id)
                ->where('account_type', 'asset')
                ->where('is_default_receipt', true)
                ->first();

            Log::info('Cash COA fetched.', [
                'umkm_id' => $transaction->umkm_id,
                'cash_coa_id' => $cashCoa?->id,
                'cash_coa_account_code' => $cashCoa?->account_code,
                'cash_coa_account_name' => $cashCoa?->account_name,
            ]);

            // Cari COA untuk pendapatan
            $incomeCoa = Coa::where('umkm_id', $transaction->umkm_id)
                ->where('account_type', 'income')
                ->where('is_default_receipt', true)
                ->first();

            Log::info('Income COA fetched.', [
                'umkm_id' => $transaction->umkm_id,
                'income_coa_id' => $incomeCoa?->id,
                'income_coa_account_code' => $incomeCoa?->account_code,
                'income_coa_account_name' => $incomeCoa?->account_name,
            ]);

            // Periksa apakah kedua COA ditemukan
            if ($cashCoa && $incomeCoa) {
                // Log sebelum insert ke journal untuk debit
                Log::info('Inserting debit journal.', [
                    'transaction_id' => $transaction->id,
                    'coa_id' => $cashCoa->id,
                    'description' => 'Penerimaan kas',
                    'amount' => $transaction->total_amount,
                    'type' => 'debit',
                ]);

                // Debit ke kas/bank
                DB::table('journals')->insert([
                    'id' => (string) \Illuminate\Support\Str::uuid(),
                    'transaction_id' => $transaction->id,
                    'coa_id' => $cashCoa->id,
                    'umkm_id' => $transaction->umkm_id,
                    'description' => 'Penerimaan kas',
                    'amount' => $transaction->total_amount,
                    'type' => 'debit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Log sebelum insert ke journal untuk kredit
                Log::info('Inserting credit journal.', [
                    'transaction_id' => $transaction->id,
                    'coa_id' => $incomeCoa->id,
                    'description' => 'Pendapatan penjualan',
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
