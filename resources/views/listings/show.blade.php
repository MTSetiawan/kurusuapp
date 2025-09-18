@extends('layouts.public')

@section('title', $listing->title . ' – ' . $listing->region->name)
@section('meta_description', Str::limit(strip_tags($listing->description), 150))

@php
    use Illuminate\Support\Str;
    $teacher = $listing->user;
    $profile = $teacher->teacherProfile;
    $avatar = $profile?->profile_image_url ?? asset('img/avatar-placeholder.png');
@endphp

@section('content')
    <nav class="text-sm mb-6">
        <a href="{{ route('landing') }}" class="text-blue-600 hover:underline">Beranda</a>
        <span class="mx-2 text-gray-400">/</span>
        <a href="{{ route('catalog') }}" class="text-blue-600 hover:underline">Kursus</a>
        <span class="mx-2 text-gray-400">/</span>
        <span class="text-gray-600">Detail</span>
    </nav>

    <article class="bg-white rounded shadow p-6">
        <h1 class="text-3xl font-bold mb-2">{{ $listing->title }}</h1>
        <p class="text-gray-600 mb-2">Kategori: <b>{{ $listing->category }}</b></p>
        <p class="text-gray-500 mb-4">Wilayah: <b>{{ $listing->region->name ?? '-' }}</b></p>
        <div class="text-lg text-green-700 font-semibold mb-4">
            {{ $listing->price ? 'Rp' . number_format($listing->price, 0, ',', '.') : 'Gratis' }}
        </div>

        @if ($listing->description)
            <div class="prose max-w-none mb-6">{!! nl2br(e($listing->description)) !!}</div>
        @endif

        {{-- Informasi Guru --}}
        <aside class="bg-gray-50 border-t pt-6 mt-6">
            <h2 class="text-xl font-semibold mb-4">Tentang Guru</h2>
            <div class="flex items-center gap-4">
                <img src="{{ $avatar }}" alt="Foto {{ $teacher->name }}"
                    class="w-20 h-20 rounded-full object-cover border">
                <div>
                    <div class="font-bold text-lg">{{ $teacher->name }}</div>
                    @if ($profile?->category)
                        <div class="text-gray-600">{{ $profile->category }}</div>
                    @endif
                    @if ($profile?->bio)
                        <div class="text-gray-500 text-sm mt-1">{{ Str::limit($profile->bio, 120) }}</div>
                    @endif
                    @if ($profile?->whatsapp_number)
                        @php
                            $waLink =
                                'https://wa.me/' .
                                preg_replace('/\D+/', '', $profile->whatsapp_number) .
                                '?text=' .
                                rawurlencode(
                                    'Halo, saya tertarik kursus: ' . $listing->title . ' di ' . $listing->region->name,
                                );
                        @endphp
                        <a href="{{ $waLink }}" target="_blank"
                            class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Hubungi via WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </aside>
    </article>
@endsection
