<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-dark text-white" style="font-family: Arial, sans-serif;">
    <div class="container my-5">
        <h2 class="mb-4 text-center">Update Data Perkebunan</h2>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">Update Data Perkebunan</div>
            <div class="card-body text-dark">
                <!-- Form Update -->
                <form action="{{ route('perkebunan.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $data->kecamatan) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="kelapa" class="form-label">Kelapa (ton)</label>
                            <input type="number" class="form-control" id="kelapa" name="kelapa" value="{{ old('kelapa', $data->kelapa) }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kopi" class="form-label">Kopi (ton)</label>
                            <input type="number" class="form-control" id="kopi" name="kopi" value="{{ old('kopi', $data->kopi) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="kakao" class="form-label">Kakao (ton)</label>
                            <input type="number" class="form-control" id="kakao" name="kakao" value="{{ old('kakao', $data->kakao) }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tebu" class="form-label">Tebu (ton)</label>
                            <input type="number" class="form-control" id="tebu" name="tebu" value="{{ old('tebu', $data->tebu) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tembakau" class="form-label">Tembakau (ton)</label>
                            <input type="number" class="form-control" id="tembakau" name="tembakau" value="{{ old('tembakau', $data->tembakau) }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Update Data</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
