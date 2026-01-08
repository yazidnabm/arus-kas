<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard') | Toko Snack Bu Ana</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f7fb;
        }
        .navbar-brand small {
            display: block;
            font-size: 12px;
            opacity: .8;
        }
        .card {
            border-radius: 12px;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="/dashboard">
            <i class="bi bi-shop me-1"></i>
            Toko Snack Bu Ana
            <small>Sistem Arus Kas</small>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarApp">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarApp">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active fw-semibold' : '' }}" href="/dashboard">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kas-masuk') ? 'active fw-semibold' : '' }}" href="/kas-masuk">
                        <i class="bi bi-arrow-down-circle me-1"></i> Kas Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kas-keluar') ? 'active fw-semibold' : '' }}" href="/kas-keluar">
                        <i class="bi bi-arrow-up-circle me-1"></i> Kas Keluar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('laporan') ? 'active fw-semibold' : '' }}" href="/laporan">
                        <i class="bi bi-file-earmark-text me-1"></i> Laporan
                    </a>
                </li>
            </ul>

            <form method="POST" action="/logout">
                @csrf
                <button class="btn btn-light btn-sm">
                    <i class="bi bi-box-arrow-right me-1"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<main class="container-fluid px-4 mt-4">
    @yield('content')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
