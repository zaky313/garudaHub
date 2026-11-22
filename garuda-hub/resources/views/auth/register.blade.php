@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
    <h1>Daftar</h1>
    <div class="card">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label>Nama</label>
            <input type="text" name="nama" value="{{ old('nama') }}" maxlength="100" required>
            @error('nama') <div class="error">{{ $message }}</div> @enderror

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" maxlength="100" required autocomplete="email">
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label>Password (minimal 8 karakter)</label>
            <input type="password" name="password" minlength="8" maxlength="72" required autocomplete="new-password">
            @error('password') <div class="error">{{ $message }}</div> @enderror

            <label>Ulangi password</label>
            <input type="password" name="password_confirmation" minlength="8" maxlength="72" required autocomplete="new-password">

            <label>Peran</label>
            <select name="role">
                <option value="klien" @selected(old('role') === 'klien')>Klien</option>
                <option value="developer" @selected(old('role') === 'developer')>Developer</option>
            </select>
            @error('role') <div class="error">{{ $message }}</div> @enderror

            <p><button type="submit" class="btn">Daftar</button></p>
        </form>
    </div>
@endsection