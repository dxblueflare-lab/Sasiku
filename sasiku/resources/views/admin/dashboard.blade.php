@extends('layouts.admin', ['title' => 'Admin Dashboard | SASIKU', 'header' => ''])

@section('content')
<!-- Custom Header with Clock -->
<div class="flex justify-between items-center mb-8">
    <h1 class="text-2xl font-bold">Dashboard</h1>
    <div class="bg-gray-100 px-4 py-2 rounded-lg flex items-center">
        <i data-lucide="clock" class="w-5 h-5 mr-2 text-gray-600"></i>
        <span id="current-time" class="font-mono">--:--:--</span>
    </div>
</div>

<!-- Quick Actions -->
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold">Statistik Umum</h2>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-gradient-to-r from-violet-600 to-pink-600 text-white rounded-xl hover:shadow-lg transition-all flex items-center space-x-2">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Tambah Produk</span>
    </a>
</div>

<!-- Stat Cards -->
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
                <p class="text-gray-500 text-sm">Pengguna</p>
                <h2 class="text-3xl font-bold mt-1">{{ $stats['total_users'] }}</h2>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Sales Chart Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-lg">Grafik Penjualan</h3>
        <div class="flex space-x-2">
            <button id="dailySalesBtn" class="px-3 py-1 text-sm bg-purple-600 text-white rounded-lg active-btn">Harian</button>
            <button id="weeklySalesBtn" class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-lg">Mingguan</button>
            <button id="monthlySalesBtn" class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded-lg">Bulanan</button>
        </div>
    </div>
    <div class="h-80">
        <canvas id="salesChart"></canvas>
    </div>
</div>

<!-- Realtime Price Updates -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-bold text-lg">Update HET bahan Pokok Realtime</h2>
        <div class="flex items-center space-x-2 text-sm text-gray-500">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <span>Live</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" id="priceList">
        @foreach ($priceUpdates as $item)
        <div class="border border-gray-100 rounded-xl p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <span class="font-medium">{{ $item['name'] }}</span>
                <i data-lucide="trending-up" class="w-4 h-4 text-green-500"></i>
            </div>
            <div class="text-xl font-bold text-purple-600">
                Rp {{ number_format($item['price'], 0, ',', '.') }}
            </div>
            <div class="text-xs text-gray-400 mt-1">By:Badan Pangan Nasional</div>
        </div>
        @endforeach
    </div>
</div>
@append

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Realtime price fluctuation simulation
    const priceItems = document.querySelectorAll('#priceList > div');
    const basePrices = [
        {{ $priceUpdates->pluck('price')->map(fn($p) => $p)->implode(', ') }}
    ];

    function randomFluctuation(price) {
        const change = Math.floor(Math.random() * 3000) - 1500;
        return Math.max(price + change, 1000);
    }

    function updatePrices() {
        priceItems.forEach((item, index) => {
            const newPrice = randomFluctuation(basePrices[index]);
            basePrices[index] = newPrice;

            const priceEl = item.querySelector('.text-purple-600');
            if (priceEl) {
                priceEl.textContent = 'Rp ' + newPrice.toLocaleString('id-ID');
            }
        });
    }

    // Update every 10 seconds
    setInterval(updatePrices, 20000);

    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Prepare data from the recent orders
    const orderData = @json($recentOrders);
    
    // Extract labels and data for the chart
    const labels = orderData.map(order => order.id);
    const data = orderData.map(order => order.total);
    
    // Create the chart
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Penjualan',
                data: data,
                borderColor: 'rgb(147, 51, 234)', // purple-600
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
    
    // Time period buttons functionality
    document.getElementById('dailySalesBtn').addEventListener('click', function() {
        setActiveButton(this);
        // Update chart with daily data (for demo purposes, using same data)
        salesChart.data.datasets[0].data = orderData.map(order => order.total);
        salesChart.update();
    });
    
    document.getElementById('weeklySalesBtn').addEventListener('click', function() {
        setActiveButton(this);
        // Update chart with weekly data (for demo purposes, using modified data)
        salesChart.data.datasets[0].data = orderData.map(order => order.total * 1.2);
        salesChart.update();
    });
    
    document.getElementById('monthlySalesBtn').addEventListener('click', function() {
        setActiveButton(this);
        // Update chart with monthly data (for demo purposes, using modified data)
        salesChart.data.datasets[0].data = orderData.map(order => order.total * 0.8);
        salesChart.update();
    });
    
    function setActiveButton(clickedBtn) {
        // Remove active class from all buttons
        document.querySelectorAll('.active-btn').forEach(btn => {
            btn.classList.remove('active-btn');
            btn.classList.replace('bg-purple-600', 'bg-gray-200');
            btn.classList.replace('text-white', 'text-gray-700');
        });

        // Add active class to clicked button
        clickedBtn.classList.add('active-btn');
        clickedBtn.classList.replace('bg-gray-200', 'bg-purple-600');
        clickedBtn.classList.replace('text-gray-700', 'text-white');
    }

    // Clock functionality
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
    }

    // Update time immediately and then every second
    updateTime();
    setInterval(updateTime, 1000);
</script>
@endpush
