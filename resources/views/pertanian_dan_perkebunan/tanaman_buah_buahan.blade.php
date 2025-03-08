@extends('layouts.layout')

@section('title', 'tanaman Buah Buahan')

@section('content')
<div class="container">
    Ini tanaman buah buahan
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="8">Kecamatan</th>
                    <th colspan="8">Produksi</th>
                </tr>
                <tr>
                    <th>Mangga</th>
                    <th>Durian</th>
                    <th>Jeruk Siam</th>
                    <th>Pisang</th>
                    <th>Pepaya</th>
                    <th>Salak</th>
                    <th>Apel</th>
                    <th>Alpukat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>contoh</td>
                    <td>contoh</td>
                    <td>contoh</td>
                    <td>contoh</td>
                    <td>contoh</td>
                    <td>contoh</td>
                    <td>contoh</td>
                    <td>contoh</td>
                    <td>contoh</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection