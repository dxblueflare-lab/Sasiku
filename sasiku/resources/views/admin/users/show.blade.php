@extends('layouts.admin', ['title' => 'Detail Pengguna | SASIKU Admin', 'header' => 'Detail Pengguna'])

@section('content')
<div class="max-w-4xl">
    <!-- Back Button -->
    <a href="{{ route('admin.users') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900 mb-6">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
        <span>Kembali ke Daftar Pengguna</span>
    </a>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- User Info Card -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-violet-500 to-pink-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h3 class="text-lg font-bold">{{ $user->name }}</h3>
                <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                <p class="text-gray-400 text-xs mt-1">Terdaftar: {{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Role & Actions -->
        <div class="md:col-span-2 space-y-6">
            <!-- Current Role -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold mb-4">Role Saat Ini</h3>
                @foreach ($user->roles as $role)
                    <span class="px-3 py-1 rounded-full text-sm font-medium mr-2
                        @if ($role->name === 'admin') bg-purple-100 text-purple-600
                        @elseif ($role->name === 'seller') bg-pink-100 text-pink-600
                        @else bg-violet-100 text-violet-600
                        @endif">
                        {{ ucfirst($role->name) }}
                    </span>
                @endforeach
            </div>

            <!-- Update Role -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold mb-4">Ubah Role</h3>
                <form method="POST" action="{{ route('admin.users.update-role', $user) }}">
                    @csrf
                    <div class="flex items-center space-x-4">
                        <select name="role" class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none">
                            <option value="">Pilih Role Baru</option>
                            <option value="admin">Admin</option>
                            <option value="seller">Seller</option>
                            <option value="customer">Customer</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors">
                            Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@append
