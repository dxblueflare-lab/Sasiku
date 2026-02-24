<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Dashboard | SASIKU')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @stack('styles')
</head>
<body class="bg-gray-100 text-gray-900">

<div class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-purple-700 text-white flex-shrink-0">
        <div class="p-6">
            <div class="flex items-center space-x-3 mb-10">
                <img src="https://www.appdapursuplai.org/images/logo.png" alt="SASIKU Logo" class="w-10 h-10 object-contain">
                <span class="text-2xl font-bold brand-font">SASIKU</span>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('seller.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('seller.dashboard') ? 'bg-purple-600' : 'hover:bg-purple-600' }} transition-colors">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('seller.products') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('seller.products*') ? 'bg-purple-600' : 'hover:bg-purple-600' }} transition-colors">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span>Produk</span>
                </a>
                <a href="{{ route('seller.orders') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('seller.orders*') ? 'bg-purple-600' : 'hover:bg-purple-600' }} transition-colors">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    <span>Pesanan</span>
                </a>
                <a href="{{ route('seller.earnings') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('seller.earnings') ? 'bg-purple-600' : 'hover:bg-purple-600' }} transition-colors">
                    <i data-lucide="wallet" class="w-5 h-5"></i>
                    <span>Pendapatan</span>
                </a>
                <a href="{{ route('seller.profile') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('seller.profile') ? 'bg-purple-600' : 'hover:bg-purple-600' }} transition-colors">
                    <i data-lucide="user" class="w-5 h-5"></i>
                    <span>Profil</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-600 transition-colors w-full text-left">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <main class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white p-6 rounded-2xl shadow m-6 mb-0 flex justify-between items-center">
            <h1 class="text-2xl font-bold">@yield('header', 'Dashboard Seller')</h1>
            <div class="text-sm text-gray-500">
                Status Akun: <span class="text-green-600 font-semibold">Terverifikasi</span>
            </div>
        </header>

        <!-- Main Content -->
        <div class="p-6">
            @yield('content')
        </div>
    </main>

</div>

@stack('scripts')

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
</body>
</html>
