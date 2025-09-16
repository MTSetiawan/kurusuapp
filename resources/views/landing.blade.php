@extends('layouts.public')

@section('title', 'Kursus Komputer – Rekomendasi')
@section('meta_description', 'Kumpulan rekomendasi kursus komputer terbaru.')

@section('content')
    <section class="text-center mb-10">
        <h1 class="text-4xl font-bold mb-3">Temukan Kursus Komputer Terbaik</h1>
        <p class="text-gray-600 max-w-2xl mx-auto">Belajar Microsoft Office, Coding, Desain, dan lainnya.</p>
    </section>

    <h2 class="text-2xl font-semibold mb-4">Rekomendasi Kursus</h2>
    @if ($listings->isEmpty())
        <div class="bg-white p-6 rounded shadow text-center text-gray-500">Belum ada kursus.</div>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($listings as $l)
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
    @endif

    <div class="text-center mt-8">
        <a class="inline-block bg-blue-600 text-white px-5 py-2 rounded" href="{{ route('catalog') }}">Lihat Semua
            Kursus</a>
    </div>
@endsection
