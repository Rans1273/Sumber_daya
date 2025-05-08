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
        <h2 class="mb-4 text-center">Data Statistik Bulungan</h2>

        <!-- Fitur Tambah & Pencarian -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
            <a href="tambah.php" class="btn btn-success mb-3 mb-md-0">+ Tambah Data</a>
            <form class="d-flex" role="search" method="GET" action="">
                <input class="form-control me-2" type="search" name="q" placeholder="Cari data..." aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Cari</button>
            </form>
        </div>

        <!-- Tabel -->
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle bg-white text-dark">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">contoh 1</th>
                        <th scope="col">contoh 2</th>
                        <th scope="col">contoh 3</th>
                        <th scope="col">contoh 4</th>
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
                        <td>
                            <div class="d-flex justify-content-center gap-2 w-100">
                                <a href="#" class="btn btn-sm btn-warning w-50 text-center">Edit</a>
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