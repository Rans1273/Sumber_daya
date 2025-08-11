@extends('layouts.dashboard_layout')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Generator Modul Aplikasi</h1>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong><br>
            {!! nl2br(e(session('success'))) !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi Error:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-success text-white">
            <h6 class="m-0 fw-bold">Buat Modul Baru</h6>
        </div>
        <div class="card-body">

            <form action="{{ route('generator.generate') }}" method="POST">
                @csrf

                {{-- LANGKAH 1 --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">1. Pilih Tipe Modul</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="generator_type" id="typeMaster" value="master" checked>
                        <label class="form-check-label" for="typeMaster">
                            <strong>Generator Master (Kecil)</strong> - CRUD data referensi (contoh: Kecamatan, Jenis Tanaman, Periode).
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="generator_type" id="typeTransactional" value="transactional">
                        <label class="form-check-label" for="typeTransactional">
                            <strong>Generator Tabel Utama (Besar)</strong> - Data utama yang kompleks & terhubung ke master.
                        </label>
                    </div>
                </div>

                <hr>

                {{-- LANGKAH 2 --}}
                <div class="mb-3">
                    <label for="dinasId" class="form-label fw-bold">2. Pilih Dinas Terkait</label>
                    <select class="form-select" id="dinasId" name="dinas_id" required>
                        <option value="" disabled selected>-- Pilih salah satu dinas --</option>
                        @foreach ($dinas as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- LANGKAH 3 --}}
                <div class="mb-3">
                    <label for="pageName" class="form-label fw-bold">3. Nama Halaman</label>
                    <input type="text" class="form-control" id="pageName" name="page_name" required placeholder="Contoh: Data Kecamatan">
                    <div class="form-text">Nama ini digunakan untuk Model, Controller, dan View.</div>
                </div>

                <hr>

                {{-- OPSI MASTER --}}
                <div id="master-options">
                    <h5 class="fw-bold">4. Kolom Tabel Master</h5>
                    <p class="small text-muted">Contoh: Tabel "Kecamatan" hanya memerlukan satu kolom `nama` (string).</p>
                    <div id="kolom-container" class="mb-2">
                        <div class="row g-3 align-items-end kolom-item">
                        <div class="col-md-6">
                            <label class="form-label">Nama Kolom</label>
                            <input type="text" name="columns[0][name]" class="form-control" placeholder="contoh: nama_kecamatan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipe Data</label>
                            <select name="columns[0][type]" class="form-select">
                                <option value="string">Teks Singkat</option>
                                <option value="text">Teks Panjang</option>
                                <option value="integer">Angka Bulat</option>
                                <option value="decimal">Angka Desimal</option>
                                <option value="date">Tanggal</option>
                                <option value="boolean">Ya/Tidak</option>
                            </select>
                        </div>
                    </div>

                    </div>
                    <button type="button" id="tambah-kolom" class="btn btn-success btn-sm">+ Tambah Kolom</button>
                </div>

                {{-- OPSI TRANSAKSIONAL --}}
                <div id="transactional-options" style="display: none;">
                    <h5 class="fw-bold">4. Hubungkan ke Tabel Master</h5>
                    <p class="small text-muted">Contoh: Produksi Perkebunan terhubung ke `kecamatans`, `periodes`, `jenis_tanamans`.</p>
                    <div id="relasi-container" class="mb-2">
                        <div class="row g-3 align-items-end relasi-item">
                        <div class="col-md-6">
                            <label class="form-label">Nama Relasi</label>
                            <input type="text" name="relations[0][name]" class="form-control" placeholder="contoh: kecamatan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tabel Master</label>
                            <select name="relations[0][references]" class="form-select">
                                <option value="">-- Pilih Tabel Tujuan --</option>
                                @foreach ($tables as $table)
                                    <option value="{{ $table }}">{{ $table }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    </div>
                    <button type="button" id="tambah-relasi" class="btn btn-success btn-sm">+ Tambah Relasi</button>
                    
                    <hr class="my-4">

                    <h5 class="fw-bold">5. Kolom Nilai</h5>
                    <p class="small text-muted">Contoh: `jumlah_produksi` (decimal).</p>
                    <div id="nilai-container" class="mb-2">
                        <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label">Nama Kolom Nilai</label>
                            <input type="text" name="value_columns[0][name]" class="form-control" placeholder="contoh: jumlah_produksi">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipe Data</label>
                            <select name="value_columns[0][type]" class="form-select">
                                <option value="decimal">Angka Desimal</option>
                                <option value="integer">Angka Bulat</option>
                                <option value="string">Teks Singkat</option>
                                <option value="text">Teks Panjang</option>
                            </select>
                        </div>
                    </div>
                    </div>
                </div>

                <hr>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Buat Modul</button>
                </div>
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

    // Fungsi untuk menampilkan/menyembunyikan form
    function toggleGeneratorOptions() {
        if (typeMasterRadio.checked) {
            masterOptionsDiv.style.display = 'block';
            transactionalOptionsDiv.style.display = 'none';
            // Aktifkan input master, non-aktifkan input transaksional
            masterOptionsDiv.querySelectorAll('input, select').forEach(el => el.disabled = false);
            transactionalOptionsDiv.querySelectorAll('input, select').forEach(el => el.disabled = true);
        } else {
            masterOptionsDiv.style.display = 'none';
            transactionalOptionsDiv.style.display = 'block';
            // Aktifkan input transaksional, non-aktifkan input master
            masterOptionsDiv.querySelectorAll('input, select').forEach(el => el.disabled = true);
            transactionalOptionsDiv.querySelectorAll('input, select').forEach(el => el.disabled = false);
        }
    }

    // Panggil fungsi saat halaman dimuat
    toggleGeneratorOptions();

    // Tambahkan event listener ke radio button
    typeMasterRadio.addEventListener('change', toggleGeneratorOptions);
    typeTransactionalRadio.addEventListener('change', toggleGeneratorOptions);
    
    // ==========================================================
    // SCRIPT UNTUK GENERATOR MASTER (KECIL)
    // ==========================================================
    let kolomIndex = 1;
    document.getElementById('tambah-kolom').addEventListener('click', function() {
        const container = document.getElementById('kolom-container');
        const newItem = document.createElement('div');
        newItem.classList.add('row', 'align-items-end', 'mb-3', 'kolom-item');
        newItem.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="columns[${kolomIndex}][name]" class="form-control" placeholder="Nama kolom baru">
            </div>
            <div class="col-md-5">
                <select name="columns[${kolomIndex}][type]" class="form-select">
                    <option value="string">Teks Singkat (string)</option>
                    <option value="text">Teks Panjang (text)</option>
                    <option value="integer">Angka Bulat (integer)</option>
                    <option value="decimal">Angka Desimal (decimal)</option>
                    <option value="date">Tanggal (date)</option>
                    <option value="boolean">Ya/Tidak (boolean)</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-item">Hapus</button>
            </div>`;
        container.appendChild(newItem);
        kolomIndex++;
    });

    // ==========================================================
    // SCRIPT UNTUK GENERATOR TABEL UTAMA (BESAR)
    // ==========================================================
    let relasiIndex = 1;
    document.getElementById('tambah-relasi').addEventListener('click', function() {
        const container = document.getElementById('relasi-container');
        const newItem = document.createElement('div');
        newItem.classList.add('row', 'align-items-end', 'mb-3', 'relasi-item');
        const selectOptions = `@foreach ($tables as $table)<option value="{{ $table }}">{{ $table }}</option>@endforeach`;
        newItem.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="relations[${relasiIndex}][name]" class="form-control" placeholder="contoh: periode">
            </div>
            <div class="col-md-5">
                <select name="relations[${relasiIndex}][references]" class="form-select">
                    <option value="">-- Pilih Tabel Tujuan --</option>
                    ${selectOptions}
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-item">Hapus</button>
            </div>`;
        container.appendChild(newItem);
        relasiIndex++;
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