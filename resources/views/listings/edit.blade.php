@extends('layouts.public')
@section('title', 'Edit Listing')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Listing</h1>

    {{-- Ganti kota untuk reload daftar kecamatan --}}
    <form method="GET" action="{{ route('listings.edit', $listing) }}" class="bg-white p-4 rounded shadow mb-4 max-w-2xl">
        <label class="block text-sm font-medium mb-1">Pilih Kota</label>
        <div class="flex gap-2">
            <select name="city" class="w-full border rounded p-2">
                @foreach ($cities as $c)
                    <option value="{{ $c->id }}" @selected($selectedCity == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 rounded bg-gray-800 text-white">Muat Kecamatan</button>
        </div>
        <p class="text-xs text-gray-500 mt-2">Mengubah kota akan menampilkan kecamatan sesuai kota tersebut.</p>
    </form>

    <form action="{{ route('listings.update', $listing) }}" method="POST"
        class="bg-white p-4 rounded shadow grid gap-4 max-w-2xl">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Judul</label>
            <input name="title" class="w-full border rounded p-2" value="{{ old('title', $listing->title) }}">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <input name="category" class="w-full border rounded p-2" value="{{ old('category', $listing->category) }}">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                <input type="number" min="0" name="price" class="w-full border rounded p-2"
                    value="{{ old('price', $listing->price) }}">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Kecamatan</label>
            <select name="region_id" class="w-full border rounded p-2">
                @foreach ($districts as $d)
                    <option value="{{ $d->id }}" @selected(old('region_id', $listing->region_id) == $d->id)>{{ $d->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="description" class="w-full border rounded p-2 h-28">{{ old('description', $listing->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="active" @selected(old('status', $listing->status) === 'active')>Active</option>
                <option value="inactive" @selected(old('status', $listing->status) === 'inactive')>Inactive</option>
            </select>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('listings.index') }}" class="px-4 py-2 rounded border">Batal</a>
            <button class="px-4 py-2 rounded bg-indigo-600 text-white">Simpan</button>
        </div>
    </form>
@endsection
