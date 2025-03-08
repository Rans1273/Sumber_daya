@extends('layouts.layout')

@section('title', 'Luas Lahan Kehutanan')

@section('content')
<div class="container">
    Ini luas lahan kehutanan
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="2">Kecamatan</th>
                    <th colspan="2">Luas Lahan</th>
                    <th rowspan="2">Jumlah</th>
                    
                </tr>
                <tr>
                    <th>Hutan Negara</th>
                    <th>Hutan Rakyat</th>
                </tr>
                <tr></tr>
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