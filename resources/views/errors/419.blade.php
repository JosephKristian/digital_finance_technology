<html class="focus-outline-visible">

<head>


    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title', 'DIGIFINTECH 419')</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- Include the CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/css/intlTelInput.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Toastr CSS -->



    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/404.css') }}" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>



    <style>
        <b:if cond='data:view.isError'><style> :root {
            --button-bg: #652f8f;
            --button-bg: #652f8f;
            --button-bg2: #652f8f;
            --button-color: #ffffff;
            --hover-button-bg: #652f8f;
            --hover-button-color: #ffffff;
            --mobile-color: #652f8f;
            --mobile-bg: #ffffff;
            --button-bg2: #652f8f;
        }
    </style>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Topbar -->
        @include('layouts.partials.topbar')
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            {{-- Sidebar --}}
            @include('layouts.partials.sidebar')
        </div>
        <div id="layoutSidenav_content">
            <main>

                <b:if cond="data:view.isError">
                    <div class="errorWrap">
                        <svg viewBox="0 0 1920 1080" xmlns="http://www.w3.org/2000/svg">
                            <title>419</title>
                            <g data-name="Layer 12" id="Layer_12 yellow-back-fig">
                                <path class="cls-1"
                                    d="M600.87,872H156a4,4,0,0,0-3.78,4.19h0a4,4,0,0,0,3.78,4.19H600.87a4,4,0,0,0,3.78-4.19h0A4,4,0,0,0,600.87,872Z">
                                </path>
                                <!-- Tambahkan elemen SVG lainnya sesuai kebutuhan -->
                            </g>
                        </svg>
                        <h3>419</h3>
                        <h4>Halaman ini telah kedaluwarsa</h4>
                        <p>Silakan <a href="{{ route('login') }}">login kembali</a> untuk melanjutkan.</p>
                    </div>
                </b:if>

            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; DIGIFINTECH 2024</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <!-- SB Admin JS -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <!-- Load intl-tel-input -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/intlTelInput.min.js"></script>
    <script src="{{ asset('js/customers.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <!-- Include the JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/intlTelInput.min.js"></script>
</body>

</html>
