<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {

        if (Auth::check() && Auth::user()->role === 'admin') {
            return  redirect()->intended(route('dashboard-admin', absolute: false));
        }

        return redirect()->intended(route('verification.umkm', absolute: false));
    }

    public function verifiedUmkm(Request $request)
    {
        $validated = $request->validate([
            'year' => 'nullable|integer|min:2000|max:' . date('Y'),
        ]);
        // Misal tahun yang dipilih
        $year = $validated['year'] ?? date('Y');
        $user = Auth::user();

        // Ambil data UMKM terkait menggunakan relasi
        $umkmData = $user->umkm;


        // Sales
        $sales = Journal::where('journals.umkm_id', $umkmData->id)
            ->where('type', 'credit') // Kredit menunjukkan penjualan
            ->whereHas('coa.coaSub', function ($query) {
                $query->where('coa_type_id', 4); // Misalnya tipe 4 adalah Sales
            })
            ->whereYear('transactions.transaction_date', $year) // Filter berdasarkan tahun
            ->join('transactions', 'journals.transaction_id', '=', 'transactions.id')
            ->selectRaw('MONTH(transactions.transaction_date) as month, SUM(amount) as total_sales')
            ->groupBy('month')
            ->pluck('total_sales', 'month');

        // Revenue
        $revenue = Journal::where('journals.umkm_id', $umkmData->id)
            ->where('type', 'credit') // Kredit menunjukkan pemasukan
            ->whereHas('coa.coaSub', function ($query) {
                $query->where('coa_type_id', 4); // Tipe 4: Revenue
            })
            ->whereYear('transactions.transaction_date', $year) // Filter berdasarkan tahun
            ->join('transactions', 'journals.transaction_id', '=', 'transactions.id')
            ->selectRaw('MONTH(transactions.transaction_date) as month, SUM(amount) as total_revenue')
            ->groupBy('month')
            ->pluck('total_revenue', 'month');

        // Expenses
        $expenses = Journal::where('journals.umkm_id', $umkmData->id)
            ->where('type', 'debit') // Debit menunjukkan pengeluaran
            ->whereHas('coa.coaSub', function ($query) {
                $query->where('coa_type_id', 5); // Tipe 5: Expenses
            })
            ->whereYear('transactions.transaction_date', $year) // Filter berdasarkan tahun
            ->join('transactions', 'journals.transaction_id', '=', 'transactions.id')
            ->selectRaw('MONTH(transactions.transaction_date) as month, SUM(amount) as total_expenses')
            ->groupBy('month')
            ->pluck('total_expenses', 'month');
        $totalCustomers = Customer::where('umkm_id', $umkmData->id)->count();
        // Gabungkan semua data ke dalam satu struktur
        $data = collect(range(1, 12))->mapWithKeys(function ($month) use ($sales, $revenue, $expenses) {
            $totalSales = $sales->get($month, 0); // Default 0 jika tidak ada data
            $totalRevenue = $revenue->get($month, 0);
            $totalExpenses = $expenses->get($month, 0);
            $profit = $totalRevenue - $totalExpenses;

            return [
                $month => [
                    'month' => Carbon::create()->month($month)->format('F'), // Nama bulan
                    'sales' => $totalSales,
                    'revenue' => $totalRevenue,
                    'expenses' => $totalExpenses,
                    'profit' => $profit,
                ],
            ];
        });

        // Simpan status approve ke session
        session(['umkm_approve' => $umkmData->approve]);

        // dd($data);

        // Kirim data UMKM ke view
        return view('umkm.dashboard', compact('umkmData', 'data', 'totalCustomers'))->with('success', '😁 Selamat bergabung anda berhasil masuk! 😁');
    }
}
