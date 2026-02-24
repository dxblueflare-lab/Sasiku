@extends('layouts.customer', ['title' => 'Profil Saya | SASIKU'])

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Profil Saya</h1>
        <p class="text-gray-600">Kelola informasi akun Anda</p>
    </div>

    <!-- Profile Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold">Informasi Pribadi</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil Anda</p>
        </div>

        <form method="POST" action="{{ route('customer.profile.update') }}" class="p-6">
            @csrf
                    @method('PUT')

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                <div class="flex items-center">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-2"></i>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <div class="flex items-start">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mr-2 mt-0.5"></i>
                    <div class="text-red-800">
                        <p class="font-medium">Terjadi kesalahan:</p>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                           placeholder="Masukkan nama lengkap">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                           placeholder="nama@email.com">
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                           placeholder="08xxxxxxxxxx">
                </div>

                <!-- Role (Read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-violet-100 text-violet-600">
                            Customer
                        </span>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="mt-6">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                <textarea id="address" name="address" rows="3"
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors resize-none"
                          placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('customer.dashboard') }}" class="px-6 py-3 border border-gray-200 rounded-xl font-medium hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <!-- Security Section -->
    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold">Keamanan</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola keamanan akun Anda</p>
        </div>
        <div class="p-6 space-y-4">
            <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                        <i data-lucide="key" class="w-5 h-5 text-purple-600"></i>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900">Ubah Password</h3>
                        <p class="text-sm text-gray-500">Ganti password untuk keamanan akun</p>
                    </div>
                </div>
                <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
            </a>
        </div>
    </div>

    <!-- Logout Section -->
    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold">Akun</h2>
        </div>
        <div class="p-6">
            <form method="POST" action="{{ route('logout') }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                @csrf
                <button type="submit" class="flex items-center justify-between p-4 rounded-xl hover:bg-red-50 transition-colors w-full text-left">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center mr-4">
                            <i data-lucide="log-out" class="w-5 h-5 text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-red-600">Keluar Akun</h3>
                            <p class="text-sm text-gray-500">Logout dari akun Anda</p>
                        </div>
                    </div>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
