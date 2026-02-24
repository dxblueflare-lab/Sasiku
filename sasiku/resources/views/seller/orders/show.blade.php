@extends('layouts.seller', ['title' => 'Detail Pesanan | SASIKU', 'header' => 'Detail Pesanan'])

@section('content')
<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('seller.orders') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
        <span>Kembali ke Daftar Pesanan</span>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold">Pesanan #{{ $order->order_number ?? $order->id }}</h2>
                    <p class="text-gray-500 text-sm">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>
                @php
                    $statusClasses = [
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'diproses' => 'bg-blue-100 text-blue-700',
                        'dikirim' => 'bg-indigo-100 text-indigo-700',
                        'selesai' => 'bg-green-100 text-green-700',
                        'dibatalkan' => 'bg-red-100 text-red-700',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu',
                        'diproses' => 'Diproses',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ];
                @endphp
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                </span>
            </div>

            <!-- Update Status Form -->
            <form method="POST" action="{{ route('seller.orders.update-status', $order) }}" class="mb-6">
                @csrf
                @method('PUT')
                <div class="flex items-center space-x-4">
                    <label class="text-sm font-medium text-gray-700">Update Status:</label>
                    <select name="status" class="px-4 py-2 border border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-100 outline-none">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm">
                        Update
                    </button>
                </div>
            </form>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pelanggan</p>
                    <p class="font-medium">{{ $order->user->name ?? '-' }}</p>
                    <p class="text-sm text-gray-600">{{ $order->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">No. Telepon</p>
                    <p class="font-medium">{{ $order->phone ?? '-' }}</p>
                </div>
            </div>

            @if ($order->shipping_address)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-sm text-gray-500 mb-2">Alamat Pengiriman</p>
                <p class="text-gray-700">{{ $order->shipping_address }}</p>
            </div>
            @endif

            @if ($order->notes)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-sm text-gray-500 mb-2">Catatan</p>
                <p class="text-gray-700">{{ $order->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold mb-4">Item Pesanan</h3>
            <div class="space-y-4">
                @foreach ($order->items as $item)
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                    @if ($item->product && $item->product->image_url)
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="w-16 h-16 rounded-lg object-cover">
                    @else
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                        </div>
                    @endif
                    <div class="flex-1">
                        <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                        @if ($item->product)
                            <p class="text-xs text-gray-500">Kode: {{ $item->product->code }}</p>
                        @endif
                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end">
                <div class="text-right">
                    <p class="text-gray-500 mb-1">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Order Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold mb-4">Ringkasan</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Ongkir</span>
                    <span class="font-medium">Rp 0</span>
                </div>
                <div class="pt-3 border-t border-gray-100 flex justify-between">
                    <span class="font-semibold">Total</span>
                    <span class="font-bold text-purple-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold mb-4">Info Pelanggan</h3>
            <div class="space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                        <i data-lucide="user" class="w-5 h-5 text-purple-600"></i>
                    </div>
                    <div>
                        <p class="font-medium">{{ $order->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</p>
                    </div>
                </div>
                @if ($order->phone)
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                        <i data-lucide="phone" class="w-5 h-5 text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm">{{ $order->phone }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
