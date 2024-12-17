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
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#masterDataSideBar"
            aria-expanded="false" aria-controls="masterDataSideBar">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            Master Data
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="masterDataSideBar" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="{{ route('super-admin.umkm.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-store"></i> <!-- Ikon toko kecil -->
                    </div>
                    Umkm
                </a>
            </nav>
        </div>






    </div>
</div>
<div class="sb-sidenav-footer">
    <div class="small">Logged in as:</div>
    {{ Auth::user()->name }} <!-- Menampilkan nama pengguna -->
</div>
