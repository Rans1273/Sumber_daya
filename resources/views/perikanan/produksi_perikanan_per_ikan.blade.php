@extends('layouts.layout')

@section('title', 'Produksi Perikanan Per Ikan')

@section('content')
<div class="container">
    Ini Produksi Perikanan Per Ikan
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="2">Jenis Ikan</th>
                    <th colspan="3">Produksi(Ton)</th>
                    <th rowspan="2">Jumlah</th>
                </tr>
                <tr>
                    <th>2019</th>
                    <th>2020</th>
                    <th>2021</th>
                </tr>
            </thead>
            <tbody>
                <tr>
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