@extends('layouts.admin')

@section('title', 'Kelola Plan')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Kelola Plan</h1>
        <a class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm"
            href="{{ route('admin.plans.create') }}">
            Tambah Plan
        </a>
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
                    <th class="p-2">Harga</th>
                    <th class="p-2">Durasi</th>
                    <th class="p-2">Kuota</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plans as $p)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $p->name }}</td>
                        <td class="p-2">Rp{{ number_format($p->price, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $p->duration_days }} hari</td>
                        <td class="p-2">{{ $p->quota_region ?? '-' }}</td>
                        <td class="p-2">
                            <div class="flex gap-2">
                                <a class="bg-gray-700 hover:bg-gray-800 text-white px-3 py-1 rounded text-sm"
                                    href="{{ route('admin.plans.edit', $p) }}">Edit</a>
                                <form method="POST" action="{{ route('admin.plans.destroy', $p) }}"
                                    onsubmit="return confirm('Hapus plan?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $plans->links() }}
    </div>
@endsection
