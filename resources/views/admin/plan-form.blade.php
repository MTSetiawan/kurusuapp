@extends('layouts.admin')

@php($isEdit = $plan->exists)

@section('title', $isEdit ? 'Edit Plan' : 'Tambah Plan')

@section('content')
    <h1 class="text-2xl font-bold mb-4">{{ $isEdit ? 'Edit Plan' : 'Tambah Plan' }}</h1>

    <form method="POST" action="{{ $isEdit ? route('admin.plans.update', $plan) : route('admin.plans.store') }}"
        class="bg-white rounded shadow p-4 max-w-xl">
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <label class="block mb-1 font-medium">Nama</label>
        <input class="input border rounded w-full px-3 py-2 mb-2" name="name" value="{{ old('name', $plan->name) }}">
        @error('name')
            <div class="text-red-600 text-sm mb-2">{{ $message }}</div>
        @enderror

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Harga (Rp)</label>
                <input class="input border rounded w-full px-3 py-2" type="number" name="price" min="0"
                    value="{{ old('price', $plan->price) }}">
                @error('price')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block mb-1 font-medium">Durasi (hari)</label>
                <input class="input border rounded w-full px-3 py-2" type="number" name="duration_days" min="1"
                    value="{{ old('duration_days', $plan->duration_days) }}">
                @error('duration_days')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <label class="block mt-4 mb-1 font-medium">Kuota Region/Listing</label>
        <input class="input border rounded w-full px-3 py-2" type="number" name="quota_region" min="0"
            value="{{ old('quota_region', $plan->quota_region) }}">
        @error('quota_region')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror

        <div class="flex gap-2 mt-6">
            <a class="px-4 py-2 rounded border" href="{{ route('admin.plans.index') }}">Batal</a>
            <button class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">
                {{ $isEdit ? 'Update' : 'Simpan' }}
            </button>
        </div>
    </form>
@endsection
