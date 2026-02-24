<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SASIKU - Belanja Harian Jadi Elegan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-violet-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center p-4">

    <!-- Background Blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-white/10 rounded-full translate-x-1/2 translate-y-1/2 blur-3xl"></div>
    </div>

    <!-- Auth Card -->
    <div class="relative w-full max-w-md">
        @if (session('status'))
            <div class="mb-4 p-3 bg-white/20 backdrop-blur-sm text-white text-center rounded-xl text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl p-8 sm:p-10 animate-fade-in">
            <!-- Logo -->
            <div class="flex flex-col items-center mb-8">
                <img src="https://www.appdapursuplai.org/images/logo.png" alt="SASIKU Logo" class="w-16 h-16 object-contain mb-4">
                <h1 class="text-3xl font-bold brand-font gradient-text">SASIKU</h1>
                <p class="text-gray-500 mt-2">@yield('subtitle', 'Selamat datang di SASIKU')</p>
            </div>

            @yield('content')


            <!-- Footer -->
            <p class="text-center text-sm text-gray-500 mt-6">
                @yield('footer-link')
            </p>
        </div>
    </div>

    <script>
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
</body>
</html>
