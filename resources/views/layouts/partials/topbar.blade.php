<!-- Navbar Brand-->
<a class="navbar-brand ps-3" href="#">D I G I F I N T E C H</a>
<a class="navbar-brand ps-3" href="#">{{ session('error') }}</a>
<a class="navbar-brand ps-3" href="#">{{ session('success') }}</a>
<!-- Sidebar Toggle-->
<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
        class="fas fa-bars"></i></button>

@auth

    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <!-- Authentication -->
    <form class="me-0 me-md-3 my-2" method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <div class="btn">
            <button type="submit" style="background: none; border: none; padding: 0;">
                <i class="fa-solid fa-arrow-right-from-bracket" style="color: #ffffff;"></i> <a
                    class="text-white">Logout</a>
            </button>
        </div>
    </form>




@endauth
