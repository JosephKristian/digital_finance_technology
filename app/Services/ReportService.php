<?php
namespace App\Services;

use App\Models\Journal;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function calculateProfitAndLoss($umkm, $startDate, $endDate)
    {
        // Aktifkan query log
        DB::enableQueryLog();

        // Pendapatan (Revenue)
        $income = Journal::where('umkm_id', $umkm->id)
            ->whereHas('coa.coaSub', function ($query) {
                $query->where('coa_type_id', 4); // Revenue
            })
            ->where('type', 'credit')
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            })
            ->sum('amount');
        Log::info('Pendapatan (Revenue)', ['income' => $income]);

        // Detail Pendapatan (Revenue Details)
        $incomeDetails = Journal::where('umkm_id', $umkm->id)
            ->whereHas('coa.coaSub', function ($query) {
                $query->where('coa_type_id', 4); // Revenue
            })
            ->where('type', 'credit')
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            })
            ->select('coa_id', DB::raw('SUM(amount) as total_amount'))
            ->with('coa')
            ->groupBy('coa_id')
            ->get();
        Log::info('Detail Pendapatan (Revenue Details)', ['incomeDetails' => $incomeDetails]);

        // Beban (Expenses), excluding Cost of Goods Sold (COGS)
        $expenses = Journal::where('umkm_id', $umkm->id)
            ->whereHas('coa.coaSub', function ($query) {
                $query->where('coa_type_id', 5) // Expense
                    ->where('sub_name', '<>', 'Cost of Goods Sold'); // Exclude COGS
            })
            ->where('type', 'debit')
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            })
            ->sum('amount');
        Log::info('Beban (Expenses)', ['expenses' => $expenses]);

        // Biaya Produksi (Cost of Goods Sold)
        $productionCosts = Journal::where('umkm_id', $umkm->id)
            ->whereHas('coa.coaSub', function ($query) {
                $query->where('coa_type_id', 5) // Expense
                    ->where('sub_name', 'Cost of Goods Sold'); // Only COGS
            })
            ->where('type', 'debit')
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            })
            ->sum('amount');
        Log::info('Biaya Produksi (COGS)', ['productionCosts' => $productionCosts]);

        // Laba Kotor (Gross Profit)
        $grossProfit = $income - $productionCosts;
        Log::info('Hasil Gross Profit', ['grossProfit' => $grossProfit]);

        // Laba Bersih (Net Profit)
        $netProfit = $grossProfit - $expenses;
        Log::info('Hasil Net Profit', ['netProfit' => $netProfit]);

        // Pendapatan Non Operasional (Non-Operational Income)
        $nonOperationalIncome = Journal::where('umkm_id', $umkm->id)
            ->whereHas('coa.coaSub', function ($query) {
                $query->where('coa_type_id', 4) // Revenue
                    ->where('sub_name', 'Non Operational'); // Non-Operational Income
            })
            ->where('type', 'credit')
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            })
            ->select('coa_id', DB::raw('SUM(amount) as total_amount'))
            ->with('coa')
            ->groupBy('coa_id')
            ->get();
        Log::info('Non-Operational Income Details', ['nonOperationalIncome' => $nonOperationalIncome]);

        // Total Non-Operational Income
        $totalNonOperationalIncome = Journal::where('umkm_id', $umkm->id)
            ->whereHas('coa.coaSub', function ($query) {
                $query->where('coa_type_id', 4) // Revenue
                    ->where('sub_name', 'Non Operational'); // Non-Operational Income
            })
            ->where('type', 'credit')
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            })
            ->sum('amount');
        Log::info('Total Non-Operational Income', ['totalNonOperationalIncome' => $totalNonOperationalIncome]);

        // Laba Operasional Bersih (Operational Net Profit)
        $operationalNetProfit = $grossProfit - $expenses;
        Log::info('Hasil Operational Net Profit', ['operationalNetProfit' => $operationalNetProfit]);

        // Total Laba Bersih (Total Net Profit)
        $totalNetProfit = $operationalNetProfit + $totalNonOperationalIncome;
        Log::info('Hasil Total Net Profit', ['totalNetProfit' => $totalNetProfit]);

        // Return hasil perhitungan
        return [
            'income' => $income,
            'incomeDetails' => $incomeDetails,
            'expenses' => $expenses,
            'productionCosts' => $productionCosts,
            'grossProfit' => $grossProfit,
            'netProfit' => $netProfit,
            'nonOperationalIncome' => $nonOperationalIncome,
            'totalNonOperationalIncome' => $totalNonOperationalIncome,
            'operationalNetProfit' => $operationalNetProfit,
            'totalNetProfit' => $totalNetProfit,
        ];
    }
}
