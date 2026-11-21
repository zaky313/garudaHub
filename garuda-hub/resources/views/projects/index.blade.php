@extends('layouts.app')

@section('title', 'Daftar Proyek')

@section('content')
    <div class="row">
        <h1>Daftar Proyek</h1>
        <a class="btn" href="{{ route('projects.create') }}">+ Proyek Baru</a>
    </div>

    @forelse ($projects as $project)
        <div class="card">
            <div class="row">
                <h3 style="margin:0">
                    <a href="{{ route('projects.show', $project) }}">{{ $project->judul }}</a>
                </h3>
                <span class="badge {{ $project->status }}">{{ $project->status }}</span>
            </div>
            <p class="muted">
                Klien: {{ $project->client->nama }} |
                Kategori: {{ $project->kategori }} |
                Budget: Rp {{ number_format($project->budget_min, 0, ',', '.') }}
                - Rp {{ number_format($project->budget_max, 0, ',', '.') }} |
                Batas lelang: {{ $project->batas_lelang->format('d M Y') }} |
                {{ $project->bids_count }} penawaran
            </p>
        </div>
    @empty
        <div class="card">Belum ada proyek.</div>
    @endforelse
@endsection