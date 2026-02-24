@extends('layouts.admin', ['title' => 'Kelola Produk | SASIKU Admin', 'header' => 'Kelola Produk'])

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div class="flex items-center space-x-4">
        <div>
            <h2 class="text-xl font-bold">Daftar Produk</h2>
            <p class="text-gray-500 text-sm">Kelola semua produk di platform SASIKU</p>
        </div>
        <!-- Live Indicator -->
        <div class="flex items-center space-x-2 px-3 py-1.5 bg-green-100 rounded-full">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
            </span>
            <span class="text-xs font-medium text-green-700">Live</span>
            <span class="text-xs text-green-600 ml-1" id="countdown">Update dalam 60d</span>
        </div>
    </div>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl hover:shadow-lg transition-all flex items-center space-x-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Tambah Produk</span>
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
    <form method="GET" action="{{ route('admin.products') }}" id="filterForm" class="flex flex-col md:flex-row gap-4">
        <!-- Search -->
        <div class="flex-1">
            <div class="relative">
                <i data-lucide="search" class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input
                    type="text"
                    name="search"
                    id="searchInput"
                    value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none"
                >
            </div>
        </div>

        <!-- Category Filter -->
        <div class="md:w-48">
            <select name="category" id="categoryFilter" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none">
                <option value="">Semua Kategori</option>
                @foreach (\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Status Filter -->
        <div class="md:w-40">
            <select name="status" id="statusFilter" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex items-center space-x-2">
            @if (request()->hasAny(['search', 'category', 'status']))
                <a href="{{ route('admin.products') }}" class="px-4 py-2.5 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors flex items-center space-x-2">
                    <i data-lucide="x" class="w-4 h-4"></i>
                    <span>Reset</span>
                </a>
            @endif
        </div>
    </form>
</div>

@push('scripts')
<script>
// Auto-submit form on search input (debounced)
const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const statusFilter = document.getElementById('statusFilter');
const filterForm = document.getElementById('filterForm');

let searchTimeout;

searchInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        filterForm.submit();
    }, 500);
});

categoryFilter.addEventListener('change', function() {
    filterForm.submit();
});

statusFilter.addEventListener('change', function() {
    filterForm.submit();
});
</script>
@endpush

