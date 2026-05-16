@extends('layouts.app')

@section('content')
<h1>Manage Users</h1>

<table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Team</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->team->team_name ?? '-' }}</td>
                <td>{{ $user->team->score ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection