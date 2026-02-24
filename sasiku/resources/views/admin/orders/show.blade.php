@extends('layouts.admin', ['title' => 'Detail Pesanan | SASIKU Admin', 'header' => 'Detail Pesanan'])

@section('content')
<div class="max-w-4xl">
    <!-- Back Button -->
    <a href="{{ route('admin.orders') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-gray-900 mb-6">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
        <span>Kembali ke Daftar Pesanan</span>
    </a>

    <!-- Order Info -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold">{{ $order->order_number }}</h1>
                <p class="text-gray-500 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                @csrf
                <div class="flex items-center space-x-2">
                    <select name="status" class="px-4 py-2 border border-gray-200 rounded-xl focus:border-violet-500 focus:ring-4 focus:ring-violet-100 transition-all outline-none">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ $order->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="dikirim" {{ $order->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                        <option value="selesai" {{ $order->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors">
                        Update Status
                    </button>
                </div>
            </form>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1">Pelanggan</p>
                <p class="font-medium">{{ $order->user?->name ?? '-' }}</p>
                <p class="text-sm text-gray-500">{{ $order->user?->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Pembayaran</p>
                <p class="text-2xl font-bold text-violet-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Status</p>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    @if ($order->status === 'selesai') bg-green-100 text-green-600
                    @elseif ($order->status === 'dikirim') bg-blue-100 text-blue-600
                    @elseif ($order->status === 'diproses') bg-yellow-100 text-yellow-600
                    @elseif ($order->status === 'pending') bg-gray-100 text-gray-600
                    @elseif ($order->status === 'dibatalkan') bg-red-100 text-red-600
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        @if ($order->shipping_address || $order->phone || $order->notes)
        <div class="mt-6 pt-6 border-t border-gray-100">
            <h3 class="font-semibold mb-3">Informasi Pengiriman</h3>
            <div class="space-y-2 text-sm">
                @if ($order->shipping_address)
                    <p><span class="text-gray-500">Alamat:</span> {{ $order->shipping_address }}</p>
                @endif
                @if ($order->phone)
                    <p><span class="text-gray-500">Telepon:</span> {{ $order->phone }}</p>
                @endif
                @if ($order->notes)
                    <p><span class="text-gray-500">Catatan:</span> {{ $order->notes }}</p>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold">Item Pesanan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">Produk</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Qty</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Harga</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach ($order->items as $item)
                    <tr>
                        <td class="p-4">{{ $item->product_name }}</td>
                        <td class="p-4">{{ $item->quantity }}</td>
                        <td class="p-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="p-4 font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 border-t">
                    <tr>
                        <td colspan="3" class="p-4 text-right font-semibold">Total:</td>
                        <td class="p-4 font-bold text-violet-600">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@append
