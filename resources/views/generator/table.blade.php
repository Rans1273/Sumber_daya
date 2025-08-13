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

                {{-- TIPE GENERATOR --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">1. Pilih Tipe Modul</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="generator_type" id="typeMaster" value="master" checked>
                        <label class="form-check-label" for="typeMaster"><strong>Generator Master</strong></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="generator_type" id="typeTransactional" value="transactional">
                        <label class="form-check-label" for="typeTransactional"><strong>Generator Tabel Utama</strong></label>
                    </div>
                </div>
                <hr>

                {{-- INFORMASI DASAR --}}
                <div class="mb-3">
                    <label for="pageName" class="form-label fw-bold">2. Nama Halaman / Modul</label>
                    <input type="text" class="form-control" id="pageName" name="page_name" required placeholder="Contoh: Data Kecamatan">
                </div>
                <div class="mb-3">
                    <label for="dinasId" class="form-label fw-bold">3. Dinas Terkait</label>
                    <select class="form-select" id="dinasId" name="dinas_id" required>
                        <option value="" disabled selected>-- Pilih Dinas --</option>
                        @foreach ($dinas as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <hr>

                {{-- OPSI GENERATOR MASTER --}}
                <div id="master-options">
                    <h5 class="fw-bold">4. Definisikan Kolom</h5>
                    <div id="kolom-container">
                        <div class="row align-items-end mb-3 kolom-item">
                            <div class="col-md-5"><label class="form-label">Nama Kolom</label><input type="text" name="columns[0][name]" class="form-control"></div>
                            <div class="col-md-5"><label class="form-label">Tipe Data</label><select name="columns[0][type]" class="form-select"><option value="string">Teks Singkat</option><option value="text">Teks Panjang</option><option value="integer">Angka Bulat</option></select></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm mt-2" id="tambah-kolom">+ Tambah Kolom</button>
                </div>

                {{-- OPSI GENERATOR TABEL UTAMA --}}
                <div id="transactional-options" style="display: none;">
                    <h5 class="fw-bold">4. Hubungkan ke Tabel Master (Dimensi)</h5>
                    <div id="relasi-container">
                        <div class="row align-items-center mb-3 pb-3 border-bottom relasi-item">
                            <div class="col-md-3"><label class="form-label">Nama Relasi</label><input type="text" name="relations[0][name]" class="form-control" placeholder="e.g., periode"></div>
                            <div class="col-md-4"><label class="form-label">Terhubung ke Tabel</label>
                                <select name="relations[0][references]" class="form-select master-table-selector">
                                    <option value="">-- Pilih Tabel --</option>
                                    @foreach ($tables as $table)<option value="{{ $table }}">{{ $table }}</option>@endforeach
                                </select>
                            </div>
                            <div class="col-md-4"><label class="form-label">Kolom untuk Tampilan</label>
                                <select name="relations[0][display_column]" class="form-select display-column-selector" disabled><option>Pilih tabel dulu</option></select>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-info btn-sm mt-2" id="tambah-relasi">+ Tambah Relasi</button>
                    <hr class="my-4">
                    <h5 class="fw-bold">5. Definisikan Kolom Nilai</h5>
                    <div id="nilai-container">
                        <div class="row align-items-end mb-3 nilai-item">
                            <div class="col-md-5"><label class="form-label">Nama Kolom Nilai</label><input type="text" name="value_columns[0][name]" class="form-control"></div>
                            <div class="col-md-5"><label class="form-label">Tipe Data</label><select name="value_columns[0][type]" class="form-select"><option value="decimal">Angka Desimal</option><option value="integer">Angka Bulat</option><option value="string">Teks Singkat</option></select></div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm mt-2" id="tambah-nilai">+ Tambah Kolom Nilai</button>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">Buat Modul Sekarang</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Logika untuk menampilkan/menyembunyikan form
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

    // --- LOGIKA BARU UNTUK DROPDOWN KOLOM DINAMIS ---
    async function updateColumnSelector(tableSelector, columnSelector) {
        const tableName = tableSelector.value;
        columnSelector.innerHTML = '<option>Loading...</option>';
        columnSelector.disabled = true;

        if (!tableName) {
            columnSelector.innerHTML = '<option>Pilih tabel dulu</option>';
            return;
        }

        try {
            const response = await fetch(`/generator/get-columns/${tableName}`);
            if (!response.ok) throw new Error('Network response was not ok');
            const columns = await response.json();
            
            columnSelector.innerHTML = ''; // Hapus loading
            columns.forEach(column => {
                const option = document.createElement('option');
                option.value = column;
                option.textContent = column;
                columnSelector.appendChild(option);
            });
            columnSelector.disabled = false;
        } catch (error) {
            console.error('Fetch error:', error);
            columnSelector.innerHTML = '<option>Error memuat kolom</option>';
        }
    }

    // Terapkan event listener ke seluruh container
    const formBody = document.querySelector('.card-body');
    formBody.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('master-table-selector')) {
            const parentRow = e.target.closest('.relasi-item');
            const columnSelector = parentRow.querySelector('.display-column-selector');
            updateColumnSelector(e.target, columnSelector);
        }
    });

    // --- Logika Tambah/Hapus Dinamis ---
    let kolomIndex = 1;
    document.getElementById('tambah-kolom').addEventListener('click', function() { /* ... logika tambah kolom ... */ });

    let relasiIndex = 1;
    document.getElementById('tambah-relasi').addEventListener('click', function() {
        const container = document.getElementById('relasi-container');
        const newItem = document.createElement('div');
        newItem.className = 'row align-items-center mb-3 pb-3 border-bottom relasi-item';
        const selectOptions = `@foreach ($tables as $table)<option value="{{ $table }}">{{ $table }}</option>@endforeach`;
        newItem.innerHTML = `
            <div class="col-md-3"><label class="form-label">Nama Relasi</label><input type="text" name="relations[${relasiIndex}][name]" class="form-control"></div>
            <div class="col-md-3"><label class="form-label">Terhubung ke Tabel</label><select name="relations[${relasiIndex}][references]" class="form-select master-table-selector"><option value="">-- Pilih Tabel --</option>${selectOptions}</select></div>
            <div class="col-md-3"><label class="form-label">Kolom Tampilan</label><select name="relations[${relasiIndex}][display_column]" class="form-select display-column-selector" disabled><option>Pilih tabel dulu</option></select></div>
            <div class="col-md-2"><label class="form-label">&nbsp;</label><button type="button" class="btn btn-danger d-block w-100 remove-item">Hapus</button></div>`;
        container.appendChild(newItem);
        relasiIndex++;
    });

    let nilaiIndex = 1;
    document.getElementById('tambah-nilai').addEventListener('click', function() { /* ... logika tambah nilai ... */ });

    formBody.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-item')) {
            e.target.closest('.row').remove();
        }
    });
});
</script>
@endsection
