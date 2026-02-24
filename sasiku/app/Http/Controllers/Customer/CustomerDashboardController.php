<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();

        // Get recent orders for this customer
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => '#'.($order->order_number ?? $order->id),
                    'date' => $order->created_at->format('d M Y'),
                    'total' => $order->total,
                    'status' => ucfirst($order->status),
                    'items' => $order->items()->count(),
                ];
            });

        return view('customer.dashboard', compact('user', 'recentOrders'));
    }

    /**
     * Display customer's orders.
     */
    public function orders(): View
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display order details.
     */
    public function orderDetail(Order $order): View
    {
        // Verify ownership - user must own the order
        if (auth()->id() !== $order->user_id) {
            abort(403);
        }

        $order->load(['items.product', 'user']);

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Display customer's favorites.
     */
    public function favorites(): View
    {
        // TODO: Implement favorites functionality with wishlist table
        // For now, show empty state
        $products = collect();

        return view('customer.favorites', compact('products'));
    }

    /**
     * Display customer profile.
     */
    public function profile(): View
    {
        $user = auth()->user();

        return view('customer.profile', compact('user'));
    }

    /**
     * Update customer profile.
     */
    public function updateProfile(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.auth()->id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        auth()->user()->update($request->only('name', 'email', 'phone', 'address'));

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
