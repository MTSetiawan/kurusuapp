@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded shadow p-4">
            <div class="text-sm text-gray-500">Total Guru</div>
            <div class="text-2xl font-bold">{{ $totalGuru ?? 0 }}</div>
        </div>
        <div class="bg-white rounded shadow p-4">
            <div class="text-sm text-gray-500">Listing Aktif</div>
            <div class="text-2xl font-bold">{{ $listingAktif ?? 0 }}</div>
        </div>
        <div class="bg-white rounded shadow p-4">
            <div class="text-sm text-gray-500">Pending Request</div>
            <div class="text-2xl font-bold">{{ $reqPending ?? 0 }}</div>
        </div>
        <div class="bg-white rounded shadow p-4">
            <div class="text-sm text-gray-500">Pendapatan Hari Ini</div>
            <div class="text-2xl font-bold">Rp{{ number_format($todayRevenue ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>
@endsection
