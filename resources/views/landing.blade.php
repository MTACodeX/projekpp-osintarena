@extends('layouts.app')

@section('content')
<section class="hero">
    <div>
        <h1>
            OSINT Arena <br>
            <span>Capture The Flag</span>
        </h1>

        <p>
            Platform CTF lokal khusus OSINT untuk latihan investigasi digital,
            geolocation, metadata, username tracking, dan pencarian informasi.
            Bisa dijalankan di localhost dan diakses lewat jaringan lokal.
        </p>

        <div class="hero-actions">
            @guest
                <a href="/register" class="btn btn-primary">Daftar Sekarang →</a>
                <a href="/login" class="btn btn-secondary">Masuk</a>
            @else
                <a href="/dashboard" class="btn btn-primary">Buka Dashboard →</a>
            @endguest
        </div>
    </div>

    <div class="hero-visual">
        <div class="hero-orb"></div>
        <div class="hero-badge">OSINT ONLY</div>
        <div class="hero-badge right">LOCAL READY</div>
    </div>
</section>

<div class="section-title">
    <small>FITUR UTAMA</small>
    <h2>Belajar Investigasi Digital dengan Cara CTF</h2>
</div>

<div class="grid grid-3">
    <div class="card">
        <h3>OSINT Challenge</h3>
        <p>
            Soal fokus ke pencarian informasi, analisis gambar, metadata,
            lokasi, username, dan clue digital.
        </p>
    </div>

    <div class="card">
        <h3>Random Team Name</h3>
        <p>
            Setiap user punya satu tim. Nama tim bisa dibuat sendiri
            atau generate otomatis saat register.
        </p>
    </div>

    <div class="card">
        <h3>Scoreboard</h3>
        <p>
            Ranking peserta berdasarkan skor tertinggi dan waktu penyelesaian
            challenge.
        </p>
    </div>
</div>
@endsection