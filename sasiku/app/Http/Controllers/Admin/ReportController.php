<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderReportExport;

class ReportController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_products' => Product::count(),
            'total_users' => User::count(),
            'total_orders' => \App\Models\Order::count(),
            'total_revenue' => \App\Models\Order::where('status', 'selesai')->sum('total'),
        ];

        // Get products by category for report
        $productsByCategory = \App\Models\Category::withCount('products')->get();

        // Get users by role
        $usersByRole = [
            'admin' => User::role('admin')->count(),
            'seller' => User::role('seller')->count(),
            'customer' => User::role('customer')->count(),
        ];

        // Get orders by status
        $ordersByStatus = [
            'pending' => \App\Models\Order::where('status', 'pending')->count(),
            'diproses' => \App\Models\Order::where('status', 'diproses')->count(),
            'dikirim' => \App\Models\Order::where('status', 'dikirim')->count(),
            'selesai' => \App\Models\Order::where('status', 'selesai')->count(),
            'dibatalkan' => \App\Models\Order::where('status', 'dibatalkan')->count(),
        ];

        return view('admin.reports.index', compact('stats', 'productsByCategory', 'usersByRole', 'ordersByStatus'));
    }

    public function downloadOrders()
    {
        return Excel::download(new OrderReportExport, 'laporan_pesanan_' . date('Y-m-d_H-i-s') . '.xls');
    }
}
