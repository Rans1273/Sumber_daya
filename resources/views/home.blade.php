@extends('layouts.layout')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="home">
        <div class="judul">
            <h1>Selamat Datang di Website Keren Broww</h1>
            <h2>Website ini berisi informasi menarik dan bermanfaat.</h2>
        </div>
        <div class="search">
            <input type="text" placeholder="Search...">
            <button>search</button>
        </div>
        <div class="featured">
            <div class="feature-box">Fitur 1</div>
            <div class="feature-box">Fitur 2</div>
            <div class="feature-box">Fitur 3</div>
        </div>
    </div>
</div>
@endsection
