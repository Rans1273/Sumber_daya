@extends('layouts.dashboard_layout')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Editor Data Master</h1>
    <p class="mb-4">Pilih tabel, klik "Tampilkan Data", lalu kelola data secara langsung di dalam tabel.</p>

    {{-- Menampilkan notifikasi sukses atau error --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- Form untuk memilih tabel, method GET akan me-reload halaman dengan parameter --}}
            <form action="{{ route('master-data.index') }}" method="GET" class="row align-items-end">
                <div class="col-md-4">
                    <label for="tableSelector" class="form-label mb-0">Pilih Tabel Master:</label>
                    <select id="tableSelector" name="table" class="form-select">
                        <option value="">-- Pilih Tabel --</option>
                        @foreach ($masterTables as $table)
                            {{-- Opsi dropdown diambil dari controller ($masterTables) --}}
                            <option value="{{ $table }}" {{ $selectedTable == $table ? 'selected' : '' }}>
                                {{ Str::title(str_replace('_', ' ', $table)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Tampilkan Data</button>
                </div>
            </form>
        </div>

        {{-- Bagian ini hanya akan tampil jika sebuah tabel telah dipilih --}}
        @if ($selectedTable)
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            @foreach ($columns as $column)
                                <th>{{ Str::title(str_replace('_', ' ', $column)) }}</th>
                            @endforeach
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Menampilkan setiap baris data dari database ($records) --}}
                        @forelse ($records as $record)
                            {{-- Logika untuk inline editing: periksa apakah ID baris ini cocok dengan ID yang akan diedit dari URL --}}
                            @if (request('edit_id') == $record->id)
                                <form action="{{ route('master-data.update', ['table' => $selectedTable, 'id' => $record->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <tr>
                                        <td>{{ $record->id }}</td>
                                        {{-- Render input field untuk setiap kolom --}}
                                        @foreach ($columns as $column)
                                            <td><input type="text" name="{{ $column }}" value="{{ old($column, $record->{$column}) }}" class="form-control form-control-sm"></td>
                                        @endforeach
                                        <td>
                                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                                            <a href="{{ route('master-data.index', ['table' => $selectedTable]) }}" class="btn btn-secondary btn-sm">Batal</a>
                                        </td>
                                    </tr>
                                </form>
                            @else
                                {{-- Tampilan baris data normal --}}
                                <tr>
                                    <td>{{ $record->id }}</td>
                                    @foreach ($columns as $column)
                                        <td>{{ $record->{$column} }}</td>
                                    @endforeach
                                    <td>
                                        {{-- Tombol Edit: link ke halaman ini lagi dengan parameter 'edit_id' --}}
                                        <a href="{{ route('master-data.index', ['table' => $selectedTable, 'edit_id' => $record->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                        {{-- Tombol Hapus: form kecil untuk mengirim request DELETE --}}
                                        <form action="{{ route('master-data.destroy', ['table' => $selectedTable, 'id' => $record->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) + 2 }}" class="text-center">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse

                        {{-- Form untuk menambah baris data baru --}}
                        <form action="{{ route('master-data.store', ['table' => $selectedTable]) }}" method="POST">
                            @csrf
                            <tr class="table-light">
                                <td>Baru</td>
                                @foreach ($columns as $column)
                                    <td><input type="text" name="{{ $column }}" class="form-control form-control-sm" placeholder="{{ $column }}"></td>
                                @endforeach
                                <td>
                                    <button type="submit" class="btn btn-primary btn-sm">Simpan Baru</button>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
