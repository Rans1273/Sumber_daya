@extends('layouts.layout')

@section('title', 'Penggunaan Lahan')

@section('content')
<div class="container">
    Ini Penggunaan Lahan
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="7">Kecamatan</th>
                    <th colspan="7">Jenis Penggunaan Lahan(Ha)</th>
                </tr>
                <tr>
                    <th>Pemukiman</th>
                    <th>Sawah</th>
                    <th>Tegas/Kebun</th>
                    <th>Ladang/Huma</th>
                    <th>Area Perkebunan</th>
                    <th>Sementara Tidak Diusahakan</th>
                    <th>Lainnya/Huma</th>
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
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection