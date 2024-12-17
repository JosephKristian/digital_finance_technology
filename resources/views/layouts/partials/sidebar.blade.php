<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    @auth
        @if (Auth::user()->role === 'umkm')
            
                @include('layouts.partials.side-umkm')
            
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
