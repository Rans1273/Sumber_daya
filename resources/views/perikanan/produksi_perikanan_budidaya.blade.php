@extends('layouts.layout')

@section('title', 'Produksi Perikanan Budisaya')

@section('content')
<div class="container">
    Ini Produksi Perikanan Budidaya
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="2">Jenis Ikan</th>
                    <th colspan="3">Produksi(Ton)</th>
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
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection