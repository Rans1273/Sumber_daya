@extends('layouts.layout')

@section('title', 'produksi Hewan unggas')

@section('content')
<div class="container">
    Ini produksi hewan unggas
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="2">Kecamatan</th>
                    <th colspan="6">Populasi</th>
                    
                </tr>
                <tr>
                    <th>Ayam Kampung</th>
                    <th>Ayam Petelor</th>
                    <th>Ayam Pedaging</th>
                    <th>Itik</th>
                    <th>Burung Puyuh</th>
                    <th>Burung Dara</th>
                </tr>
                <tr></tr>
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
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection