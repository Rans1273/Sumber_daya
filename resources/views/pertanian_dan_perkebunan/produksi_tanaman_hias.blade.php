@extends('layouts.layout')

@section('title', 'Produksi Tanaman hias')

@section('content')
<div class="container">
    Ini produksi tanaman hias
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="3">Jenis Tanaman</th>
                    <th colspan="3">Produksi</th>
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