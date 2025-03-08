@extends('layouts.layout')

@section('title', 'luas panen perkebunan ton')

@section('content')
<div class="container">
    Ini luas panen perkebunan ton
    <div class="table">
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th rowspan="3">Jenis Tanaman</th>
                    <th colspan="3">Produksi</th>
                </tr>
                <tr>
                    <th>2020</th>
                    <th>2021</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>contoh</td>
                    <td>contoh</td>
                    <td>contoh</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection