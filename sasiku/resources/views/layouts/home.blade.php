<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SASIKU - Belanja Harian Jadi Elegan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 overflow-x-hidden">
    <!-- Background Blobs -->
    <div class="blob bg-purple-400 w-96 h-96 rounded-full top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="blob bg-pink-400 w-80 h-80 rounded-full top-40 right-0 translate-x-1/2"></div>
    <div class="blob bg-amber-300 w-72 h-72 rounded-full bottom-0 left-1/3"></div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                    <img src="https://www.appdapursuplai.org/images/logo.png" alt="SASIKU Logo" class="w-10 h-10 object-contain">
                    <span class="text-2xl font-bold brand-font gradient-text">SASIKU</span>
                </a>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-lg mx-8">
                    <div class="relative w-full group">
                        <input type="text" placeholder="Cari kebutuhan harianmu..."
                            class="w-full pl-12 pr-4 py-3 rounded-full bg-white/80 border border-purple-100 focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all outline-none group-hover:shadow-lg">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-4">
                    <button class="p-2 hover:bg-purple-50 rounded-full transition-colors relative">
                        <i data-lucide="heart" class="w-6 h-6 text-gray-700"></i>
                    </button>
                    <button class="p-2 hover:bg-purple-50 rounded-full transition-colors relative group" onclick="toggleCart()">
                        <i data-lucide="shopping-cart" class="w-6 h-6 text-gray-700 group-hover:text-purple-600 transition-colors"></i>
                        <span id="cart-badge" class="absolute -top-1 -right-1 bg-gradient-to-r from-violet-500 to-pink-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center hidden">0</span>
                    </button>
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium hover:text-purple-600 transition-colors">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-purple-600 transition-colors">
                            Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Cart Sidebar -->
    <div id="cart-sidebar" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="toggleCart()"></div>
        <div class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-2xl transform transition-transform translate-x-full" id="cart-panel">
            <div class="flex flex-col h-full">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-2xl font-bold brand-font">Keranjang Belanja</h2>
                    <button onclick="toggleCart()" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6" id="cart-items">
                    <div class="text-center text-gray-400 mt-20">
                        <i data-lucide="shopping-bag" class="w-16 h-16 mx-auto mb-4 opacity-30"></i>
                        <p>Keranjang masih kosong</p>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 bg-gray-50">
                    <div class="flex justify-between mb-4 text-lg font-semibold">
                        <span>Total</span>
                        <span id="cart-total">Rp 0</span>
                    </div>
                    <button id="checkout-btn" onclick="goToCheckout()" class="w-full py-4 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-full font-semibold hover:shadow-lg transition-all">
                        Check Out Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-6 py-3 rounded-full shadow-2xl transform translate-y-20 opacity-0 transition-all duration-300 z-50 flex items-center space-x-2">
        <i data-lucide="check-circle" class="w-5 h-5 text-green-400"></i>
        <span id="toast-message">Produk ditambahkan ke keranjang</span>
    </div>

    @stack('scripts')

    <script>
        // Initialize Lucide Icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Go to checkout
        function goToCheckout() {
            const cart = JSON.parse(localStorage.getItem('sasiku_cart')) || [];

            if (cart.length === 0) {
                alert('Keranjang belanja kosong');
                return;
            }

            // Check if user is logged in
            @auth
                window.location.href = '{{ route('checkout') }}';
            @else
                // Redirect to login with return URL
                window.location.href = '{{ route('login') }}?redirect={{ route('checkout') }}';
            @endauth
        }
    </script>
</body>
</html>
