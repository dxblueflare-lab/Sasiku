@extends('layouts.customer', ['title' => 'Customer Dashboard | SASIKU'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-violet-500 to-pink-500 rounded-3xl p-8 mb-8 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ $user->name }}! 👋</h1>
            <p class="text-white/80">Siap untuk belanja kebutuhan harianmu dengan harga terbaik?</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <a href="{{ route('home') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow text-center group">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-200 transition-colors">
                <i data-lucide="shopping-bag" class="w-6 h-6 text-purple-600"></i>
            </div>
            <span class="font-medium text-gray-700">Belanja Sekarang</span>
        </a>
        <a href="{{ route('customer.orders') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow text-center group">
            <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-pink-200 transition-colors">
                <i data-lucide="package" class="w-6 h-6 text-pink-600"></i>
            </div>
            <span class="font-medium text-gray-700">Pesanan Saya</span>
        </a>
        <a href="{{ route('customer.favorites') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow text-center group">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-red-200 transition-colors">
                <i data-lucide="heart" class="w-6 h-6 text-red-600"></i>
            </div>
            <span class="font-medium text-gray-700">Favorit</span>
        </a>
        <a href="{{ route('customer.profile') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow text-center group">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-200 transition-colors">
                <i data-lucide="map-pin" class="w-6 h-6 text-blue-600"></i>
            </div>
            <span class="font-medium text-gray-700">Profil</span>
        </a>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-bold">Pesanan Terbaru</h2>
            <a href="{{ route('customer.orders') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">Lihat Semua</a>
        </div>

        @forelse ($recentOrders as $order)
        <div class="divide-y divide-gray-50">
            @foreach ($recentOrders as $order)
            <a href="{{ route('customer.orders.show', $order['id']) }}" class="block p-6 hover:bg-gray-50 transition-colors cursor-pointer">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i data-lucide="package" class="w-6 h-6 text-purple-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $order['order_number'] }}</p>
                            <p class="text-sm text-gray-500">{{ $order['date'] }} • {{ $order['items'] }} barang</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-lg">Rp {{ number_format($order['total'], 0, ',', '.') }}</p>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-medium
                            @if ($order['status'] === 'Selesai') bg-green-100 text-green-600
                            @elseif ($order['status'] === 'Dikirim') bg-blue-100 text-blue-600
                            @elseif ($order['status'] === 'Diproses') bg-yellow-100 text-yellow-600
                            @else bg-gray-100 text-gray-600
                            @endif">
                            {{ $order['status'] }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @empty
        <div class="p-12 text-center">
            <i data-lucide="shopping-cart" class="w-16 h-16 mx-auto mb-4 text-gray-300"></i>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada pesanan</h3>
            <p class="text-gray-500 mb-6">Mulai belanja sekarang dan nikmati pengalaman belanja yang mudah!</p>
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                <span>Mulai Belanja</span>
            </a>
        </div>
        @endforelse
    </div>

    <!-- Account Settings -->
    <div class="mt-8 grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold mb-4 flex items-center space-x-2">
                <i data-lucide="user" class="w-5 h-5 text-purple-600"></i>
                <span>Informasi Akun</span>
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-500">Nama</span>
                    <span class="font-medium">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-50">
                    <span class="text-gray-500">Email</span>
                    <span class="font-medium">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-500">Role</span>
                    <span class="px-2 py-1 bg-violet-100 text-violet-600 rounded-lg text-xs font-medium">Customer</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold mb-4 flex items-center space-x-2">
                <i data-lucide="shield" class="w-5 h-5 text-purple-600"></i>
                <span>Keamanan</span>
            </h3>
            <div class="space-y-3">
                <a href="#" class="flex items-center justify-between py-2 hover:bg-gray-50 rounded-lg px-2 -mx-2 transition-colors">
                    <span class="text-gray-700">Ubah Password</span>
                    <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
                </a>
                <a href="#" class="flex items-center justify-between py-2 hover:bg-gray-50 rounded-lg px-2 -mx-2 transition-colors">
                    <span class="text-gray-700">Two-Factor Authentication</span>
                    <i data-lucide="chevron-right" class="w-5 h-5 text-gray-400"></i>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex items-center justify-between py-2 hover:bg-red-50 rounded-lg px-2 -mx-2 transition-colors">
                    @csrf
                    <button type="submit" class="text-red-600 flex items-center space-x-2 flex-1 text-left">
                        <span>Keluar Akun</span>
                    </button>
                    <i data-lucide="log-out" class="w-5 h-5 text-red-400"></i>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
