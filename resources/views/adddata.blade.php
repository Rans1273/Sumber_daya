@extends('layouts.dashboard_layout')

@section('title', 'Add - SDA Bulungan')

@section('content')
<div class="container my-5 text-white" style="font-family: Arial, sans-serif;">
    <h2 class="mb-4 text-center">Tambah Data Perkebunan</h2>

    <!-- Form Tambah Manual -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Tambah Data Perkebunan</div>
        <div class="card-body text-dark">
            <form action="{{ route('perkebunan.store') }}" method="POST">
                @csrf

                <!-- Dropdown Kecamatan -->
                <div class="mb-3">
                    <label for="kecamatan_id" class="form-label">Kecamatan</label>
                    <select class="form-select" name="kecamatan_id" id="kecamatan_id" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Tahun -->
                <div class="mb-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select class="form-select" name="tahun" id="tahun" required>
                        <option value="">-- Pilih Tahun --</option>
                        @foreach ($periodes->pluck('tahun')->unique() as $tahun)
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Triwulan -->
                <div class="mb-3">
                    <label for="triwulan" class="form-label">Triwulan</label>
                    <select class="form-select" name="triwulan" id="triwulan" required>
                        <option value="">-- Pilih Triwulan --</option>
                        @foreach ($periodes->pluck('triwulan')->unique() as $triwulan)
                            <option value="{{ $triwulan }}">{{ $triwulan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Input semua jenis tanaman -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="kelapa" class="form-label">Kelapa (ton)</label>
                        <input type="number" class="form-control" id="kelapa" name="produksi[kelapa]" value="{{ old('produksi.kelapa') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="kopi" class="form-label">Kopi (ton)</label>
                        <input type="number" class="form-control" id="kopi" name="produksi[kopi]" value="{{ old('produksi.kopi') }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="kakao" class="form-label">Kakao (ton)</label>
                        <input type="number" class="form-control" id="kakao" name="produksi[kakao]" value="{{ old('produksi.kakao') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tebu" class="form-label">Tebu (ton)</label>
                        <input type="number" class="form-control" id="tebu" name="produksi[tebu]" value="{{ old('produksi.tebu') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="tembakau" class="form-label">Tembakau (ton)</label>
                    <input type="number" class="form-control" id="tembakau" name="produksi[tembakau]" value="{{ old('produksi.tembakau') }}" required>
                </div>

                <button type="submit" class="btn btn-success shadow-sm border-2 border-secondary px-4 py-2 flex-fill">Simpan Data</button>
                <a href="{{ route('perkebunan.index') }}" class="btn btn-danger shadow-sm border-2 border-secondary px-4 py-2 flex-fill">Batalkan</a>
            </form>
        </div>
    </div>

</div>
@endsection
