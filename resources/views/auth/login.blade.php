@extends('layouts.layout')

@section('title', 'Login - SDA Bulungan')

@section('content')
<body class="bg-dark text-white" style="font-family: Arial, sans-serif;">

    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center"
        style="background-image: url('{{ asset('img/image/pegunungan.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;">

        <div class="card bg-dark bg-opacity-75 p-4 rounded shadow text-white" style="max-width: 400px; width: 100%;">
            <div class="text-center mb-4">
                <img src="{{ asset('img/logo/logo.png') }}" alt="Logo" style="height: 60px;">
                <h3 class="fw-bold mt-2">SDA BULUNGAN</h3>
                <p class="text-white mb-0">Silakan masuk untuk melanjutkan</p>
            </div>

            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label text-white">Alamat Email</label>
                    <input type="email" class="form-control bg-dark text-white border-secondary" 
                        id="email" name="email" placeholder="email@example.com" required
                        style="::placeholder { color: rgba(255,255,255,0.7); }">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-white">Kata Sandi</label>
                    <input type="password" class="form-control bg-dark text-white border-secondary" 
                        id="password" name="password" placeholder="••••••••" required
                        style="::placeholder { color: rgba(255,255,255,0.7); }">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-light">Masuk</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="#" class="text-white">Lupa kata sandi?</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
@endsection
