@extends('layouts.app')

@section('content')
<h1>Profile</h1>

<div class="card">
    <p><strong>Username:</strong> {{ $user->username }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Team Name:</strong> {{ $team->team_name }}</p>
    <p><strong>Score:</strong> {{ $team->score }} pts</p>
</div>

<br>

<div class="card">
    <h3>Edit Nama Team</h3>

    <form method="POST" action="/profile/team-name">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Team Baru</label>
            <input type="text" name="team_name" value="{{ $team->team_name }}" required>
            @error('team_name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</div>

<br>

<h2>Solved Challenges</h2>

<table class="table">
    <thead>
        <tr>
            <th>Challenge</th>
            <th>Points</th>
            <th>Solved At</th>
        </tr>
    </thead>
    <tbody>
        @forelse($solves as $solve)
            <tr>
                <td>{{ $solve->challenge->title }}</td>
                <td>{{ $solve->points_awarded }}</td>
                <td>{{ \Carbon\Carbon::parse($solve->solved_at)->timezone('Asia/Jakarta')->format('d M Y H:i:s') }} WIB</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Belum ada challenge yang solved.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection