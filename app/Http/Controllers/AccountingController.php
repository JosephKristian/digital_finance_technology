<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Umkm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountingController extends Controller
{
    public function generalLedger(Request $request)
    {

        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();

        // Validasi input bulan dan tahun
        $validated = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2000|max:' . date('Y'),
        ]);
        // Ambil periode (default: bulan dan tahun saat ini)
        $month = $validated['month'] ?? date('m');
        $year = $validated['year'] ?? date('Y');

        $startDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->endOfMonth();


        $generalLedger = Journal::select(
            'transactions.transaction_id',
            'transactions.transaction_date',
            'coa.account_name',
            'coa.account_code',
            'journals.type',
            'journals.amount'
        )
            ->join('coa', 'journals.coa_id', '=', 'coa.id') // Gabungkan dengan tabel coa
            ->join('transactions', 'journals.transaction_id', '=', 'transactions.id') // Gabungkan dengan tabel transactions
            ->where('journals.umkm_id', $umkm->id)
            ->whereBetween('transactions.transaction_date', [$startDate, $endDate])
              // Urutkan per transaksi
            ->orderBy('transactions.transaction_date', 'asc') // Urutkan berdasarkan tanggal transaksi
            ->orderBy('journals.created_at', 'asc')  // Urutkan per transaksi
            ->orderByRaw("CASE WHEN journals.type = 'debit' THEN 1 ELSE 2 END") // Debit dulu baru kredit
            ->get();



        return view('umkm.accounting.general-ledger', compact(
            'generalLedger',
            'month',
            'year',
        ));
    }
}
