@extends('layouts.app')

@section('content')
<h1 class="h1">{{ ($listing->exists ?? false) ? 'Edit Listing' : 'Buat Listing' }}</h1>

<form method="POST" action="{{ ($listing->exists ?? false) ? route('listings.update',$listing) : route('listings.store') }}" class="card pad" style="max-width:720px">
  @csrf
  @if($listing->exists ?? false) @method('PUT') @endif

  <label>Judul</label>
  <input class="input" name="title" value="{{ old('title', $listing->title ?? '') }}">

  <div class="grid grid-2">
    <div>
      <label>Mata Pelajaran (category)</label>
      <input class="input" name="category" value="{{ old('category',$listing->category ?? '') }}">
    </div>
    <div>
      <label>Kecamatan (region)</label>
      <select name="region_id" class="select">
        @foreach(($regions ?? []) as $r)
          <option value="{{ $r->id }}" @selected(old('region_id', $listing->region_id ?? null)==$r->id)>{{ $r->name }}</option>
        @endforeach
      </select>
    </div>
  </div>

  <div class="grid grid-2">
    <div>
      <label>Harga per Jam (IDR)</label>
      <input class="input" type="number" name="price" value="{{ old('price',$listing->price ?? '') }}">
    </div>
    <div>
      <label>Status</label>
      <select name="status" class="select">
        <option value="active" @selected(old('status',$listing->status ?? '')=='active')>Active</option>
        <option value="inactive" @selected(old('status',$listing->status ?? '')=='inactive')>Inactive</option>
      </select>
    </div>
  </div>

  <label>Deskripsi</label>
  <textarea class="input" rows="6" name="description">{{ old('description',$listing->description ?? '') }}</textarea>

  <div style="display:flex;gap:8px;margin-top:10px">
    <a href="{{ route('teacher.dashboard') }}" class="btn">Batal</a>
    <button class="btn primary">{{ ($listing->exists ?? false) ? 'Update' : 'Publish' }}</button>
  </div>
</form>
@endsection
