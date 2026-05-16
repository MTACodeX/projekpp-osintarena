@extends('layouts.app')

@section('content')
<h1>OSINT Challenges</h1>

<div class="grid grid-3">
    @forelse($challenges as $challenge)
        <div class="card">
            <h3>{{ $challenge->title }}</h3>

            <p>
                <span class="badge badge-{{ strtolower($challenge->difficulty) }}">
                    {{ $challenge->difficulty }}
                </span>
                <span class="badge">
                    {{ $challenge->calculatePoints($challenge->solves_count) }} pts now
                </span>
            </p>

            <p>Status:
                @if(in_array($challenge->id, $solvedIds))
                    <strong style="color: var(--primary)">Solved</strong>
                @else
                    <strong>Unsolved</strong>
                @endif
            </p>

            <a href="/challenges/{{ $challenge->slug }}" class="btn btn-secondary">Open</a>
        </div>
    @empty
        <p>Belum ada challenge aktif.</p>
    @endforelse
</div>
@endsection