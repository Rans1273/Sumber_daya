<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-dark text-white" style="font-family: Arial, sans-serif;">
    <div class="container my-5">
        <h2 class="mb-4 text-center">Data Statistik Produksi Perkebunan</h2>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 gap-3">
            <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                <a href="{{ route('add')}}" class="btn btn-success">+ Tambah</a>
        
                <!-- Dropdown Konten -->
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Pilih Kolom</button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="">Kecamatan</a></li>
                        <li><a class="dropdown-item" href="">Kelapa</a></li>
                        <li><a class="dropdown-item" href="">Kopi</a></li>
                        <li><a class="dropdown-item" href="">Kakao</a></li>
                        <li><a class="dropdown-item" href="">Tebu</a></li>
                        <li><a class="dropdown-item" href="">Tembakau</a></li>
                    </ul>
                </div>
            </div>
        
            <!-- Form Pencarian -->
            <form class="d-flex" role="search" method="GET" action="">
                <input class="form-control me-2" type="search" name="q" placeholder="Cari data..." aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Cari</button>
            </form>
        </div>

        <!-- Tabel -->
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle bg-white text-dark">
                <thead class="table-dark">
                    <thead class="table-dark text-center">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kecamatan</th>
                            <th scope="col">Kelapa</th>
                            <th scope="col">Kopi</th>
                            <th scope="col">Kakao</th>
                            <th scope="col">Tebu</th>
                            <th scope="col">Tembakau</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>contoh</td>
                        <td>contoh</td>
                        <td>contoh</td>
                        <td>contoh</td>
                        <td>contoh</td>
                        <td>contoh</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2 w-100">
                                <a href="{{ route('up')}}" class="btn btn-sm btn-warning w-50 text-center">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger w-50 text-center"
                                    onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>