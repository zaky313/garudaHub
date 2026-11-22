@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
    <h1>Masuk</h1>
    <div class="card">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label>Password</label>
            <input type="password" name="password" required autocomplete="current-password">
            @error('password') <div class="error">{{ $message }}</div> @enderror

            <p><button type="submit" class="btn">Masuk</button></p>
        </form>
    </div>
@endsection