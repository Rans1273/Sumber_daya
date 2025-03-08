@extends('layout')

@section('title', 'Contact - My Website')

@section('content')
<div class="contact-wrapper">
    <h2 class="contact-title">Hubungi Kami</h2>
    <form class="contact-form">
        <label for="name">Nama:</label>
        <input type="text" id="name" placeholder="Masukkan nama Anda">

        <label for="email">Email:</label>
        <input type="email" id="email" placeholder="Masukkan email Anda">

        <label for="message">Pesan:</label>
        <textarea id="message" placeholder="Tulis pesan Anda"></textarea>

        <button type="submit">Kirim</button>
    </form>
</div>
@endsection
