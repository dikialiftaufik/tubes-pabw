<nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top px-4">
    <div class="container-fluid">
        <!-- Menu Kiri -->
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                {{-- Menggunakan helper 'request()->routeIs()' untuk menandai link yang aktif --}}
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('menu.index') ? 'active' : '' }}" href="{{ route('menu.index') }}">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Reservasi</a></li>
            </ul>
        </div>

        <!-- Logo Tengah -->
        <a class="navbar-brand mx-auto" href="#">THE KOMAR'S</a>

        <!-- Menu Kanan -->
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#">Lokasi</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('feedback.form') ? 'active' : '' }}" href="{{ route('feedback.form') }}">Feedback</a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-user"></i></a></li>
            </ul>
        </div>
    </div>
</nav>
