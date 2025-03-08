@extends('layouts.layout')

@section('title', 'Tanaman Sayur')

@section('content')
<div class="container">
    Ini tanaman sayur
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="8">Kecamatan</th>
                    <th colspan="8">Tanaman Sayur</th>
                </tr>
                <tr>
                    <th>Bawang Merah</th>
                    <th>Cabai Besar</th>
                    <th>Cabai Rawit</th>
                    <th>Kentang</th>
                    <th>Kubis Tomat</th>
                    <th>Bawang Putih</th>
                    <th>Petai</th>
                    <th>Terung</th>
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