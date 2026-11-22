<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Garuda-Hub')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f6f8; color: #222; }
        nav { background: #1f3a5f; padding: 14px 24px; }
        nav a { color: #fff; text-decoration: none; font-weight: bold; }
        main { max-width: 900px; margin: 24px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 8px; padding: 16px 20px; margin-bottom: 14px; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
        .btn { display: inline-block; padding: 7px 14px; border: 0; border-radius: 5px; background: #1f3a5f; color: #fff; text-decoration: none; cursor: pointer; font-size: 14px; }
        .btn-danger { background: #c0392b; }
        .btn-gray { background: #7f8c8d; }
        .badge { padding: 2px 10px; border-radius: 12px; font-size: 12px; background: #d5e8d4; }
        .badge.ditutup { background: #f8cecc; }
        .alert { background: #d5e8d4; padding: 10px 14px; border-radius: 6px; margin-bottom: 14px; }
        .error { color: #c0392b; font-size: 13px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; border: 1px solid #bbb; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
        .muted { color: #666; font-size: 14px; }
        .row { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
    </style>
</head>
<body>
    <nav>
        <div class="row">
            <a href="{{ route('projects.index') }}">Garuda-Hub</a>
            <span>
                @auth
                    <span style="color:#fff">{{ auth()->user()->nama }} ({{ auth()->user()->role }})</span>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-gray">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Masuk</a> &nbsp;
                    <a href="{{ route('register') }}">Daftar</a>
                @endauth
            </span>
        </div>
    </nav>
    <main>
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert" style="background:#f8cecc">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>