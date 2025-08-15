@extends('layouts.layout')

@section('title', 'Dashboard - SDA Bulungan')

@section('content')
<body class="bg-dark text-white" style="font-family: Arial, sans-serif;">

    <!-- Section -->
    <div class="container-fluid text-white min-vh-100 d-flex align-items-center"
        style="background-image: url('img/image/pegunungan.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;">
        <div class="row w-100 align-items-center justify-content-center px-3">
            <!-- section -->
            <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                <h1 class="fw-bold display-5" style="font-size: 60px;">
                    JELAJAHI STATISTIK DATA 
                    <span id="typing" style="border-right: 2px solid white; white-space: nowrap; overflow: hidden; display: inline-block; vertical-align: bottom; font-family: inherit; animation: blink 0.7s step-end infinite;"></span>
                </h1>
                <p class="lead" style="font-size: 16px;">CARI BERDASARKAN KOTA, INDUSTRI, UNIVERSITAS, DAN LAINNYA</p>
                <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start align-items-center gap-3 mb-3">
                    <a href="#" class="btn btn-outline-light">LIHAT DATA GEOGRAFIS</a>
                    <a href="#" class="btn btn-outline-light">LIHAT DATA PEKERJAAN</a>
                    <a href="#" class="btn btn-outline-light">LIHAT DATA BUDIDAYA</a>
                </div>
                <style>
                    @keyframes blink { 50% { border-color: transparent; } }
                </style>
                <script>
                    const text = "BULUNGAN";
                    const el = document.getElementById("typing");
                    let i = 0, del = false;
                    function type() {
                        el.textContent = text.substring(0, i);
                        if (!del && i <= text.length) { i++; }
                        else if (del && i >= 0) { i--; }
                        if (i > text.length) { del = true; setTimeout(type, 1000); }
                        else if (i < 0) { del = false; setTimeout(type, 700); }
                        else setTimeout(type, del ? 100 : 150);
                    }
                    document.addEventListener("DOMContentLoaded", type);
                </script>
            </div>
            <!-- section -->
            <div class="col-lg-6 text-center">
                <img src="img/image/peta.png" class="img-fluid my-3" alt="Peta" style="max-height: 500px;">
            </div>
        </div>
    </div>

    <!-- Section -->
    <section class="py-5 text-white" style="background-color: #002c04;">
        <div class="container">
            <h3 class="text-center mb-4">LAPORAN POPULER TERBARU</h3>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                <a href="{{ route('perkebunan.index') }}" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/dinas/dpmptsp-prov.jpg" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">DPMPTSP</h5>
                            <p class="card-text">Provinsi Kalimantan Utara</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('perkebunan.index') }}" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/dinas/esdm-prov.png" class="card-img-top" alt=""/>
                        <div class="card-body">
                            <h5 class="card-title">ESDM</h5>
                            <p class="card-text">Provinsi Kalimantan Utara</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('perkebunan.index') }}" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/sumberdaya/perkebunan.jpg" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">KEHUTANAN</h5>
                            <p class="card-text">Provinsi Kalimantan Utara</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('perkebunan.index') }}" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/sumberdaya/perkebunan.jpg" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">DPUPR</h5>
                            <p class="card-text">KABUPATEN BULUNGAN</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('perkebunan.index') }}" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/sumberdaya/perkebunan.jpg" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">DPMPTSP</h5>
                            <p class="card-text">KABUPATEN BULUNGAN</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/sumberdaya/sumber air.jpg" class="card-img-top" alt="" />
                        <div class="card-body ">
                            <h5 class="card-title">PERTANIAN</h5>
                            <p class="card-text">KABUPATEN BULUNGAN</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/sumberdaya/tambang.jpg" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">PERIKANAN</h5>
                            <p class="card-text">KABUPATEN BULUNGAN</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/sumberdaya/embung.jpeg" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">DISKOPERINDAG</h5>
                            <p class="card-text">KABUPATEN BULUNGAN</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/sumberdaya/kayu_bulat.jpg" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">KETAHANAN PANGAN</h5>
                            <p class="card-text">KABUPATEN BULUNGAN</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/sumberdaya/produksi_susu.jpg" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">TRANSMIGRASI & TENAGA KERJA</h5>
                            <p class="card-text">KABUPATEN BULUNGAN</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/sumberdaya/hewan_unggas.jpg" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">PEMUDA OLAHRAGA & PARIWISATA</h5>
                            <p class="card-text">KABUPATEN BULUNGAN</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col text-decoration-none">
                    <div class="card h-100 bg-secondary text-white">
                        <img src="img/sumberdaya/produksi_daging.jpg" class="card-img-top" alt="" />
                        <div class="card-body">
                            <h5 class="card-title">LINGKUNGAN HIDUP</h5>
                            <p class="card-text">KABUPATEN BULUNGAN</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="text-center mt-4">
                <button class="btn btn-outline-light">Lihat Semua Laporan</button>
            </div>
        </div>
    </section>

    <!-- Tools -->
    <section class="bg-light text-dark py-5">
        <div class="container text-center">
            <h3>GRAFIK SUMBERDAYA BULUNGAN</h3>
            <div class="row justify-content-center align-items-center mt-4">
                <div class="col-md-6">
                    <img src="img/image1.jpg" class="img-fluid" alt="" />
                </div>
                <div class="col-md-6 text-start">
                    <h5>PEMBUATAN VISUALISAI</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur eaque perferendis sed
                        voluptates eos commodi adipisci ea quos vero nisi maxime, dolorem eius pariatur? Repudiandae
                        officiis quo repellat animi quam?</p>
                    <a href="#" class="btn btn-primary">KE PEMBUAT VISUALISASI</a>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

@endsection