@extends('layouts.app')

@section('content')
    <x-plan-banner :plan="$planName ?? 'bronze'" :used="$used ?? 0" :limit="$limit ?? 3" :endDate="$endDate" />


    <div class="grid grid-3" style="margin:16px 0">
        <x-stat-card label="Views (7d)" :value="$stats['views'] ?? 0" />
        <x-stat-card label="WA Clicks (7d)" :value="$stats['wa'] ?? 0" />
        <x-stat-card label="Active Listings" :value="$stats['active'] ?? 0" />
    </div>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
        <h2 class="h2">My Listings</h2>
    </div>

    <div class="grid" style="gap:12px">
        @forelse(($listings ?? collect()) as $item)
            <x-listing-card-teacher :listing="$item" />
        @empty
            <x-empty-state message="Belum ada listing." />
        @endforelse
    </div>

    <div id="upgrade-modal" class="modal-backdrop" hidden aria-hidden="true">
        <div class="modal-scrim" data-close="upgrade-modal"></div>
        <div class="modal-card card pad" role="dialog" aria-modal="true" aria-labelledby="upgrade-title">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                <h2 id="upgrade-title" class="h2" style="margin:0">Paket Langganan</h2>
                <button class="btn" type="button" data-close="upgrade-modal">Tutup</button>
            </div>

            <div class="grid grid-3" style="margin-top:12px">
                @foreach ($plans as $plan)
                    <article class="card pad" style="display:flex;flex-direction:column;gap:8px">
                        <div class="title" style="margin:0">{{ $plan->name }}</div>
                        @if ($plan->benefits)
                            <div class="muted">
                                {{-- tampilkan ringkas manfaat kalau ada --}}
                                {{ is_array($plan->benefits) ? implode(' · ', $plan->benefits) : $plan->benefits }}
                            </div>
                        @endif
                        <div class="h1" style="margin:2px 0">
                            {{-- contoh: kuota / info singkat, sesuaikan kolommu --}}
                            {{ $plan->quota_listings ?? ($plan->quota_region ?? '-') }}
                        </div>
                        <div class="muted">
                            @if ((int) $plan->price === 0)
                                Gratis ({{ $plan->duration_days }} hari)
                            @else
                                Rp{{ number_format($plan->price, 0, ',', '.') }}/{{ $plan->duration_days }} hari
                            @endif
                        </div>

                        {{-- Aksi 1: Kirim request upgrade (POST) --}}
                        <form method="POST" action="{{ route('plan-requests.store') }}" style="margin-top:6px">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <button class="btn primary block" type="submit">Kirim Request {{ $plan->name }}</button>
                        </form>

                        {{-- Aksi 2: Chat admin via WA (GET redirect) --}}
                        <a class="btn block" style="margin-top:6px" href="{{ route('plans.wa', $plan) }}">
                            Chat Admin via WA
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
@endsection
