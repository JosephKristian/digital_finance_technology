<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Transaction;
use App\Models\Umkm;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    public function incomeStatement(Request $request)
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        // dd($request->month,$request->year);
        // Validasi input bulan dan tahun
        $validated = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2000|max:' . date('Y'),
        ]);
        // Ambil periode (default: bulan dan tahun saat ini)
        $month = $validated['month'] ?? date('m');
        $year = $validated['year'] ?? date('Y');
        // dd($month, $year);

        // Format tanggal untuk filter
        $startDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->endOfMonth();
        // dd($startDate, $endDate);
        try {
            // Log awal eksekusi
            // Aktifkan query log
            DB::enableQueryLog();

            Log::info('Memulai perhitungan laporan laba rugi', [
                'user_id' => Auth::user()->id,
                'umkm_id' => $umkm->id,
                'month' => $month,
                'year' => $year,
            ]);

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
                        ->where('coa_sub_id', 18)
                        ->orWhere('coa_sub_id', 20);
                })
                ->where('type', 'debit')
                ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate]);
                })
                ->sum('amount');
            Log::info('Beban (Expenses)', ['expenses' => $expenses]);

            // Biaya Produksi (Cost of Goods Sold)
            $pembelian = Journal::where('umkm_id', $umkm->id)
                ->whereHas('coa.coaSub', function ($query) {
                    $query->where('coa_type_id', 5) // Expense
                        ->where('coa_sub_id', 15); // Pembelian
                })
                ->where('type', 'debit')
                ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate]);
                })
                ->sum('amount');

            $disc = Journal::where('umkm_id', $umkm->id)
                ->whereHas('coa.coaSub', function ($query) {
                    $query->where('coa_type_id', 5) // Expense
                        ->where('coa_sub_id', 16); // Pembelian
                })
                ->where('type', 'debit')
                ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate]);
                })
                ->sum('amount');

            $retur = Journal::where('umkm_id', $umkm->id)
                ->whereHas('coa.coaSub', function ($query) {
                    $query->where('coa_type_id', 5) // Expense
                        ->where('coa_sub_id', 17); // Pembelian
                })
                ->where('type', 'debit')
                ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate]);
                })
                ->sum('amount');
            $pengurangan = $disc + $retur;
            $productionCosts = $pembelian - $pengurangan;
            Log::info('Biaya Produksi (COGS)', ['productionCosts' => $productionCosts]);




            // Detail Beban (Expenses Details)
            $expensesDetails = Journal::where('umkm_id', $umkm->id)
                ->whereHas('coa.coaSub', function ($query) {
                    $query->where('coa_sub_id', 18)
                        ->orWhere('coa_sub_id', 20);
                })
                ->where('type', 'debit')
                ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate]);
                })
                ->select('coa_id', DB::raw('SUM(amount) as total_amount'))
                ->with('coa')
                ->groupBy('coa_id')
                ->get();
            Log::info('Detail Beban (expense)', ['expensesDetails' => $expensesDetails]);

            $totalExpenses = Journal::where('umkm_id', $umkm->id)
                ->whereHas('coa.coaSub', function ($query) {
                    $query->where('coa_type_id', 5) // Expense
                        ->where('sub_name', '<>', 'Cost of Goods Sold'); // Exclude COGS
                })
                ->where('type', 'debit')
                ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate]);
                })
                ->sum('amount');
            Log::info('Total Beban (expenses)', ['totalExpenses' => $productionCosts]);

            // dd($expensesDetails);
            // Log query yang dieksekusi
            Log::info('Executed Queries', ['queries' => DB::getQueryLog()]);
            DB::flushQueryLog();


            // Laba Kotor (Gross Profit)
            Log::info('Menghitung Gross Profit', [
                'income' => $income,
                'productionCosts' => $productionCosts,
            ]);
            // Laba Kotor (Gross Profit)
            $grossProfit = $income - $productionCosts;
            Log::info('Hasil Gross Profit', [
                'grossProfit' => $grossProfit,
            ]);
            // Laba Bersih (Net Profit)
            Log::info('Menghitung Net Profit', ['grossProfit' => $grossProfit, 'expenses' => $expenses,]);
            // Laba Bersih (Net Profit)
            $netProfit = $grossProfit - $expenses;
            Log::info('Hasil Net Profit', [
                'netProfit' => $netProfit,
            ]);
            // Pendapatan Non Operasional (Non-Operational Income)
            Log::info('Mengambil Non-Operational Income Details');
            $nonOperationalIncomeQuery = Journal::where('umkm_id', $umkm->id)
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
                ->groupBy('coa_id');

            Log::info('Non-Operational Income Query', [
                'query' => $nonOperationalIncomeQuery->toSql(),
                'bindings' => $nonOperationalIncomeQuery->getBindings(),
            ]);
            $nonOperationalIncome = $nonOperationalIncomeQuery->get();
            Log::info('Non-Operational Income Details', [
                'nonOperationalIncome' => $nonOperationalIncome,
            ]);

            Log::info('Menghitung Total Non-Operational Income');
            $totalNonOperationalIncomeQuery = Journal::where('umkm_id', $umkm->id)
                ->whereHas('coa.coaSub', function ($query) {
                    $query->where('coa_type_id', 4) // Revenue
                        ->where('sub_name', 'Non Operational'); // Non-Operational Income
                })
                ->where('type', 'credit')
                ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('transaction_date', [$startDate, $endDate]);
                });

            Log::info('Total Non-Operational Income Query', [
                'query' => $totalNonOperationalIncomeQuery->toSql(),
                'bindings' => $totalNonOperationalIncomeQuery->getBindings(),
            ]);
            $totalNonOperationalIncome = $totalNonOperationalIncomeQuery->sum('amount');
            Log::info('Total Non-Operational Income', [
                'totalNonOperationalIncome' => $totalNonOperationalIncome,
            ]);

            // Laba Operasional Bersih (Operational Net Profit)
            Log::info('Menghitung Operational Net Profit', [
                'grossProfit' => $grossProfit,
                'expenses' => $expenses,
            ]);
            $operationalNetProfit = $grossProfit - $expenses;
            Log::info('Hasil Operational Net Profit', [
                'operationalNetProfit' => $operationalNetProfit,
            ]);

            // Total Laba Bersih (Total Net Profit)
            Log::info('Menghitung Total Net Profit', [
                'operationalNetProfit' => $operationalNetProfit,
                'totalNonOperationalIncome' => $totalNonOperationalIncome,
            ]);
            $totalNetProfit = $operationalNetProfit + $totalNonOperationalIncome;
            Log::info('Hasil Total Net Profit', [
                'totalNetProfit' => $totalNetProfit,
            ]);

            // Kirim data ke view
            return view('umkm.reports.income_statement', compact(
                'income',
                'incomeDetails',
                'month',
                'year',
                'productionCosts',
                'grossProfit',
                'expensesDetails',
                'totalExpenses',
                'operationalNetProfit',
                'nonOperationalIncome',
                'totalNonOperationalIncome',
                'netProfit',
            ));
        } catch (\Exception $e) {
            // Log error lengkap
            Log::error('Terjadi kesalahan saat memproses laporan laba rugi', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            dd('ERROR');

            return back()->withErrors(['error' => 'Terjadi kesalahan saat memproses laporan.']);
        }
    }


    public function salesReport(Request $request)
    {

        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        // dd($request->month,$request->year);
        // Validasi input bulan dan tahun
        $validated = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2000|max:' . date('Y'),
        ]);

        // Ambil periode (default: bulan dan tahun saat ini)
        $month = $validated['month'] ?? date('m');
        $year = $validated['year'] ?? date('Y');

        // Format tanggal untuk filter
        $startDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->endOfMonth();

        // Jalankan query menggunakan Query Builder
        $transactions = DB::table('transactions as t')
            ->join('transaction_details as td', 't.transaction_id', '=', 'td.transaction_id')
            ->join('products as p', 'td.product_id', '=', 'p.id')
            ->where('t.umkm_id', $umkm->id)
            ->where('t.status', true)
            ->whereBetween('t.transaction_date', [$startDate, $endDate])
            ->select(

                'td.product_id',
                DB::raw('SUM(td.quantity) as quantity'),
                'p.name as product_name'
            )
            ->groupBy('t.transaction_date', 'td.product_id', 'p.name')
            ->get();


        return view('umkm.reports.sales_report', compact(
            'month',
            'year',
            'transactions',
        ));
    }


    public function cashInflows(Request $request)
    {
        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        // dd($request->month,$request->year);
        // Validasi input bulan dan tahun
        $validated = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2000|max:' . date('Y'),
        ]);

        // Ambil periode (default: bulan dan tahun saat ini)
        $month = $validated['month'] ?? date('m');
        $year = $validated['year'] ?? date('Y');

        // Format tanggal untuk filter
        $startDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->endOfMonth();

        $cashInflows = Journal::where('journals.umkm_id', $umkm->id)
            ->where('type', 'debit') // Kredit menunjukkan pemasukan
            ->whereHas('coa.coaSub', function ($query) {
                $query->where('coa_type_id', 1)

                    ->where('is_default_receipt', true)
                ;
            })
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            })
            ->select(
                'coa_id',
                'transactions.transaction_date',
                'transactions.id as transaction_id',
                DB::raw('SUM(amount) as total_amount')
            )
            ->join('transactions', 'journals.transaction_id', '=', 'transactions.id') // Gabungkan dengan tabel transaksi
            ->with(['coa.coaSub', 'transaction.journals' => function ($query) {
                $query->where('type', 'credit'); // Ambil hanya transaksi tipe debit
            }])
            ->groupBy('coa_id', 'transactions.id', 'transactions.transaction_date') // Tambahkan transaction_date ke GROUP BY
            ->orderBy('transactions.transaction_date', 'asc')
            ->get()
            ->map(function ($journal) {
                return [
                    'transaction_id' => $journal->transaction_id,
                    'date' => $journal->transaction_date,
                    'account_name' => $journal->coa->coaSub->account_name ?? $journal->coa->account_name,
                    'total_amount' => $journal->total_amount,
                    'opposites' => $journal->transaction->journals->map(function ($opposite) {
                        return [
                            'account_name' => $opposite->coa->coaSub->account_name ?? $opposite->coa->account_name,
                        ];
                    }),
                ];
            });

        // Total pemasukan
        $totalCashInflow = $cashInflows->sum('total_amount');

        return view('umkm.reports.cash_inflows', compact(
            'cashInflows',
            'totalCashInflow',
            'month',
            'year'
        ));
    }


    public function cashOutflows(Request $request)
    {

        $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();
        // dd($request->month,$request->year);
        // Validasi input bulan dan tahun
        $validated = $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2000|max:' . date('Y'),
        ]);

        // Ambil periode (default: bulan dan tahun saat ini)
        $month = $validated['month'] ?? date('m');
        $year = $validated['year'] ?? date('Y');

        // Format tanggal untuk filter
        $startDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->startOfMonth();
        $endDate = Carbon::createFromFormat('Y-m-d', "{$year}-{$month}-01")->endOfMonth();

        $cashOutflows = Journal::where('journals.umkm_id', $umkm->id)
            ->where('type', 'credit') // Kredit menunjukkan pemasukan
            ->whereHas('coa.coaSub', function ($query) {
                $query->where('coa_type_id', 1) // Hanya tipe expense
                    ->where('sub_name', '<>', 'Cost of Goods Sold'); // Exclude COGS
            })
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('transaction_date', [$startDate, $endDate]);
            })
            ->select(
                'coa_id',
                'transactions.transaction_date',
                'transactions.id as transaction_id',
                DB::raw('SUM(amount) as total_amount')
            )
            ->join('transactions', 'journals.transaction_id', '=', 'transactions.id') // Gabungkan dengan tabel transaksi
            ->with(['coa.coaSub', 'transaction.journals' => function ($query) {
                $query->where('type', 'debit'); // Ambil hanya transaksi tipe debit
            }])
            ->groupBy('coa_id', 'transactions.id', 'transactions.transaction_date') // Tambahkan transaction_date ke GROUP BY
            ->orderBy('transactions.transaction_date', 'asc')
            ->get()
            ->map(function ($journal) {
                return [
                    'transaction_id' => $journal->transaction_id,
                    'date' => $journal->transaction_date,
                    'account_name' => $journal->coa->coaSub->account_name ?? $journal->coa->account_name,
                    'total_amount' => $journal->total_amount,
                    'opposites' => $journal->transaction->journals->map(function ($opposite) {
                        return [
                            'account_name' => $opposite->coa->coaSub->account_name ?? $opposite->coa->account_name,
                        ];
                    }),
                ];
            });

        // Total pemasukan
        $totalCashOutflow = $cashOutflows->sum('total_amount');

        return view('umkm.reports.cash_outflows', compact(
            'cashOutflows',
            'totalCashOutflow',
            'month',
            'year'
        ));
    }




    // public function balanceSheet(Request $request)
    // {
    //     $umkm = Umkm::where('user_id', Auth::user()->id)->firstOrFail();

    //     // Aset
    //     $assets = Journal::where('umkm_id', $umkm->id)
    //         ->whereHas('coa', function ($query) {
    //             $query->where('account_type', 'asset');
    //         })
    //         ->where('type', 'debit')
    //         ->sum('amount');

    //     // Liabilitas
    //     $liabilities = Journal::where('umkm_id', $umkm->id)
    //         ->whereHas('coa', function ($query) {
    //             $query->where('account_type', 'liability');
    //         })
    //         ->where('type', 'credit')
    //         ->sum('amount');

    //     // Ekuitas
    //     $equity = Journal::where('umkm_id', $umkm->id)
    //         ->whereHas('coa', function ($query) {
    //             $query->where('account_type', 'equity');
    //         })
    //         ->where('type', 'credit')
    //         ->sum('amount');

    //     return view('umkm.reports.balance_sheet', compact('assets', 'liabilities', 'equity'));
    // }
}
