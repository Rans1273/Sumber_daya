@extends('layouts.dashboard_layout')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Generator Modul Aplikasi</h1>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <strong>Sukses!</strong><br>
            {!! nl2br(e(session('success'))) !!}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Terjadi Error:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Buat Modul Baru</h6>
            <a href="{{ route('master-data.index') }}" class="btn btn-sm btn-info">
                <i class="fas fa-edit"></i> Buka Editor Data Master
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('generator.generate') }}" method="POST">
                @csrf

                {{-- LANGKAH 1: PILIH TIPE GENERATOR --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">1. Pilih Tipe Modul</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="generator_type" id="typeMaster" value="master" checked>
                        <label class="form-check-label" for="typeMaster">
                            <strong>Generator Master</strong> - Untuk data referensi (Kecamatan, Jenis Tanaman, dll).
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="generator_type" id="typeTransactional" value="transactional">
                        <label class="form-check-label" for="typeTransactional">
                            <strong>Generator Tabel Utama</strong> - Untuk data kompleks yang terhubung ke data master.
                        </label>
                    </div>
                </div>

                <hr>

                {{-- LANGKAH 2: INFORMASI DASAR --}}
                <div class="mb-3">
                    <label for="pageName" class="form-label fw-bold">2. Beri Nama Halaman / Modul</label>
                    <input type="text" class="form-control" id="pageName" name="page_name" required placeholder="Contoh: Data Kecamatan atau Produksi Perkebunan">
                </div>

                <div class="mb-3">
                    <label for="dinasId" class="form-label fw-bold">3. Pilih Dinas Terkait</label>
                    <select class="form-select" id="dinasId" name="dinas_id" required>
                        <option value="" disabled selected>-- Pilih salah satu dinas --</option>
                        @foreach ($dinas as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>

                {{-- ========================================================== --}}
                {{-- OPSI UNTUK GENERATOR MASTER --}}
                {{-- ========================================================== --}}
                <div id="master-options">
                    <h5 class="fw-bold">4. Definisikan Kolom Tabel Master</h5>
                    <p class="text-muted small">Generator ini hanya akan membuat Tabel Database dan Model-nya. Untuk mengisi dan mengedit data, gunakan "Editor Data Master".</p>
                    <div id="kolom-container">
                        <div class="row align-items-end mb-3 kolom-item">
                            <div class="col-md-5">
                                <label class="form-label">Nama Kolom</label>
                                <input type="text" name="columns[0][name]" class="form-control" placeholder="contoh: nama_kecamatan">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Tipe Data</label>
                                <select name="columns[0][type]" class="form-select">
                                    <option value="string">Teks Singkat (string)</option>
                                    <option value="text">Teks Panjang (text)</option>
                                    <option value="integer">Angka Bulat (integer)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="tambah-kolom" class="btn btn-success btn-sm mt-2">+ Tambah Kolom</button>
                </div>

                {{-- ========================================================== --}}
                {{-- OPSI UNTUK GENERATOR TABEL UTAMA --}}
                {{-- ========================================================== --}}
                <div id="transactional-options" style="display: none;">
                    <h5 class="fw-bold">4. Hubungkan ke Tabel Master (Dimensi)</h5>
                     <div class="alert alert-light small p-2">
                        Pastikan data master (seperti daftar kecamatan) sudah Anda isi terlebih dahulu menggunakan <strong>Editor Data Master</strong>.
                    </div>
                    <div id="relasi-container">
                        <div class="row align-items-end mb-3 relasi-item">
                            <div class="col-md-5">
                                <label class="form-label">Nama Relasi</label>
                                <input type="text" name="relations[0][name]" class="form-control" placeholder="contoh: kecamatan">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Terhubung ke Tabel</label>
                                <select name="relations[0][references]" class="form-select">
                                    <option value="">-- Pilih Tabel Tujuan --</option>
                                    @foreach ($tables as $table)
                                        <option value="{{ $table }}">{{ $table }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="tambah-relasi" class="btn btn-info btn-sm mt-2">+ Tambah Relasi</button>
                    
                    <hr class="my-4">

                    <h5 class="fw-bold">5. Definisikan Kolom Nilai</h5>
                    <div id="nilai-container">
                        <div class="row align-items-end mb-3 nilai-item">
                            <div class="col-md-5">
                                <label class="form-label">Nama Kolom Nilai</label>
                                <input type="text" name="value_columns[0][name]" class="form-control" placeholder="contoh: jumlah_produksi">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Tipe Data</label>
                                <select name="value_columns[0][type]" class="form-select">
                                    <option value="decimal">Angka Desimal (decimal)</option>
                                    <option value="integer">Angka Bulat (integer)</option>
                                    <option value="string">Teks Singkat (string)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="tambah-nilai" class="btn btn-success btn-sm mt-2">+ Tambah Kolom Nilai</button>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Buat Modul Sekarang</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const typeMasterRadio = document.getElementById('typeMaster');
    const typeTransactionalRadio = document.getElementById('typeTransactional');
    const masterOptionsDiv = document.getElementById('master-options');
    const transactionalOptionsDiv = document.getElementById('transactional-options');

    function toggleGeneratorOptions() {
        const isMaster = typeMasterRadio.checked;
        masterOptionsDiv.style.display = isMaster ? 'block' : 'none';
        transactionalOptionsDiv.style.display = isMaster ? 'none' : 'block';
        masterOptionsDiv.querySelectorAll('input, select').forEach(el => el.disabled = !isMaster);
        transactionalOptionsDiv.querySelectorAll('input, select').forEach(el => el.disabled = isMaster);
    }

    toggleGeneratorOptions();
    typeMasterRadio.addEventListener('change', toggleGeneratorOptions);
    typeTransactionalRadio.addEventListener('change', toggleGeneratorOptions);
    
    // --- Logika Tambah/Hapus Dinamis ---
    let kolomIndex = 1;
    document.getElementById('tambah-kolom').addEventListener('click', function() {
        const container = document.getElementById('kolom-container');
        const newItem = document.createElement('div');
        newItem.className = 'row align-items-end mb-3 kolom-item';
        newItem.innerHTML = `
            <div class="col-md-5"><input type="text" name="columns[${kolomIndex}][name]" class="form-control" placeholder="Nama kolom baru"></div>
            <div class="col-md-5">
                <select name="columns[${kolomIndex}][type]" class="form-select">
                    <option value="string">Teks Singkat (string)</option>
                    <option value="text">Teks Panjang (text)</option>
                    <option value="integer">Angka Bulat (integer)</option>
                </select>
            </div>
            <div class="col-md-2"><button type="button" class="btn btn-danger remove-item">Hapus</button></div>`;
        container.appendChild(newItem);
        kolomIndex++;
    });

    let relasiIndex = 1;
    document.getElementById('tambah-relasi').addEventListener('click', function() {
        const container = document.getElementById('relasi-container');
        const newItem = document.createElement('div');
        newItem.className = 'row align-items-end mb-3 relasi-item';
        const selectOptions = `@foreach ($tables as $table)<option value="{{ $table }}">{{ $table }}</option>@endforeach`;
        newItem.innerHTML = `
            <div class="col-md-5"><input type="text" name="relations[${relasiIndex}][name]" class="form-control" placeholder="contoh: periode"></div>
            <div class="col-md-5">
                <select name="relations[${relasiIndex}][references]" class="form-select">
                    <option value="">-- Pilih Tabel Tujuan --</option>${selectOptions}
                </select>
            </div>
            <div class="col-md-2"><button type="button" class="btn btn-danger remove-item">Hapus</button></div>`;
        container.appendChild(newItem);
        relasiIndex++;
    });

    let nilaiIndex = 1;
    document.getElementById('tambah-nilai').addEventListener('click', function() {
        const container = document.getElementById('nilai-container');
        const newItem = document.createElement('div');
        newItem.className = 'row align-items-end mb-3 nilai-item';
        newItem.innerHTML = `
            <div class="col-md-5"><input type="text" name="value_columns[${nilaiIndex}][name]" class="form-control" placeholder="Nama kolom nilai baru"></div>
            <div class="col-md-5">
                <select name="value_columns[${nilaiIndex}][type]" class="form-select">
                    <option value="decimal">Angka Desimal (decimal)</option>
                    <option value="integer">Angka Bulat (integer)</option>
                    <option value="string">Teks Singkat (string)</option>
                </select>
            </div>
            <div class="col-md-2"><button type="button" class="btn btn-danger remove-item">Hapus</button></div>`;
        container.appendChild(newItem);
        nilaiIndex++;
    });

    // Event listener umum untuk tombol hapus
    document.querySelector('.card-body').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-item')) {
            e.target.closest('.row').remove();
        }
    });
});
</script>
@endsection
