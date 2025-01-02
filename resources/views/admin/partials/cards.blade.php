<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2"
            style="border-radius: 15px; background: linear-gradient(to right, #333333, #E60012);">
            <div class="card-header text-center" style="font-size: 1.25rem; color: #fff; font-weight: bold;">
                <p>UMKM of the MONTH</p>
            </div>
            <div class="card-body" style="padding: 20px; text-align: left; color: #f8f9fc;">
                @if ($currentMonthData)
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <!-- Menampilkan nama UMKM -->
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 1.25rem;">
                                {{ $currentMonthData['umkm_name'] }}
                            </div>
                            <!-- Menampilkan total penghasilan -->
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 1.25rem;">
                                Total Penghasilan: </br> Rp
                                {{ number_format($currentMonthData['profit'], 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-medal fa-flip fa-2xl"></i>
                        </div>
                    </div>
                @else
                    <div class="text-center text-gray-500">
                        Data UMKM bulan ini belum tersedia.
                    </div>
                @endif
            </div>
            <div class="card-footer text-center"
                style="background-color: #f1f1f1; border-top: 2px solid #ccc; padding: 10px;">
                <p style="font-size: 1rem; color: #333; font-weight: bold;">Terbaik Bulan Ini</p>
            </div>
        </div>
    </div>


    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2"
            style="border-radius: 15px; background: linear-gradient(to right, #4e73df, #36b9cc);">
            <div class="card-header text-center" style="font-size: 1.25rem; color: #fff; font-weight: bold;">
                <p>Produk Terlaris</p>
            </div>
            <div class="card-body" style="padding: 20px; text-align: left; color: #f8f9fc;">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <!-- Menampilkan nama produk terlaris -->
                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 1.25rem;">
                            @if (isset($currentMonthDataProduct) && $currentMonthDataProduct['product_name'] !== 'No Sales')
                                {{ $currentMonthDataProduct['product_name'] }}
                            @else
                                Tidak Ada Penjualan
                            @endif
                        </div>
                        <!-- Menampilkan nama UMKM yang menjual produk tersebut -->
                        <div class="text-xs font-weight-bold text-gray-500 mb-1" style="font-size: 0.875rem;">
                            @if (isset($currentMonthDataProduct) && $currentMonthDataProduct['product_name'] !== 'No Sales')
                                Dari: {{ $currentMonthDataProduct['umkm_name'] }}
                            @else
                                -
                            @endif
                        </div>
                        <!-- Menampilkan total produk yang terjual -->
                        <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 1.25rem;">
                            @if (isset($currentMonthDataProduct['total_quantity']) && $currentMonthDataProduct['total_quantity'] > 0)
                                Total Terjual: <br>
                                {{ number_format($currentMonthDataProduct['total_quantity'], 0, ',', '.') }}
                            @else
                                Total Terjual: 0
                            @endif
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-boxes-stacked fa-bounce fa-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center"
                style="background-color: #f1f1f1; border-top: 2px solid #ccc; padding: 10px;">
                <p style="font-size: 1rem; color: #333; font-weight: bold;">Produk Terlaris Bulan Ini</p>
            </div>
        </div>
    </div>






    {{-- 
    <!-- Kartu: Total Pelanggan -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pelanggan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalCustomers }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('customers.index') }}" class="btn btn-sm btn-success">Lihat Detail</a>
            </div>
        </div>
    </div>

    <!-- Kartu: Total Transaksi -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Transaksi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalTransactions }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="#" class="btn btn-sm btn-warning">Lihat Detail</a>
            </div>
        </div>
    </div>

    <!-- Kartu: Kas Masuk -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Kas Masuk bulan ini ({{ \Carbon\Carbon::now()->translatedFormat('F') }})
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                            {{ number_format($data[\Carbon\Carbon::now()->month]['revenue'], 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-piggy-bank fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('reports.cash-inflows') }}" class="btn btn-sm btn-success">Lihat Detail</a>
            </div>
        </div>
    </div>

    <!-- Kartu: Kas Keluar -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Kas Keluar bulan ini ({{ \Carbon\Carbon::now()->translatedFormat('F') }})
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($data[\Carbon\Carbon::now()->month]['expenses'], 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('reports.cash-outflows') }}" class="btn btn-sm btn-danger">Lihat Detail</a>
            </div>
        </div>
    </div> --}}
</div>
