<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DoccumentController extends Controller
{
    public function printPDFIncomeStatement(Request $request)
    {
        // Decode JSON data
        $incomeDetails = json_decode($request->incomeDetails);
        $expensesDetails = json_decode($request->expensesDetails);
        $nonOperationalIncome = json_decode($request->nonOperationalIncome);


        // Siapkan data untuk view PDF
        $data = [
            'month' => $request->month,
            'year' => $request->year,
            'incomeDetails' => $incomeDetails,
            'productionCosts' => $request->productionCosts,
            'grossProfit' => $request->grossProfit,
            'expensesDetails' => $expensesDetails,
            'totalExpenses' => $request->totalExpenses,
            'operationalNetProfit' => $request->operationalNetProfit,
            'nonOperationalIncome' => $nonOperationalIncome,
            'totalNonOperationalIncome' => $request->totalNonOperationalIncome,
            'netProfit' => $request->netProfit,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('umkm.reports.pdf.income-statement', $data);
        return $pdf->stream('income-statement.pdf');
    }

    // Function to print Cash Inflows as PDF
    public function printPDFCashInflows(Request $request)
    {
        // Decode JSON data
        $cashInflows = json_decode($request->cashInflows, true);

        // Siapkan data untuk view PDF
        $data = [
            'month' => $request->month,
            'year' => $request->year,
            'cashInflows' => $cashInflows,
            'totalCashInflow' => $request->totalCashInflow,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('umkm.reports.pdf.cash-inflows', $data);
        return $pdf->stream('cash-inflows.pdf');
    }

    // Function to print Cash Outflows as PDF
    public function printPDFCashOutflows(Request $request)
    {
        // Decode JSON data
        $cashOutflows = json_decode($request->cashOutflows, true);

        // Siapkan data untuk view PDF
        $data = [
            'month' => $request->month,
            'year' => $request->year,
            'cashOutflows' => $cashOutflows,
            'totalCashOutflow' => $request->totalCashOutflow,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('umkm.reports.pdf.cash-outflows', $data);
        return $pdf->stream('cash-outflows.pdf');
    }

    public function printPDFGeneralLedger(Request $request)
    {
        // Decode JSON data
        $generalLedger = json_decode($request->generalLedger);

        // Siapkan data untuk view PDF
        $data = [
            'month' => $request->month,
            'year' => $request->year,
            'generalLedger' => $generalLedger,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('umkm.accounting.pdf.general-ledger', $data);
        return $pdf->stream('general-ledger.pdf');
    }


    // Function to print Sales Report as PDF
    public function printPDFSalesReport(Request $request)
    {
        // Decode JSON data
        $transactions = json_decode($request->transactions);

        // Siapkan data untuk view PDF
        $data = [
            'month' => $request->month,
            'year' => $request->year,
            'transactions' => $transactions,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('umkm.reports.pdf.sales-report', $data);
        return $pdf->stream('sales-report.pdf');
    }

    // Function to print Income Statement as Excel
    public function printExcelIncomeStatement(Request $request)
    {
        // Tambahkan logic di sini
    }

    // Function to print Cash Inflows as Excel
    public function printExcelCashInflows(Request $request)
    {
        // Tambahkan logic di sini
    }

    // Function to print Cash Outflows as Excel
    public function printExcelCashOutflows(Request $request)
    {
        // Tambahkan logic di sini
    }

    // Function to print Sales Report as Excel
    public function printExcelSalesReport(Request $request)
    {
        // Tambahkan logic di sini
    }
}
