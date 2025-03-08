<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title', 'My Website')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <header>
        <div class="header">
            <div class="instasi">
                <img src="img/image.png" alt="">
                <h1>Sumber Daya Bulungan</h1>
            </div>
            <nav class="navbar">
                <ul class="nav">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </nav>
        </div>
        <div class="navigasibar">
            <ul class="nav">
                <li class="dropdown">
                    <a href="#">Gambaran Umum</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('gambaran_umum.luas_wilayah')}}">Luas Wilayah</a></li>
                        <li><a href="{{ route('gambaran_umum.nama_dan_ketinggian_gunung')}}">Nama dan Ketinggian Gunung</a></li>
                        <li><a href="{{ route('gambaran_umum.Tinggi_rata_rata')}}">Tinggi Rata-Rata</a></li>
                        <li><a href="{{ route('gambaran_umum.luas_daerah')}}">Luas Daerah</a></li>
                        <li><a href="{{ route('gambaran_umum.luas_daerah2')}}">Luas Daerah2</a></li>
                        <li><a href="{{ route('gambaran_umum.luas_wilayah2')}}">Luas Wilayah2</a></li>
                        <li><a href="{{ route('gambaran_umum.kepadatan_penduduk')}}">Kepadatan Penduduk</a></li>
                        <li><a href="{{ route('gambaran_umum.Produk_somestik_regional')}}">Produk Somestik Regional</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Bab 2</a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Sub bab</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Sumberdaya Pertanian Dan Perkebunan</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('pertanian_dan_perkebunan.luas_penggunaan_lahan')}}">Luas Penggunaan Lahan</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.luas_panen_ton')}}">Luas Panen(Ton)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.luas_panen_hektar')}}">Luas Panen(Hektar)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.produksi_tanaman_pangan')}}">Produksi Tanaman Pangan</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.produski_sayuran_kw')}}">Produksi Sayuran(Kw)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.produksi_sayuran_hektar')}}">Produksi Sayuran(Hektar)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.produski_sayuran_kw')}}">Produksi Buah-Buahan(Kw)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.tanaman_sayur')}}">Tanaman Sayur(Kw)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.tanaman_buah_buahan')}}">Tanaman Buah-Buahan(Ha)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.luas_panen_biofarmaka_kg')}}">Luas Panen Biofarmaka(Kg)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.luas_panen_biofarmaka_m2')}}">Luas Panen Biofarmaka(m2)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.produksi_tanaman_biofarmaka')}}">Produksi Tanaman Biofarmak</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.produksi_tanaman_hias')}}">Produksi Tanaman Hias</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.produksi_perkebunan')}}">Produksi Perkebunan</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.luas_panen_perkebunan_ha')}}">Luas Panen Perkebunan(Ha)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.luas_panen_perkebunan_ton')}}">Luas Panen Perkebunan(Ton)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.jumlah_bangunan_air_ha')}}">Jumlah Bangunan Air(Ha)</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.jumlah_sumber_air')}}">Jumlah Sumber Air</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.jumlah_embung')}}">Jumlah Embung</a></li>
                        <li><a href="{{ route('pertanian_dan_perkebunan.luas_lahan_sawah_ha')}}">Luas Lahan Sawah(Ha)</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Sumberdaya Kehutanan</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('kehutanan.produksi_non_kayu')}}">Produksi Non Kayu</a></li>
                        <li><a href="{{ route('kehutanan.produksi_kayu_bulat')}}">Produksi Kayu Bulat</a></li>
                        <li><a href="{{ route('kehutanan.luas_lahan_kehutanan')}}">Luas Lahan Kehutanan(Ha)</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Sumberdaya Peternakan</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('peternakan.populasi_hewan_ternak')}}">Populasi Hewan Ternak</a></li>
                        <li><a href="{{ route('peternakan.produk_daging')}}">Produk Daging</a></li>
                        <li><a href="{{ route('peternakan.populasi_hewan_unggas')}}">Populasi Hewan Unggas</a></li>
                        <li><a href="{{ route('peternakan.produksi_susu')}}">Produksi Susu</a></li>
                        <li><a href="{{ route('peternakan.produksi_telur')}}">Produksi Telur</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Sumberdaya Perikanan</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('perikanan.profil_perikanan')}}">Profil Perikanan</a></li>
                        <li><a href="{{ route('perikanan.produksi_perikanan')}}">Produksi Perikanan</a></li>
                        <li><a href="{{ route('perikanan.lokasi_usaha_perikanan')}}">Lokasi Usaha Perikanan</a></li>
                        <li><a href="{{ route('perikanan.produksi_perikanan_budidaya')}}">Produksi Perikanan Budidaya</a></li>
                        <li><a href="{{ route('perikanan.produksi_perikanan_per_ikan')}}">Produksi Perikanan Per Ikan</a></li>
                        <li><a href="{{ route('perikanan.produksi_perikanan_tangkap')}}">Produksi Perikanan Tangkap</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Sumberdaya Energi Dan Mineral</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route("pertambangan.perkembangan_pertambangan")}}">Perkembangan Pertambangan</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Sumberdaya Air</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route("air.jumlah_sumber_daya_air")}}">Jumlah Sumberdaya Air</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>
    
    <main>
        <div class="content">
            @yield('content')
        </div>
    </main>

    <footer>
        &copy; 2025 Website Keren - Semua Hak Dilindungi
    </footer>
</body>
</html>