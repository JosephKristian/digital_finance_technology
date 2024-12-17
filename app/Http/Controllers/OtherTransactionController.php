<?php

namespace App\Http\Controllers;

use App\Models\OtherTransaction;
use App\Http\Requests\StoreOtherTransactionRequest;
use App\Http\Requests\UpdateOtherTransactionRequest;
use App\Models\Coa;
use App\Models\CoaType;
use App\Models\Journal;
use App\Models\Transaction;
use App\Models\Umkm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OtherTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
/**
     * Tampilkan halaman transaksi lainnya.
     */
    public function index()
    {
        // Ambil data COA berdasarkan kategori coa_type_id
        $incomeTypeId = CoaType::where('type_name', 'Revenue')->first()?->coa_type_id; // Cari ID untuk tipe Revenue
        $expenseTypeId = CoaType::where('type_name', 'Expense')->first()?->coa_type_id; // Cari ID untuk tipe Expense
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        // Validasi jika tipe tidak ditemukan
        if (!$incomeTypeId || !$expenseTypeId) {
            abort(500, 'COA types for Revenue or Expense not found.');
        }

        $incomeOptions = Coa::where('is_active', true)
            ->where('umkm_id', $umkm->id)
            ->whereHas('coaSub', function ($query) use ($umkm) {
                $query->where('coa_type_id', 4) // 4 = Revenue
                    ->where('umkm_id', $umkm->id);
            })
            ->pluck('account_name', 'id');

        $expenseOptions = Coa::where('is_active', true)
            ->where('umkm_id', $umkm->id)
            ->whereHas('coaSub', function ($query) use ($umkm) {
                $query->where('coa_type_id', 5) // 5 = Expense
                    ->where('umkm_id', $umkm->id);
            })
            ->pluck('account_name', 'id');


        return view('umkm.transaction.others.index', [
            'incomeOptions' => $incomeOptions,
            'expenseOptions' => $expenseOptions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreOtherTransactionRequest $request)
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        $transactionId = 'OTR-' . date('Ymd') . substr(uniqid('', true), -4);
        $uuidTransaction = Str::uuid();
        // Aktifkan query log
        DB::enableQueryLog();

        // Simpan transaksi
        $transaction = Transaction::create([
            'id' => $uuidTransaction,
            'umkm_id' => $umkm->id,
            'transaction_id' => $transactionId,
            'transaction_date' => $request->tanggalTransaksi,
            'total_amount' => $request->nominal,
            'information' => $request->keterangan,
            'status' => true,
        ]);

        // Log data transaksi
        Log::info('Transaksi berhasil disimpan', [
            'id' => $uuidTransaction,
            'umkm_id' => $umkm->id,
            'transaction_id' => $transactionId,
            'transaction_date' => $request->tanggalTransaksi,
            'total_amount' => $request->nominal,
            'information' => $request->keterangan,
            'status' => true,
        ]);

        // Ambil query log
        $queries = DB::getQueryLog();

        // Log query yang dijalankan
        foreach ($queries as $query) {
            Log::info('Query executed', [
                'query' => $query['query'],
                'bindings' => $query['bindings'],
                'time' => $query['time']
            ]);
        }



        $transactionCategory = $request->kategori == 'income' ? 'Penerimaan' : 'Pengeluaran';

        // Tentukan COA
        if ($request->kategori == 'income') {
            $coaDebit = Coa::where('umkm_id', $umkm->id)
                ->where('is_active', true)
                ->where('account_code', '10101')
                ->where('is_default_receipt', true)
                ->first();

            $coaCredit = Coa::where('id', $request->namaTransaksi)
                ->where('umkm_id', $umkm->id)
                ->where('is_active', true)
                ->first();
        } elseif ($request->kategori == 'expense') {
            $coaDebit = Coa::where('id', $request->namaTransaksi)
                ->where('umkm_id', $umkm->id)
                ->where('is_active', true)
                ->first();

            $coaCredit = Coa::where('umkm_id', $umkm->id)
                ->where('is_active', true)
                ->where('account_code', '10101')
                ->where('is_default_receipt', true)
                ->first();
        }

        if (!$coaDebit || !$coaCredit) {
            Log::error("COA terkait tidak ditemukan untuk transaksi ID: {$transactionId}", ['request' => $request->all()]);
            return redirect()->route('other.transactions.index')->with('error', 'COA terkait tidak ditemukan.');
        }

        // Simpan jurnal
        Journal::create([
            'umkm_id' => $umkm->id,
            'transaction_id' => $uuidTransaction,
            'coa_id' => $coaDebit->id,
            'description' => $coaDebit->account_name,
            'amount' => $request->nominal,
            'type' => 'debit',
        ]);

        Journal::create([
            'umkm_id' => $umkm->id,
            'transaction_id' => $uuidTransaction,
            'coa_id' => $coaCredit->id,
            'description' => $coaCredit->account_name,
            'amount' => $request->nominal,
            'type' => 'credit',
        ]);


        Log::info("Transaksi berhasil disimpan", [
            'transaction_id' => $transactionId,
            'umkm_id' => $umkm->id,
            'nominal' => $request->nominal,
            'kategori' => $transactionCategory,
            'tanggal' => $request->tanggalTransaksi,
        ]);

        // Detail untuk notifikasi
        $transactionDetails = [
            'transaksi' => $request->keterangan,
            'nominal' => 'Rp. ' . number_format($request->nominal, 2, ',', '.'),
            'kategori' => $transactionCategory,
            'tanggal' => $request->tanggalTransaksi,
        ];

        // Kirim notifikasi atau umpan balik
        return redirect()->route('other.transactions.index')->with('success', "Transaksi berhasil disimpan! Detail: " .
            "Transaksi: {$transactionDetails['transaksi']}, Nominal: {$transactionDetails['nominal']}, " .
            "Kategori: {$transactionDetails['kategori']}, Tanggal: {$transactionDetails['tanggal']}");
    }



    // Fungsi untuk mencari COA kredit yang cocok
    private function getMatchingCreditCoa($kategori, $coaDebit)
    {
        // Menentukan COA kredit berdasarkan kategori dan COA debit yang dipilih
        if ($kategori == 'income') {
            return Coa::where('account_type', 'income')->where('id', '!=', $coaDebit->id)->first();
        }

        if ($kategori == 'expense') {
            return Coa::where('account_type', 'expense')->where('id', '!=', $coaDebit->id)->first();
        }

        return null;
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOtherTransactionRequest $request)
    {
        //

    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOtherTransactionRequest $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
