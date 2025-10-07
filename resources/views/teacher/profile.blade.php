@extends('layouts.app')

@section('content')
<h1 class="h1">Profil Guru</h1>

@php
  // $profile may be null on first-time setup
  $isEditing = (bool) ($profile ?? null);
@endphp

<form
  method="POST"
  action="{{ $isEditing ? route('teacher.profile.update') : route('teacher.profile.store') }}"
  enctype="multipart/form-data"
  class="card pad"
  style="max-width:720px"
>
  @csrf
  @if($isEditing) @method('PUT') @endif

  <label>Nama</label>
  <input class="input" name="name" value="{{ old('name', $user->name ?? '') }}">

  <label>Nomor WhatsApp</label>
  <input class="input" name="whatsapp_number"
         value="{{ old('whatsapp_number', $profile->whatsapp_number ?? '') }}"
         placeholder="62812xxxxxxx">

  <label>Lokasi</label>
  <input class="input" name="location" value="{{ old('location', $profile->location ?? '') }}">

  <label>Bio</label>
  <textarea class="input" rows="6" name="bio">{{ old('bio', $profile->bio ?? '') }}</textarea>

  <label>Foto Profil (opsional)</label>
  <input class="input" type="file" name="profile_image" accept=".jpg,.jpeg,.png,.webp">

  <div style="margin-top:10px; display:flex; gap:8px">
    <a href="{{ route('teacher.dashboard') }}" class="btn">Batal</a>
    <button class="btn primary">{{ $isEditing ? 'Simpan Perubahan' : 'Simpan Profil' }}</button>
  </div>
</form>
@endsection
