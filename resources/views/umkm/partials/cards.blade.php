<div class="row">
    <!-- Kartu: Total Produk -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Produk
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalProducts }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">Lihat Detail</a>
            </div>
        </div>
    </div>

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
    </div>
</div>
