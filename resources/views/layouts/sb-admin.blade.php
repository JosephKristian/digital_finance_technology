<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <!-- Include the CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/css/intlTelInput.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    {{-- sweet alert --}}
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
    <!-- Pemuatan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Pemuatan Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    {{-- chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    

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

                @include('layouts.partials.notifications')

                <!-- Konten halaman akan ditampilkan di sini -->
                @yield('content')
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



    @yield('script')


    </script>
    <!-- SB Admin JS -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <!-- Load intl-tel-input -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/intlTelInput.min.js"></script>
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

    {{-- fontawesome --}}
    <script src="https://kit.fontawesome.com/ba5c81e8b3.js" crossorigin="anonymous"></script>
</body>

</html>
