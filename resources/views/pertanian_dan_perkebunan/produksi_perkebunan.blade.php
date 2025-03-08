@extends('layouts.layout')

@section('title', 'Produksi perkebunan')

@section('content')
<div class="container">
    Ini produksi perkebunan
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="5">Kecamatan</th>
                    <th colspan="5">Produksi</th>
                </tr>
                <tr>
                    <th>Kelapa</th>
                    <th>Kopi</th>
                    <th>Kakao</th>
                    <th>Tebu</th>
                    <th>Tembakau</th>
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
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection