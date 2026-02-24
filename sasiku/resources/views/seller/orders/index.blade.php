@extends('layouts.seller', ['title' => 'Pesanan | SASIKU', 'header' => 'Daftar Pesanan'])

@section('content')
<!-- Stats Cards -->
<section class="grid md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Total Pesanan</h3>
                <p class="text-3xl font-bold mt-1">{{ $orders->total() }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i data-lucide="shopping-cart" class="w-6 h-6 text-purple-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Pending</h3>
                <p class="text-3xl font-bold mt-1">{{ $statusCounts['pending'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i data-lucide="clock" class="w-6 h-6 text-yellow-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Diproses</h3>
                <p class="text-3xl font-bold mt-1">{{ $statusCounts['processing'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i data-lucide="package" class="w-6 h-6 text-blue-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Selesai</h3>
                <p class="text-3xl font-bold mt-1">{{ $statusCounts['completed'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6 text-green-600"></i>
            </div>
        </div>
    </div>
</section>

<!-- Orders Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">No. Pesanan</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Pelanggan</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Total</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-center">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4">
                        <span class="font-mono text-sm font-semibold text-purple-600">#{{ $order->order_number ?? $order->id }}</span>
                    </td>
                    <td class="p-4">
                        <div>
                            <p class="font-medium text-gray-900">{{ $order->user->name ?? '-' }}</p>
                            <p class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</p>
                        </div>
                    </td>
                    <td class="p-4">
                        <p class="font-semibold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </td>
                    <td class="p-4 text-center">
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
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</p>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('seller.orders.show', $order) }}" class="px-3 py-2 text-sm bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition-colors">
                                Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-12">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="shopping-cart" class="w-10 h-10 text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada pesanan</h3>
                            <p class="text-gray-500">Pesanan dari pelanggan akan muncul di sini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($orders->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
