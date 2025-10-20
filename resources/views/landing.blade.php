@extends('layouts.user')

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Komar's</title>
  <link rel="icon" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {font-family: 'Poppins', sans-serif; color: #333;}
    nav.navbar {background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);}
    .navbar-brand img {height: 50px;}
    .hero {
      background: url('{{ asset('img/fotorestoran.jpg') }}') center/cover no-repeat;
      height: 100vh; color: white; display: flex;
      align-items: center; justify-content: center;
      text-align: center; position: relative;
    }
    .hero::after {
      content: ""; position: absolute; inset: 0;
      background: rgba(0,0,0,0.5);
    }
    .hero-content {position: relative; z-index: 2;}
    section {padding: 80px 0;}
    #reservation {background-color: #f8f9fa;}
    footer {background-color: #222; color: #fff; padding: 40px 0;}
  </style>
</head>
<body>


  {{-- Hero Section --}}
  <section id="hero" class="hero">
    <div class="hero-content">
      <h1 class="display-4 fw-bold">Selamat Datang di <span class="text-warning">The Komar's</span></h1>
      <p class="lead">Nikmati cita rasa terbaik dari pilihan menu kami.</p>
      <a href="#reservation" class="btn btn-warning btn-lg mt-3">Reservasi Sekarang</a>
      <a href="menu" class="btn btn-warning btn-lg mt-3">Pesan Sekarang</a>
    </div>
  </section>

  {{-- About Section --}}
  <section id="about">
    <div class="container text-center">
      <h2 class="fw-bold mb-4">Tentang Kami</h2>
      <p class="mx-auto" style="max-width: 700px;">
        BOLOOO adalah tempat yang menyajikan pengalaman kuliner unik dengan menu khas yang dibuat dari bahan segar pilihan.
        Kami percaya bahwa setiap hidangan harus membawa kebahagiaan bagi setiap pelanggan.
      </p>
    </div>

    <div class="container text-center">
      <h2 class="fw-bold mb-5">Menu Favorit</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card border-0 shadow-sm">
            <img src="{{ asset('img\menu/tengkleng-kambing.jpg') }}" class="card-img-top" alt="Menu 1">
            <div class="card-body">
              <h5 class="card-title">Tengkleng Kambing</h5>
              <p class="card-text text-muted">Rp25.000</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-0 shadow-sm">
            <img src="{{ asset('img\menu/nasi-goreng.jpg') }}" class="card-img-top" alt="Menu 2">
            <div class="card-body">
              <h5 class="card-title">Nasi Goreng</h5>
              <p class="card-text text-muted">Rp28.000</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card border-0 shadow-sm">
            <img src="{{ asset('img\menu/tongseng-ayam.jpg') }}" class="card-img-top" alt="Menu 3">
            <div class="card-body">
              <h5 class="card-title">Tongseng Ayam</h5>
              <p class="card-text text-muted">Rp20.000</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  {{-- Reservation Section --}}
  <section id="reservation">
    <div class="container "style="max-width: 1800px; background-color: #262626;">
      <div class="text-center mb-5 ">
        <h2 class="fw-bold">Reservasi Meja</h2>
        <p>Pesan meja Anda sekarang dan nikmati pengalaman kuliner istimewa.</p>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <form action="#" method="POST" class="card shadow-sm p-4 border-0">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" class="form-control" placeholder="Nama lengkap" required>
              </div>
              <div class="col-md-6">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="tel" id="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
              </div>
              <div class="col-md-6">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" id="date" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label for="people" class="form-label">Jumlah Orang</label>
                <input type="number" id="people" class="form-control" min="1" required>
              </div>
              <div class="col-12">
                <label for="message" class="form-label">Catatan</label>
                <textarea id="message" class="form-control" rows="3"></textarea>
              </div>
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-warning mt-3 px-5">Kirim</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      {{-- Google Maps --}}
      <div class="mt-5 text-center">
        <h4 class="fw-bold mb-3">Lokasi Kami</h4>
        <div class="ratio ratio-16x9">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.3451322296482!2d107.63457970949146!3d-6.968548693002976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e9b22a7c041d%3A0xf61de0f3037c02f0!2sSate%20Solo%20Pak%20Komar!5e0!3m2!1sid!2sid!4v1760926790037!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </div>
  </section>

  @push('scripts')
<script>
    const navbar = document.getElementById('mainNavbar');
    // Efek transparan hanya berlaku di halaman menu
    if (window.pageYOffset < 50) {
        navbar.style.backgroundColor = 'transparent';
    }
    window.onscroll = function () {
        if (window.pageYOffset > 50) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
            navbar.style.backgroundColor = 'transparent';
        }
    };
</script>
@endpush

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
