@extends('layouts.home')

@section('title', 'SASIKU - Belanja Harian Jadi Elegan')

@push('styles')
<style>
/* SASIKU Animation Styles */
.sasiku-animation-container {
    position: relative;
    width: 500px;
    height: 400px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

/* Logo SASIKU */
.sasiku-animation-container .logo-gif {
    font-size: 80px;
    font-weight: 800;
    position: relative;
    z-index: 10;
}

.sasiku-animation-container .logo-text {
    background: linear-gradient(135deg, #667eea, #764ba2, #f093fb, #f5576c);
    background-size: 500% 500%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: holographic 3s ease infinite;
    font-family: 'Space Grotesk', sans-serif;
    margin-top: -40px; /* Geser ke atas */
}

/* Orbiting Icons (Mewakili kategori) */
.sasiku-animation-container .category-icon {
    position: absolute;
    font-size: 40px;
    filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
    animation: orbit 10s linear infinite;
}

/* Penempatan & Animasi Ikon Spesifik */
.sasiku-animation-container .icon-commodity { animation-delay: 0s; }
.sasiku-animation-container .icon-transport { animation-delay: -2s; }
.sasiku-animation-container .icon-hotel { animation-delay: -4s; }
.sasiku-animation-container .icon-kitchen { animation-delay: -6s; }
.sasiku-animation-container .icon-elec { animation-delay: -8s; }

@keyframes orbit {
    from { transform: rotate(0deg) translateX(180px) translateY(-40px) rotate(0deg); }
    to { transform: rotate(360deg) translateX(180px) translateY(-40px) rotate(-360deg); }
}

@keyframes holographic {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.sasiku-animation-container .tagline {
    margin-top: 30px;
    font-size: 14px;
    color: #888;
    letter-spacing: 0.3em;
    text-transform: uppercase;
    font-family: 'Space Grotesk', sans-serif;
}

/* Align Sasiku logo with text */
.hero-section-align {
    display: flex;
    align-items: center;
    min-height: 500px;
    gap: 2rem;
}

.text-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
    flex: 1;
}

.logo-content {
    display: flex;
    justify-content: center;
    align-items: center;
    flex: 1;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .hero-section-align {
        min-height: auto;
        padding: 2rem 0;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .sasiku-animation-container {
        width: 350px;
        height: 300px;
    }
    .sasiku-animation-container .logo-gif {
        font-size: 60px;
    }
    .sasiku-animation-container .category-icon {
        font-size: 30px;
    }
    @keyframes orbit {
        from { transform: rotate(0deg) translateX(130px) rotate(0deg); }
        to { transform: rotate(360deg) translateX(130px) rotate(-360deg); }
    }
    
    /* On mobile, stack elements vertically */
    .hero-section-align {
        flex-direction: column;
        text-align: center;
    }
    
    .text-content {
        padding-bottom: 2rem;
    }
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="pt-11 pb-14 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="hero-section-align">
        <div class="text-content flex-1">
            <div class="space-y-8 animate-slide-up">
                <h1 class="text-5xl md:text-7xl font-bold leading-tight brand-font poppins-font">
                    Belanja Harian<br>
                    <span class="solid-text">Menyenangkan</span>✨
                </h1>

                <p class="text-lg text-gray-600 max-w-lg leading-relaxed">
                    Temukan kebutuhan harianmu dengan pengalaman belanja modern.
                    Dari sayur segar hingga snack kekinian, semua ada di Sasiku.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#products" class="px-8 py-4 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-full font-semibold hover:shadow-lg hover:shadow-purple-500/30 transform hover:-translate-y-1 transition-all flex items-center space-x-2">
                        <span>Mulai Belanja</span>
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                    <a href="http://localhost/penginapan.html" class="px-8 py-4 bg-white text-gray-800 rounded-full font-semibold border border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all flex items-center space-x-2">
                        <i data-lucide="hotel" class="w-5 h-5"></i>
                        <span>Sasiku Hotel</span>
                    </a>
                    <a href="http://localhost/travel.html" class="px-8 py-4 bg-white text-gray-800 rounded-full font-semibold border border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all flex items-center space-x-2">
                        <i data-lucide="plane" class="w-5 h-5"></i>
                        <span>Sasiku Travel</span>
                    </a>
					<a href="http://localhost/travel.html" class="px-8 py-4 bg-white text-gray-800 rounded-full font-semibold border border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all flex items-center space-x-2">
                        <i data-lucide="store" class="w-5 h-5"></i>
                        <span>Sasiku Food</span>
                    </a>
					<a href="http://localhost/travel.html" class="px-8 py-4 bg-white text-gray-800 rounded-full font-semibold border border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all flex items-center space-x-2">
                        <i data-lucide="truck" class="w-5 h-5"></i>
                        <span>Sasiku Kirim</span>
                    </a>
					<a href="http://localhost/travel.html" class="px-8 py-4 bg-white text-gray-800 rounded-full font-semibold border border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all flex items-center space-x-2">
                        <i data-lucide="phone" class="w-5 h-5"></i>
                        <span>Digital Payment</span>
                    </a>
					<a href="http://localhost/kdmp/index.html" class="px-8 py-4 bg-white text-gray-800 rounded-full font-semibold border border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all flex items-center space-x-2">
                        <i data-lucide="phone" class="w-5 h-5"></i>
                        <span>KDKMP</span>
                    </a>
                    @guest
					<a href="{{ route('register') }}" class="px-8 py-4 bg-white text-gray-800 rounded-full font-semibold border border-gray-200 hover:border-purple-300 hover:shadow-lg transition-all flex items-center space-x-2">
                        <i data-lucide="circle" class="w-5 h-5"></i>
                        <span>Daftar Sekarang</span>
                    </a>
                    @endguest
                </div>
				
                <div class="flex items-center space-x-8 pt-4">
                    <div>
                        <p class="text-3xl font-bold brand-font gradient-text">{{ $products->count() }}+</p>
                        <p class="text-sm text-gray-500">Produk</p>
                    </div>
                    <div class="w-px h-12 bg-gray-200"></div>
                    <div>
                        <p class="text-3xl font-bold brand-font gradient-text">30min</p>
                        <p class="text-sm text-gray-500">Pengiriman</p>
                    </div>
                    <div class="w-px h-12 bg-gray-200"></div>
                    <div>
                        <p class="text-3xl font-bold brand-font gradient-text">4.9</p>
                        <p class="text-sm text-gray-500">Rating</p>
                    </div>
                </div>

                <div class="inline-flex items-center space-x-2 px-4 py-2 bg-white/60 rounded-full border border-purple-100 shadow-sm">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    <span class="text-sm font-medium text-gray-600">Gratis Ongkir Hari Ini</span>
                </div>
            </div>
        </div>

        <div class="logo-content">
            <!-- SASIKU Animated Logo -->
            <div class="sasiku-animation-container">
                <div class="category-icon icon-commodity">🍎</div>
                <div class="category-icon icon-transport">✈️</div>
                <div class="category-icon icon-hotel">🏨</div>
                <div class="category-icon icon-kitchen">🍳</div>
                <div class="category-icon icon-elec">📱</div>

                <div class="logo-gif">
                    <div class="logo-text">SASIKU</div>
                </div>
                <div class="tagline">All-in-One Lifestyle</div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="flex overflow-x-auto pb-4 space-x-4 scrollbar-hide" id="categories">
        @foreach($categories as $category)
            <a href="{{ route('home', ['category' => $category->slug]) }}"
               class="category-pill flex items-center space-x-2 px-6 py-3 bg-white rounded-full border border-gray-200 whitespace-nowrap transition-all hover:border-purple-300 {{ $categorySlug === $category->slug ? 'active' : '' }}">
                <i data-lucide="{{ $category->icon }}" class="w-4 h-4"></i>
                <span class="font-medium text-sm">{{ $category->name }}</span>
            </a>
        @endforeach
    </div>
</section>

<!-- Flash Sale -->
<section class="py-6 px-8 sm:px-8 lg:px-8 max-w-2xl mx-auto">
    <div class="bg-gradient-to-r from-violet-600 via-purple-600 to-pink-600 rounded-2xl p-4 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-30 h-30 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-xl"></div>
        <div class="absolute bottom-0 left-0 w-30 h-24 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2 blur-xl"></div>

        <div class="relative z-10 flex flex-col items-center text-center gap-2">
            <div class="inline-flex items-center space-x-2 bg-white/20 px-3 py-1 rounded-full text-xs mb-1">
                <i data-lucide="zap" class="w-3 h-3"></i>
                <span>Flash Sale</span>
            </div>
            <h2 class="text-lg md:text-xl font-bold brand-font">Diskon Spesial Hari Ini</h2>
            <p class="text-purple-100 text-xs">Jangan sampai kehabisan!</p>
            
            <div class="flex space-x-1 text-center mt-2">
                <div class="bg-white/20 backdrop-blur rounded-lg p-1 min-w-[45px]">
                    <p class="text-base font-bold" id="hours">00</p>
                    <p class="text-[0.5rem] uppercase tracking-wider">Jam</p>
                </div>
                <div class="bg-white/20 backdrop-blur rounded-lg p-1 min-w-[45px]">
                    <p class="text-base font-bold" id="minutes">00</p>
                    <p class="text-[0.5rem] uppercase tracking-wider">Menit</p>
                </div>
                <div class="bg-white/20 backdrop-blur rounded-lg p-1 min-w-[45px]">
                    <p class="text-base font-bold" id="seconds">00</p>
                    <p class="text-[0.5rem] uppercase tracking-wider">Detik</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section id="products" class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-bold brand-font mb-2">Produk Populer</h2>
            <p class="text-gray-500">Pilihan terbaik untuk kebutuhan harianmu</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="products-grid">
        @foreach($products as $product)
            <div class="product-card group">
                <div class="relative overflow-hidden">
                    <img src="{{ $product->image_url }}"
                         alt="{{ $product->name }}"
                         class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500">
                    @if($product->badge)
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur rounded-full text-xs font-semibold text-purple-600 shadow-sm">
                                {{ $product->badge }}
                            </span>
                        </div>
                    @endif
                    <button onclick="addToCart({{ $product->id }}, {{ \Illuminate\Support\Js::from($product->name) }}, {{ $product->price }}, {{ \Illuminate\Support\Js::from($product->image_url) }})"
                            class="absolute bottom-4 right-4 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center transform translate-y-16 group-hover:translate-y-0 transition-transform duration-300 hover:bg-purple-600 hover:text-white">
                        <i data-lucide="plus" class="w-6 h-6"></i>
                    </button>
                </div>
                <div class="p-5">
                    <div class="flex items-center space-x-1 mb-2">
                        <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-current"></i>
                        <span class="text-sm font-medium text-gray-600">{{ number_format($product->rating, 1) }}</span>
                        <span class="text-xs text-gray-400">({{ $product->review_count }})</span>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-gray-900 line-clamp-1">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-bold gradient-text">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            @if($product->original_price)
                                <p class="text-sm text-gray-400 line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Features -->
<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white rounded-3xl p-8 border border-purple-50 hover:border-purple-200 transition-colors group">
            <div class="w-14 h-14 bg-gradient-to-br from-violet-100 to-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <i data-lucide="truck" class="w-7 h-7 text-violet-600"></i>
            </div>
            <h3 class="text-xl font-bold mb-3 brand-font">Pengiriman Cepat</h3>
            <p class="text-gray-500 leading-relaxed">Pesananmu sampai dalam 30 menit dengan jaminan kesegaran produk.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 border border-purple-50 hover:border-purple-200 transition-colors group">
            <div class="w-14 h-14 bg-gradient-to-br from-pink-100 to-rose-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <i data-lucide="shield-check" class="w-7 h-7 text-pink-600"></i>
            </div>
            <h3 class="text-xl font-bold mb-3 brand-font">Kualitas Terjamin</h3>
            <p class="text-gray-500 leading-relaxed">Semua produk melalui kurasi ketat dan sertifikasi kualitas.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 border border-purple-50 hover:border-purple-200 transition-colors group">
            <div class="w-14 h-14 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <i data-lucide="headphones" class="w-7 h-7 text-amber-600"></i>
            </div>
            <h3 class="text-xl font-bold mb-3 brand-font">Support 24/7</h3>
            <p class="text-gray-500 leading-relaxed">Tim kami siap membantu kapan saja dengan respons super cepat.</p>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto mb-16">
    <div class="bg-gray-900 rounded-3xl p-8 md:p-16 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-20">
            <div class="absolute top-10 left-10 w-32 h-32 bg-purple-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-32 h-32 bg-pink-500 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-2xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 brand-font">Dapatkan Update Eksklusif</h2>
            <p class="text-gray-400 mb-8">Langganan newsletter kami untuk dapatkan promo dan tips gaya hidup modern.</p>

            <form class="flex flex-col sm:flex-row gap-4">
                <input type="email" placeholder="Masukkan email kamu"
                    class="flex-1 px-6 py-4 rounded-full bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:border-purple-400 transition-colors">
                <button type="submit" class="px-8 py-4 bg-gradient-to-r from-violet-500 to-pink-500 text-white rounded-full font-semibold hover:shadow-lg hover:shadow-purple-500/30 transition-all whitespace-nowrap">
                    Berlangganan
                </button>
            </form>
        </div>
    </div>
    
    <!-- Gambar Pendaftaran di pojok kiri bawah -->
    <div class="fixed bottom-4 left-4 z-50">
        <img src="{{ asset('img/ebook.png') }}" alt="Ebook" class="w-20 h-20 object-contain">
    </div>
    
    <!-- Gambar Ebook di pojok kanan bawah -->
    <!--<div class="fixed bottom-4 right-4 z-50">
        <img src="{{ asset('img/ebook.png') }}" alt="Ebook" class="w-20 h-20 object-contain">
    </div>--!>
    
    <!-- Toggle WhatsApp di sebelah kanan tengah -->
    <div class="fixed right-4 bottom-4 z-50">
        <a href="https://wa.me/6281336674687" target="_blank" class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-lg flex items-center justify-center transition-all duration-300 relative">
            <i data-lucide="message-circle" class="w-8 h-8"></i>
            <span class="absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 bg-white text-green-500 text-[0.7rem] rounded-full w-4 h-4 flex items-center justify-center font-bold">W</span>
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Products data for cart functionality
    const products = {!! $products->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'price' => (float) $p->price, 'image' => $p->image_url])->toJson() !!};

    // Cart state
    let cart = JSON.parse(localStorage.getItem('sasiku_cart')) || [];

    // Cart Functions
    function addToCart(id, name, price, image) {
        // Convert price to number
        price = parseFloat(price);

        const existingItem = cart.find(item => item.id === id);

        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.push({ id, name, price, image, quantity: 1 });
        }

        saveCart();
        updateCart();
        showToast(name + ' ditambahkan ke keranjang');

        // Animate badge
        const badge = document.getElementById('cart-badge');
        badge.classList.add('badge-bounce');
        setTimeout(() => badge.classList.remove('badge-bounce'), 300);
    }

    function removeFromCart(productId) {
        cart = cart.filter(item => item.id !== productId);
        saveCart();
        updateCart();
    }

    function updateQuantity(productId, change) {
        const item = cart.find(item => item.id === productId);
        if (item) {
            item.quantity += change;
            if (item.quantity <= 0) {
                removeFromCart(productId);
            } else {
                saveCart();
                updateCart();
            }
        }
    }

    function saveCart() {
        localStorage.setItem('sasiku_cart', JSON.stringify(cart));
    }

    function updateCart() {
        const badge = document.getElementById('cart-badge');
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);

        if (totalItems > 0) {
            badge.textContent = totalItems;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }

        renderCartItems();
    }

    function renderCartItems() {
        const container = document.getElementById('cart-items');
        const totalElement = document.getElementById('cart-total');

        if (cart.length === 0) {
            container.innerHTML = `
                <div class="text-center text-gray-400 mt-20">
                    <i data-lucide="shopping-bag" class="w-16 h-16 mx-auto mb-4 opacity-30"></i>
                    <p>Keranjang masih kosong</p>
                </div>
            `;
            totalElement.textContent = 'Rp 0';
        } else {
            container.innerHTML = cart.map(item => `
                <div class="flex gap-4 mb-6 bg-gray-50 p-4 rounded-2xl">
                    <img src="${item.image}" class="w-20 h-20 object-cover rounded-xl">
                    <div class="flex-1">
                        <h4 class="font-semibold text-sm mb-1">${item.name}</h4>
                        <p class="text-purple-600 font-bold">Rp ${item.price.toLocaleString('id-ID')}</p>
                        <div class="flex items-center mt-2 space-x-3">
                            <button onclick="updateQuantity(${item.id}, -1)" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:border-purple-400 transition-colors">
                                <i data-lucide="minus" class="w-4 h-4"></i>
                            </button>
                            <span class="font-medium w-4 text-center">${item.quantity}</span>
                            <button onclick="updateQuantity(${item.id}, 1)" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:border-purple-400 transition-colors">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                    <button onclick="removeFromCart(${item.id})" class="text-gray-400 hover:text-red-500 transition-colors">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                </div>
            `).join('');

            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            totalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        // Reinitialize icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function toggleCart() {
        const sidebar = document.getElementById('cart-sidebar');
        const panel = document.getElementById('cart-panel');

        if (sidebar.classList.contains('hidden')) {
            sidebar.classList.remove('hidden');
            setTimeout(() => {
                panel.classList.remove('translate-x-full');
            }, 10);
        } else {
            panel.classList.add('translate-x-full');
            setTimeout(() => {
                sidebar.classList.add('hidden');
            }, 300);
        }
    }

    function showToast(message) {
        const toast = document.getElementById('toast');
        document.getElementById('toast-message').textContent = message;

        toast.classList.remove('translate-y-20', 'opacity-0');

        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    }

    // Countdown Timer
    function updateCountdown() {
        const now = new Date();
        const endOfDay = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59);
        const diff = endOfDay - now;

        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateCart();
        setInterval(updateCountdown, 1000);
        updateCountdown();

        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && document.querySelector(href)) {
                    e.preventDefault();
                    document.querySelector(href).scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    });
</script>
@endpush
