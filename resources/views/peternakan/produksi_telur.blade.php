@extends('layouts.layout')

@section('title', 'produksi telur')

@section('content')
<div class="container">
    Ini produksi telur
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="2">Jenis</th>
                    <th colspan="3">Total Produksi(Kg)</th>
                    
                </tr>
                <tr>
                    <th>2019</th>
                    <th>2020</th>
                    <th>2021</th>
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