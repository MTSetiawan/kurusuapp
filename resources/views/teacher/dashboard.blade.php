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
</div>

<div class="grid" style="gap:12px">
  @forelse($listings ?? [] as $listing)
    <x-listing-card-teacher :listing="$listing" />
  @empty
    <x-empty-state message="Belum ada listing." />
  @endforelse
</div>

{{-- ===== Upgrade Modal ===== --}}
<div id="upgrade-modal" class="modal-backdrop" hidden aria-hidden="true">
  <div class="modal-scrim" data-close="upgrade-modal"></div>

  <div class="modal-card card pad" role="dialog" aria-modal="true" aria-labelledby="upgrade-title">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
      <h2 id="upgrade-title" class="h2" style="margin:0">Paket Langganan</h2>
      <button class="btn" type="button" data-close="upgrade-modal">Tutup</button>
    </div>

    @php
      // UI-only demo data; backend can replace with real Plan models later
      $tiers = [
        ['name' => 'Bronze', 'quota' => 3,  'price' => 0,      'desc' => 'Cocok mulai dulu'],
        ['name' => 'Silver', 'quota' => 6,  'price' => 99000,  'desc' => 'Lebih banyak kecamatan'],
        ['name' => 'Gold',   'quota' => 12, 'price' => 149000, 'desc' => 'Skala kota besar'],
      ];
    @endphp

    <div class="grid grid-3" style="margin-top:12px">
      @foreach($tiers as $t)
        <article class="card pad" style="display:flex;flex-direction:column;gap:8px">
          <div class="title" style="margin:0">{{ $t['name'] }}</div>
          <div class="muted">{{ $t['desc'] }}</div>
          <div class="h1" style="margin:2px 0">{{ $t['quota'] }}</div>
          <div class="muted">
            @if($t['price'] === 0)
              Gratis (30 hari)
            @else
              Rp{{ number_format($t['price'],0,',','.') }}/30 hari
            @endif
          </div>
          {{-- UI-only for now; backend can wire to checkout later --}}
          <a class="btn primary block" href="{{ url('/teacher') }}?select_plan={{ strtolower($t['name']) }}">
            Pilih {{ $t['name'] }}
          </a>
        </article>
      @endforeach
    </div>
  </div>
</div>

@endsection