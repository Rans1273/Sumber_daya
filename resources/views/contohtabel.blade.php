@extends('layouts.layout')

@section('title', 'Data - SDA Bulungan')

@section('content')
<body class="bg-dark text-white" style="font-family: Arial, sans-serif;">
    <div class="container my-5">
        <h2 class="mb-4 text-center">Data Statistik Produksi Perkebunan</h2>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 gap-3">
            <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                <a href="{{ route('perkebunan.create') }}" class="btn btn-success">+ Tambah</a>
                
                 {{-- Dropdown Kolom --}}
                <form id="searchForm" class="d-flex gap-2" method="GET" action="{{ route('perkebunan.index') }}">
                    <select name="column" class="form-select" required onchange="this.form.submit()">
                        <option value="">Pilih Kolom</option>
                        <option value="kecamatan" {{ request('column') == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                        <option value="tahun" {{ request('column') == 'tahun' ? 'selected' : '' }}>Tahun</option>
                        <option value="triwulan" {{ request('column') == 'triwulan' ? 'selected' : '' }}>Triwulan</option>
                        <option value="kelapa" {{ request('column') == 'kelapa' ? 'selected' : '' }}>Kelapa (Ton)</option>
                        <option value="kopi" {{ request('column') == 'kopi' ? 'selected' : '' }}>Kopi (Ton)</option>
                        <option value="kakao" {{ request('column') == 'kakao' ? 'selected' : '' }}>Kakao (Ton)</option>
                        <option value="tebu" {{ request('column') == 'tebu' ? 'selected' : '' }}>Tebu (Ton)</option>
                        <option value="tembakau" {{ request('column') == 'tembakau' ? 'selected' : '' }}>Tembakau (Ton)</option>
                    </select>
                {{-- Input atau dropdown dinamis --}}
                @php
                    $selectedColumn = request('column');
                @endphp
                @if ($selectedColumn === 'kecamatan')
                    <select name="search" class="form-select" required>
                        <option value="">Pilih Kecamatan</option>
                        @foreach ($kecamatanList as $nama)
                            <option value="{{ $nama }}" {{ request('search') == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                @elseif ($selectedColumn === 'tahun')
                    <select name="search" class="form-select" required>
                        <option value="">Pilih Tahun</option>
                        @foreach ($tahunList as $tahun)
                            <option value="{{ $tahun }}" {{ request('search') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endforeach
                    </select>
                @elseif ($selectedColumn === 'triwulan')
                    <select name="search" class="form-select" required>
                        <option value="">Pilih Triwulan</option>
                        @foreach ($triwulanList as $triwulan)
                            <option value="{{ $triwulan }}" {{ request('search') == $triwulan ? 'selected' : '' }}>{{ $triwulan }}</option>
                        @endforeach
                    </select>
                @else
                    <input class="form-control" type="search" name="search" value="{{ request('search') }}" placeholder="Cari data..." required>
                @endif
                {{-- Tombol Reset --}}
                @if(request('search') || request('column'))
                    <a href="{{ route('perkebunan.index') }}" class="btn btn-outline-warning">Reset</a>
                @endif
                    <button class="btn btn-outline-light" type="submit">Cari</button>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle bg-white text-dark">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Triwulan</th>
                        <th scope="col">Kecamatan</th>
                        <th scope="col">Kelapa</th>
                        <th scope="col">Kopi</th>
                        <th scope="col">Kakao</th>
                        <th scope="col">Tebu</th>
                        <th scope="col">Tembakau</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['tahun'] }}</td>
                            <td>{{ $item['triwulan'] }}</td>
                            <td>{{ $item['kecamatan'] }}</td>
                            <td>{{ $item['produksi']['kelapa'] ?? '-' }} Ton</td>
                            <td>{{ $item['produksi']['kopi'] ?? '-' }} Ton</td>
                            <td>{{ $item['produksi']['kakao'] ?? '-' }} Ton</td>
                            <td>{{ $item['produksi']['tebu'] ?? '-' }} Ton</td>
                            <td>{{ $item['produksi']['tembakau'] ?? '-' }} Ton</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2 w-100">
                                    <a href="{{ route('perkebunan.edit', $item['id']) }}" class="btn btn-sm btn-warning w-50 text-center">Edit</a>
                                    <form action="{{ route('perkebunan.destroy', [$item['kecamatan_id'], $item['periode_id']]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua data pada grup ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection
