@extends('layouts.admin')

@section('title', 'Plan Requests')

@section('content')
    <h1 class="text-2xl font-bold mb-4">📊 Daftar Request Upgrade Plan</h1>

    @if (session('success'))
        <div class="p-3 mb-4 text-green-800 bg-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="mb-4 flex gap-2">
        <select name="status" onchange="this.form.submit()" class="border p-2 rounded">
            <option value="">Semua Status</option>
            @foreach (['requested', 'approved', 'rejected'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </form>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">User</th>
                    <th class="p-2">Plan</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Catatan</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reqs as $r)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $r->created_at->format('d M Y H:i') }}</td>
                        <td class="p-2">
                            <strong>{{ $r->user->name }}</strong><br>
                            <small>{{ $r->user->email }}</small>
                        </td>
                        <td class="p-2">
                            {{ $r->plan->name }}<br>
                            <small>Rp {{ number_format($r->plan->price, 0, ',', '.') }}</small>
                        </td>
                        <td class="p-2">
                            @if ($r->status === 'requested')
                                <span class="px-2 py-1 text-sm bg-yellow-200 text-yellow-800 rounded">Requested</span>
                            @elseif($r->status === 'approved')
                                <span class="px-2 py-1 text-sm bg-green-200 text-green-800 rounded">Approved</span>
                            @else
                                <span class="px-2 py-1 text-sm bg-red-200 text-red-800 rounded">Rejected</span>
                            @endif
                        </td>
                        <td class="p-2">{{ $r->note ?? '-' }}</td>
                        <td class="p-2">
                            @if ($r->status === 'requested')
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('admin.plan-requests.approve', $r) }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                            ✅ Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.plan-requests.reject', $r) }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                            ❌ Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <em class="text-gray-400">Tidak ada aksi</em>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 text-gray-500">Belum ada request plan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $reqs->links() }}
    </div>
@endsection
