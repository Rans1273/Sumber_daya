<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashbaord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-dark text-white" style="font-family: Arial, sans-serif;">
    <div class="container my-5">
        <h2 class="mb-4 text-center">Data Statistik Bulungan</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle bg-white text-dark">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Nama Data</th>
                        <th scope="col">Nilai</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>CONTOH</td>
                        <td>CONTOH</td>
                        <td>CONTOH</td>
                        <td>CONTOH</td>
                        <td>CONTOH</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2 w-100">
                                <a href="" class="btn btn-sm btn-warning w-50 text-center">Edit</a>
                                <a href="" class="btn btn-sm btn-danger w-50 text-center" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
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