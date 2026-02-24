@extends('layouts.seller', ['title' => 'Produk Saya | SASIKU', 'header' => 'Produk Saya'])

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold">Daftar Produk</h2>
        <p class="text-gray-500 text-sm">Kelola produk yang Anda jual</p>
    </div>
    <a href="{{ route('seller.products.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors flex items-center space-x-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Tambah Produk</span>
    </a>
</div>

<!-- Products Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">Kode Produk</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Produk</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Kategori</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-center">Stok</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-center">Satuan</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Harga</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-center">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4">
                        <span class="font-mono text-sm">{{ $product->code }}</span>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden bg-gray-100">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="image" class="w-6 h-6 text-gray-300"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        @if ($product->category)
                            <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-xs font-medium">
                                {{ $product->category->name }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <span class="font-semibold {{ $product->stock <= 10 ? 'text-red-600' : ($product->stock <= 50 ? 'text-yellow-600' : 'text-gray-900') }}">
                            {{ $product->stock ?? 0 }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="text-sm text-gray-600">{{ $product->unit ?? 'kg' }}</span>
                    </td>
                    <td class="p-4">
                        <p class="font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        @if ($product->original_price && $product->original_price > $product->price)
                            <p class="text-xs text-gray-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if ($product->is_active)
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('admin.products.show', $product) }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-12">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="package" class="w-10 h-10 text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada produk</h3>
                            <p class="text-gray-500 mb-6">Mulai dengan menambahkan produk pertama Anda</p>
                            <a href="{{ route('seller.products.create') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors">
                                <i data-lucide="plus" class="w-5 h-5"></i>
                                <span>Tambah Produk</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($products->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $products->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
