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
                <tr><th>Developer</th><th>Harga</th><th>Durasi</th><th>Proposal</th><th></th></tr>
                @foreach ($project->bids as $bid)
                    <tr style="{{ $bid->is_winner ? 'background:#fff8e1' : '' }}">
                        <td>
                            {{ $bid->developer->nama }}
                            @if ($bid->is_winner)
                                <span class="badge">Pemenang</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($bid->harga, 0, ',', '.') }}</td>
                        <td>{{ $bid->durasi }} hari</td>
                        <td>{{ $bid->proposal }}</td>
                        <td>
                            @if ($project->status === 'terbuka')
                                <form method="POST" action="{{ route('bids.pick', [$project, $bid]) }}" style="display:inline"
                                      onsubmit="return confirm('Pilih penawaran ini sebagai pemenang?')">
                                    @csrf
                                    <button type="submit" class="btn">Pilih pemenang</button>
                                </form>
                                <form method="POST" action="{{ route('bids.destroy', $bid) }}" style="display:inline"
                                      onsubmit="return confirm('Hapus penawaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>

    @if ($project->isOpen())
        <div class="card">
            <h3>Ajukan Penawaran</h3>
            <form method="POST" action="{{ route('bids.store', $project) }}">
                @csrf

                <label>Developer</label>
                <select name="developer_id">
                    @foreach ($developers as $dev)
                        <option value="{{ $dev->id }}" @selected(old('developer_id') == $dev->id)>{{ $dev->nama }}</option>
                    @endforeach
                </select>
                @error('developer_id') <div class="error">{{ $message }}</div> @enderror

                <label>Harga (Rp)</label>
                <input type="number" name="harga" min="1" value="{{ old('harga') }}">
                @error('harga') <div class="error">{{ $message }}</div> @enderror

                <label>Durasi (hari)</label>
                <input type="number" name="durasi" min="1" value="{{ old('durasi') }}">
                @error('durasi') <div class="error">{{ $message }}</div> @enderror

                <label>Proposal</label>
                <textarea name="proposal" rows="3">{{ old('proposal') }}</textarea>
                @error('proposal') <div class="error">{{ $message }}</div> @enderror

                <p><button type="submit" class="btn">Kirim penawaran</button></p>
            </form>
        </div>
    @else
        <div class="card muted">Lelang sudah ditutup; penawaran tidak dapat diajukan.</div>
    @endif
@endsection