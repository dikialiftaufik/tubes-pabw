<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | The Komar's</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #121212;
            color: #fff;
        }
        .sidebar {
            width: 230px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1c1c1c;
            padding-top: 20px;
            border-right: 1px solid #333;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #bbb;
            text-decoration: none;
            font-weight: 500;
        }
        .sidebar a:hover {
            background-color: #00b894;
            color: #fff;
        }
        .content {
            margin-left: 250px;
            padding: 30px;
        }
        .navbar-brand {
            font-size: 1.3rem;
        }
    </style>
</head>

<body>

    {{-- NAVBAR --}}
    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">🍢 The Komar's - Kasir</a>
        </div>
    </nav>

    {{-- SIDEBAR --}}
    <div class="sidebar">
        <a href="{{ route('kasir.dashboard') }}">📊 Dashboard</a>
        <a href="{{ route('kasir.stok') }}">📦 Kelola Stok</a>
        <a href="{{ route('kasir.status-pesanan') }}">🧾 Status Pesanan</a>
        <a href="{{ route('kasir.status-reservasi') }}">📅 Status Reservasi</a>
    </div>

    {{-- ISI HALAMAN --}}
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
