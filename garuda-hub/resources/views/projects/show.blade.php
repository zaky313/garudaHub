@extends('layouts.app')

@section('title', $project->judul)

@section('content')
    <div class="card">
        <div class="row">
            <h1 style="margin:0">{{ $project->judul }}</h1>
            <span class="badge {{ $project->status }}">{{ $project->status }}</span>
        </div>
        <p class="muted">
            Klien: {{ $project->client->nama }} |
            Kategori: {{ $project->kategori }} |
            Budget: Rp {{ number_format($project->budget_min, 0, ',', '.') }}
            - Rp {{ number_format($project->budget_max, 0, ',', '.') }} |
            Batas lelang: {{ $project->batas_lelang->format('d M Y') }}
        </p>
        <p>{{ $project->deskripsi }}</p>

        <a class="btn" href="{{ route('projects.edit', $project) }}">Edit</a>
        <form method="POST" action="{{ route('projects.destroy', $project) }}" style="display:inline"
              onsubmit="return confirm('Hapus proyek ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
        <a class="btn btn-gray" href="{{ route('projects.index') }}">Kembali</a>
    </div>

    <div class="card">
        <h3>Penawaran ({{ $project->bids->count() }})</h3>
        @if ($project->bids->isEmpty())
            <p class="muted">Belum ada penawaran.</p>
        @else
            <table>
                <tr><th>Developer</th><th>Harga</th><th>Durasi</th><th>Proposal</th></tr>
                @foreach ($project->bids as $bid)
                    <tr>
                        <td>{{ $bid->developer->nama }}</td>
                        <td>Rp {{ number_format($bid->harga, 0, ',', '.') }}</td>
                        <td>{{ $bid->durasi }} hari</td>
                        <td>{{ $bid->proposal }}</td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
@endsection