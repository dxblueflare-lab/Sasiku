@extends('layouts.admin', ['title' => 'Kelola Pesanan | SASIKU Admin', 'header' => 'Kelola Pesanan'])

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold">Daftar Pesanan</h2>
        <p class="text-gray-500 text-sm">Kelola semua pesanan masuk</p>
    </div>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">No. Pesanan</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Pelanggan</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Total</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 font-medium">{{ $order->order_number }}</td>
                    <td class="p-4">{{ $order->user?->name ?? '-' }}</td>
                    <td class="p-4 font-medium">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if ($order->status === 'selesai') bg-green-100 text-green-600
                            @elseif ($order->status === 'dikirim') bg-blue-100 text-blue-600
                            @elseif ($order->status === 'diproses') bg-yellow-100 text-yellow-600
                            @elseif ($order->status === 'pending') bg-gray-100 text-gray-600
                            @elseif ($order->status === 'dibatalkan') bg-red-100 text-red-600
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="p-4">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

            @if ($orders->hasPages())
            <tfoot class="bg-gray-50 border-t">
                <tr>
                    <td colspan="6" class="p-4">
                        {{ $orders->links() }}
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@append
