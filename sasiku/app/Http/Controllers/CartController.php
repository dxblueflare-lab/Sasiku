<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get cart items (for logged in users from session or guest from localStorage)
     */
    public function index(Request $request): JsonResponse
    {
        $cart = $request->input('cart', []);

        $productIds = collect($cart)->pluck('id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $items = collect($cart)->map(function ($item) use ($products) {
            $product = $products->get($item['id']);
            if (! $product) {
                return null;
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image' => $product->image_url,
                'quantity' => $item['quantity'] ?? 1,
                'stock' => $product->stock ?? 100,
                'subtotal' => (float) $product->price * ($item['quantity'] ?? 1),
            ];
        })->filter()->values();

        $total = $items->sum('subtotal');

        return response()->json([
            'items' => $items,
            'total' => $total,
            'count' => $items->sum('quantity'),
        ]);
    }

    /**
     * Validate cart items (stock check)
     */
    public function validateCart(Request $request): JsonResponse
    {
        $cart = $request->input('cart', []);

        $productIds = collect($cart)->pluck('id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $unavailable = [];

        foreach ($cart as $item) {
            $product = $products->get($item['id']);
            if (! $product) {
                $unavailable[] = [
                    'id' => $item['id'],
                    'name' => $item['name'] ?? 'Unknown',
                    'reason' => 'Produk tidak ditemukan',
                ];
            } elseif (! $product->is_active) {
                $unavailable[] = [
                    'id' => $item['id'],
                    'name' => $product->name,
                    'reason' => 'Produk tidak tersedia',
                ];
            } elseif (($product->stock ?? 0) < ($item['quantity'] ?? 1)) {
                $unavailable[] = [
                    'id' => $item['id'],
                    'name' => $product->name,
                    'reason' => 'Stok tidak mencukupi (tersedia: '.$product->stock.')',
                ];
            }
        }

        return response()->json([
            'valid' => empty($unavailable),
            'unavailable' => $unavailable,
        ]);
    }
}
