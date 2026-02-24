@extends('layouts.customer', ['title' => 'Pesanan Saya | SASIKU'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Pesanan Saya</h1>
        <p class="text-gray-600">Riwayat pesanan belanja Anda</p>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-4 text-sm font-semibold text-gray-600">No. Pesanan</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="p-4 text-sm font-semibold text-gray-600">Total</th>
                        <th class="p-4 text-sm font-semibold text-gray-600 text-center">Status</th>
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
                            <p class="text-gray-900">{{ $order->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</p>
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
                        <td class="p-4 text-right">
                            <a href="{{ route('customer.orders.show', $order) }}" class="text-purple-600 hover:text-purple-700 font-medium">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i data-lucide="shopping-cart" class="w-10 h-10 text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada pesanan</h3>
                                <p class="text-gray-500 mb-6">Mulai belanja dan nikmati pengalaman belanja yang mudah!</p>
                                <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                                    <span>Mulai Belanja</span>
                                </a>
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
</div>
@endsection
