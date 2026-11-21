@extends('layouts.app')

@section('title', 'Edit Proyek')

@section('content')
    <h1>Edit Proyek</h1>
    <div class="card">
        <form method="POST" action="{{ route('projects.update', $project) }}">
            @csrf
            @method('PUT')
            @include('projects._form')
        </form>
    </div>
@endsection