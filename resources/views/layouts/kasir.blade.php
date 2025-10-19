<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | The komar's</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
        .card {
            border-radius: 12px;
        }
        .btn-outline-light:hover {
            background-color: #00b894;
            color: #fff;
        }
        footer {
            background-color: #1c1c1c;
            padding: 15px 0;
            color: #888;
            font-size: 0.9rem;
            text-align: center;
            border-top: 1px solid #2c2c2c;
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">🍢 The Komar's</a>
            <span class="navbar-text text-secondary">Kasir</span>
        </div>
    </nav>

    {{-- ISI UTAMA --}}
    <main class="container my-4">
        @yield('content')
    </main>

   
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
