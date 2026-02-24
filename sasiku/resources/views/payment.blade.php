@extends('layouts.home', ['title' => 'Pembayaran | SASIKU'])

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <a href="{{ route('customer.orders.show', $order) }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali ke Detail Pesanan
        </a>
        <h1 class="text-3xl font-bold mb-2">Pembayaran</h1>
        <p class="text-gray-600">Selesaikan pembayaran untuk pesanan #{{ $order->order_number }}</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Payment Methods -->
        <div class="lg:col-span-2">
            <!-- Order Summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <h2 class="text-lg font-bold mb-4">Ringkasan Pesanan</h2>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="package" class="w-6 h-6 text-gray-400"></i>
                            </div>
                            <div>
                                <p class="font-medium text-sm">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <p class="font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold mb-4">Metode Pembayaran</h2>

                <!-- E-Wallet -->
                <div class="mb-6">
                    <h3 class="font-medium text-sm text-gray-600 mb-3">E-Wallet</h3>
                    <div class="space-y-3" id="ewallet-methods">
                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 hover:bg-purple-50/50 transition-all payment-method">
                            <input type="radio" name="payment_method" value="gopay" class="w-5 h-5 text-purple-600" required>
                            <div class="ml-4 flex items-center space-x-3 flex-1">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <span class="text-green-600 font-bold text-sm">Go</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">GoPay</p>
                                    <p class="text-xs text-gray-500">Scan QRIS untuk bayar</p>
                                </div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/512px-Gopay_logo.svg.png" alt="GoPay" class="h-6 object-contain">
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 hover:bg-purple-50/50 transition-all payment-method">
                            <input type="radio" name="payment_method" value="ovo" class="w-5 h-5 text-purple-600">
                            <div class="ml-4 flex items-center space-x-3 flex-1">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <span class="text-purple-600 font-bold text-sm">OVO</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">OVO</p>
                                    <p class="text-xs text-gray-500">Push notification untuk bayar</p>
                                </div>
                                <div class="w-12 h-6 bg-purple-600 rounded flex items-center justify-center">
                                    <span class="text-white font-bold text-xs">OVO</span>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 hover:bg-purple-50/50 transition-all payment-method">
                            <input type="radio" name="payment_method" value="dana" class="w-5 h-5 text-purple-600">
                            <div class="ml-4 flex items-center space-x-3 flex-1">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">DANA</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">DANA</p>
                                    <p class="text-xs text-gray-500">Scan QRIS untuk bayar</p>
                                </div>
                                <div class="w-12 h-6 bg-blue-600 rounded flex items-center justify-center">
                                    <span class="text-white font-bold text-xs">DANA</span>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 hover:bg-purple-50/50 transition-all payment-method">
                            <input type="radio" name="payment_method" value="shopeepay" class="w-5 h-5 text-purple-600">
                            <div class="ml-4 flex items-center space-x-3 flex-1">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <span class="text-orange-600 font-bold text-sm">SPay</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">ShopeePay</p>
                                    <p class="text-xs text-gray-500">Scan QRIS untuk bayar</p>
                                </div>
                                <div class="w-12 h-6 bg-orange-500 rounded flex items-center justify-center">
                                    <span class="text-white font-bold text-xs">SPay</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Virtual Account -->
                <div class="mb-6">
                    <h3 class="font-medium text-sm text-gray-600 mb-3">Virtual Account</h3>
                    <div class="space-y-3" id="va-methods">
                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 hover:bg-purple-50/50 transition-all payment-method">
                            <input type="radio" name="payment_method" value="bca_va" class="w-5 h-5 text-purple-600">
                            <div class="ml-4 flex items-center space-x-3 flex-1">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">BCA</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">BCA Virtual Account</p>
                                    <p class="text-xs text-gray-500">Transfer melalui ATM BCA</p>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 hover:bg-purple-50/50 transition-all payment-method">
                            <input type="radio" name="payment_method" value="mandiri_va" class="w-5 h-5 text-purple-600">
                            <div class="ml-4 flex items-center space-x-3 flex-1">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">MDR</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">Mandiri Bill</p>
                                    <p class="text-xs text-gray-500">Transfer melalui ATM Mandiri</p>
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 hover:bg-purple-50/50 transition-all payment-method">
                            <input type="radio" name="payment_method" value="bri_va" class="w-5 h-5 text-purple-600">
                            <div class="ml-4 flex items-center space-x-3 flex-1">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-sm">BRI</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">BRI Virtual Account</p>
                                    <p class="text-xs text-gray-500">Transfer melalui ATM BRI</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- QRIS -->
                <div>
                    <h3 class="font-medium text-sm text-gray-600 mb-3">QRIS</h3>
                    <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-purple-300 hover:bg-purple-50/50 transition-all payment-method">
                        <input type="radio" name="payment_method" value="qris" class="w-5 h-5 text-purple-600">
                        <div class="ml-4 flex items-center space-x-3 flex-1">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <i data-lucide="qr-code" class="w-5 h-5 text-red-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium">QRIS (All Payment)</p>
                                <p class="text-xs text-gray-500">Scan QRIS dengan aplikasi e-wallet atau mobile banking</p>
                            </div>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/512px-Logo_QRIS.svg.png" alt="QRIS" class="h-8 object-contain">
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h2 class="text-lg font-bold mb-4">Detail Pembayaran</h2>

                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Nomor Pesanan</span>
                        <span class="font-medium">#{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Ongkos Kirim</span>
                        <span>{{ $order->shipping_cost == 0 ? 'Gratis' : 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between text-lg font-bold">
                        <span>Total Pembayaran</span>
                        <span class="text-purple-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Expiry Notice -->
                <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-700 mb-6">
                    <div class="flex items-center">
                        <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                        <span>Selesaikan pembayaran dalam 23 jam 59 menit</span>
                    </div>
                </div>

                <button id="pay-button" onclick="processPayment()" class="w-full py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                    <span id="pay-text">Bayar Sekarang</span>
                    <i data-lucide="chevron-right" class="w-5 h-5 ml-2"></i>
                </button>

                <p class="text-xs text-gray-500 text-center mt-4">
                    Dengan melanjutkan, Anda menyetujui Syarat & Ketentuan pembayaran kami.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="payment-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closePaymentModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform transition-all">
            <!-- Processing State -->
            <div id="payment-processing" class="text-center">
                <div class="w-20 h-20 border-4 border-purple-200 border-t-purple-600 rounded-full animate-spin mx-auto mb-6"></div>
                <h3 class="text-xl font-bold mb-2">Memproses Pembayaran...</h3>
                <p class="text-gray-500">Mohon tunggu, jangan tutup halaman ini.</p>
            </div>

            <!-- QRIS State -->
            <div id="payment-qris" class="text-center hidden">
                <div class="w-48 h-48 mx-auto mb-6 p-4 bg-white border-2 border-gray-200 rounded-xl flex items-center justify-center">
                    <!-- Dummy QR Code -->
                    <div class="grid grid-cols-8 gap-1 w-full h-full">
                        @for($i = 0; $i < 64; $i++)
                        <div class="@if(rand(0,1)) bg-black @else bg-white @endif rounded-sm"></div>
                        @endfor
                    </div>
                </div>
                <h3 class="text-xl font-bold mb-2">Scan QRIS</h3>
                <p class="text-gray-500 mb-4">Scan QR code dengan aplikasi e-wallet atau mobile banking Anda</p>
                <div class="bg-gray-100 rounded-xl p-4 mb-4">
                    <p class="text-sm text-gray-500">Nominal Pembayaran</p>
                    <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
                <button onclick="simulatePayment()" class="w-full py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                    Simulasi Pembayaran Berhasil
                </button>
            </div>

            <!-- Success State -->
            <div id="payment-success" class="text-center hidden">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="check" class="w-10 h-10 text-green-600"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Pembayaran Berhasil!</h3>
                <p class="text-gray-500 mb-6">Pesanan Anda sedang diproses</p>
                <button onclick="redirectToSuccess()" class="w-full py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                    Lihat Detail Pesanan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let selectedPaymentMethod = null;

// Add click handlers for payment methods
document.querySelectorAll('.payment-method').forEach(function(element) {
    element.addEventListener('click', function() {
        // Remove selected class from all
        document.querySelectorAll('.payment-method').forEach(function(el) {
            el.classList.remove('border-purple-500', 'bg-purple-50');
            el.classList.add('border-gray-200');
        });

        // Add selected class to clicked
        this.classList.remove('border-gray-200');
        this.classList.add('border-purple-500', 'bg-purple-50');

        // Store selected method
        selectedPaymentMethod = this.querySelector('input[type="radio"]').value;

        // Enable pay button
        document.getElementById('pay-button').disabled = false;
    });
});

function processPayment() {
    if (!selectedPaymentMethod) {
        alert('Silakan pilih metode pembayaran terlebih dahulu');
        return;
    }

    const payButton = document.getElementById('pay-button');
    const payText = document.getElementById('pay-text');

    // Show modal
    document.getElementById('payment-modal').classList.remove('hidden');
    document.getElementById('payment-processing').classList.remove('hidden');
    document.getElementById('payment-qris').classList.add('hidden');
    document.getElementById('payment-success').classList.add('hidden');

    // Disable button
    payButton.disabled = true;
    payText.textContent = 'Memproses...';

    // Simulate processing delay
    setTimeout(function() {
        if (selectedPaymentMethod === 'gopay' || selectedPaymentMethod === 'ovo' ||
            selectedPaymentMethod === 'dana' || selectedPaymentMethod === 'shopeepay' ||
            selectedPaymentMethod === 'qris') {
            // Show QRIS for e-wallet payments
            document.getElementById('payment-processing').classList.add('hidden');
            document.getElementById('payment-qris').classList.remove('hidden');
        } else {
            // For VA payments, show success directly after delay
            completePayment();
        }
    }, 2000);
}

function simulatePayment() {
    completePayment();
}

function completePayment() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Call backend to update order
    fetch('{{ route("payment.process", $order) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            payment_method: selectedPaymentMethod,
            _token: csrfToken
        })
    })
    .then(function(response) {
        if (!response.ok) {
            return response.text().then(function(text) {
                throw new Error('Server error: ' + response.status);
            });
        }
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            // Show success state
            document.getElementById('payment-processing').classList.add('hidden');
            document.getElementById('payment-qris').classList.add('hidden');
            document.getElementById('payment-success').classList.remove('hidden');

            // Reinitialize icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        } else {
            throw new Error(data.message || 'Pembayaran gagal');
        }
    })
    .catch(function(error) {
        console.error('Payment error:', error);
        closePaymentModal();

        const payButton = document.getElementById('pay-button');
        const payText = document.getElementById('pay-text');
        payButton.disabled = false;
        payText.textContent = 'Bayar Sekarang';

        alert('Pembayaran gagal: ' + error.message);
    });
}

function closePaymentModal() {
    document.getElementById('payment-modal').classList.add('hidden');

    const payButton = document.getElementById('pay-button');
    const payText = document.getElementById('pay-text');
    payButton.disabled = false;
    payText.textContent = 'Bayar Sekarang';
}

function redirectToSuccess() {
    window.location.href = '{{ route("payment.success", $order) }}';
}
</script>
@endpush
