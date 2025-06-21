@extends('layouts.dashboard_layout') 

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Generator Migrasi Tabel</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Buat File Migrasi Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('generator.table.generate') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tableName" class="form-label">Nama Tabel (e.g., "Data Industri")</label>
                    <input type="text" class="form-control" id="tableName" name="table_name" required>
                </div>

                <hr>

                <h5>Definisi Kolom</h5>
                <div id="kolom-container">
                    {{-- Template untuk kolom pertama --}}
                    <div class="row align-items-end mb-3 kolom-item">
                        <div class="col-md-5">
                            <label class="form-label">Nama Kolom</label>
                            <input type="text" name="columns[0][name]" class="form-control" placeholder="contoh: nama_perusahaan" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Tipe Data</label>
                            <select name="columns[0][type]" class="form-select">
                                <option value="string">Teks (string)</option>
                                <option value="integer">Angka Bulat (integer)</option>
                                <option value="text">Teks Panjang (text)</option>
                                <option value="date">Tanggal (date)</option>
                                <option value="decimal">Angka Desimal (decimal)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="button" id="tambah-kolom" class="btn btn-success btn-sm">+ Tambah Kolom</button>
                <hr>
                <button type="submit" class="btn btn-primary">Buat File Migrasi</button>
            </form>
        </div>
    </div>
</div>

{{-- Script untuk menambah dan menghapus baris kolom secara dinamis --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    let kolomIndex = 1;
    document.getElementById('tambah-kolom').addEventListener('click', function() {
        const container = document.getElementById('kolom-container');
        const newItem = document.createElement('div');
        newItem.classList.add('row', 'align-items-end', 'mb-3', 'kolom-item');
        newItem.innerHTML = `
            <div class="col-md-5">
                <label class="form-label">Nama Kolom</label>
                <input type="text" name="columns[${kolomIndex}][name]" class="form-control" required>
            </div>
            <div class="col-md-5">
                <label class="form-label">Tipe Data</label>
                <select name="columns[${kolomIndex}][type]" class="form-select">
                    <option value="string">Teks (string)</option>
                    <option value="integer">Angka Bulat (integer)</option>
                    <option value="text">Teks Panjang (text)</option>
                    <option value="date">Tanggal (date)</option>
                    <option value="decimal">Angka Desimal (decimal)</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-kolom">Hapus</button>
            </div>
        `;
        container.appendChild(newItem);
        kolomIndex++;
    });

    document.getElementById('kolom-container').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-kolom')) {
            e.target.closest('.kolom-item').remove();
        }
    });
});
</script>
@endsection