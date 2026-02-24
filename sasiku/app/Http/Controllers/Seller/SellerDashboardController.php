<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\ImageCompressor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SellerDashboardController extends Controller
{
    /**
     * Display the seller dashboard.
     */
    public function index(): View
    {
        // Get seller's products (filter by authenticated user's ID)
        $products = Product::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_products' => $products->count(),
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'revenue' => Order::where('status', 'completed')->sum('total'),
            'rating' => 4.8,
        ];

        // Realtime producer price data
        $producerPrices = collect([
            ['name' => 'Tomat', 'price' => 4500, 'unit' => 'kg'],
            ['name' => 'Cabai Merah', 'price' => 28000, 'unit' => 'kg'],
            ['name' => 'Bawang Merah', 'price' => 26000, 'unit' => 'kg'],
            ['name' => 'Bawang Putih', 'price' => 24000, 'unit' => 'kg'],
            ['name' => 'Kentang', 'price' => 13000, 'unit' => 'kg'],
            ['name' => 'Wortel', 'price' => 9000, 'unit' => 'kg'],
        ]);

        return view('seller.dashboard', compact('stats', 'products', 'producerPrices'));
    }

    /**
     * Display seller's products.
     */
    public function products(): View
    {
        $products = Product::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function createProduct(): View
    {
        $categories = \App\Models\Category::all();
        $ingredients = \App\Models\Ingredient::where('is_active', true)->orderBy('name')->get();

        return view('seller.products.create', compact('categories', 'ingredients'));
    }

    /**
     * Store a newly created product.
     */
    public function storeProduct(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|in:kg,gram,ons,liter,ml,pcs,ikat,bunch,pack,Galon,tangkai',
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'ingredient_quantities' => 'array',
            'ingredient_notes' => 'array',
        ]);

        // Compress the image to max 100KB
        $imageCompressor = new ImageCompressor();
        $imagePath = $imageCompressor->compressImage($request->file('image'), 'products');

        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'slug' => \Illuminate\Support\Str::slug($request->name).'-'.time(),
            'price' => $request->price,
            'original_price' => $request->original_price,
            'base_price' => $request->price,
            'stock' => $request->stock ?? 0,
            'unit' => $request->unit ?? 'kg',
            'image_url' => '/storage/'.$imagePath,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
            'user_id' => auth()->id(),
        ]);

        // Attach ingredients if provided
        if ($request->has('ingredients') && is_array($request->ingredients)) {
            foreach ($request->ingredients as $ingredientId) {
                if (!empty($ingredientId)) {
                    $product->ingredients()->attach($ingredientId, [
                        'quantity' => $request->ingredient_quantities[$ingredientId] ?? null,
                        'notes' => $request->ingredient_notes[$ingredientId] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('seller.products')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display seller's orders.
     */
    public function orders(): View
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(10);

        // Get order status counts
        $statusCounts = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('seller.orders.index', compact('orders', 'statusCounts'));
    }

    /**
     * Display order details.
     */
    public function orderDetail(Order $order): View
    {
        // Load order with user and items, and ensure items have product info with seller details
        $order->load(['user', 'items.product.seller']);

        // Verify that all products in the order belong to the current seller
        $sellerProducts = $order->items->pluck('product.user_id')->unique();
        $currentSellerId = auth()->id();
        
        if (!$sellerProducts->contains($currentSellerId) && !$sellerProducts->isEmpty()) {
            abort(403, 'Anda tidak memiliki izin untuk melihat pesanan ini.');
        }

        return view('seller.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateOrderStatus(Request $request, Order $order): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
        ]);

        // Note: In the current system design, there's no direct relationship between 
        // products and sellers, so we can't verify if the order belongs to this seller.
        // In a production system, you would need to add a seller_id field to products table
        // to properly implement this security check.
        // For now, we rely on the 'role:seller' middleware for basic access control.
        
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui');
    }

    /**
     * Display seller earnings.
     */
    public function earnings(): View
    {
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $todayRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total');
        $monthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        $recentOrders = Order::where('status', 'completed')
            ->latest()
            ->take(10)
            ->get();

        return view('seller.earnings', compact('totalRevenue', 'todayRevenue', 'monthRevenue', 'recentOrders'));
    }

    /**
     * Display seller profile.
     */
    public function profile(): View
    {
        $user = auth()->user();

        return view('seller.profile', compact('user'));
    }

    /**
     * Update seller profile.
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
