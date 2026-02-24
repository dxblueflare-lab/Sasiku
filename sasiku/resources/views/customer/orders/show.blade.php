@extends('layouts.customer', ['title' => 'Detail Pesanan | SASIKU'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <a href="{{ route('customer.orders') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali ke Daftar Pesanan
        </a>
        <h1 class="text-3xl font-bold mb-2">Detail Pesanan</h1>
        <p class="text-gray-600">No. Pesanan: <span class="font-mono font-semibold text-purple-600">#{{ $order->order_number ?? $order->id }}</span></p>
    </div>

    <!-- Order Status & Info -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-700">Status Pesanan</h3>
                @php
                    $statusClasses = [
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'processing' => 'bg-blue-100 text-blue-700',
                        'completed' => 'bg-green-100 text-green-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu',
                        'processing' => 'Diproses',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ];
                    $statusClass = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700';
                    $statusLabel = $statusLabels[$order->status] ?? ucfirst($order->status);
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                    {{ $statusLabel }}
                </span>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Pemesanan</span>
                    <span class="font-medium">{{ $order->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Jam</span>
                    <span class="font-medium">{{ $order->created_at->format('H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Informasi Pengiriman</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama</span>
                    <span class="font-medium">{{ $order->shipping_name ?? $order->user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Telepon</span>
                    <span class="font-medium">{{ $order->shipping_phone ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Alamat</span>
                    <span class="font-medium text-right max-w-[200px]">{{ $order->shipping_address ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-violet-500 to-pink-500 rounded-2xl shadow-sm p-6 text-white">
            <h3 class="font-semibold mb-4">Total Pembayaran</h3>
            <p class="text-3xl font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            <p class="text-white/80 text-sm mt-2">{{ $order->items->count() }} barang</p>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold">Item Pesanan</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($order->items as $item)
            <div class="p-6 flex items-center space-x-4">
                <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    @if($item->product && $item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-xl">
                    @else
                        <i data-lucide="package" class="w-8 h-8 text-gray-400"></i>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900">{{ $item->product->name ?? 'Produk tidak tersedia' }}</h3>
                    <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-lg">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="p-6 bg-gray-50 border-t border-gray-100">
            <div class="max-w-md ml-auto space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium">Rp {{ number_format($order->subtotal ?? $order->total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Ongkos Kirim</span>
                    <span class="font-medium">Rp {{ number_format($order->shipping_cost ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold pt-2 border-t border-gray-200">
                    <span>Total</span>
                    <span class="text-purple-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @if($order->status === 'completed' || $order->status === 'processing')
    <div class="mt-6 flex justify-end space-x-4">
        <button class="px-6 py-3 border border-gray-200 rounded-xl font-medium hover:bg-gray-50 transition-colors">
            <i data-lucide="message-circle" class="w-5 h-5 inline mr-2"></i>
            Hubungi Penjual
        </button>
        <button class="px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
            <i data-lucide="star" class="w-5 h-5 inline mr-2"></i>
            Beri Ulasan
        </button>
    </div>
    @endif

    @if($order->status === 'pending')
    <div class="mt-6 flex justify-end space-x-4">
        <form method="POST" action="{{ route('customer.orders.cancel', $order) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-3 border border-red-200 text-red-600 rounded-xl font-medium hover:bg-red-50 transition-colors">
                <i data-lucide="x" class="w-5 h-5 inline mr-2"></i>
                Batalkan Pesanan
            </button>
        </form>
        <a href="{{ route('home') }}" class="px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all inline-flex items-center">
            <i data-lucide="shopping-bag" class="w-5 h-5 mr-2"></i>
            Belanja Lagi
        </a>
    </div>
    @endif
</div>
@endsection
