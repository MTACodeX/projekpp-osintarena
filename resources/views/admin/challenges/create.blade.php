@extends('layouts.app')

@section('content')
<h1>Create OSINT Challenge</h1>

<div class="card">
    <form method="POST" action="/admin/challenges" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required></textarea>
        </div>

        <div class="form-group">
            <label>Difficulty</label>
            <select name="difficulty">
                <option>Easy</option>
                <option>Medium</option>
                <option>Hard</option>
            </select>
        </div>

        <div class="form-group">
            <label>Max Points</label>
            <input type="number" name="points" value="500" required>
            @error('points') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Min Points</label>
            <input type="number" name="min_points" value="100" required>
            @error('min_points') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Decay Per Solve</label>
            <input type="number" name="decay_per_solve" value="20" required>
            @error('decay_per_solve') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Flag</label>
            <input type="text" name="flag" placeholder="{jawaban}" required>
            @error('flag') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>External Link</label>
            <input type="url" name="external_link">
        </div>

        <div class="form-group">
            <label>Upload Files</label>
            <input type="file" name="files[]" multiple>
        </div>

        <div class="form-group">
            <label>Active
                <input type="checkbox" name="is_active" value="1" checked>
            </label>
        </div>

        <button class="btn btn-primary">Save Challenge</button>
    </form>
</div>
@endsection