<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    @auth
        @if (Auth::user()->role === 'umkm')
            @if (session('umkm_approve') == 1)
                @include('layouts.partials.side-umkm')
            @endif
        @endif

        @if (Auth::user()->role === 'admin')
        @include('layouts.partials.side-admin')
        @endif
    @endauth
    @guest
        <p class="text-center text-white mt-5">
            Anda belum login. Silakan
            <a href="{{ route('login') }}" class="text-warning text-decoration-none">login</a>
            terlebih dahulu untuk mengakses fitur ini.
        </p>
    @endguest

</nav>
