<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'OSINT Arena' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1.0.0">
</head>
<body>
    <nav class="navbar">
        <div class="nav-inner">
            <div class="nav-brand">
                <a href="/">
                    <span class="brand-main">OSINT</span>
                    <span class="brand-sub">ARENA</span>
                </a>
            </div>

            <button class="nav-toggle" id="navToggle" type="button">
                ☰
            </button>

            <div class="nav-links" id="navLinks">
                <!-- <a href="/" class="{{ request()->is('/') ? 'is-active' : '' }}">
                    Home
                </a> -->

                <!-- <a href="/rules" class="{{ request()->is('rules') ? 'is-active' : '' }}">
                    Rules
                </a> -->

                @auth
                    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'is-active' : '' }}">
                        Dashboard
                    </a>

                    <a href="/challenges" class="{{ request()->is('challenges*') ? 'is-active' : '' }}">
                        Challenges
                    </a>

                    <a href="/scoreboard" class="{{ request()->is('scoreboard') ? 'is-active' : '' }}">
                        Scoreboard
                    </a>

                    <a href="/profile" class="{{ request()->is('profile') ? 'is-active' : '' }}">
                        Profile
                    </a>

                    @if(auth()->user()->isAdmin())
                        <a href="/admin" class="admin-link {{ request()->is('admin*') ? 'is-active' : '' }}">
                            Admin
                        </a>
                    @endif

                    <form action="/logout" method="POST" class="inline-form">
                        @csrf
                        <button type="submit" class="nav-login-button">Logout</button>
                    </form>
                @else
                    <a href="/login" class="nav-login-button {{ request()->is('login') ? 'is-active' : '' }}">
                        Masuk
                    </a>

                    <a href="/register" class="nav-login-button {{ request()->is('register') ? 'is-active' : '' }}">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert danger">{{ session('error') }}</div>
        @endif

        @if(session('info'))
            <div class="alert info">{{ session('info') }}</div>
        @endif

        @php
        $popupType = session('popup_type');
        $popupTitle = session('popup_title');
        $popupMessage = session('popup_message');

        if (!$popupType && session('success')) {
            $popupType = 'success';
            $popupTitle = 'Berhasil';
            $popupMessage = session('success');
        }

        if (!$popupType && session('error')) {
            $popupType = 'danger';
            $popupTitle = 'Gagal';
            $popupMessage = session('error');
        }

        if (!$popupType && session('info')) {
            $popupType = 'info';
            $popupTitle = 'Info';
            $popupMessage = session('info');
        }
        @endphp

        @if($popupType)
            <div class="popup-overlay is-visible" id="resultPopup">
                <div class="popup-card popup-{{ $popupType }}">
                    <button class="popup-close" type="button" onclick="closeResultPopup()">
                        ×
                    </button>

                    <div class="popup-icon">
                        @if($popupType === 'success')
                            ✓
                        @elseif($popupType === 'danger')
                            ×
                        @else
                            !
                        @endif
                    </div>

                    <h2>{{ $popupTitle }}</h2>
                    <p>{{ $popupMessage }}</p>

                    <button class="btn btn-primary" type="button" onclick="closeResultPopup()">
                        Oke
                    </button>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-inner">
            <div>
                <h3>OSINT ARENA</h3>
                <p>Platform CTF lokal khusus OSINT untuk latihan investigasi digital, geolocation, metadata, dan pencarian informasi.</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© {{ date('Y') }} OSINT Arena. Built for local CTF training.</p>
        </div>
    </footer>

    <script>
        const navToggle = document.getElementById('navToggle');
        const navLinks = document.getElementById('navLinks');

        navToggle.addEventListener('click', function () {
            navLinks.classList.toggle('is-open');
        });
    </script>

    <script>
        function closeResultPopup() {
            const popup = document.getElementById('resultPopup');

            if (!popup) {
                return;
            }

            popup.classList.remove('is-visible');

            setTimeout(() => {
                popup.remove();
            }, 250);
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeResultPopup();
            }
        });
    </script>
</body>
</html>