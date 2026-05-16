@extends('layouts.app')

@section('content')
<h1>Manage Challenges</h1>

<a href="/admin/challenges/create" class="btn btn-primary">Create Challenge</a>

<br><br>

<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Difficulty</th>
            <th>Points</th>
            <th>Solves</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($challenges as $challenge)
            <tr>
                <td>{{ $challenge->title }}</td>
                <td>{{ $challenge->difficulty }}</td>
                <td>{{ $challenge->points }}</td>
                <td>{{ $challenge->solves_count }}</td>
                <td>{{ $challenge->is_active ? 'Active' : 'Hidden' }}</td>
                <td>
                    <a href="/admin/challenges/{{ $challenge->id }}/edit" class="btn btn-secondary">Edit</a>

                    <form method="POST" action="/admin/challenges/{{ $challenge->id }}" class="inline-form">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Hapus challenge?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Belum ada challenge.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection