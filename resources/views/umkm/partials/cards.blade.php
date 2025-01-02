<div class="row">
    <!-- Kartu: Total Produk -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card" style="border-left: 5px solid #E60012; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-body" style="background-color: #ffffff; padding: 1.5rem;">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold" style="color: #E60012; text-transform: uppercase; margin-bottom: 10px;">
                            Total Produk
                        </div>
                        <div class="h5 mb-0 font-weight-bold" style="color: #333333;">
                            {{ $totalProducts }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x" style="color: #E60012;"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center" style="background-color: #f7f7f7;">
                <a href="{{ route('products.index') }}" class="btn btn-sm" style="background-color: #E60012; color: white;">Lihat Detail</a>
            </div>
        </div>
    </div>

    <!-- Kartu: Total Pelanggan -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card" style="border-left: 5px solid #0073E6; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-body" style="background-color: #ffffff; padding: 1.5rem;">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold" style="color: #0073E6; text-transform: uppercase; margin-bottom: 10px;">
                            Total Pelanggan
                        </div>
                        <div class="h5 mb-0 font-weight-bold" style="color: #333333;">
                            {{ $totalCustomers }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x" style="color: #0073E6;"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center" style="background-color: #f7f7f7;">
                <a href="{{ route('customers.index') }}" class="btn btn-sm" style="background-color: #0073E6; color: white;">Lihat Detail</a>
            </div>
        </div>
    </div>

    <!-- Kartu: Total Transaksi -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card" style="border-left: 5px solid #FF9F00; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-body" style="background-color: #ffffff; padding: 1.5rem;">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold" style="color: #FF9F00; text-transform: uppercase; margin-bottom: 10px;">
                            Total Transaksi
                        </div>
                        <div class="h5 mb-0 font-weight-bold" style="color: #333333;">
                            {{ $totalTransactions }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x" style="color: #FF9F00;"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center" style="background-color: #f7f7f7;">
                <a href="#" class="btn btn-sm" style="background-color: #FF9F00; color: white;">Lihat Detail</a>
            </div>
        </div>
    </div>

    <!-- Kartu: Kas Masuk -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card" style="border-left: 5px solid #00A859; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-body" style="background-color: #ffffff; padding: 1.5rem;">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold" style="color: #00A859; text-transform: uppercase; margin-bottom: 10px;">
                            Kas Masuk bulan ini ({{ \Carbon\Carbon::now()->translatedFormat('F') }})
                        </div>
                        <div class="h5 mb-0 font-weight-bold" style="color: #333333;">Rp
                            {{ number_format($data[\Carbon\Carbon::now()->month]['revenue'], 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-piggy-bank fa-2x" style="color: #00A859;"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center" style="background-color: #f7f7f7;">
                <a href="{{ route('reports.cash-inflows') }}" class="btn btn-sm" style="background-color: #00A859; color: white;">Lihat Detail</a>
            </div>
        </div>
    </div>

    <!-- Kartu: Kas Keluar -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card" style="border-left: 5px solid #FF4F4F; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <div class="card-body" style="background-color: #ffffff; padding: 1.5rem;">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold" style="color: #FF4F4F; text-transform: uppercase; margin-bottom: 10px;">
                            Kas Keluar bulan ini ({{ \Carbon\Carbon::now()->translatedFormat('F') }})
                        </div>
                        <div class="h5 mb-0 font-weight-bold" style="color: #333333;">Rp {{ number_format($data[\Carbon\Carbon::now()->month]['expenses'], 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x" style="color: #FF4F4F;"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center" style="background-color: #f7f7f7;">
                <a href="{{ route('reports.cash-outflows') }}" class="btn btn-sm" style="background-color: #FF4F4F; color: white;">Lihat Detail</a>
            </div>
        </div>
    </div>
</div>
