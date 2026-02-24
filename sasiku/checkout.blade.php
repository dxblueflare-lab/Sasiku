@extends('layouts.home', ['title' => 'Checkout | SASIKU'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Checkout</h1>
        <p class="text-gray-600">Lengkapi informasi pengiriman pesanan Anda</p>
    </div>

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
        <div class="flex items-center">
            <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 mr-2"></i>
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}">
                @csrf

                <!-- Shipping Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h2 class="text-lg font-bold mb-4 flex items-center">
                        <i data-lucide="map-pin" class="w-5 h-5 mr-2 text-purple-600"></i>
                        Informasi Pengiriman
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Penerima <span class="text-red-500">*</span></label>
                            <input type="text" id="shipping_name" name="shipping_name" value="{{ old('shipping_name', $user->name ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                                   placeholder="Masukkan nama penerima" required>
                        </div>

                        <div>
                            <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="text" id="shipping_phone" name="shipping_phone" value="{{ old('shipping_phone', $user->phone ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors"
                                   placeholder="08xxxxxxxxxx" required>
                        </div>

                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea id="shipping_address" name="shipping_address" rows="3"
                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors resize-none"
                                      placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota/kabupaten, kode pos" required>{{ old('shipping_address', $user->address ?? '') }}</textarea>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea id="notes" name="notes" rows="2"
                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors resize-none"
                                      placeholder="Patokan, instruksi khusus, dll.">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Cart Items Summary -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold mb-4 flex items-center">
                        <i data-lucide="shopping-cart" class="w-5 h-5 mr-2 text-purple-600"></i>
                        Ringkasan Pesanan
                    </h2>
                    <div id="checkout-items" class="space-y-4">
                        <div class="text-center text-gray-400 py-8">
                            <i data-lucide="shopping-bag" class="w-12 h-12 mx-auto mb-2 opacity-30"></i>
                            <p>Memuat keranjang...</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h2 class="text-lg font-bold mb-4">Total Pembayaran</h2>

                <div class="space-y-3 mb-6" id="order-summary">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span id="summary-subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Ongkos Kirim</span>
                        <span id="summary-shipping">Rp 0</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span id="summary-total" class="text-purple-600">Rp 0</span>
                    </div>
                </div>

                <!-- Free Shipping Info -->
                <div id="free-shipping-info" class="mb-6 p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 hidden">
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                        <span>Gratis ongkos kirim!</span>
                    </div>
                </div>

                <div id="need-more-info" class="mb-6 p-3 bg-purple-50 border border-purple-200 rounded-xl text-sm text-purple-700">
                    <div class="flex items-center">
                        <i data-lucide="info" class="w-4 h-4 mr-2"></i>
                        <span>Beli <span id="need-more-amount">Rp 0</span> lagi untuk gratis ongkir!</span>
                    </div>
                </div>

                <button type="submit" form="checkout-form" id="submit-btn"
                        class="w-full py-4 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                    <span id="submit-text">Buat Pesanan</span>
                    <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
                </button>

                <p class="text-xs text-gray-500 text-center mt-4">
                    Dengan membeli, Anda menyetujui Syarat & Ketentuan kami.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const FREE_SHIPPING_THRESHOLD = 500000;
const SHIPPING_COST = 15000;

// Get cart from localStorage
function getCart() {
    return JSON.parse(localStorage.getItem('sasiku_cart')) || [];
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Load checkout items from API
async function loadCheckoutItems() {
    const cart = getCart();

    if (cart.length === 0) {
        window.location.href = '{{ route('home') }}';
        return;
    }

    try {
        const response = await fetch('/api/cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cart })
        });

        if (!response.ok) {
            throw new Error('Failed to load cart');
        }

        const data = await response.json();
        renderCheckoutItems(data.items);
        updateOrderSummary(data.items);
        updateCartInput();

    } catch (error) {
        console.error('Error loading cart:', error);
        const container = document.getElementById('checkout-items');
        container.textContent = '';
        const errorMsg = document.createElement('p');
        errorMsg.className = 'text-center text-red-500 py-8';
        errorMsg.textContent = 'Gagal memuat keranjang. Silakan coba lagi.';
        container.appendChild(errorMsg);
    }
}

function renderCheckoutItems(items) {
    const container = document.getElementById('checkout-items');
    container.textContent = '';

    if (items.length === 0) {
        const emptyMsg = document.createElement('p');
        emptyMsg.className = 'text-center text-gray-400 py-8';
        emptyMsg.textContent = 'Keranjang kosong';
        container.appendChild(emptyMsg);
        return;
    }

    items.forEach(item => {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'flex items-center space-x-4 p-3 bg-gray-50 rounded-xl';

        const imgContainer = document.createElement('div');
        imgContainer.className = 'w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden';

        if (item.image) {
            const img = document.createElement('img');
            img.src = item.image;
            img.className = 'w-full h-full object-cover';
            img.alt = escapeHtml(item.name);
            imgContainer.appendChild(img);
        } else {
            const icon = document.createElement('i');
            icon.setAttribute('data-lucide', 'package');
            icon.className = 'w-8 h-8 text-gray-400';
            imgContainer.appendChild(icon);
        }

        const infoDiv = document.createElement('div');
        infoDiv.className = 'flex-1 min-w-0';

        const nameEl = document.createElement('h4');
        nameEl.className = 'font-medium text-sm text-gray-900 truncate';
        nameEl.textContent = item.name;

        const qtyEl = document.createElement('p');
        qtyEl.className = 'text-xs text-gray-500';
        qtyEl.textContent = item.quantity + ' x Rp ' + item.price.toLocaleString('id-ID');

        infoDiv.appendChild(nameEl);
        infoDiv.appendChild(qtyEl);

        const priceEl = document.createElement('p');
        priceEl.className = 'font-semibold text-purple-600';
        priceEl.textContent = 'Rp ' + item.subtotal.toLocaleString('id-ID');

        itemDiv.appendChild(imgContainer);
        itemDiv.appendChild(infoDiv);
        itemDiv.appendChild(priceEl);
        container.appendChild(itemDiv);
    });

    // Reinitialize icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

function updateOrderSummary(items) {
    const subtotal = items.reduce(function(sum, item) {
        return sum + (item.price * item.quantity);
    }, 0);
    const shippingCost = subtotal >= FREE_SHIPPING_THRESHOLD ? 0 : SHIPPING_COST;
    const total = subtotal + shippingCost;

    document.getElementById('summary-subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');

    const shippingEl = document.getElementById('summary-shipping');
    if (shippingCost === 0) {
        shippingEl.innerHTML = '<span class="text-green-600">Gratis</span>';
    } else {
        shippingEl.textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
    }

    document.getElementById('summary-total').textContent = 'Rp ' + total.toLocaleString('id-ID');

    // Update free shipping info
    const freeShippingInfo = document.getElementById('free-shipping-info');
    const needMoreInfo = document.getElementById('need-more-info');

    if (subtotal >= FREE_SHIPPING_THRESHOLD) {
        freeShippingInfo.classList.remove('hidden');
        needMoreInfo.classList.add('hidden');
    } else {
        freeShippingInfo.classList.add('hidden');
        needMoreInfo.classList.remove('hidden');
        document.getElementById('need-more-amount').textContent =
            'Rp ' + (FREE_SHIPPING_THRESHOLD - subtotal).toLocaleString('id-ID');
    }
}

function updateCartInput() {
    const cart = getCart();
    const form = document.getElementById('checkout-form');

    // Remove existing cart input
    const existingInput = form.querySelector('input[name="cart"]');
    if (existingInput) {
        existingInput.remove();
    }

    // Add cart as hidden input
    const cartInput = document.createElement('input');
    cartInput.type = 'hidden';
    cartInput.name = 'cart';
    cartInput.value = JSON.stringify(cart);
    form.appendChild(cartInput);
}

// Form submission
document.getElementById('checkout-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');

    // Validate cart first
    try {
        const cart = getCart();
        const validateResponse = await fetch('/api/cart/validate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ cart })
        });

        const validateData = await validateResponse.json();

        if (!validateData.valid) {
            const unavailableNames = validateData.unavailable.map(function(item) {
                return item.name;
            }).join(', ');
            alert('Beberapa produk tidak tersedia:\n' + unavailableNames);
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitText.textContent = 'Memproses...';

        // Prepare form data as object
        const formData = {
            shipping_name: document.getElementById('shipping_name').value,
            shipping_phone: document.getElementById('shipping_phone').value,
            shipping_address: document.getElementById('shipping_address').value,
            notes: document.getElementById('notes').value,
            cart: cart
        };

        // Submit form using fetch
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        if (response.ok) {
            // Get the redirect URL from response or check for success
            const data = await response.json();
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                // Fallback - reload page to show success/error
                window.location.href = this.action;
            }
        } else {
            // Handle error
            const error = await response.json();
            if (error.message) {
                alert(error.message);
            } else {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
            submitBtn.disabled = false;
            submitText.textContent = 'Buat Pesanan';
        }

    } catch (error) {
        console.error('Submission error:', error);
        submitBtn.disabled = false;
        submitText.textContent = 'Buat Pesanan';
        alert('Terjadi kesalahan. Silakan coba lagi.');
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Check if cart exists first
    const cart = getCart();
    console.log('Cart on checkout page:', cart);

    if (cart.length === 0) {
        // Show empty cart message instead of redirect
        const container = document.getElementById('checkout-items');
        if (container) {
            container.innerHTML = `
                <div class="text-center py-12">
                    <i data-lucide="shopping-cart" class="w-16 h-16 mx-auto mb-4 text-gray-300"></i>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Keranjang Kosong</h3>
                    <p class="text-gray-500 mb-6">Tambahkan produk ke keranjang terlebih dahulu</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        <span>Mulai Belanja</span>
                    </a>
                </div>
            `;
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
        // Disable checkout button
        const submitBtn = document.getElementById('submit-btn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Keranjang Kosong';
        }
    } else {
        loadCheckoutItems();
    }
});
</script>
@endpush
