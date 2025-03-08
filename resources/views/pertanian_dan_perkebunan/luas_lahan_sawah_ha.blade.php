@extends('layouts.layout')

@section('title', 'luas lahan sawah ha')

@section('content')
<div class="container">
    Ini luas lahan Sawah ha
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="1">Kecamatan</th>
                    <th rowspan="1">Irigasi</th>
                    <th rowspan="1">Non-irigasi</th>
                    <th colspan="1">Jumlah</th>
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