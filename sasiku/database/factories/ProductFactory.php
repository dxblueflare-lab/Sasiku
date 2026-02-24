<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => fake()->words(3, true),
            'slug' => str()->slug(),
            'description' => fake()->sentence(),
            'image_url' => fake()->imageUrl(400, 400, 'food'),
            'price' => fake()->randomFloat(2, 10000, 150000),
            'original_price' => fake()->optional()->randomFloat(2, 10000, 200000),
            'badge' => fake()->randomElement(['Organik', 'Best Seller', 'Segar', 'New', 'Limited', 'Promo', 'Premium', 'Superfood', null]),
            'rating' => fake()->randomFloat(1, 3.5, 5.0),
            'review_count' => fake()->numberBetween(0, 500),
            'is_active' => true,
            'is_organic' => fake()->boolean(30),
            'stock' => fake()->numberBetween(10, 200),
        ];
    }

    /**
     * Define the products from the reference design.
     *
     * @return array<string, mixed>
     */
    public function sasikuProducts(): array
    {
        return [
            [
                'name' => 'Bayam Hijau Organik',
                'slug' => 'bayam-hijau-organik',
                'description' => 'Bayam hijau segar organik langsung dari petani lokal. Kaya akan nutrisi dan serat.',
                'image_url' => 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=400&h=400&fit=crop',
                'price' => 12500,
                'original_price' => 15000,
                'badge' => 'Organik',
                'rating' => 4.8,
                'review_count' => 124,
                'is_organic' => true,
                'stock' => 50,
            ],
            [
                'name' => 'Apel Fuji Premium',
                'slug' => 'apel-fuji-premium',
                'description' => 'Apel Fuji premium manis dan segar. Cocok untuk camilan sehat sehari-hari.',
                'image_url' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=400&h=400&fit=crop',
                'price' => 35000,
                'original_price' => 42000,
                'badge' => 'Premium',
                'rating' => 4.9,
                'review_count' => 256,
                'is_organic' => true,
                'stock' => 80,
            ],
            [
                'name' => 'Daging Sapi Giling',
                'slug' => 'daging-sapi-giling',
                'description' => 'Daging sapi segar giling premium. 100% daging sapi pilihan tanpa pengawet.',
                'image_url' => 'https://images.unsplash.com/photo-1588168333986-5078d3ae3976?w=400&h=400&fit=crop',
                'price' => 85000,
                'original_price' => null,
                'badge' => 'Best Seller',
                'rating' => 4.7,
                'review_count' => 189,
                'is_organic' => false,
                'stock' => 30,
            ],
            [
                'name' => 'Matcha Latte Premium',
                'slug' => 'matcha-latte-premium',
                'description' => 'Matcha latte premium dari Jepang. Rasakan kelezatan matcha autentik.',
                'image_url' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?w=400&h=400&fit=crop',
                'price' => 28000,
                'original_price' => 35000,
                'badge' => 'Superfood',
                'rating' => 4.6,
                'review_count' => 98,
                'is_organic' => true,
                'stock' => 60,
            ],
            [
                'name' => 'Keripik Kentang Artisan',
                'slug' => 'keripik-kentang-artisan',
                'description' => 'Keripik kentang artisan dengan berbagai pilihan rasa. Renyah dan gurih.',
                'image_url' => 'https://images.unsplash.com/photo-1576179635662-9d1983e97e1e?w=400&h=400&fit=crop',
                'price' => 22000,
                'original_price' => null,
                'badge' => 'Segar',
                'rating' => 4.5,
                'review_count' => 76,
                'is_organic' => false,
                'stock' => 100,
            ],
            [
                'name' => 'Tisu Basah Premium',
                'slug' => 'tisu-basah-premium',
                'description' => 'Tisu basah premium dengan ekstrak aloe vera. Lembut dan aman untuk kulit.',
                'image_url' => 'https://images.unsplash.com/photo-1584030373081-f37b8bb9b42f?w=400&h=400&fit=crop',
                'price' => 18500,
                'original_price' => 22000,
                'badge' => 'Promo',
                'rating' => 4.4,
                'review_count' => 145,
                'is_organic' => false,
                'stock' => 200,
            ],
            [
                'name' => 'Salmon Fillet Norway',
                'slug' => 'salmon-fillet-norway',
                'description' => 'Salmon fillet segar dari Norway. Kaya akan Omega-3 dan protein berkualitas.',
                'image_url' => 'https://images.unsplash.com/photo-1599084993091-1cb5c0721cc6?w=400&h=400&fit=crop',
                'price' => 120000,
                'original_price' => 145000,
                'badge' => 'Premium',
                'rating' => 4.9,
                'review_count' => 67,
                'is_organic' => false,
                'stock' => 25,
            ],
            [
                'name' => 'Avocado Hass',
                'slug' => 'avocado-hass',
                'description' => 'Avocado Hass premium creamy. Sempurna untuk toast, smoothie, atau salad.',
                'image_url' => 'https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?w=400&h=400&fit=crop',
                'price' => 28000,
                'original_price' => 32000,
                'badge' => 'Superfood',
                'rating' => 4.7,
                'review_count' => 203,
                'is_organic' => true,
                'stock' => 45,
            ],
        ];
    }
}
