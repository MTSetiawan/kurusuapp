@extends('layouts.public')
@section('title', 'Listing Saya')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Listing Saya</h1>
        <a href="{{ route('listings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Buat Listing</a>
    </div>

    @if ($listing->isEmpty())
        <p class="text-gray-500">Belum ada listing.</p>
    @else
        <table class="min-w-full bg-white rounded shadow">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left p-3">Judul</th>
                    <th class="text-left p-3">Wilayah</th>
                    <th class="text-left p-3">Kategori</th>
                    <th class="text-left p-3">Harga</th>
                    <th class="text-left p-3">Status</th>
                    <th class="text-left p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listing as $l)
                    <tr class="border-t">
                        <td class="p-3">{{ $l->title }}</td>
                        <td class="p-3">{{ $l->region->name ?? '-' }}</td>
                        <td class="p-3">{{ $l->category }}</td>
                        <td class="p-3">{{ $l->price ? 'Rp' . number_format($l->price, 0, ',', '.') : '-' }}</td>
                        <td class="p-3">
                            <span
                                class="px-2 py-1 rounded text-xs {{ $l->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $l->status }}
                            </span>
                        </td>
                        <td class="p-3">
                            <a href="{{ route('listings.edit', $l) }}"
                                class="px-3 py-1 rounded bg-indigo-600 text-white">Edit</a>
                            <form action="{{ route('listings.destroy', $l) }}" method="POST" class="inline"
                                onsubmit="return confirm('Hapus listing?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1 rounded bg-red-600 text-white">Hapus</button>
                            </form>
                            <a target="_blank" class="px-3 py-1 rounded border"
                                href="{{ route('listing.show', ['slug' => $l->slug, 'region' => optional($l->region)->slug]) }}">Lihat</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $listing->links() }}</div>
    @endif
@endsection
