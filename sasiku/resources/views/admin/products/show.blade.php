@extends('layouts.admin', ['title' => 'Detail Produk | SASIKU Admin', 'header' => 'Detail Produk'])

@section('content')
<div class="max-w-4xl">
    <!-- Back Button -->
    <a href="{{ route('admin.products') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900 mb-6">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
        <span>Kembali ke Daftar Produk</span>
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Product Image -->
        <div class="relative h-64 bg-gradient-to-br from-violet-100 to-pink-100">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
        </div>

        <!-- Product Info -->
        <div class="p-6">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold mb-2">{{ $product->name }}</h1>
                    <p class="text-gray-500 text-sm">{{ $product->slug }}</p>
                </div>
                @if ($product->is_active)
                    <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-sm font-medium">Aktif</span>
                @else
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm font-medium">Nonaktif</span>
                @endif
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <p class="text-sm text-gray-500 mb-1">Kategori</p>
                    @if ($product->category)
                        <span class="px-2 py-1 bg-purple-100 text-purple-600 rounded-lg text-sm font-medium">
                            {{ $product->category->name }}
                        </span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </div>

                <!-- Price -->
                <div>
                    <p class="text-sm text-gray-500 mb-1">Harga</p>
                    <p class="text-2xl font-bold text-violet-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    @if ($product->original_price && $product->original_price > $product->price)
                        <p class="text-sm text-gray-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>

            @if ($product->description)
            <div class="mt-6 pt-6 border-t border-gray-100">
                <p class="text-sm text-gray-500 mb-2">Deskripsi</p>
                <p class="text-gray-700">{{ $product->description }}</p>
            </div>
            @endif

            <!-- Actions -->
            <div class="mt-6 pt-6 border-t border-gray-100 flex items-center space-x-4">
                <a href="{{ route('admin.products.edit', $product) }}" class="px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors flex items-center space-x-2">
                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                    <span>Edit Produk</span>
                </a>
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors flex items-center space-x-2">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                        <span>Hapus Produk</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
