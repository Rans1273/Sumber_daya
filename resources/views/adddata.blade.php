@extends('layouts.layout')

@section('title', 'Add - SDA Bulungan')

@section('content')
<body class="bg-dark text-white" style="font-family: Arial, sans-serif;">
    <div class="container my-5">
        <h2 class="mb-4 text-center">Tambah Data Perkebunan</h2>

        <!-- Form Tambah Manual -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">Tambah Data Perkebunan</div>
            <div class="card-body text-dark">
                <form action="{{ route('perkebunan.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                        </div>
                        <div class="col-md-6">
                            <label for="kelapa" class="form-label">Kelapa (ton)</label>
                            <input type="number" class="form-control" id="kelapa" name="kelapa" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kopi" class="form-label">Kopi (ton)</label>
                            <input type="number" class="form-control" id="kopi" name="kopi" required>
                        </div>
                        <div class="col-md-6">
                            <label for="kakao" class="form-label">Kakao (ton)</label>
                            <input type="number" class="form-control" id="kakao" name="kakao" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tebu" class="form-label">Tebu (ton)</label>
                            <input type="number" class="form-control" id="tebu" name="tebu" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tembakau" class="form-label">Tembakau (ton)</label>
                            <input type="number" class="form-control" id="tembakau" name="tembakau" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </form>
            </div>
        </div>

        <!-- Form Upload CSV -->
        <div class="card">
            <div class="card-header bg-success text-white">Upload CSV</div>
            <div class="card-body text-dark">
                <form action="{{ route('perkebunan.uploadCSV') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="csv_file" class="form-label">Pilih file CSV</label>
                        <input class="form-control" type="file" name="csv_file" id="csv_file" accept=".csv" required>
                        <div class="form-text">Format: kecamatan,kelapa,kopi,kakao,tebu,tembakau</div>
                    </div>
                    <button type="submit" class="btn btn-success">Upload CSV</button>
                </form>
            </div>
        </div>
        <a href="{{ route('perkebunan.index') }}" class="btn btn-danger mt-3 shadow-sm border-2 border-secondary px-4 py-2">Batalkan</a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

@endsection
