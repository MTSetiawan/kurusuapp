@extends('layouts.public')
@section('title', 'Profil Guru')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Profil Guru</h1>

    <div class="bg-white p-4 rounded shadow max-w-2xl">
        <form action="{{ $profile ? route('teacher.profile.update') : route('teacher.profile.store') }}" method="POST"
            enctype="multipart/form-data" class="grid gap-4">
            @csrf
            @if ($profile)
                @method('PUT')
            @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">WhatsApp</label>
                    <input type="text" name="whatsapp_number" class="w-full border rounded p-2"
                        value="{{ old('whatsapp_number', $profile->whatsapp_number ?? '') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Kategori Utama</label>
                    <input type="text" name="category" class="w-full border rounded p-2"
                        value="{{ old('category', $profile->category ?? '') }}" placeholder="MS Office / Coding / Desain">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Bio</label>
                <textarea name="bio" class="w-full border rounded p-2 h-28">{{ old('bio', $profile->bio ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Foto Profil</label>
                @if ($profile && $profile->profile_image_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $profile->profile_image_path) }}" alt="Foto profil"
                            class="h-24 w-24 object-cover rounded-full border">
                    </div>
                @endif
                <input type="file" name="profile_image" accept="image/*" class="block">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG/WebP, maks 2MB.</p>
            </div>

            <div class="flex justify-end">
                <button class="px-4 py-2 rounded bg-blue-600 text-white">
                    {{ $profile ? 'Simpan Perubahan' : 'Buat Profil' }}
                </button>
            </div>
        </form>
    </div>
@endsection
