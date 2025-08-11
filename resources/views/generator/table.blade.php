@extends('layouts.dashboard_layout')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Generator Modul Aplikasi</h1>

    {{-- Notifikasi Sukses dan Error --}}
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
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Buat Modul Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('generator.generate') }}" method="POST">
                @csrf

                {{-- ========================================================== --}}
                {{-- LANGKAH 1: PILIH TIPE GENERATOR --}}
                {{-- ========================================================== --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">1. Pilih Tipe Modul yang Ingin Dibuat</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="generator_type" id="typeMaster" value="master" checked>
                        <label class="form-check-label" for="typeMaster">
                            <strong>Generator Master (Kecil)</strong> - Untuk membuat CRUD data referensi seperti Kecamatan, Jenis Tanaman, Periode, dll.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="generator_type" id="typeTransactional" value="transactional">
                        <label class="form-check-label" for="typeTransactional">
                            <strong>Generator Tabel Utama (Besar)</strong> - Untuk membuat tabel data utama yang kompleks dan terhubung dengan data master (contoh: Produksi Perkebunan).
                        </label>
                    </div>
                </div>

                <hr>

                {{-- ========================================================== --}}
                {{-- LANGKAH 2: INFORMASI DASAR --}}
                {{-- ========================================================== --}}
                <div class="mb-3">
                    <label for="dinasId" class="form-label fw-bold">2. Pilih Dinas Terkait</label>
                    <select class="form-select" id="dinasId" name="dinas_id" required>
                        <option value="" disabled selected>-- Pilih salah satu dinas --</option>
                        @foreach ($dinas as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="pageName" class="form-label fw-bold">3. Beri Nama Halaman</label>
                    <input type="text" class="form-control" id="pageName" name="page_name" required placeholder="Contoh: Data Kecamatan atau Produksi Perkebunan">
                    <div class="form-text">Nama ini akan menjadi nama Model, Controller, dan View.</div>
                </div>

                <hr>

                {{-- ========================================================== --}}
                {{-- OPSI UNTUK GENERATOR MASTER (KECIL) --}}
                {{-- ========================================================== --}}
                <div id="master-options">
                    <h5 class="fw-bold">4. Definisikan Kolom Tabel Master</h5>
                    <p>Definisikan kolom-kolom untuk tabel master ini. Contoh untuk tabel "Kecamatan", Anda hanya butuh satu kolom: `nama` (tipe: string).</p>
                    <div id="kolom-container">
                        {{-- Template untuk kolom pertama --}}
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
                                    <option value="decimal">Angka Desimal (decimal)</option>
                                    <option value="date">Tanggal (date)</option>
                                    <option value="boolean">Ya/Tidak (boolean)</option>
                                </select>
                            </div>
                            {{-- Kolom pertama tidak bisa dihapus --}}
                        </div>
                    </div>
                    <button type="button" id="tambah-kolom" class="btn btn-success btn-sm mt-2">+ Tambah Kolom</button>
                </div>


                {{-- ========================================================== --}}
                {{-- OPSI UNTUK GENERATOR TABEL UTAMA (BESAR) --}}
                {{-- ========================================================== --}}
                <div id="transactional-options" style="display: none;">
                    <h5 class="fw-bold">4. Hubungkan ke Tabel Master</h5>
                    <p>Pilih tabel-tabel master yang akan menjadi "dimensi" atau acuan untuk tabel utama ini. Contoh: Tabel "Produksi Perkebunan" akan terhubung ke tabel `kecamatans`, `periodes`, dan `jenis_tanamans`.</p>
                    <div id="relasi-container">
                        {{-- Template untuk relasi pertama --}}
                        <div class="row align-items-end mb-3 relasi-item">
                            <div class="col-md-5">
                                <label class="form-label">Nama Relasi (untuk pemanggilan)</label>
                                <input type="text" name="relations[0][name]" class="form-control" placeholder="contoh: kecamatan">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Terhubung ke Tabel Master</label>
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
                    <p>Definisikan kolom utama yang akan menampung nilai/data dari tabel ini. Contoh: `jumlah_produksi` (tipe: decimal).</p>
                    <div id="nilai-container">
                        <div class="row align-items-end mb-3">
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
                                    <option value="text">Teks Panjang (text)</option>
                                </select>
                            </div>
                        </div>
                        {{-- Bisa ditambahkan tombol tambah kolom nilai jika perlu --}}
                    </div>
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