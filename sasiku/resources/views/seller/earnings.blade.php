@extends('layouts.seller', ['title' => 'Pendapatan | SASIKU', 'header' => 'Pendapatan'])

@section('content')
<!-- Stats Cards -->
<section class="grid md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Pendapatan Hari Ini</h3>
                <p class="text-2xl font-bold mt-1 text-purple-600">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i data-lucide="trending-up" class="w-6 h-6 text-green-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Pendapatan Bulan Ini</h3>
                <p class="text-2xl font-bold mt-1 text-purple-600">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i data-lucide="calendar" class="w-6 h-6 text-blue-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-gray-500 text-sm">Total Pendapatan</h3>
                <p class="text-2xl font-bold mt-1 text-purple-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i data-lucide="wallet" class="w-6 h-6 text-purple-600"></i>
            </div>
        </div>
    </div>
</section>

<!-- Recent Transactions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h2 class="text-lg font-bold mb-6">Transaksi Terbaru</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">No. Pesanan</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Pelanggan</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($recentOrders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4">
                        <span class="font-mono text-sm font-semibold text-purple-600">#{{ $order->order_number ?? $order->id }}</span>
                    </td>
                    <td class="p-4">
                        <p class="font-medium text-gray-900">{{ $order->user->name ?? '-' }}</p>
                    </td>
                    <td class="p-4">
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </td>
                    <td class="p-4 text-right">
                        <p class="font-semibold text-green-600">+Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-12">
                        <div class="flex flex-col items-center justify-center text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="receipt" class="w-10 h-10 text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada transaksi</h3>
                            <p class="text-gray-500">Transaksi selesai akan muncul di sini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
