<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | the komar's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #fff;
        }
        .card {
            border-radius: 12px;
        }
        .form-select, .form-control {
            border-radius: 10px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">🍢 BoloFood</a>
            <span class="navbar-text text-secondary">Pembayaran</span>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer class="text-center text-secondary mt-5 mb-3">
        <small>© 2025 The komar's — Pembayaran | Makanan Khas Jawa Tengah</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
