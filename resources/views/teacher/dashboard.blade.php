@extends('layouts.app')

@section('content')
<x-plan-banner :plan="$planName ?? 'Basic'" :used="$used ?? 0" :limit="$limit ?? 3" />

<div class="grid grid-3" style="margin:16px 0">
  <x-stat-card label="Views (7d)" :value="$stats['views'] ?? 0" />
  <x-stat-card label="WA Clicks (7d)" :value="$stats['wa'] ?? 0" />
  <x-stat-card label="Active Listings" :value="$stats['active'] ?? 0" />
</div>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
  <h2 class="h2">My Listings</h2>
  @can('create', App\Models\Listing::class)
    <a class="btn primary" href="{{ route('listings.create') }}">+ New Listing</a>
  @else
    <button class="btn" disabled>+ New Listing</button>
  @endcan
</div>

<div class="grid" style="gap:12px">
  @forelse($listings ?? [] as $listing)
    <x-listing-card-teacher :listing="$listing" />
  @empty
    <x-empty-state message="Belum ada listing." />
  @endforelse
</div>
@endsection
