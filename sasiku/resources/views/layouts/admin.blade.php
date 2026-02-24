<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard | SASIKU')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @stack('styles')
    @stack('head')
</head>
<body class="bg-gray-100 text-gray-900">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-purple-600 to-pink-500 text-white shadow-xl flex-shrink-0">
        <div class="p-6 flex items-center space-x-3">
            <img src="https://www.appdapursuplai.org/images/logo.png" alt="SASIKU Logo" class="w-10 h-10 object-contain">
            <span class="text-2xl font-bold brand-font">SASIKU Admin</span>
        </div>

        <nav class="space-y-1 px-4">
            <!-- Main Menu -->
            <div class="pb-2">
                <p class="px-3 text-xs text-white/60 uppercase tracking-wider mb-2">Menu Utama</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'hover:bg-white/10' }} transition-colors">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.products') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.products*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition-colors">
                <i data-lucide="package" class="w-5 h-5"></i>
                <span>Produk</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.orders*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition-colors">
                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                <span>Pesanan</span>
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.users*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition-colors">
                <i data-lucide="users" class="w-5 h-5"></i>
                <span>Pengguna</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.reports') ? 'bg-white/20' : 'hover:bg-white/10' }} transition-colors">
                <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
                <span>Laporan</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-white/20' : 'hover:bg-white/10' }} transition-colors">
                <i data-lucide="settings" class="w-5 h-5"></i>
                <span>Pengaturan</span>
            </a>

            <!-- External Links -->
            <div class="pt-4 pb-2 mt-4">
                <div class="border-t border-white/20 my-2"></div>
                <p class="px-3 text-xs text-white/60 uppercase tracking-wider">Eksternal</p>
            </div>

            <a href="http://localhost/het.html" target="_blank" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors">
                <i data-lucide="external-link" class="w-5 h-5"></i>
                <span class="text-sm">CEK HET Disini</span>
            </a>
            <a href="http://localhost/blackbox.html" target="_blank" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors">
                <i data-lucide="external-link" class="w-5 h-5"></i>
                <span class="text-sm">CEK Regulasi Disini</span>
            </a>
            
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">@yield('header', 'Dashboard')</h1>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-500">Administrator</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-br from-violet-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 hover:bg-gray-100 rounded-full transition-colors" title="Logout">
                        <i data-lucide="log-out" class="w-5 h-5 text-gray-600"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Content -->
        <div class="p-8">
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
