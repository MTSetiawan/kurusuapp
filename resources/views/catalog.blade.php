@extends('layouts.public')

@section('title', 'Semua Kursus Komputer')
@section('meta_description', 'Cari kursus berdasarkan lokasi dan kategori.')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Semua Kursus</h1>

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <select name="region" class="border p-2 rounded min-w-[180px]">
            <option value="">Semua Wilayah</option>
            @foreach ($regions as $r)
                <option value="{{ $r->id }}" @selected(($filters['region'] ?? '') == $r->id)>{{ $r->name }}</option>
            @endforeach
        </select>
        <input type="text" name="category" value="{{ $filters['category'] ?? '' }}" placeholder="Cari kategori…"
            class="border p-2 rounded min-w-[180px]">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
    </form>

    @if ($items->count() === 0)
        <p class="text-gray-500">Tidak ada kursus yang ditemukan.</p>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($items as $l)
                <a href="{{ route('listing.show', ['slug' => $l->slug, 'region' => $l->region->slug]) }}"
                    class="block bg-white border rounded-lg shadow hover:shadow-lg transition p-4">
                    <div class="font-semibold text-lg mb-1">{{ $l->title }}</div>
                    <div class="text-sm text-gray-600 mb-1">{{ $l->category }}</div>
                    <div class="text-sm text-gray-500 mb-2">{{ $l->region->name ?? '-' }}</div>
                    <div class="text-sm text-green-700 font-semibold">
                        {{ $l->price ? 'Rp' . number_format($l->price, 0, ',', '.') : 'Gratis' }}
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $items->links() }}
        </div>
    @endif
@endsection
