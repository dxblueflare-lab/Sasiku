@extends('layouts.auth', [
    'title' => 'Masuk - SASIKU'
])

@section('content')
<form method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf

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
                autofocus
                autocomplete="username"
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                placeholder="nama@email.com"
            >
        </div>
        @error('email')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
        <div class="relative">
            <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                placeholder="••••••••"
            >
        </div>
        @error('password')
            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Remember & Forgot Password -->
    <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer">
            <input
                type="checkbox"
                name="remember"
                class="w-4 h-4 text-violet-600 border-gray-300 rounded focus:ring-violet-500"
            >
            <span class="text-sm text-gray-600">Ingat saya</span>
        </label>

        @if (Route::has('password.request'))
            <a
                href="{{ route('password.request') }}"
                class="text-sm font-medium text-violet-600 hover:text-violet-700 transition-colors"
            >
                Lupa password?
            </a>
        @endif
    </div>

    <!-- Submit Button -->
    <button
        type="submit"
        class="w-full py-4 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-violet-500/30 transition-all duration-300 transform hover:-translate-y-0.5"
    >
        Masuk Sekarang
    </button>
</form>
@append

@section('footer-link')
    Belum punya akun?
    <a href="{{ route('register') }}" class="font-semibold text-violet-600 hover:text-violet-700 transition-colors">
        Daftar Sekarang
    </a>
@append
