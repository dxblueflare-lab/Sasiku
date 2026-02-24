@extends('layouts.admin', ['title' => 'Laporan | SASIKU Admin', 'header' => 'Laporan'])

@section('content')
<!-- Download Menu -->
<div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-bold mb-4">Unduh Laporan</h3>
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('admin.reports.orders.download') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
            Unduh Laporan Pesanan (.xls)
        </a>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Produk</p>
                <h2 class="text-3xl font-bold mt-1">{{ $stats['total_products'] }}</h2>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i data-lucide="package" class="w-6 h-6 text-purple-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Pesanan</p>
                <h2 class="text-3xl font-bold mt-1">{{ $stats['total_orders'] }}</h2>
            </div>
            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                <i data-lucide="shopping-cart" class="w-6 h-6 text-pink-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Pendapatan</p>
                <h2 class="text-2xl font-bold mt-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h2>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i data-lucide="wallet" class="w-6 h-6 text-green-600"></i>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Pengguna</p>
                <h2 class="text-3xl font-bold mt-1">{{ $stats['total_users'] }}</h2>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <!-- Products by Category -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold mb-4">Produk per Kategori</h3>
        <div class="space-y-3">
            @foreach ($productsByCategory as $category)
            @if ($category->products_count > 0)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                <span class="font-medium">{{ $category->name }}</span>
                <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-medium">
                    {{ $category->products_count }} produk
                </span>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <!-- Users by Role -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold mb-4">Pengguna per Role</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full bg-purple-600"></div>
                    <span class="font-medium">Admin</span>
                </div>
                <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full text-sm font-medium">
                    {{ $usersByRole['admin'] }} pengguna
                </span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full bg-pink-600"></div>
                    <span class="font-medium">Seller</span>
                </div>
                <span class="px-3 py-1 bg-pink-100 text-pink-600 rounded-full text-sm font-medium">
                    {{ $usersByRole['seller'] }} pengguna
                </span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 rounded-full bg-violet-600"></div>
                    <span class="font-medium">Customer</span>
                </div>
                <span class="px-3 py-1 bg-violet-100 text-violet-600 rounded-full text-sm font-medium">
                    {{ $usersByRole['customer'] }} pengguna
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Orders by Status -->
<div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-bold mb-4">Status Pesanan</h3>
    <div class="grid grid-cols-5 gap-4">
        <div class="text-center p-4 bg-gray-50 rounded-xl">
            <p class="text-gray-500 text-sm mb-1">Pending</p>
            <p class="text-2xl font-bold text-gray-600">{{ $ordersByStatus['pending'] }}</p>
        </div>
        <div class="text-center p-4 bg-yellow-50 rounded-xl">
            <p class="text-yellow-600 text-sm mb-1">Diproses</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $ordersByStatus['diproses'] }}</p>
        </div>
        <div class="text-center p-4 bg-blue-50 rounded-xl">
            <p class="text-blue-600 text-sm mb-1">Dikirim</p>
            <p class="text-2xl font-bold text-blue-600">{{ $ordersByStatus['dikirim'] }}</p>
        </div>
        <div class="text-center p-4 bg-green-50 rounded-xl">
            <p class="text-green-600 text-sm mb-1">Selesai</p>
            <p class="text-2xl font-bold text-green-600">{{ $ordersByStatus['selesai'] }}</p>
        </div>
        <div class="text-center p-4 bg-red-50 rounded-xl">
            <p class="text-red-600 text-sm mb-1">Dibatalkan</p>
            <p class="text-2xl font-bold text-red-600">{{ $ordersByStatus['dibatalkan'] }}</p>
        </div>
    </div>
</div>
@append
