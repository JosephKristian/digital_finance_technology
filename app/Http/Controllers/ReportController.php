<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //
    public function incomeStatement(Request $request)
{
    $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();

    // Total Pendapatan
    $income = Journal::where('umkm_id', $umkm->id)
        ->whereHas('coa', function ($query) {
            $query->where('account_type', 'income');
        })
        ->where('type', 'credit')
        ->sum('amount');

    // Total Beban
    $expenses = Journal::where('umkm_id', $umkm->id)
        ->whereHas('coa', function ($query) {
            $query->where('account_type', 'expense');
        })
        ->where('type', 'debit')
        ->sum('amount');

    // Laba Bersih
    $netProfit = $income - $expenses;

    return view('umkm.reports.income_statement', compact('income', 'expenses', 'netProfit'));
}


    public function balanceSheet(Request $request)
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();

        // Aset
        $assets = Journal::where('umkm_id', $umkm->id)
            ->whereHas('coa', function ($query) {
                $query->where('account_type', 'asset');
            })
            ->where('type', 'debit')
            ->sum('amount');

        // Liabilitas
        $liabilities = Journal::where('umkm_id', $umkm->id)
            ->whereHas('coa', function ($query) {
                $query->where('account_type', 'liability');
            })
            ->where('type', 'credit')
            ->sum('amount');

        // Ekuitas
        $equity = Journal::where('umkm_id', $umkm->id)
            ->whereHas('coa', function ($query) {
                $query->where('account_type', 'equity');
            })
            ->where('type', 'credit')
            ->sum('amount');

        return view('umkm.reports.balance_sheet', compact('assets', 'liabilities', 'equity'));
    }
}
