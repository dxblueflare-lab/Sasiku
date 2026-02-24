@extends('layouts.admin', ['title' => 'Kelola Pengguna | SASIKU Admin', 'header' => 'Kelola Pengguna'])

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold">Daftar Pengguna</h2>
        <p class="text-gray-500 text-sm">Kelola semua pengguna platform SASIKU</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl hover:shadow-lg transition-all flex items-center space-x-2">
        <i data-lucide="user-plus" class="w-4 h-4"></i>
        <span>Tambah Pengguna</span>
    </a>
</div>

<!-- Users Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">Pengguna</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Email</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Role</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Terdaftar</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-medium">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="p-4 text-gray-600">{{ $user->email }}</td>
                    <td class="p-4">
                        @foreach ($user->roles as $role)
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                @if ($role->name === 'admin') bg-purple-100 text-purple-600
                                @elseif ($role->name === 'seller') bg-pink-100 text-pink-600
                                @else bg-violet-100 text-violet-600
                                @endif">
                                {{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    </td>
                    <td class="p-4 text-gray-500 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="p-4">
                        <div class="flex items-center justify-end space-x-1">
                            <a href="{{ route('admin.users.show', $user) }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" title="Lihat">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($users->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
    @endif
</div>
@append
