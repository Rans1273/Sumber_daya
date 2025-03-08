@extends('layouts.layout')

@section('title', 'Luas Panen(Hekar)')

@section('content')
<div class="container">
    Ini Luas Panen hekar
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="3">Jenis Tanaman</th>
                    <th colspan="3">Luas Panen(Ha)</th>
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