@extends('layouts.app')

@section('content')
    @php($isEdit = $listing->exists)

    <h1 class="h1">{{ $isEdit ? 'Edit Listing' : 'Buat Listing' }}</h1>

    <form method="POST" action="{{ $isEdit ? route('listings.update', $listing) : route('listings.store') }}" class="card pad"
        style="max-width:720px">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        {{-- Judul --}}
        <label>Judul</label>
        <input class="input" name="title" value="{{ old('title', $listing->title) }}">
        @error('title')
            <div class="text-red" style="margin:.25rem 0">{{ $message }}</div>
        @enderror

        <div class="grid grid-2">
            <div>
                <label>Mata Pelajaran (category)</label>
                <input class="input" name="category" value="{{ old('category', $listing->category) }}">
                @error('category')
                    <div class="text-red" style="margin:.25rem 0">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label>Kecamatan (region)</label>
                <select name="region_id" class="select">
                    @foreach ($regions as $r)
                        <option value="{{ $r->id }}" @selected((int) old('region_id', (int) $listing->region_id) === (int) $r->id)>
                            {{ $r->name }}
                        </option>
                    @endforeach
                </select>
                @error('region_id')
                    <div class="text-red" style="margin:.25rem 0">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="grid grid-2">
            <div>
                <label>Harga per Jam (IDR)</label>
                <input class="input" type="number" name="price" min="0"
                    value="{{ old('price', $listing->price) }}">
                @error('price')
                    <div class="text-red" style="margin:.25rem 0">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label>Status</label>
                <select name="status" class="select">
                    <option value="active" @selected(old('status', $listing->status ?? 'inactive') === 'active')>Active</option>
                    <option value="inactive" @selected(old('status', $listing->status ?? 'inactive') === 'inactive')>Inactive</option>
                </select>

                @error('status')
                    <div class="text-red" style="margin:.25rem 0">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <label>Deskripsi</label>
        <textarea class="input" rows="6" name="description">{{ old('description', $listing->description) }}</textarea>
        @error('description')
            <div class="text-red" style="margin:.25rem 0">{{ $message }}</div>
        @enderror

        <div style="display:flex;gap:8px;margin-top:10px">
            <a href="{{ route('teacher.dashboard') }}" class="btn">Batal</a>
            <button class="btn primary">{{ $isEdit ? 'Update' : 'Publish' }}</button>
        </div>
    </form>
@endsection
