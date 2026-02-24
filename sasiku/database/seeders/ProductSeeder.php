<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Database\Factories\ProductFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = (new ProductFactory)->sasikuProducts();

        // Map category slugs to IDs
        $categoryMap = [
            'sayur' => Category::where('slug', 'sayur')->first()?->id,
            'buah' => Category::where('slug', 'buah')->first()?->id,
            'daging' => Category::where('slug', 'daging')->first()?->id,
            'snack' => Category::where('slug', 'snack')->first()?->id,
            'minuman' => Category::where('slug', 'minuman')->first()?->id,
            'kebutuhan' => Category::where('slug', 'kebutuhan')->first()?->id,
        ];

        // Assign categories to products based on product type
        $productCategories = [
            'bayam-hijau-organik' => $categoryMap['sayur'],
            'apel-fuji-premium' => $categoryMap['buah'],
            'daging-sapi-giling' => $categoryMap['daging'],
            'matcha-latte-premium' => $categoryMap['minuman'],
            'keripik-kentang-artisan' => $categoryMap['snack'],
            'tisu-basah-premium' => $categoryMap['kebutuhan'],
            'salmon-fillet-norway' => $categoryMap['daging'],
            'avocado-hass' => $categoryMap['buah'],
        ];

        foreach ($products as $product) {
            $categoryId = $productCategories[$product['slug']] ?? null;

            Product::firstOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, ['category_id' => $categoryId])
            );
        }
    }
}
