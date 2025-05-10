<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-dark text-white" style="font-family: Arial, sans-serif;">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">DATA BULUNGAN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#">JELAJAHI</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">CERITA</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">TENTANG</a></li>
                </ul>
                <button class="btn btn-danger">LOGIN</button>
            </div>
        </div>
    </nav>

    <main>
        <div class="content">
            <!-- Konten Dinamis -->
            @yield('content')
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-dark text-center py-3 border-top border-secondary">
        <p>&copy; 2025 SDA Bulungan | </p>
    </footer>

    <!-- Bootstrap JS Bundle (harus ada agar dropdown bekerja) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