<!-- Products Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600 w-24">Kode</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 w-1/4">Produk</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Kategori</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-center w-20">Stok</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-center w-20">Satuan</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Harga Jual</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">
                        <div class="flex items-center justify-center space-x-1">
                            <i data-lucide="refresh-cw" class="w-4 h-4 text-green-600"></i>
                            <span>Update Harga Real Time</span>
                        </div>
                    </th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-center w-24">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50" id="productsTableBody">
                @forelse ($products as $product)
                <tr class="hover:bg-gray-50 transition-colors" data-product-id="{{ $product->id }}">
                    <td class="p-4">
                        <span class="font-semibold text-gray-900">{{ $product->created_at->format('Y').sprintf('%04d', $product->id) ?? '-' }}</span>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center space-x-4">
                            <!-- Thumbnail -->
                            <div class="flex-shrink-0 w-16 h-16 rounded-xl overflow-hidden bg-gray-100">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i data-lucide="image" class="w-6 h-6 text-gray-300"></i>
                                    </div>
                                @endif
                            </div>
                            <!-- Product Info -->
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $product->seller->name ?? 'Penjual tidak ditemukan' }}</p>
                                
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
                        <p class="font-semibold text-gray-900">{{ $product->base_price ?? $product->price }}</p>
                        @if ($product->original_price && $product->original_price > $product->price)
                            <p class="text-xs text-gray-400 line-through">{{ $product->original_price }}</p>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-center space-x-2">
                            <span class="realtime-price font-bold text-lg text-green-600 transition-all duration-300" data-base-price="{{ $product->base_price ?? $product->price }}" data-product-id="{{ $product->id }}">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="price-trend text-xs px-2 py-1 rounded" data-product-id="{{ $product->id }}"></span>
                        </div>
                    </td>
                    <td class="p-4 text-center">
                        @if ($product->is_active)
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span>
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-end space-x-1">
                            <a href="{{ route('admin.products.show', $product) }}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors" title="Lihat">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="p-12">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="package" class="w-10 h-10 text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ request('search') ? 'Tidak ada produk yang ditemukan' : 'Belum ada produk' }}</h3>
                            <p class="text-gray-500 mb-6">{{ request('search') ? 'Coba kata kunci lain' : 'Mulai dengan menambahkan produk pertama Anda' }}</p>
                            @if (!request('search'))
                                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl hover:shadow-lg transition-all">
                                    <i data-lucide="plus" class="w-5 h-5"></i>
                                    <span>Tambah Produk</span>
                                </a>
                            @endif
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
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600">
                Menampilkan <span class="font-semibold">{{ $products->firstItem() }}</span>
                sampai <span class="font-semibold">{{ $products->lastItem() }}</span>
                dari <span class="font-semibold">{{ $products->total() }}</span> produk
            </div>
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    console.log('[Realtime Prices] Script initialized - DOM ready');

    // Store previous prices for trend calculation
    const previousPrices = {};

    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    console.log('[Realtime Prices] CSRF token:', csrfToken ? 'found' : 'NOT FOUND');

    if (!csrfToken) {
        console.error('[Realtime Prices] CSRF token not found - aborting');
        return;
    }

    // Get all price elements
    const priceElements = document.querySelectorAll('.realtime-price');
    console.log('[Realtime Prices] Found', priceElements.length, 'price elements');

    // Initialize previous prices from current display
    priceElements.forEach(function(element) {
        const productId = element.getAttribute('data-product-id');
        if (!productId) {
            console.warn('[Realtime Prices] Element missing data-product-id:', element);
            return;
        }
        const currentPriceText = element.textContent.replace(/[^\d]/g, '');
        previousPrices[productId] = parseInt(currentPriceText) || 0;
        console.log('[Realtime Prices] Product', productId, 'initial price:', previousPrices[productId]);
    });

    function formatRupiah(price) {
        return 'Rp ' + price.toLocaleString('id-ID');
    }

    function updateTrendElement(element, trend) {
        if (!element) return;
        element.textContent = trend.icon;
        element.className = 'price-trend text-xs px-2 py-1 rounded ' + trend.class;
    }

    // Fetch real-time prices from server
    function fetchRealtimePrices() {
        console.log('[Realtime Prices] Fetching prices from server...');

        return fetch('{{ route('admin.products.realtime-prices') }}', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(function(response) {
            console.log('[Realtime Prices] Response status:', response.status);
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.json();
        })
        .catch(function(error) {
            console.error('[Realtime Prices] Error fetching prices:', error);
            return null;
        });
    }

    function updatePricesFromServer() {
        console.log('[Realtime Prices] ========== Starting price update ==========');

        fetchRealtimePrices().then(function(data) {
            console.log('[Realtime Prices] Received data:', data);

            if (!data) {
                console.warn('[Realtime Prices] No data received');
                return;
            }

            if (!data.prices || !Array.isArray(data.prices)) {
                console.warn('[Realtime Prices] Invalid data format:', data);
                return;
            }

            console.log('[Realtime Prices] Updating', data.prices.length, 'products');

            // Update each product price
            const priceElements = document.querySelectorAll('.realtime-price');

            priceElements.forEach(function(element) {
                const productId = element.getAttribute('data-product-id');
                const row = element.closest('tr');
                const trendElement = row ? row.querySelector('.price-trend') : null;

                // Find new price from server response
                const updatedPrice = data.prices.find(function(p) {
                    return p.id == productId;
                });

                if (updatedPrice) {
                    const oldPrice = previousPrices[productId] || updatedPrice.price;
                    const newPrice = updatedPrice.price;

                    console.log('[Realtime Prices] Product', productId, ':', oldPrice, '->', newPrice);

                    // Determine trend
                    var trend;
                    if (newPrice > oldPrice) {
                        trend = { icon: '↑', class: 'text-green-600 bg-green-100' };
                    } else if (newPrice < oldPrice) {
                        trend = { icon: '↓', class: 'text-red-600 bg-red-100' };
                    } else {
                        trend = { icon: '→', class: 'text-gray-600 bg-gray-100' };
                    }

                    // Update price display with animation
                    element.classList.add('scale-110');
                    element.textContent = formatRupiah(newPrice);
                    setTimeout(function() {
                        element.classList.remove('scale-110');
                    }, 200);

                    // Update trend
                    updateTrendElement(trendElement, trend);

                    // Store new price as previous
                    previousPrices[productId] = newPrice;
                } else {
                    console.warn('[Realtime Prices] No price found for product:', productId);
                }
            });

            console.log('[Realtime Prices] ========== Update complete ==========');
        });
    }

    // Countdown timer
    var countdownElement = document.getElementById('countdown');
    var secondsLeft = 300;

    function updateCountdown() {
        secondsLeft--;
        if (secondsLeft <= 0) {
            secondsLeft = 300;
            // Trigger price update when countdown reaches 0
            console.log('[Realtime Prices] Countdown reached 0 - triggering update');
            updatePricesFromServer();
        }

        if (countdownElement) {
            countdownElement.textContent = 'Update dalam ' + secondsLeft + 'd';
        }
    }

    // Start countdown timer (every second)
    setInterval(updateCountdown, 20000);
    console.log('[Realtime Prices] Countdown timer started');

    // Initial fetch after 2 seconds
    setTimeout(function() {
        console.log('[Realtime Prices] Starting initial price fetch...');
        updatePricesFromServer();
    }, 2000);

    console.log('[Realtime Prices] Setup complete - will update every 5 minutes');
});
</script>
@endpush
@endsection
