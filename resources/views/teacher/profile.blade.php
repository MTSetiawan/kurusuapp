@extends('layouts.app')

@section('content')
<h1 class="h1">Profil Guru</h1>

<form method="POST" action="{{ route('teacher.profile.update') }}" class="card pad" style="max-width:720px">
  @csrf @method('PUT')

  <label>Nama</label>
  <input class="input" name="name" value="{{ old('name', $user->name ?? '') }}">

  <label>Nomor WhatsApp</label>
  <input class="input" name="whatsapp_number" value="{{ old('whatsapp_number', $profile->whatsapp_number ?? '') }}" placeholder="62812xxxxxxx">

  <label>Lokasi</label>
  <input class="input" name="location" value="{{ old('location', $profile->location ?? '') }}">

  <label>Bio</label>
  <textarea class="input" rows="6" name="bio">{{ old('bio', $profile->bio ?? '') }}</textarea>

  <div style="margin-top:10px">
    <button class="btn primary">Simpan</button>
  </div>
</form>
@endsection
