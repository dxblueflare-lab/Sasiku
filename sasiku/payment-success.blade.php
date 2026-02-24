@extends('layouts.home', ['title' => 'Pembayaran Berhasil | SASIKU'])

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Success Header -->
    <div class="text-center mb-12">
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i data-lucide="check" class="w-12 h-12 text-green-600"></i>
        </div>
        <h1 class="text-3xl font-bold mb-2">Pembayaran Berhasil!</h1>
        <p class="text-gray-600">Terima kasih. Pesanan Anda sedang kami proses</p>
    </div>

    <!-- Order Confirmation -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="p-6 bg-gradient-to-r from-green-500 to-emerald-600 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-white/80 text-sm mb-1">Nomor Pesanan</p>
                    <p class="text-2xl font-bold font-mono">#{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-4 py-2 bg-white/20 rounded-full text-sm font-medium">
                        <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                        Sudah Dibayar
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <h3 class="font-bold text-lg mb-4">Detail Pesanan</h3>

            <!-- Items -->
            <div class="space-y-4 mb-6">
                @foreach($order->items as $item)
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl">
                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i data-lucide="package" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium">{{ $item->product_name }}</h4>
                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <p class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>

            <!-- Shipping Info -->
            <div class="border-t border-gray-100 pt-6 mb-6">
                <h4 class="font-medium mb-3">Informasi Pengiriman</h4>
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="grid md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Nama Penerima</p>
                            <p class="font-medium">{{ $order->shipping_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Telepon</p>
                            <p class="font-medium">{{ $order->shipping_phone ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-500">Alamat</p>
                            <p class="font-medium">{{ $order->shipping_address ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="border-t border-gray-100 pt-6 mb-6">
                <h4 class="font-medium mb-3">Ringkasan Pembayaran</h4>
                <div class="bg-green-50 rounded-xl p-4">
                    <div class="max-w-xs ml-auto space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Ongkos Kirim</span>
                            <span>{{ $order->shipping_cost == 0 ? 'Gratis' : 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-green-600">
                            <span>Status Pembayaran</span>
                            <span class="font-medium">Lunas</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-2 border-t border-green-200">
                            <span>Total Dibayar</span>
                            <span class="text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="border-t border-gray-100 pt-6">
                <h4 class="font-medium mb-3">Langkah Selanjutnya</h4>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-purple-600 font-bold text-sm">1</span>
                        </div>
                        <div>
                            <p class="font-medium">Konfirmasi Pesanan</p>
                            <p class="text-sm text-gray-500">Kami akan mengonfirmasi pesanan Anda dalam 1x24 jam</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-purple-600 font-bold text-sm">2</span>
                        </div>
                        <div>
                            <p class="font-medium">Pengemasan</p>
                            <p class="text-sm text-gray-500">Produk akan dikemas dengan hati-hati</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-purple-600 font-bold text-sm">3</span>
                        </div>
                        <div>
                            <p class="font-medium">Pengiriman</p>
                            <p class="text-sm text-gray-500">Pesanan akan dikirim ke alamat tujuan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="{{ route('customer.orders.show', $order) }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-200 rounded-xl font-medium hover:bg-gray-50 transition-colors">
            <i data-lucide="eye" class="w-5 h-5 mr-2"></i>
            Lihat Detail Pesanan
        </a>
        <a href="{{ route('customer.orders') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-200 rounded-xl font-medium hover:bg-gray-50 transition-colors">
            <i data-lucide="list" class="w-5 h-5 mr-2"></i>
            Daftar Pesanan Saya
        </a>
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
            <i data-lucide="shopping-bag" class="w-5 h-5 mr-2"></i>
            Belanja Lagi
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Clear cart after successful payment
    localStorage.removeItem('sasiku_cart');
});
</script>
@endpush
