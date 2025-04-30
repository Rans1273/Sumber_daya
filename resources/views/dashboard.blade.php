<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashbaord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-dark text-white">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">DATA BULUNGAN:</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#">Jelajahi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Cerita</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tentang</a></li>
                </ul>
                <form class="d-flex me-2" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
                <button class="btn btn-danger">Login</button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container-fluid text-center bg-secondary py-5">
        <h1 class="display-4 fw-bold">jelajahi statistik data bulungan</h1>
        <p class="lead">Visualisasi data dari ribuan sumber</p>
        <img src="img/image.png" class="img-fluid my-3" alt="Peta" />
    </div>

    <!-- Feature Section -->
    <section class="bg-light text-dark py-5">
        <div class="container text-center">
            <h2>Telusuri lebih dari ribuan data</h2>
            <p class="mb-4">Cari berdasarkan kota, industri, universitas, dan lainnya</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap mb-3">
                <a href="#" class="btn btn-outline-primary">Lihat data geografis</a>
                <a href="#" class="btn btn-outline-danger">Lihat data pekerjaan</a>
                <a href="#" class="btn btn-outline-dark">Lihat data budidaya</a>
            </div>
            <a href="#" class="text-decoration-underline">Cari Laporan →</a>
        </div>
    </section>

    <!-- Popular Reports Section -->
    <section class="bg-dark py-5">
        <div class="container">
            <h3 class="text-center mb-4">Laporan populer terbaru</h3>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                <!-- Ulangi kartu ini -->
                <a href="{{ Route('sajiandata')}}" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/image.png" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">Ekonomi Bulungan</h5>
                            <p class="card-text">Ekonomi dari Bulungan.</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/image.png" class="card-img-top" alt="" />
                        <div class="card-body ">
                            <h5 class="card-title">Ekonomi Bulungan</h5>
                            <p class="card-text">Ekonomi dari Bulungan.</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/image.png" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">Ekonomi Bulungan</h5>
                            <p class="card-text">Ekonomi dari Bulungan.</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/image.png" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">Ekonomi Bulungan</h5>
                            <p class="card-text">Ekonomi dari Bulungan.</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/image.png" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">Ekonomi Bulungan</h5>
                            <p class="card-text">Ekonomi dari Bulungan.</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/image.png" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">Ekonomi Bulungan</h5>
                            <p class="card-text">Ekonomi dari Bulungan.</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/image.png" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">Ekonomi Bulungan</h5>
                            <p class="card-text">Ekonomi dari Bulungan.</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/image.png" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">Ekonomi Bulungan</h5>
                            <p class="card-text">Ekonomi dari Bulungan.</p>
                        </div>
                    </div>
                </a>
                <!-- ... -->
            </div>
            <div class="text-center mt-4">
                <button class="btn btn-outline-light">Lihat Semua Laporan</button>
            </div>
        </div>
    </section>

    <!-- Visualization Tools -->
    <section class="bg-light text-dark py-5">
        <div class="container text-center">
            <h3>Grafik Sumberdaya Bulungan.</h3>
            <div class="row justify-content-center align-items-center mt-4">
                <div class="col-md-6">
                    <img src="img/image.png" class="img-fluid" alt="" />
                </div>
                <div class="col-md-6 text-start">
                    <h5>Pembuat Visualisasi</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur eaque perferendis sed
                        voluptates eos commodi adipisci ea quos vero nisi maxime, dolorem eius pariatur? Repudiandae
                        officiis quo repellat animi quam?</p>
                    <a href="#" class="btn btn-primary">Ke Pembuat Visualisasi</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-center py-3 border-top border-secondary">
        <p>&copy; 2025 Data Bulungan | Baghas</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>