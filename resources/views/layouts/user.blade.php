<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Judul halaman akan dinamis, dengan judul default 'Restoran Nusantara' --}}
    <title>@yield('title', 'Restoran Nusantara')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (untuk ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Google Fonts: Montserrat & Lora -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@500&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    {{-- CSS Kustom untuk semua halaman user --}}
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #1a1a1a;
            color: #f8f9fa;
        }
        main {
            padding-top: 120px;
        }
        .navbar {
            transition: background-color 0.3s ease-in-out;
            font-family: 'Lora', serif;
        }
        .navbar-brand {
            font-size: 1.8rem;
            letter-spacing: 2px;
        }
        .navbar-scrolled {
            background-color: rgba(18, 18, 18, 0.9) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }
        .nav-link, .navbar-brand, .navbar-nav .nav-link.active {
            color: #f8f9fa !important;
        }
        .nav-link:hover {
            color: #ffc107 !important;
        }
        footer {
            padding: 2rem 0;
            background-color: #111;
            margin-top: 5rem;
        }
    </style>

    {{-- Memungkinkan halaman lain menambahkan style kustom jika diperlukan --}}
    @stack('styles')
</head>
<body>

    {{-- Memasukkan file partial navbar --}}
    @include('user.partials.navbar')

    <!-- Konten utama yang akan diisi oleh setiap halaman -->
    <main class="container">
        @yield('content')
    </main>

    {{-- Memasukkan file partial footer --}}
    @include('user.partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Memungkinkan halaman lain menambahkan script kustom jika diperlukan --}}
    @stack('scripts')

</body>
</html>
