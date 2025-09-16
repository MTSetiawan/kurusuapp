@extends('layouts.public')
@php use Illuminate\Support\Str; @endphp

@section('title', $listing->title . ' – ' . $listing->region->name)
@section('meta_description', Str::limit(strip_tags($listing->description), 150))
@section('canonical', route('listing.show', ['slug' => $listing->slug, 'region' => $listing->region->slug]))

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

        @php
            $wa = optional($listing->user->teacherProfile)->whatsapp_number;
            $waLink = $wa
                ? 'https://wa.me/' .
                    preg_replace('/\D+/', '', $wa) .
                    '?text=' .
                    rawurlencode('Halo, saya tertarik kursus: ' . $listing->title . ' di ' . $listing->region->name)
                : null;
        @endphp
        @if ($waLink)
            <a href="{{ $waLink }}" target="_blank" rel="noopener"
                class="inline-block bg-green-600 text-white px-6 py-2 rounded shadow hover:bg-green-700">
                Chat WhatsApp
            </a>
        @endif
    </article>
@endsection
