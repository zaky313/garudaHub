<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('client')->withCount('bids')->latest()->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = User::where('role', 'klien')->get();

        return view('projects.create', compact('clients'));
    }

    public function store(Request $request)
    {
        Project::create($this->validated($request));

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil dibuat.');
    }

    public function show(Project $project)
    {
        $project->load(['client', 'bids.developer']);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $clients = User::where('role', 'klien')->get();

        return view('projects.edit', compact('project', 'clients'));
    }

    public function update(Request $request, Project $project)
    {
        $project->update($this->validated($request));

        return redirect()->route('projects.show', $project)
            ->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'client_id'    => 'required|exists:users,id',
            'judul'        => 'required|string|max:200',
            'deskripsi'    => 'required|string',
            'kategori'     => 'required|string|max:50',
            'budget_min'   => 'required|integer|min:0',
            'budget_max'   => 'required|integer|gte:budget_min',
            'batas_lelang' => 'required|date',
            'status'       => 'required|in:terbuka,ditutup',
        ]);
    }
}