<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BidController extends Controller
{
    public function store(Request $request, Project $project)
    {
        if (! $project->isOpen()) {
            return back()->with('error', 'Lelang sudah ditutup; penawaran tidak dapat diajukan.');
        }

        $data = $request->validate([
            'developer_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'developer'),
                Rule::unique('bids', 'developer_id')->where('project_id', $project->id),
            ],
            'harga'    => 'required|integer|min:1',
            'durasi'   => 'required|integer|min:1|max:3650',
            'proposal' => 'required|string|max:5000',
        ], [
            'developer_id.unique' => 'Developer ini sudah mengajukan penawaran pada proyek ini.',
        ]);

        $project->bids()->create($data);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Penawaran berhasil dikirim.');
    }

    public function pick(Project $project, Bid $bid)
    {
        $error = DB::transaction(function () use ($project, $bid) {
            // Kunci baris proyek agar tidak ada dua pemenang
            $locked = Project::whereKey($project->id)->lockForUpdate()->first();

            if ($locked->status !== 'terbuka') {
                return 'Pemenang sudah dipilih atau lelang sudah ditutup.';
            }
            if ((int) $bid->project_id !== (int) $locked->id) {
                return 'Penawaran tidak valid untuk proyek ini.';
            }

            $bid->update(['is_winner' => true]);
            $locked->update(['status' => 'ditutup']);

            return null;
        });

        if ($error) {
            return back()->with('error', $error);
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'Pemenang berhasil dipilih.');
    }

    public function destroy(Bid $bid)
    {
        $project = $bid->project;

        if ($project->status !== 'terbuka') {
            return back()->with('error', 'Penawaran tidak dapat dihapus setelah lelang ditutup.');
        }

        $bid->delete();

        return redirect()->route('projects.show', $project)
            ->with('success', 'Penawaran berhasil dihapus.');
    }
}