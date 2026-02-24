@extends('layouts.admin', ['title' => 'Edit Pengguna | SASIKU Admin', 'header' => 'Edit Pengguna'])

@section('content')
<div class="max-w-xl">
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- User Info Card -->
            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-violet-500 to-pink-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm text-gray-500">Mengedit data pengguna</p>
                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    autofocus
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                    placeholder="Contoh: Budi Santoso"
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                    placeholder="contoh@email.com"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Selection -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">Role Pengguna</label>
                <div class="grid grid-cols-2 gap-4">
                    @php
                        $userRole = $user->roles->first()?->name ?? 'customer';
                    @endphp

                    <!-- Customer -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="role" value="customer" {{ old('role', $userRole) === 'customer' ? 'checked' : '' }} required class="peer sr-only">
                        <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-violet-500 peer-checked:bg-violet-50 transition-all">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-12 h-12 bg-violet-100 rounded-full flex items-center justify-center mb-3">
                                    <i data-lucide="shopping-bag" class="w-6 h-6 text-violet-600"></i>
                                </div>
                                <span class="font-semibold text-gray-900">Customer</span>
                                <span class="text-xs text-gray-500 mt-1">Pembeli produk</span>
                            </div>
                        </div>
                    </label>

                    <!-- Seller -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="role" value="seller" {{ old('role', $userRole) === 'seller' ? 'checked' : '' }} required class="peer sr-only">
                        <div class="p-4 border-2 border-gray-200 rounded-xl peer-checked:border-pink-500 peer-checked:bg-pink-50 transition-all">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center mb-3">
                                    <i data-lucide="store" class="w-6 h-6 text-pink-600"></i>
                                </div>
                                <span class="font-semibold text-gray-900">Seller</span>
                                <span class="text-xs text-gray-500 mt-1">Penjual produk</span>
                            </div>
                        </div>
                    </label>
                </div>
                @error('role')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Account Info -->
            <div class="p-4 bg-blue-50 rounded-xl">
                <div class="flex items-start space-x-3">
                    <i data-lucide="info" class="w-5 h-5 text-blue-600 mt-0.5"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-medium mb-1">Informasi Akun</p>
                        <p class="text-blue-600">Akun dibuat pada {{ $user->created_at->format('d M Y, H:i') }}</p>
                        @if ($user->updated_at != $user->created_at)
                            <p class="text-blue-600">Terakhir diperbarui: {{ $user->updated_at->format('d M Y, H:i') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.users') }}" class="px-6 py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl hover:shadow-lg transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@append
