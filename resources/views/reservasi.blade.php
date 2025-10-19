<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Restoran Nusantara</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (untuk ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Google Fonts: Montserrat & Lora -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@500&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #1a1a1a;
            color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(to bottom, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
            padding-top: 1rem;
            padding-bottom: 1rem;
            transition: background-color 0.3s ease-in-out;
        }
        .navbar-scrolled {
            background-color: rgba(15, 15, 15, 0.95);
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }
        .navbar-brand {
            font-family: 'Lora', serif;
            font-size: 1.8rem;
            letter-spacing: 2px;
        }
        .nav-link {
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
            color: #fff !important;
        }
        .navbar-nav .nav-link {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .navbar-icons .nav-link {
            font-size: 1.2rem;
        }
        .hero-section {
            height: 60vh;
            background: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1974&auto=format&fit=crop') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        .hero-content h1 {
            font-family: 'Lora', serif;
            font-size: 4rem;
            font-weight: 700;
        }
        .menu-section {
            padding: 80px 0;
        }
        .card {
            background-color: #262626;
            border: 1px solid #444;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }
        .card-img-top {
            height: 220px;
            object-fit: cover;
        }
        .price {
            font-size: 1.4rem;
            font-weight: 700;
            color: #ffc107;
        }
        .btn-order {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
            font-weight: bold;
        }
        .btn-order:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }
        footer {
            background-color: #0f0f0f;
            padding: 30px 0;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    
    <!-- Navbar -->
    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <!-- Left Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/menu">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="/reservasi">Reservasi</a></li>
                </ul>
            </div>

            <!-- Center Logo -->
            <a class="navbar-brand mx-auto" href="#">
                <i class="fa-solid fa-utensils"></i> BOXSATE
            </a>

            <!-- Right Links & Icons -->
            <div class="collapse navbar-collapse" id="navbarNavRight">
                <ul class="navbar-nav ms-auto navbar-icons align-items-center">
                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#">Lokasi</a></li>
                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="#">Karir</a></li>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-user"></i></a></li>
                </ul>
            </div>
            
            <!-- Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content text-white">
            <h1>Form Reservasi</h1>
            <p class="lead">Cita rasa terbaik dari dapur tradisional kami.</p>
        </div>
    </section>

    <div class="card shadow-lg mx-auto my-5" style="max-width: 1200px; background-color: #262626; border: none;">
      <div class="card-body px-5 py-4 text-white">
        <form action="{{ route('reservasi.store') }}" method="POST">
            @csrf

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama" class="form-label text-white">Nama Pelanggan</label>
                        <input type="text" name="nama" id="nama" class="form-control bg-secondary text-white border-0" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label text-white">Tanggal Reservasi</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control bg-secondary text-white border-0" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jam" class="form-label text-white">Jam Reservasi</label>
                        <input type="time" name="jam" id="jam" class="form-control bg-secondary text-white border-0" required>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_orang" class="form-label text-white">Jumlah Orang</label>
                        <input type="number" name="jumlah_orang" id="jumlah_orang" class="form-control bg-secondary text-white border-0" min="1" required>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning px-4 fw-bold">Kirim Reservasi</button>
            </div>
        </form>
      </div>
    </div>



    <!-- Footer -->
    <footer class="text-center text-white-50">
        <p>&copy; 2024 Restoran Nusantara. Didesain dengan penuh cita rasa.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script untuk mengubah background navbar saat di-scroll
        const navbar = document.getElementById('mainNavbar');
        window.onscroll = function () {
            if (window.pageYOffset > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        };
    </script>
</body>
</html>

