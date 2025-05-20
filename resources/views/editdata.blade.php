@extends('layouts.layout')

@section('title', 'Update - SDA Bulungan')

@section('content')
<body class="bg-dark text-white" style="font-family: Arial, sans-serif;">
    <div class="container my-5">
        <h2 class="mb-4 text-center">Update Data Perkebunan</h2>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">Update Data Perkebunan</div>
            <div class="card-body text-dark">

            <form action="{{ route('perkebunan.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- KECAMATAN --}}
                <div class="mb-3">
                    <label for="kecamatan_id" class="form-label">Kecamatan</label>
                    <select class="form-select" name="kecamatan_id" id="kecamatan_id" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id }}" {{ $data->kecamatan_id == $kecamatan->id ? 'selected' : '' }}>
                                {{ $kecamatan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TAHUN & TRIWULAN --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="tahun" name="tahun"
                            value="{{ old('tahun', $data->periode->tahun) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="triwulan" class="form-label">Triwulan</label>
                        <select name="triwulan" class="form-select" id="triwulan" required>
                            <option value="I" {{ $data->periode->triwulan == 'I' ? 'selected' : '' }}>I</option>
                            <option value="II" {{ $data->periode->triwulan == 'II' ? 'selected' : '' }}>II</option>
                            <option value="III" {{ $data->periode->triwulan == 'III' ? 'selected' : '' }}>III</option>
                            <option value="IV" {{ $data->periode->triwulan == 'IV' ? 'selected' : '' }}>IV</option>
                        </select>
                    </div>
                </div>

                {{-- FORM DEFAULT UNTUK SEMUA JENIS TANAMAN --}}
                @php
                    $produksiSemuaTanaman = \App\Models\ProduksiPerkebunan::where('kecamatan_id', $data->kecamatan_id)
                        ->where('periode_id', $data->periode_id)
                        ->get()
                        ->keyBy('jenis_tanaman_id');
                @endphp

                @foreach ($jenis_tanamans->chunk(2) as $chunk)
                <div class="row mb-3">
                    @foreach ($chunk as $tanaman)
                    <div class="col-md-6">
                        <label for="tanaman_{{ $tanaman->id }}" class="form-label">{{ $tanaman->nama }} (ton)</label>
                        <input type="number" step="any" class="form-control"
                            id="tanaman_{{ $tanaman->id }}"
                            name="produksi[{{ $tanaman->id }}]"
                            value="{{ old('produksi.' . $tanaman->id, $produksiSemuaTanaman[$tanaman->id]->produksi_ton ?? '') }}"
                            required>
                    </div>
                    @endforeach
                </div>
                @endforeach

                <button type="submit" class="btn btn-success">Update Data</button>
                <a href="{{ route('perkebunan.index') }}" class="btn btn-secondary ml-2">Batalkan</a>
            </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection
