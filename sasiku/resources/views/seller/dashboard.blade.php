@extends('layouts.seller', ['title' => 'Seller Dashboard | SASIKU', 'header' => 'Dashboard Seller'])

@section('content')
<!-- Stats Cards -->
<section class="grid md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Total Produk</h3>
                <p class="text-3xl font-bold mt-1">{{ $stats['total_products'] }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i data-lucide="package" class="w-6 h-6 text-purple-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Pesanan Hari Ini</h3>
                <p class="text-3xl font-bold mt-1">{{ $stats['orders_today'] }}</p>
            </div>
            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                <i data-lucide="shopping-cart" class="w-6 h-6 text-pink-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Pendapatan</h3>
                <p class="text-2xl font-bold mt-1">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i data-lucide="wallet" class="w-6 h-6 text-green-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Rating</h3>
                <p class="text-3xl font-bold mt-1">{{ $stats['rating'] }} ⭐</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i data-lucide="star" class="w-6 h-6 text-yellow-600"></i>
            </div>
        </div>
    </div>
</section>

<!-- Products Table -->
<section class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold">Produk Saya</h2>
        <a href="{{ route('seller.products.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors flex items-center space-x-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Tambah Produk</span>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left p-3 font-semibold text-gray-600">Kode Produk</th>
                    <th class="text-left p-3 font-semibold text-gray-600">Nama Produk</th>
                    <th class="text-left p-3 font-semibold text-gray-600">Kategori</th>
                    <th class="text-left p-3 font-semibold text-gray-600">Harga</th>
                    <th class="text-left p-3 font-semibold text-gray-600">Stok</th>
                    <th class="text-left p-3 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                    <td class="p-3">
                        <span class="font-mono text-sm">{{ $product->code ?? '-' }}</span>
                    </td>
                    <td class="p-3">
                        <div class="flex items-center space-x-3">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <i data-lucide="image" class="w-5 h-5 text-gray-400"></i>
                                </div>
                            @endif
                            <span class="font-medium">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="p-3">
                        @if($product->category)
                            <span class="px-2 py-1 bg-purple-100 text-purple-600 rounded-lg text-xs font-medium">{{ $product->category->name }}</span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="p-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 {{ $product->stock > 10 ? 'bg-green-100 text-green-600' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-600' : 'bg-red-100 text-red-600') }} rounded-lg text-xs font-medium">
                            {{ $product->stock ?? 0 }} {{ $product->unit ?? 'kg' }}
                        </span>
                    </td>
                    <td class="p-3">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-700 font-medium mr-3">Edit</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">
                        <i data-lucide="package" class="w-12 h-12 mx-auto mb-3 opacity-30"></i>
                        <p>Belum ada produk.</p>
                        <a href="{{ route('seller.products.create') }}" class="text-purple-600 hover:text-purple-700 font-medium">Mulai tambah produk sekarang!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 text-center">
        <a href="{{ route('seller.products') }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">Lihat Semua Produk →</a>
    </div>
</section>

<!-- Realtime Producer Prices -->
<section class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold">📈 Update Harga Realtime Bahan Pokok (Tingkat Produsen)</h2>
        <div class="flex items-center space-x-2 text-sm text-gray-500">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <span>Live Update</span>
        </div>
    </div>

    <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-4" id="producer-prices">
        @foreach ($producerPrices as $item)
        <div class="border border-gray-100 rounded-xl p-4 hover:shadow-md transition-shadow" data-base-price="{{ $item['price'] }}">
            <div class="font-semibold text-gray-700 mb-2">{{ $item['name'] }}</div>
            <div class="text-xl font-bold text-purple-600 price-display">
                Rp {{ number_format($item['price'], 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-400 mt-1">Update realtime produsen</div>
        </div>
        @endforeach
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Producer price fluctuation simulation
    const priceCards = document.querySelectorAll('#producer-prices > div');

    function updateProducerPrices() {
        priceCards.forEach(card => {
            const basePrice = parseInt(card.dataset.basePrice);
            const delta = Math.floor(Math.random() * 1500);
            const newPrice = basePrice + (Math.random() > 0.5 ? delta : -delta);
            const finalPrice = Math.max(newPrice, 1000);

            const priceDisplay = card.querySelector('.price-display');
            if (priceDisplay) {
                priceDisplay.textContent = 'Rp ' + finalPrice.toLocaleString('id-ID');
            }
        });
    }

    // Update every 5 seconds
    setInterval(updateProducerPrices, 5000);
</script>
@endpush
