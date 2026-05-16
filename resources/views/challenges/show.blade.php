@extends('layouts.app')

@section('content')
@php
    $solveCount = $challenge->solves_count ?? $challenge->solves()->count();

    $displayCurrentPoints = isset($currentPoints)
        ? $currentPoints
        : (
            method_exists($challenge, 'calculatePoints')
                ? $challenge->calculatePoints($solveCount)
                : $challenge->points
        );
@endphp

<h1>{{ $challenge->title }}</h1>

<div class="card">
    <p>
        <span class="badge">OSINT</span>

        <span class="badge badge-{{ strtolower($challenge->difficulty) }}">
            {{ $challenge->difficulty }}
        </span>

        <span class="badge">
            {{ $displayCurrentPoints }} pts now
        </span>

        <span class="badge">
            max {{ $challenge->points }} pts
        </span>
    </p>

    <h3>Deskripsi Challenge</h3>

    <p>{!! nl2br(e($challenge->description)) !!}</p>

    @if($challenge->external_link)
        <p>
            <strong>External Link:</strong>
            <a href="{{ $challenge->external_link }}" target="_blank">
                {{ $challenge->external_link }}
            </a>
        </p>
    @endif

    @if($challenge->files->count())
        <h3>Download Attachment</h3>

        <div class="evidence-list">
            @foreach($challenge->files as $file)
                <div class="evidence-box">
                    <div class="evidence-header">
                        <strong>{{ $file->original_name }}</strong>

                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-secondary">
                            Open / Download
                        </a>
                    </div>

                    @if(str_starts_with((string) $file->file_type, 'image/'))
                        <img
                            src="{{ asset('storage/' . $file->file_path) }}"
                            alt="{{ $file->original_name }}"
                            class="challenge-image-preview"
                        >
                    @else
                        <div class="file-preview-placeholder">
                            <p>File non-gambar tersedia untuk diunduh.</p>
                            <p>{{ $file->file_type ?? 'Unknown file type' }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

<br>

@if($solved)
    <div class="alert success">
        Challenge ini sudah solved.
    </div>
@else
    <div class="card">
        <h3>Kirim Flag</h3>

        <form method="POST" action="/challenges/{{ $challenge->id }}/submit">
            @csrf

            <div class="form-group">
                <label>Flag</label>
                <input type="text" name="flag" placeholder="{jawaban}" required>

                @error('flag')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-primary">
                Kirim Flag
            </button>
        </form>
    </div>
@endif
@endsection