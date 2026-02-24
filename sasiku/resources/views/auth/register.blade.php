@extends('layouts.auth', [
    'title' => 'Daftar Akun - SASIKU',
    'subtitle' => 'Buat akun baru untuk mulai belanja'
])

@section('content')
<form method="POST" action="{{ route('register') }}" class="space-y-5">
    @csrf

    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
        <div class="relative">
            <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                placeholder="Nama lengkap"
            >
        </div>
        @error('name')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
        <div class="relative">
            <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                placeholder="nama@email.com"
            >
        </div>
        @error('email')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Role Selection -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Daftar sebagai</label>
        <div class="grid grid-cols-2 gap-3">
            <label
                class="relative flex cursor-pointer"
            >
                @php
                    $selectedRole = old('role', 'customer');
                @endphp
                <input
                    type="radio"
                    name="role"
                    value="customer"
                    {{ $selectedRole === 'customer' ? 'checked' : '' }}
                    class="peer sr-only"
                    required
                >
                <div class="w-full p-4 border-2 border-gray-200 rounded-xl peer-checked:border-violet-500 peer-checked:bg-violet-50 transition-all">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 bg-violet-100 rounded-full flex items-center justify-center mb-2 peer-checked:bg-violet-500">
                            <i data-lucide="shopping-cart" class="w-5 h-5 text-violet-600 peer-checked:text-white"></i>
                        </div>
                        <span class="font-semibold text-gray-700">Customer</span>
                        <span class="text-xs text-gray-500 mt-1">Belanja untuk kebutuhan harian</span>
                    </div>
                </div>
            </label>

            <label class="relative flex cursor-pointer">
                <input
                    type="radio"
                    name="role"
                    value="seller"
                    {{ $selectedRole === 'seller' ? 'checked' : '' }}
                    class="peer sr-only"
                    required
                >
                <div class="w-full p-4 border-2 border-gray-200 rounded-xl peer-checked:border-pink-500 peer-checked:bg-pink-50 transition-all">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mb-2 peer-checked:bg-pink-500">
                            <i data-lucide="store" class="w-5 h-5 text-pink-600 peer-checked:text-white"></i>
                        </div>
                        <span class="font-semibold text-gray-700">Seller</span>
                        <span class="text-xs text-gray-500 mt-1">Jual produk ke pelanggan</span>
                    </div>
                </div>
            </label>
        </div>
        @error('role')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                placeholder="••••••••"
            >
            @error('password')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                placeholder="••••••••"
            >
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Submit Button -->
    <button
        type="submit"
        class="w-full py-4 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-violet-500/30 transition-all duration-300 transform hover:-translate-y-0.5"
    >
        Daftar Sekarang
    </button>
</form>
@append

@section('footer-link')
    Sudah punya akun?
    <a href="{{ route('login') }}" class="font-semibold text-violet-600 hover:text-violet-700 transition-colors">
        Masuk Sekarang
    </a>
@append
