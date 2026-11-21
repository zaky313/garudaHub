<label>Klien</label>
<select name="client_id">
    @foreach ($clients as $client)
        <option value="{{ $client->id }}" @selected(old('client_id', $project->client_id) == $client->id)>
            {{ $client->nama }}
        </option>
    @endforeach
</select>
@error('client_id') <div class="error">{{ $message }}</div> @enderror

<label>Judul</label>
<input type="text" name="judul" value="{{ old('judul', $project->judul) }}">
@error('judul') <div class="error">{{ $message }}</div> @enderror

<label>Deskripsi</label>
<textarea name="deskripsi" rows="4">{{ old('deskripsi', $project->deskripsi) }}</textarea>
@error('deskripsi') <div class="error">{{ $message }}</div> @enderror

<label>Kategori</label>
<input type="text" name="kategori" value="{{ old('kategori', $project->kategori) }}">
@error('kategori') <div class="error">{{ $message }}</div> @enderror

<label>Budget minimum (Rp)</label>
<input type="number" name="budget_min" value="{{ old('budget_min', $project->budget_min ?? 0) }}">
@error('budget_min') <div class="error">{{ $message }}</div> @enderror

<label>Budget maksimum (Rp)</label>
<input type="number" name="budget_max" value="{{ old('budget_max', $project->budget_max ?? 0) }}">
@error('budget_max') <div class="error">{{ $message }}</div> @enderror

<label>Batas lelang</label>
<input type="date" name="batas_lelang" value="{{ old('batas_lelang', $project->batas_lelang?->format('Y-m-d')) }}">
@error('batas_lelang') <div class="error">{{ $message }}</div> @enderror

<label>Status</label>
<select name="status">
    @foreach (['terbuka', 'ditutup'] as $status)
        <option value="{{ $status }}" @selected(old('status', $project->status ?? 'terbuka') == $status)>
            {{ $status }}
        </option>
    @endforeach
</select>
@error('status') <div class="error">{{ $message }}</div> @enderror

<p>
    <button type="submit" class="btn">Simpan</button>
    <a class="btn btn-gray" href="{{ route('projects.index') }}">Batal</a>
</p>