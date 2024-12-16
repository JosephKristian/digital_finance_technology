
<div class="sb-sidenav-menu">
    <div class="nav">
        <div class="sb-sidenav-menu-heading">Core</div>
        <a class="nav-link" href="{{ route('dashboard') }}">
            <div class="sb-nav-link-icon">
                <i class="fas fa-tachometer-alt"></i> <!-- Ikon untuk Dashboard -->
            </div>
            Dashboard
        </a>

        <div class="sb-sidenav-menu-heading">Master Data</div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
            data-bs-target="#masterDataSideBar" aria-expanded="false" aria-controls="masterDataSideBar">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            Master Data
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="masterDataSideBar" aria-labelledby="headingOne"
            data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{ route('products.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-box"></i> <!-- Ikon untuk Produk -->
                    </div>
                    Produk
                </a>

                <a class="nav-link" href="{{ route('customers.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-users"></i> <!-- Ikon untuk Pelanggan -->
                    </div>
                    Pelanggan
                </a>
            </nav>
        </div>



        <div class="sb-sidenav-menu-heading">Transaksi</div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
            data-bs-target="#transaksiSideBar" aria-expanded="false" aria-controls="transaksiSideBar">
            <div class="sb-nav-link-icon"><i class="fas fa-handshake"></i></div>
            Transaksi
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="transaksiSideBar" aria-labelledby="headingOne"
            data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{ route('transactions.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-shopping-cart"></i> <!-- Ikon untuk Penjualan -->
                    </div>
                    Penjualan
                </a>
                <a class="nav-link" href="{{ route('other.transactions.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-ellipsis-h"></i> <!-- Ikon untuk Penerimaan -->
                    </div>
                    Lain -lain
                </a>
            </nav>
        </div>


        <div class="sb-sidenav-menu-heading">Berkas</div>


        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
            data-bs-target="#accountingSideBar" aria-expanded="false" aria-controls="accountingSideBar">
            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
            <!-- Ikon dokumen laporan -->
            Catatan Akuntansi
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="accountingSideBar" aria-labelledby="headingOne"
            data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">

                <a class="nav-link" id="onDev">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-shopping-cart"></i> <!-- Ikon untuk Penjualan -->
                    </div>
                    Jurnal Umum
                </a>


            </nav>
        </div>
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
            data-bs-target="#reportsSideBar" aria-expanded="false" aria-controls="reportsSideBar">
            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
            <!-- Ikon dokumen laporan -->
            Laporan
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="reportsSideBar" aria-labelledby="headingOne"
            data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">

                <a class="nav-link" href="{{ route('reports.sales-report') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-shopping-cart"></i> <!-- Ikon untuk Penjualan -->
                    </div>
                    Penjualan
                </a>

                <a class="nav-link" href="{{ route('reports.cash-inflows') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-wallet"></i> <!-- Ikon untuk Penerimaan Kas -->
                    </div>
                    Penerimaan Kas
                </a>

                <a class="nav-link" href="{{ route('reports.cash-outflows') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-hand-holding-usd"></i> <!-- Ikon untuk Pengeluaran Kas -->
                    </div>
                    Pengeluaran Kas
                </a>


                {{-- income statement --}}
                <a class="nav-link" href="{{ route('reports.income-statement') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-chart-line"></i> <!-- Ikon grafik naik -->
                    </div>
                    Laba - Rugi
                </a>

                <a class="nav-link" id="onDev">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-balance-scale"></i> <!-- Ikon timbangan -->
                    </div>
                    Neraca Saldo
                </a>


            </nav>
        </div>


    </div>
</div>
<div class="sb-sidenav-footer">
    <div class="small">Logged in as:</div>
    {{ Auth::user()->name }} <!-- Menampilkan nama pengguna -->
</div>
@else
<p class="text-center text-white mt-5 px-4">
    Silakan lakukan <strong>verifikasi data</strong> terlebih dahulu. Pastikan file yang Anda unggah
    menggunakan format <span class="text-warning">PDF</span>.
    Setelah mengunggah file pendukung yang mendeskripsikan UMKM Anda, Anda dapat:
<ul class="text-left mt-3 px-4">
    <li>Menunggu email verifikasi dari kami, atau</li>
    <li>Langsung menggunakan kode token yang diberikan oleh admin.</li>
</ul>
</p>