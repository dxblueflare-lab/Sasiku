<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => 0, // TODO: Create Order model
            'total_revenue' => 0, // TODO: Calculate from orders
            'total_users' => User::count(),
        ];

        // Recent sample orders (placeholder data)
        $recentOrders = collect([
            ['id' => '#INV001', 'customer' => 'Andy', 'total' => 125000, 'status' => 'Selesai'],
            ['id' => '#INV002', 'customer' => 'Masyithah', 'total' => 250000, 'status' => 'Selesai'],
            ['id' => '#INV003', 'customer' => 'Andy', 'total' => 180000, 'status' => 'Selesai'],
            ['id' => '#INV004', 'customer' => 'Masyithah', 'total' => 200000, 'status' => 'Selesai'],
        ]);

        // Realtime price data (placeholder) - use collection
        $priceUpdates = collect([
            ['name' => 'Cabai Merah', 'price' => 45000],
            ['name' => 'Bawang Merah', 'price' => 32000],
            ['name' => 'Daging Sapi', 'price' => 118000],
            ['name' => 'Ayam Broiler', 'price' => 36000],
        ]);

        return view('admin.dashboard', compact('stats', 'recentOrders', 'priceUpdates'));
    }
}
