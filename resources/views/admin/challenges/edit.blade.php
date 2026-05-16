@extends('layouts.app')

@section('content')
<h1>Edit Challenge</h1>

<div class="card">
    <form method="POST" action="/admin/challenges/{{ $challenge->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="{{ $challenge->title }}" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required>{{ $challenge->description }}</textarea>
        </div>

        <div class="form-group">
            <label>Difficulty</label>
            <select name="difficulty">
                <option {{ $challenge->difficulty === 'Easy' ? 'selected' : '' }}>Easy</option>
                <option {{ $challenge->difficulty === 'Medium' ? 'selected' : '' }}>Medium</option>
                <option {{ $challenge->difficulty === 'Hard' ? 'selected' : '' }}>Hard</option>
            </select>
        </div>

        <div class="form-group">
            <label>Max Points</label>
            <input type="number" name="points" value="{{ $challenge->points }}" required>
            @error('points') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Min Points</label>
            <input type="number" name="min_points" value="{{ $challenge->min_points }}" required>
            @error('min_points') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Decay Per Solve</label>
            <input type="number" name="decay_per_solve" value="{{ $challenge->decay_per_solve }}" required>
            @error('decay_per_solve') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Flag</label>
            <input type="text" name="flag" value="{{ $challenge->flags->first()->flag_text ?? '' }}" placeholder="{jawaban}" required>
            @error('flag') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>External Link</label>
            <input type="url" name="external_link" value="{{ $challenge->external_link }}">
        </div>

        <div class="form-group">
            <label>Upload More Files</label>
            <input type="file" name="files[]" multiple>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_active" value="1" {{ $challenge->is_active ? 'checked' : '' }}>
                Active
            </label>
        </div>

        <button class="btn btn-primary">Update Challenge</button>
    </form>
</div>

<br>

<div class="card">
    <h3>Current Files</h3>

    @forelse($challenge->files as $file)
        <p>
            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                {{ $file->original_name }}
            </a>
        </p>
    @empty
        <p>Belum ada file.</p>
    @endforelse
</div>
@endsection