@extends('layouts.seller', ['title' => 'Profil | SASIKU', 'header' => 'Profil Saya'])

@section('content')
<div class="max-w-2xl">
    <!-- Profile Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center space-x-6 mb-6">
            <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                <p class="text-gray-500">{{ $user->email }}</p>
                <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium mt-2">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                    Seller Terverifikasi
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('seller.profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none"
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
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                <input
                    type="text"
                    name="phone"
                    id="phone"
                    value="{{ old('phone', $user->phone ?? '') }}"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none"
                    placeholder="Contoh: 08123456789"
                >
                @error('phone')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                <textarea
                    name="address"
                    id="address"
                    rows="3"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all outline-none"
                    placeholder="Alamat lengkap..."
                >{{ old('address', $user->address ?? '') }}</textarea>
                @error('address')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Account Info -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold mb-4">Informasi Akun</h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                <div>
                    <p class="font-medium">Role</p>
                    <p class="text-sm text-gray-500">Hak akses akun Anda</p>
                </div>
                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-sm font-medium">Seller</span>
            </div>
            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                <div>
                    <p class="font-medium">Tanggal Bergabung</p>
                    <p class="text-sm text-gray-500">Waktu pendaftaran akun</p>
                </div>
                <span class="text-sm text-gray-600">{{ $user->created_at->format('d F Y') }}</span>
            </div>
            <div class="flex justify-between items-center py-3">
                <div>
                    <p class="font-medium">Status Akun</p>
                    <p class="text-sm text-gray-500">Status verifikasi akun</p>
                </div>
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-sm font-medium">Aktif</span>
            </div>
        </div>
    </div>
</div>
@endsection
