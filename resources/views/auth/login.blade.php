@extends('layouts.app')

@section('content')
<h1>Login</h1>

<div class="card">
    <form method="POST" action="/login">
        @csrf

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}" required>
            @error('username') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
@endsection