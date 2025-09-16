@extends('layouts.public')
@section('title', 'Buat Listing')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Buat Listing</h1>

    {{-- Pilih kota dulu agar daftar kecamatan ter-filter --}}
    <form method="GET" action="{{ route('listings.create') }}" class="bg-white p-4 rounded shadow mb-4 max-w-2xl">
        <label class="block text-sm font-medium mb-1">Pilih Kota</label>
        <div class="flex gap-2">
            <select name="city" class="w-full border rounded p-2">
                <option value="">-- Pilih kota --</option>
                @foreach ($cities as $c)
                    <option value="{{ $c->id }}" @selected($selectedCity == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 rounded bg-gray-800 text-white">Muat Kecamatan</button>
        </div>
        <p class="text-xs text-gray-500 mt-2">Pilih kota lalu klik "Muat Kecamatan".</p>
    </form>

    <form action="{{ route('listings.store') }}" method="POST" class="bg-white p-4 rounded shadow grid gap-4 max-w-2xl">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Judul</label>
            <input name="title" class="w-full border rounded p-2" value="{{ old('title') }}">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <input name="category" class="w-full border rounded p-2" value="{{ old('category') }}"
                    placeholder="MS Office / Coding / Desain">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                <input type="number" min="0" name="price" class="w-full border rounded p-2"
                    value="{{ old('price') }}">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Kecamatan</label>
            <select name="region_id" class="w-full border rounded p-2" @disabled(!$selectedCity)>
                <option value="">-- Pilih kecamatan --</option>
                @foreach ($districts as $d)
                    <option value="{{ $d->id }}" @selected(old('region_id') == $d->id)>{{ $d->name }}</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Daftar kecamatan mengikuti kota yang dipilih.</p>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="description" class="w-full border rounded p-2 h-28">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end">
            <button class="px-4 py-2 rounded bg-blue-600 text-white">Simpan</button>
        </div>
    </form>
@endsection
