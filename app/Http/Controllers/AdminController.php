<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $umkms = UMKM::all(); // Ambil semua UMKM
        $year = $request->input('year', now()->year);
        $m = $request->input('month', now()->month);
        $monthInput = sprintf('%02d', $m);
        $startDate = Carbon::now()->subYear(); // Mulai dari satu tahun yang lalu
        $endDate = Carbon::now(); // Sampai sekarang

        $monthlyNetProfits = [];

        foreach ($umkms as $umkm) {
            $monthlyNetProfits[$umkm->id] = [
                'umkm_name' => $umkm->name,
                'data' => []
            ];

            for ($month = 0; $month < 12; $month++) {
                $startOfMonth = Carbon::createFromDate($year, 1, 1)->addMonths($month)->startOfMonth();
                $endOfMonth = Carbon::createFromDate($year, 1, 1)->addMonths($month)->endOfMonth();

                // Hitung pendapatan
                $income = Journal::where('umkm_id', $umkm->id)
                    ->whereHas('coa.coaSub', function ($query) {
                        $query->where('coa_type_id', 4); // Revenue
                    })
                    ->where('type', 'credit')
                    ->whereHas('transaction', function ($query) use ($startOfMonth, $endOfMonth) {
                        $query->whereBetween('transaction_date', [$startOfMonth, $endOfMonth]);
                    })
                    ->sum('amount');

                // Hitung biaya produksi (COGS)
                $productionCosts = Journal::where('umkm_id', $umkm->id)
                    ->whereHas('coa.coaSub', function ($query) {
                        $query->where('coa_type_id', 5) // Expense
                            ->where('coa_sub_id', 15); // Pembelian
                    })
                    ->where('type', 'debit')
                    ->whereHas('transaction', function ($query) use ($startOfMonth, $endOfMonth) {
                        $query->whereBetween('transaction_date', [$startOfMonth, $endOfMonth]);
                    })
                    ->sum('amount');

                // Hitung total beban
                $expenses = Journal::where('umkm_id', $umkm->id)
                    ->whereHas('coa.coaSub', function ($query) {
                        $query->where('coa_sub_id', 18)
                            ->orWhere('coa_sub_id', 20);
                    })
                    ->where('type', 'debit')
                    ->whereHas('transaction', function ($query) use ($startOfMonth, $endOfMonth) {
                        $query->whereBetween('transaction_date', [$startOfMonth, $endOfMonth]);
                    })
                    ->sum('amount');

                // Hitung keuntungan bersih
                $netProfit = $income - $productionCosts - $expenses;

                // Simpan hasil per bulan
                $monthlyNetProfits[$umkm->id]['data'][$startOfMonth->format('Y-m')] = $netProfit;
            }
        }


        // Log hasil
        Log::info('Monthly Net Profits', ['monthlyNetProfits' => $monthlyNetProfits]);
        $monthlySalesData = [];

        foreach ($umkms as $umkm) {
            $monthlySalesData[$umkm->id] = [
                'umkm_name' => $umkm->name,
                'data' => []
            ];

            for ($month = 0; $month < 12; $month++) {
                $startOfMonth = Carbon::createFromDate($year, 1, 1)->addMonths($month)->startOfMonth();
                $endOfMonth = Carbon::createFromDate($year, 1, 1)->addMonths($month)->endOfMonth();

                // Ambil data penjualan dengan nama produk
                $monthlySales = DB::table('transactions as t')
                    ->join('transaction_details as td', 't.transaction_id', '=', 'td.transaction_id')
                    ->join('products as p', 'td.product_id', '=', 'p.id')
                    ->where('t.umkm_id', $umkm->id)
                    ->where('t.status', true)
                    ->whereBetween('t.transaction_date', [$startOfMonth, $endOfMonth])
                    ->select('p.name as product_name', DB::raw('SUM(td.quantity) as total_quantity'))
                    ->groupBy('p.id', 'p.name')
                    ->get();

                // Format bulan sebagai YYYY-MM
                $monthKey = $startOfMonth->format('Y-m');
                $monthlySalesData[$umkm->id]['data'][$monthKey] = [];

                foreach ($monthlySales as $sale) {
                    $monthlySalesData[$umkm->id]['data'][$monthKey][] = [
                        'product_name' => $sale->product_name,
                        'total_quantity' => $sale->total_quantity
                    ];
                }
            }
        }


        // Log hasil
        Log::info('Monthly Sales Data', ['monthlySalesData' => $monthlySalesData]);


        // Data produk terlaris (Best Selling Product)


        // Data UMKM of the Month
        // Data produk terlaris (Best Selling Product)
        $umkmOfTheMonth = []; // Untuk menyimpan UMKM terbaik per bulan

        // Iterasi setiap bulan
        foreach (range(1, 12) as $month) {
            $currentMonth = Carbon::createFromDate($year, 1, 1)->addMonths($month - 1)->format('Y-m');
            $highestProfit = null;
            $bestUmkm = null;

            foreach ($monthlyNetProfits as $umkmId => $umkmData) {
                $profit = $umkmData['data'][$currentMonth] ?? 0;

                // Abaikan jika profit <= 0
                if ($profit <= 0) {
                    continue;
                }

                if (is_null($highestProfit) || $profit > $highestProfit) {
                    $highestProfit = $profit;
                    $bestUmkm = [
                        'umkm_id' => $umkmId,
                        'umkm_name' => $umkmData['umkm_name'],
                        'profit' => $profit
                    ];
                }
            }

            // Hanya tambahkan jika ada UMKM dengan profit > 0
            if ($bestUmkm) {
                $umkmOfTheMonth[$currentMonth] = $bestUmkm;
            }
        }


        // Data produk terlaris (Best Selling Product)
        $bestSellingProduct = []; // Untuk menyimpan produk terlaris per bulan

        // Iterasi setiap bulan
        foreach (range(1, 12) as $month) {
            $currentMonth = Carbon::createFromDate($year, 1, 1)->addMonths($month - 1)->format('Y-m');

            // Menyiapkan array untuk menghitung jumlah produk terlaris
            $productSales = [];

            // Menggabungkan data penjualan dari semua UMKM untuk bulan tertentu
            foreach ($monthlySalesData as $umkmId => $umkmData) {
                // Ambil data penjualan untuk bulan tertentu
                $salesData = $umkmData['data'][$currentMonth] ?? [];

                if (empty($salesData)) {
                    // Jika tidak ada data penjualan, lanjutkan ke UMKM berikutnya
                    continue;
                }

                // Menghitung total penjualan untuk setiap produk
                foreach ($salesData as $product) {
                    $productName = $product['product_name'];
                    $quantity = (int) $product['total_quantity'];

                    // Menambahkan jumlah produk ke dalam array
                    if (!isset($productSales[$productName])) {
                        $productSales[$productName] = [
                            'umkm_id' => $umkmId,   // Menyimpan umkm_id
                            'umkm_name' => $umkmData['umkm_name'], // Menyimpan umkm_name
                            'quantity' => $quantity
                        ];
                    } else {
                        // Jika produk sudah ada, tambahkan jumlahnya
                        $productSales[$productName]['quantity'] += $quantity;
                    }
                }
            }

            // Menentukan produk terlaris untuk bulan ini
            $bestProduct = null;
            $highestQuantity = 0;

            foreach ($productSales as $productName => $productData) {
                if ($productData['quantity'] > $highestQuantity) {
                    $highestQuantity = $productData['quantity'];
                    $bestProduct = [
                        'umkm_id' => $productData['umkm_id'],
                        'umkm_name' => $productData['umkm_name'],
                        'product_name' => $productName,
                        'total_quantity' => $highestQuantity
                    ];
                }
            }

            // Jika produk terlaris ditemukan, masukkan ke dalam array
            if ($bestProduct) {
                $bestSellingProduct[$currentMonth] = $bestProduct;
            } else {
                // Jika tidak ada penjualan, set produk terlaris sebagai 'no_sales'
                $bestSellingProduct[$currentMonth] = [
                    'umkm_id' => 'No Sales',
                    'umkm_name' => 'No Sales',
                    'product_name' => 'No Sales',
                    'total_quantity' => 0
                ];
            }
        }






        // Mendapatkan bulan terkini
        $currentMonth = $monthInput;
        // dd($currentMonth, $monthInput);

        // Gabungkan tahun dan bulan untuk mendapatkan key yang benar
        $currentMonthKey = $year . '-' . $currentMonth; // Format: '2024-12'

        // Mengambil data untuk bulan dan tahun yang dipilih
        $currentMonthData = $umkmOfTheMonth[$currentMonthKey] ?? null;
        // Mengambil data untuk bulan dan tahun yang dipilih
        $currentMonthDataProduct = $bestSellingProduct[$currentMonthKey] ?? null;

        // dd($umkmData, $currentMonthData, $currentMonthDataProduct, $monthlySalesData, $monthlyNetProfits);

        $data = [
            'monthlyNetProfits' => $monthlyNetProfits,
            'monthlySalesData' => $monthlySalesData,
        ];

        // Return view dengan data
        return view('admin.dashboard', compact(
            'currentMonthData',
            'currentMonthDataProduct',
            'data',
            'umkmOfTheMonth',
            'bestSellingProduct',
            'year',
            'monthInput',
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
