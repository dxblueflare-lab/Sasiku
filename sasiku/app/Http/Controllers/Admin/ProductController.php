<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ImageCompressor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'seller'])->select([
            'id',
            'name',
            'slug',
            'category_id',
            'user_id',
            'price',
            'base_price',
            'original_price',
            'stock',
            'unit',
            'image_url',
            'is_active',
            'created_at',
        ]);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = \App\Models\Category::all();
        $ingredients = \App\Models\Ingredient::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'ingredients'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
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
            'slug' => \Illuminate\Support\Str::slug($request->name).'-'.time().'-'.rand(1000, 9999), // Added random number to prevent conflicts
            'price' => $request->price,
            'original_price' => $request->original_price,
            'base_price' => $request->price, // Ensure base_price is set during creation
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

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Update product price via AJAX.
     */
    public function updatePrice(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            'price' => 'required|numeric|min:1000',
        ]);

        $product->update([
            'price' => $request->price,
        ]);

        // Set base_price if not set
        if (! $product->base_price) {
            $product->update(['base_price' => $request->price]);
        }

        return response()->json([
            'success' => true,
            'price' => $product->price,
        ]);
    }

    /**
     * Get all products with real-time prices.
     */
    public function realtimePrices(): JsonResponse
    {
        $products = Product::select(['id', 'price', 'base_price'])->get();

        // Apply random fluctuation to each product price
        $prices = $products->map(function ($product) {
            $basePrice = $product->base_price ?? $product->price;
            $currentPrice = $product->price;

            // Calculate new price with fluctuation
            $change = rand(-1500, 1500);
            $newPrice = max($currentPrice + $change, 1000);

            // Update in database
            $product->update(['price' => $newPrice]);

            return [
                'id' => $product->id,
                'price' => $newPrice,
            ];
        });

        return response()->json([
            'prices' => $prices,
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        $product->load('seller');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $product->load('seller', 'ingredients');
        $categories = \App\Models\Category::all();
        $ingredients = \App\Models\Ingredient::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'ingredients'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(\Illuminate\Http\Request $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|in:kg,gram,ons,liter,ml,pcs,ikat,bunch,pack,Galon,tangkai',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'ingredients' => 'array',
            'ingredients.*' => 'exists:ingredients,id',
            'ingredient_quantities' => 'array',
            'ingredient_notes' => 'array',
        ]);

        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'slug' => \Illuminate\Support\Str::slug($request->name).'-'.time().'-'.rand(1000, 9999), // Added random number to prevent conflicts
            'price' => $request->price,
            'original_price' => $request->original_price,
            'stock' => $request->stock ?? 0,
            'unit' => $request->unit ?? 'kg',
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
        ];
        
        // Only update base_price if it hasn't been set before (during initial creation)
        if (!$product->base_price) {
            $data['base_price'] = $request->price;
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $product->image_url);
                if (\Storage::disk('public')->exists($oldPath)) {
                    \Storage::disk('public')->delete($oldPath);
                }
            }

            // Compress the image to max 100KB
            $imageCompressor = new ImageCompressor();
            $imagePath = $imageCompressor->compressImage($request->file('image'), 'products');
            $data['image_url'] = '/storage/'.$imagePath;
        }

        $product->update($data);

        // Sync ingredients if provided
        if ($request->has('ingredients')) {
            $ingredientsData = [];
            if (is_array($request->ingredients)) {
                foreach ($request->ingredients as $ingredientId) {
                    if (!empty($ingredientId)) {
                        $ingredientsData[$ingredientId] = [
                            'quantity' => $request->ingredient_quantities[$ingredientId] ?? null,
                            'notes' => $request->ingredient_notes[$ingredientId] ?? null,
                        ];
                    }
                }
            }
            $product->ingredients()->sync($ingredientsData);
        } else {
            // If no ingredients are provided, detach all existing ones
            $product->ingredients()->detach();
        }

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): \Illuminate\Http\RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus');
    }
}
