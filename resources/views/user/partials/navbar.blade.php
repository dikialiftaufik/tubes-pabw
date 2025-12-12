<style>
    .navbar-custom {
        background-color: #131212;
        padding: 15px 0;
        transition: all 0.4s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 1100 !important;
    }
    .navbar-glass {
        background-color: rgba(0, 0, 0, 0.85) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 10px 0;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }
    .navbar-brand {
        letter-spacing: 2px;
        font-weight: 700;
        color: white !important;
    }
    .nav-link {
        color: rgba(255,255,255,0.8) !important;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.85rem;
    }
    .nav-link:hover, .nav-link.active {
        color: #ffc107 !important;
    }

    /* Notifikasi */
    .notif-dropdown {
        width: 350px;
        max-height: 400px;
        overflow-y: auto;
        background-color: #1f1f1f;
        color: white;
        border: 1px solid #444;
    }
    .notif-item {
        padding: 10px 15px;
        border-bottom: 1px solid #333;
        transition: background-color 0.3s;
    }
    .notif-item:hover {
        background-color: #2a2a2a;
    }
    .notif-item:last-child {
        border-bottom: none;
    }
    .notif-title {
        font-weight: 600;
        color: #ffc107;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    .notif-message {
        font-size: 0.8rem;
        color: #ccc;
        margin-bottom: 5px;
    }
    .notif-time {
        font-size: 0.7rem;
        color: #888;
    }
    .notif-unread {
        background-color: rgba(255, 193, 7, 0.1);
        border-left: 3px solid #ffc107;
    }
</style>

<nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom">
    <div class="container-fluid px-4 px-lg-5 position-relative">

        <button class="navbar-toggler" type="button" 
            data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand d-lg-none mx-auto" href="#">THE KOMAR'S</a>

        <div class="collapse navbar-collapse w-100" id="navbarContent">
            
            {{-- LEFT --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('menu.index') ? 'active' : '' }}" href="{{ route('menu.index') }}">Menu</a></li>
                <li class="nav-item"><a class="nav-link" href="#reservation">Reservasi</a></li>
            </ul>

            {{-- CENTER --}}
            <a class="navbar-brand navbar-brand-center d-none d-lg-block position-absolute start-50 translate-middle-x" href="{{ url('/') }}">
                THE KOMAR'S
            </a>

            {{-- RIGHT --}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item"><a class="nav-link" href="#reservation">Lokasi</a></li>

                <li class="nav-item me-3">
                    <a class="nav-link {{ request()->routeIs('feedback.index') ? 'active' : '' }}" href="{{ route('feedback.index') }}">Feedback</a>
                </li>

                <li class="nav-item d-none d-lg-block border-end border-secondary mx-2" style="height:20px;"></li>

                {{-- CART --}}
                <li class="nav-item">
                    <a class="nav-link position-relative" href="#">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.5rem;">0</span>
                    </a>
                </li>

                {{-- NOTIFIKASI --}}
                @auth
                <li class="nav-item dropdown mx-2">

                    <a class="nav-link dropdown-toggle position-relative" 
                       href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown">
                       
                        <i class="fas fa-bell"></i>

                        <span id="notifCount" 
                              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                              style="font-size:0.5rem;">
                            0
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end notif-dropdown" aria-labelledby="notifDropdown">

                        <li class="dropdown-header text-warning fw-bold">Notifikasi</li>
                        <li><hr class="dropdown-divider"></li>

                        <div id="notifList" class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-warning" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span class="ms-2 text-muted">Memuat...</span>
                        </div>

                    </ul>
                </li>
                @endauth

                {{-- USER --}}
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user text-warning"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item ms-2">
                    <a class="nav-link btn btn-outline-light rounded-pill px-3 py-1 text-white" href="{{ route('login') }}">Login</a>
                </li>
                @endauth
            </ul>

        </div>
    </div>
</nav>

{{-- SCRIPT NOTIFIKASI --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    function loadNotifications() {
        fetch("{{ route('notif.fetch') }}")
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log("Notifikasi data:", data); // Untuk debugging
                
                // Update counter
                const notifCount = document.getElementById("notifCount");
                if (notifCount) {
                    notifCount.textContent = data.count > 9 ? '9+' : data.count;
                    notifCount.style.display = data.count > 0 ? 'block' : 'none';
                }

                // Update list
                const list = document.getElementById("notifList");
                if (list) {
                    if (data.list && data.list.length > 0) {
                        list.innerHTML = '';
                        data.list.forEach(n => {
                            const notifClass = n.is_read == 0 ? 'notif-unread' : '';
                            const notifItem = document.createElement('div');
                            notifItem.className = `notif-item ${notifClass}`;
                            notifItem.innerHTML = `
                                <div class="notif-title">${n.title || 'Notifikasi'}</div>
                                <div class="notif-message">${n.message || ''}</div>
                                <div class="notif-time">${formatDate(n.created_at)}</div>
                            `;
                            list.appendChild(notifItem);
                        });
                    } else {
                        list.innerHTML = '<div class="text-muted text-center py-3">Tidak ada notifikasi</div>';
                    }
                }
            })
            .catch(err => {
                console.error("ERROR NOTIF:", err);
                const list = document.getElementById("notifList");
                if (list) {
                    list.innerHTML = '<div class="text-danger text-center py-3">Gagal memuat notifikasi</div>';
                }
            });
    }

    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    // Load notifikasi saat halaman dimuat
    loadNotifications();

    // Refresh notifikasi setiap 30 detik
    setInterval(loadNotifications, 30000);

    // Efek scroll
    window.addEventListener("scroll", function(){
        const navbar = document.getElementById('mainNavbar');
        if (window.scrollY > 50) {
            navbar.classList.add('navbar-glass');
        } else {
            navbar.classList.remove('navbar-glass');
        }
    });
});
</script>