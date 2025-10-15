{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Daftar Guru')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Daftar Guru</h1>

        {{-- Pencarian sederhana --}}
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / email..."
                class="border rounded px-3 py-2 w-64">
            <button class="bg-gray-800 hover:bg-gray-900 text-white px-3 py-2 rounded text-sm">Cari</button>
        </form>
    </div>

    @if (session('success'))
        <div class="p-3 mb-4 text-green-800 bg-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Plan Aktif</th>
                    <th class="p-2">Masa Aktif</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    @php
                        $activePlan = $u->activePlan; // relasi hasOne -> latest plan aktif
                        $planName = $activePlan?->plan?->name ?? '-';
                        $endDate = $activePlan?->end_date;
                        $remaining = $endDate ? now()->diffInDays(\Carbon\Carbon::parse($endDate), false) : null;
                    @endphp
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">
                            <div class="font-semibold">{{ $u->name }}</div>
                        </td>
                        <td class="p-2">
                            <div class="text-gray-700">{{ $u->email }}</div>
                        </td>
                        <td class="p-2">
                            {{ $planName }}
                        </td>
                        <td class="p-2">
                            @if ($endDate)
                                <div>{{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $remaining > 0 ? $remaining . ' hari tersisa' : 'expired' }}
                                </div>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="p-2">
                            @if ($u->is_banned ?? false)
                                <span class="px-2 py-1 rounded text-sm bg-red-100 text-red-700">Banned</span>
                            @else
                                <span class="px-2 py-1 rounded text-sm bg-green-100 text-green-700">Active</span>
                            @endif
                        </td>
                        <td class="p-2">
                            <div class="flex items-center gap-2">
                                {{-- Toggle Ban / Unban --}}
                                <form method="POST" action="{{ route('admin.users.toggleBan', $u) }}">
                                    @csrf
                                    <button
                                        class="px-3 py-1 rounded text-sm
                                 {{ $u->is_banned ?? false ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-red-600 hover:bg-red-700 text-white' }}">
                                        {{ $u->is_banned ?? false ? 'Unban' : 'Ban' }}
                                    </button>
                                </form>

                                {{-- Lihat listing user di halaman admin listing (filter by user) --}}
                                <a class="px-3 py-1 rounded text-sm bg-gray-800 hover:bg-gray-900 text-white"
                                    href="{{ route('admin.listings.index', ['user' => $u->id]) }}">
                                    Lihat Listing
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">Belum ada guru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->withQueryString()->links() }}
    </div>
@endsection
