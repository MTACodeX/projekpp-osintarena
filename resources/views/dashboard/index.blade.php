@extends('layouts.app')

@section('content')
<h1>Dashboard</h1>

<div class="grid grid-3">
    <div class="card">
        <h3>Team Name</h3>
        <p>{{ $team->team_name }}</p>
    </div>

    <div class="card">
        <h3>Total Score</h3>
        <p>{{ $team->score }} pts</p>
    </div>

    <div class="card">
        <h3>Progress</h3>
        <p>{{ $totalSolves }} / {{ $totalChallenges }} solved</p>
    </div>
</div>

<br>

<a href="/challenges" class="btn btn-secondary">Open Challenges</a>
<a href="/scoreboard" class="btn btn-secondary">View Scoreboard</a>
@endsection