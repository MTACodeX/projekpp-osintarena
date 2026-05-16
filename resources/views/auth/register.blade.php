@extends('layouts.app')

@section('content')
<h1>Register</h1>

<div class="card">
    <form method="POST" action="/register">
        @csrf

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required>
            @error('username') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <div class="form-group">
            <label>Nama Team</label>
            <input type="text" name="team_name" id="team_name" value="{{ old('team_name') }}">
            @error('team_name') <div class="error">{{ $message }}</div> @enderror
            <br><br>
            <button type="button" class="btn btn-secondary" onclick="generateTeamName()">Generate Random Team Name</button>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<script>
function generateTeamName() {
    const first = [
    'Buzzer', 'Admin', 'Server', 'Kuota', 'WiFi', 'Sinyal', 'Keyboard', 'Mouse', 'Laptop', 'Charger',
    'Kabel', 'Monitor', 'Speaker', 'Headset', 'Webcam', 'Folder', 'File', 'Screenshot', 'Download', 'Upload',
    'Browser', 'Tab', 'Cache', 'Cookie', 'Link', 'Password', 'Login', 'Logout', 'Akun', 'Username',

    'Meme', 'Meme', 'Meme', 'Meme', 'Meme', 'Meme', 'Meme', 'Meme', 'Meme', 'Meme',
    'Aura', 'Rizz', 'Skibidi', 'Sigma', 'NPC', 'Brainrot', 'FYP', 'Konten', 'Reels', 'Scroll',
    'Like', 'Komen', 'Status', 'Typing', 'Chat', 'Grup', 'Admin', 'Moderator', 'Notif', 'DM',

    'Gorengan', 'Seblak', 'Cilok', 'Cimol', 'Batagor', 'Somay', 'Indomie', 'Mie', 'Bakso', 'Sate',
    'Pecel', 'Cendol', 'Klepon', 'Risol', 'Odading', 'Kerupuk', 'Donat', 'Cireng', 'EsTeh', 'Kopi',
    'Warkop', 'Warteg', 'Kantin', 'Nasi', 'Telur', 'Tahu', 'Tempe', 'Sambal', 'Kecap', 'Sendok',

    'Kaum', 'Bocil', 'Anak', 'Tim', 'Pasukan', 'Skuad', 'Kelompok', 'Rombongan', 'Barisan', 'Komplotan',
    'Unit', 'Divisi', 'Brigade', 'Pasukan', 'Skuad', 'Kaum', 'Anak', 'Tim', 'Grup', 'Liga',

    'Sendal', 'Sepatu', 'Kaos', 'Hoodie', 'Celana', 'Topi', 'Payung', 'Tas', 'Dompet', 'Kunci',
    'Bantal', 'Selimut', 'Kasur', 'Kipas', 'Lampu', 'Meja', 'Kursi', 'Pintu', 'Jendela', 'Ember',

    'Botol', 'Galon', 'Sabun', 'Handuk', 'Sisir', 'Parfum', 'Cermin', 'Foto', 'Alarm', 'Kalender',
    'Jam', 'Remote', 'TV', 'Antena', 'Motor', 'Helm', 'Ojol', 'Jalan', 'Tikungan', 'Parkiran'
    ];

    const second = [
    'Kosan', 'Ngambek', 'Gabut', 'Sekarat', 'Tetangga', 'Ilang', 'Meledak', 'Ngambek', 'Demam', 'Palsu',
    'Ruwet', 'Galau', 'Kesurupan', 'Putus', 'Buram', 'Rahasia', 'Nyasar', 'Burik', 'Gagal', 'Panik',
    'Ngelag', 'Menumpuk', 'Berdosa', 'Gosong', 'Mencurigakan', 'Bocor', 'Gagal', 'Paksa', 'Halu', 'Aneh',

    'Gosong', 'Korporat', 'Kecamatan', 'Berdaulat', 'Kesasar', 'Darurat', 'Premium', 'Basi', 'Rebus', 'Sigma',
    'Minus', 'Lokal', 'Warteg', 'Kosan', 'Santuy', 'Halal', 'Gelap', 'Receh', 'Keramat', 'Abadi',
    'Palsu', 'Kosong', 'Pending', 'Lama', 'Gantung', 'Sepi', 'Tidur', 'Lelah', 'Brutal', 'Nyasar',

    'Digital', 'Enterprise', 'Premium', 'Berisik', 'Kosmik', 'Elite', 'Strategis', 'Filosofis', 'Astral', 'Kapital',
    'Siber', 'Brutal', 'Viral', 'Barbar', 'Misterius', 'Politik', 'Nasional', 'Kosong', 'Keramat', 'Barbar',
    'Digital', 'Sigma', 'Rahasia', 'Ambisi', 'Revolusi', 'Meledak', 'Terbang', 'Kosmik', 'Rahasia', 'Publik',

    'Rebahan', 'Elite', 'Pending', 'Ngantuk', 'Gabut', 'Receh', 'Halu', 'Random', 'Gagal', 'Santuy',
    'Tidur', 'Ngopi', 'Meme', 'Typo', 'Screenshot', 'Silent', 'Orbit', 'Astral', 'Misterius', 'Receh',

    'Keramat', 'Basah', 'Hilang', 'Oversize', 'Training', 'Terbalik', 'Nyasar', 'Kosong', 'Tipis', 'Hilang',
    'Strategis', 'Nasional', 'Magnet', 'Rusak', 'Disko', 'Goyang', 'Plastik', 'Bunyi', 'Curiga', 'Bocor',

    'Kosong', 'Sekarat', 'Licin', 'Gaib', 'Publik', 'Pinjam', 'Buram', 'Burik', 'Bohong', 'Lama',
    'Ngaco', 'Hilang', 'Bisu', 'Patah', 'Mogok', 'Pinjam', 'Nyasar', 'Buntu', 'Curiga', 'Horor'
    ];

    const name = first[Math.floor(Math.random() * first.length)] + ' ' +
                 second[Math.floor(Math.random() * second.length)] +
                 Math.floor(Math.random() * 90 + 10);

    document.getElementById('team_name').value = name;
}
</script>
@endsection