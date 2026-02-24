<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index(): View
    {
        $user = auth()->user();

        return view('checkout', compact('user'));
    }

    /**
     * Process the order
     */
    public function store(StoreOrderRequest $request): RedirectResponse|JsonResponse
    {
        $cart = $request->input('cart', []);

        if (empty($cart)) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Keranjang belanja kosong'], 422);
            }
            return back()->with('error', 'Keranjang belanja kosong');
        }

        $productIds = collect($cart)->pluck('id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            $orderItemsData = [];

            foreach ($cart as $item) {
                $product = $products->get($item['id']);
                if (! $product || ! $product->is_active) {
                    continue;
                }

                $quantity = $item['quantity'] ?? 1;
                $price = (float) $product->price;
                $itemSubtotal = $price * $quantity;

                $subtotal += $itemSubtotal;

                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $itemSubtotal,
                ];

                // Update stock
                if ($product->stock !== null) {
                    $product->decrement('stock', $quantity);
                }
            }

            // Calculate shipping cost (simple flat rate for now)
            $shippingCost = $subtotal > 500000 ? 0 : 15000;
            $total = $subtotal + $shippingCost;

            // Generate order number
            $orderNumber = 'ORD'.date('Ymd').str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'phone' => $request->shipping_phone,
                'notes' => $request->notes,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
            ]);

            // Create order items
            foreach ($orderItemsData as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product_id'],
                    'product_name' => $itemData['product_name'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'subtotal' => $itemData['subtotal'],
                ]);
            }

            DB::commit();

            // Clear cart from localStorage (will be done on success page)
            if ($request->wantsJson()) {
                return response()->json([
                    'redirect' => route('checkout.success', $order),
                    'message' => 'Pesanan berhasil dibuat!',
                    'order_number' => $orderNumber,
                ]);
            }

            return redirect()
                ->route('checkout.success', $order)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Terjadi kesalahan: '.$e->getMessage()], 500);
            }

            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    /**
     * Display order success page
     */
    public function success(Order $order): View
    {
        // Verify ownership
        if (auth()->id() !== $order->user_id) {
            abort(403);
        }

        $order->load('items');

        return view('checkout-success', compact('order'));
    }
}
