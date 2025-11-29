<style>
    /* Styling Navbar Default (Hitam) */
    .navbar-custom {
        background-color: #131212; /* Hitam Solid */
        padding: 15px 0;
        transition: all 0.4s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Styling Navbar saat Scroll (Glass) */
    .navbar-glass {
        background-color: rgba(0, 0, 0, 0.85) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 10px 0;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
        font-family: 'Montserrat', sans-serif; /* Opsional: Font keren */
        letter-spacing: 2px;
        font-weight: 700;
        color: white !important;
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.85rem;
        transition: color 0.3s ease;
    }

    .nav-link:hover, .nav-link.active {
        color: #ffc107 !important; /* Warna kuning emas */
    }

    /* Trik agar Logo benar-benar di tengah pada layar besar */
    @media (min-width: 992px) {
        .navbar-brand-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
    }
</style>

<nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom">
    <div class="container-fluid px-4 px-lg-5 position-relative"> 
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand d-lg-none mx-auto" href="#">THE KOMAR'S</a>

        <div class="collapse navbar-collapse w-100" id="navbarContent">
            
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('menu.index') ? 'active' : '' }}" href="{{ route('menu.index') }}">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Reservasi</a>
                </li>
            </ul>

            <a class="navbar-brand navbar-brand-center d-none d-lg-block" href="{{ url('/') }}">
                THE KOMAR'S
            </a>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="#">Lokasi</a>
                </li>
                <li class="nav-item me-3">
                    <a class="nav-link {{ request()->routeIs('feedback.form') ? 'active' : '' }}" href="{{ route('feedback.form') }}">Feedback</a>
                </li>
                
                <li class="nav-item d-none d-lg-block border-end border-secondary mx-2" style="height: 20px;"></li>

                <li class="nav-item">
                    <a class="nav-link position-relative" href="#">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem;">0</span>
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#"><i class="fas fa-bell"></i></a>
                </li>
                
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user text-warning"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item ms-2">
                    <a class="nav-link btn btn-outline-light rounded-pill px-3 py-1 text-white" href="{{ route('login') }}" style="border: 1px solid white;">Login</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<script>
    // Script Efek Scroll Glassmorphism
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNavbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-glass');
        } else {
            navbar.classList.remove('navbar-glass');
        }
    });
</script>