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
                                    <li><a href="#" class="nav-link text-white">data</a></li>
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
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 3 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#bappeda" aria-expanded="false">
                                Badan Perencanaan Pembangunan Daerah (Bappeda) dan Penelitian Pengembangan
                            </button>
                            <div class="collapse ps-3" id="bappeda">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">Data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 4 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#bkad" aria-expanded="false">
                                Badan Keuangan dan Aset Daerah (BKAD)
                            </button>
                            <div class="collapse ps-3" id="bkad">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 5 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#dinas-pendidikan" aria-expanded="false">
                                Dinas Pendidikan
                            </button>
                            <div class="collapse ps-3" id="dinas-pendidikan">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 6 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#dinas-kesehatan" aria-expanded="false">
                                Dinas Kesehatan
                            </button>
                            <div class="collapse ps-3" id="dinas-kesehatan">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 7 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#dinas-pertania" aria-expanded="false">
                                Dinas Pertanian
                            </button>
                            <div class="collapse ps-3" id="dinas-pertania">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="{{ route('perkebunan.index')}}" class="nav-link text-white">Data Statistik Produksi Perkebunan</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 8 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#pupr" aria-expanded="false">
                                Dinas Pekerjaan Umum dan Penataan Ruang
                            </button>
                            <div class="collapse ps-3" id="pupr">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 9 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#dinas-sosial" aria-expanded="false">
                                Dinas Sosial
                            </button>
                            <div class="collapse ps-3" id="dinas-sosial">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 10 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#komunikasi-informatika" aria-expanded="false">
                                Dinas Komunikasi dan Informatika
                            </button>
                            <div class="collapse ps-3" id="komunikasi-informatika">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 11 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#dlh" aria-expanded="false">
                                Dinas Lingkungan Hidup
                            </button>
                            <div class="collapse ps-3" id="dlh">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 12 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#kelistrikan-dan-SD-mineral" aria-expanded="false">
                                Dinas Ketenagalistrikan dan Sumber Daya Mineral
                            </button>
                            <div class="collapse ps-3" id="kelistrikan-dan-SD-mineral">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 13 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#koperasi-dan-usaha-kecil-menengah" aria-expanded="false">
                                Dinas Koperasi dan Usaha Kecil Menengah
                            </button>
                            <div class="collapse ps-3" id="koperasi-dan-usaha-kecil-menengah">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 14 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#pariwisata" aria-expanded="false">
                                Dinas Pariwisata
                            </button>
                            <div class="collapse ps-3" id="pariwisata">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 15 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#pemuda-dan-olahraga" aria-expanded="false">
                                Dinas Pemuda dan Olahraga
                            </button>
                            <div class="collapse ps-3" id="pemuda-dan-olahraga">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 16 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#perpustakaan-dan-kearsipan" aria-expanded="false">
                                Dinas Perpustakaan dan Kearsipan
                            </button>
                            <div class="collapse ps-3" id="perpustakaan-dan-kearsipan">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 17 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#pemberdayaan-perempuan-dan-perlindungan-anak" aria-expanded="false">
                                Dinas Pemberdayaan Perempuan dan Perlindungan Anak
                            <div class="collapse ps-3" id="pemberdayaan-perempuan-dan-perlindungan-anak">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 18 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#peternakan" aria-expanded="false">
                                Dinas Peternakan
                            <div class="collapse ps-3" id="peternakan">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 19 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#perikanan" aria-expanded="false">
                                Dinas Perikanan
                            <div class="collapse ps-3" id="perikanan">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 20 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#perhubungan" aria-expanded="false">
                                Dinas Perhubungan
                            <div class="collapse ps-3" id="perhubungan">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 21 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#peneneman-modal-dan-perizinan" aria-expanded="false">
                                Dinas Penanaman Modal dan Perizinan
                            <div class="collapse ps-3" id="peneneman-modal-dan-perizinan">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 22 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#satpol-pp-dan-limnas" aria-expanded="false">
                                Satuan Polisi Pamong Praja dan Perlindungan Masyarakat (Satpol PP dan Linmas)
                            <div class="collapse ps-3" id="satpol-pp-dan-limnas">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
                                </ul>
                            </div>
                        </li>

                        <!-- 23 -->
                        <li class="nav-item">
                            <button
                                class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                                data-bs-toggle="collapse" data-bs-target="#p2p" aria-expanded="false">
                                Pusat Pelayanan Publik (P2P)
                            <div class="collapse ps-3" id="p2p">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#" class="nav-link text-white">data</a></li>
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