@extends('layouts.layout')

@section('title', 'Produksi Perikanan Tangkap')

@section('content')
<div class="container">
    Ini Produksi Perikanan Tangkap
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="2">Kecamatan</th>
                    <th colspan="2">Perikanan Tangkap</th>
                    <th colspan="4">Perikanan Budidaya</th>

                </tr>
                <tr>
                    <th>Peraiaran Laut</th>
                    <th>Perairan Umum</th>
                    <th>Tambak</th>
                    <th>Kolam</th>
                    <th>Jaring Apung</th>
                    <th>Sawah</th>
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
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection