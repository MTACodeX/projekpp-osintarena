@extends('layouts.app')

@section('content')
<h1>Admin Dashboard</h1>

<div class="grid grid-3">
    <div class="card">
        <h3>Users</h3>
        <p>{{ $usersCount }}</p>
    </div>

    <div class="card">
        <h3>Teams</h3>
        <p>{{ $teamsCount }}</p>
    </div>

    <div class="card">
        <h3>Challenges</h3>
        <p>{{ $challengesCount }}</p>
    </div>

    <div class="card">
        <h3>Submissions</h3>
        <p>{{ $submissionsCount }}</p>
    </div>
</div>

<br>

<a href="/admin/challenges" class="btn btn-secondary">Manage Challenges</a>
<a href="/admin/users" class="btn btn-secondary">Manage Users</a>
<a href="/admin/submissions" class="btn btn-secondary">View Submissions</a>
@endsection