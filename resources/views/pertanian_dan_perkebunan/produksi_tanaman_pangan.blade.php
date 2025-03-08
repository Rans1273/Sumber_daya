@extends('layouts.layout')

@section('title', 'tanaman pangan')

@section('content')
<div class="container">
    Ini tanaman pangan
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="7">Kecamatan</th>
                    <th colspan="7">Jenis Tanaman Pangan</th>
                </tr>
                <tr>
                    <th>Padi Sawah</th>
                    <th>Padi Ladang</th>
                    <th>Jagung</th>
                    <th>Ubi Kayu</th>
                    <th>Ubi Jalar</th>
                    <th>Kacang Tanah</th>
                    <th>Kacang Ledelai</th>
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