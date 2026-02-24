@extends('layouts.customer', ['title' => 'Favorit Saya | SASIKU'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Favorit Saya</h1>
        <p class="text-gray-600">Daftar produk yang Anda simpan</p>
    </div>

    <!-- Favorites List -->
    @forelse($products as $product)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-shadow">
            <div class="relative">
                <div class="aspect-square bg-gray-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i data-lucide="package" class="w-16 h-16 text-gray-300"></i>
                        </div>
                    @endif
                </div>
                <button class="absolute top-3 right-3 w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                    <i data-lucide="heart" class="w-5 h-5 fill-current"></i>
                </button>
            </div>
            <div class="p-4">
                <span class="text-xs text-purple-600 font-medium">{{ $product->category->name ?? 'Umum' }}</span>
                <h3 class="font-semibold text-gray-900 mt-1 line-clamp-2">{{ $product->name }}</h3>
                <div class="mt-3 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 line-through">Rp {{ number_format($product->price * 1.1, 0, ',', '.') }}</p>
                        <p class="font-bold text-purple-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <button class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center hover:bg-purple-200 transition-colors">
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @empty
    <!-- Empty State -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="heart" class="w-10 h-10 text-gray-400"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada favorit</h3>
        <p class="text-gray-500 mb-6">Simpan produk yang Anda sukai agar mudah ditemukan!</p>
        <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
            <i data-lucide="search" class="w-5 h-5"></i>
            <span>Jelajah Produk</span>
        </a>
    </div>
    @endforelse

    <!-- Note for future implementation -->
    @if($products->isEmpty())
    <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
        <div class="flex items-start">
            <i data-lucide="info" class="w-5 h-5 text-yellow-600 mr-3 mt-0.5"></i>
            <div>
                <h4 class="font-semibold text-yellow-800">Fitur Favorit</h4>
                <p class="text-sm text-yellow-700 mt-1">Fitur ini akan berfungsi penuh setelah tabel wishlist ditambahkan ke database. Untuk saat ini, halaman ini menampilkan state kosong sebagai placeholder.</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
