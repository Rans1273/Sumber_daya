<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-dark text-white" style="font-family: Arial, sans-serif;">
    <!-- Header -->
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
                <a href="{{ route('dashboard')}}" class="btn btn-danger">LOGOUT</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark text-white sidebar py-4 border-end border-secondary">
                <div class="position-sticky">
                    <ul class="nav flex-column px-3">

                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#sek-dprd-bulungan" aria-expanded="false">
                                Sekretariat DPRD Kabupaten Bulungan
                            </button>
                            <div class="collapse ps-3" id="sek-dprd-bulungan">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data 1</a></li>
                                    <li><a href="#" class="nav-link text-white">data 2</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item mt-2">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#insektorat" aria-expanded="false">
                                Inspektorat
                            </button>
                            <div class="collapse ps-3" id="insektorat">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data 1</a></li>
                                    <li><a href="#" class="nav-link text-white">data 2</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#dinas_pertania" aria-expanded="false">
                                Dinas Pertanian
                            </button>
                            <div class="collapse ps-3" id="dinas_pertania">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="{{ route('perkebunan.index')}}" class="nav-link text-white">Data Statistik Produksi Perkebunan</a></li>
                                    <li><a href="#" class="nav-link text-white">data 2</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-1 py-0">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-center py-3 border-top border-secondary mt-auto">
        <p class="mb-0">&copy; 2025 SDA Bulungan</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>