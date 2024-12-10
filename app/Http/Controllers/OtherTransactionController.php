<?php

namespace App\Http\Controllers;

use App\Models\OtherTransaction;
use App\Http\Requests\StoreOtherTransactionRequest;
use App\Http\Requests\UpdateOtherTransactionRequest;
use App\Models\Coa;
use App\Models\Journal;
use App\Models\Transaction;
use App\Models\Umkm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OtherTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data COA berdasarkan kategori account_type
        $incomeOptions = Coa::where('account_type', 'income')
            ->where('is_active', true)
            ->pluck('account_name', 'id');
        $expenseOptions = Coa::where('account_type', 'expense')
            ->where('is_active', true)
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
        // dd($request);
        // Ambil data UMKM berdasarkan pengguna yang login
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        $transactionId = 'PSN-' . date('Ymd') . substr(uniqid('', true), -4);

        // Generate UUID untuk transaksi
        $uuidTransaction = Str::uuid();

        // Simpan transaksi
        Transaction::create([
            'id' => $uuidTransaction,
            'umkm_id' => $umkm->id, // UMKM_ID diambil dari pengguna yang login
            'transaction_id' => $transactionId,
            'transaction_date' => $request->tanggalTransaksi,
            'total_amount' => $request->nominal,
            'information' => $request->keterangan,
            'status' => true,
        ]);

        // Tentukan kategori transaksi
        $transactionCategory = $request->kategori == 'income' ? 'Penerimaan' : 'Pengeluaran';

        // Ambil COA terkait berdasarkan kategori (untuk transaksi debit)
        if ($request->kategori == 'income') {
            // Income: Debit adalah kas/bank, Kredit adalah COA dari $request->namaTransaksi
            $coaDebit = Coa::where('umkm_id', $umkm->id)
                ->where('is_active', true)
                ->where('is_default_receipt', true) // Kas atau bank
                ->first();

            $coaCredit = Coa::where('id', $request->namaTransaksi)
                ->where('umkm_id', $umkm->id)
                ->where('is_active', true)
                ->first();
        }

        if ($request->kategori == 'expense') {
            // Expense: Debit adalah COA dari $request->namaTransaksi, Kredit adalah kas/bank
            $coaDebit = Coa::where('id', $request->namaTransaksi)
                ->where('umkm_id', $umkm->id)
                ->where('is_active', true)
                ->first();

            $coaCredit = Coa::where('umkm_id', $umkm->id)
                ->where('is_active', true)
                ->where('is_default_receipt', true) // Kas atau bank
                ->first();
        }

        if (!$coaDebit || !$coaCredit) {
            return redirect()->route('other.transactions.index')->with('error', 'COA terkait tidak ditemukan.');
        }

        // Keterangan untuk jurnal akan diambil dari COA
        $descriptionDebit = $coaDebit->account_name;
        $descriptionCredit = $coaCredit->account_name;

        // Buat entri jurnal untuk transaksi debit
        $journalDebit = new Journal([
            'umkm_id' => $umkm->id,
            'transaction_id' => $uuidTransaction,
            'coa_id' => $coaDebit->id,
            'description' => $descriptionDebit, // Atau bisa disesuaikan untuk pengeluaran
            'amount' => $request->nominal,
            'type' => 'debit',
        ]);
        $journalDebit->save();

        // Buat entri jurnal untuk transaksi kredit
        $journalCredit = new Journal([
            'umkm_id' => $umkm->id,
            'transaction_id' => $uuidTransaction,
            'coa_id' => $coaCredit->id,
            'description' => $descriptionCredit, // Atau bisa disesuaikan untuk pengeluaran
            'amount' => $request->nominal,
            'type' => 'credit',
        ]);
        $journalCredit->save();

        // Detail transaksi untuk feedback
        $transactionDetails = [
            'transaksi' => $request->keterangan,
            'nominal' => 'Rp. '.number_format($request->nominal, 2, ',', '.'),
            'kategori' => $transactionCategory,
            'tanggal' => $request->tanggalTransaksi,
        ];

        return redirect()->route('other.transactions.index')->with('success', 'Transaksi berhasil disimpan! Detail: ' .
            'Transaksi: ' . $transactionDetails['transaksi'] .
            ', Nominal: ' . $transactionDetails['nominal'] .
            ', Kategori: ' . $transactionDetails['kategori'] .
            ', Tanggal: ' . $transactionDetails['tanggal']);
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
