@extends('layouts.app')

@section('title', 'Proyek Baru')

@section('content')
    <h1>Proyek Baru</h1>
    <div class="card">
        <form method="POST" action="{{ route('projects.store') }}">
            @csrf
            @include('projects._form', ['project' => new \App\Models\Project])
        </form>
    </div>
@endsection