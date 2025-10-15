{{-- resources/views/admin/listings/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Listing')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Manajemen Listing</h1>

    @if (session('success'))
        <div class="p-3 mb-4 text-green-800 bg-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="p-2">Judul</th>
                    <th class="p-2">Guru</th>
                    <th class="p-2">Region</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($listing as $it)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $it->title }}</td>
                        <td class="p-2">{{ $it->user->name }}</td>
                        <td class="p-2">{{ $it->region->name ?? '-' }}</td>
                        <td class="p-2">
                            <form method="POST" action="{{ route('admin.listings.updateStatus', $it) }}">
                                @csrf @method('PATCH')
                                <select name="status" class="border rounded px-2 py-1" onchange="this.form.submit()">
                                    <option value="active" @selected($it->status === 'active')>active</option>
                                    <option value="inactive" @selected($it->status === 'inactive')>inactive</option>
                                </select>
                            </form>
                        </td>
                        <td class="p-2">
                            <form method="POST" action="{{ route('admin.listings.destroy', $it) }}"
                                onsubmit="return confirm('Hapus listing ini?')">
                                @csrf @method('DELETE')
                                <button
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Belum ada listing.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $listing->links() }}
    </div>
@endsection
