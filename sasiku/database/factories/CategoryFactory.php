<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => str()->slug(),
            'name' => fake()->word(),
            'icon' => fake()->randomElement(['grid', 'carrot', 'apple', 'beef', 'cookie', 'cup-soda', 'home']),
            'sort_order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }

    /**
     * Define the categories from the reference design.
     *
     * @return array<string, mixed>
     */
    public function sasikuCategories(): array
    {
        return [
            ['slug' => 'all', 'name' => 'Semua', 'icon' => 'grid', 'sort_order' => 0],
            ['slug' => 'sayur', 'name' => 'Sayur Segar', 'icon' => 'carrot', 'sort_order' => 1],
            ['slug' => 'buah', 'name' => 'Buah-buahan', 'icon' => 'apple', 'sort_order' => 2],
            ['slug' => 'daging', 'name' => 'Daging & Ikan', 'icon' => 'beef', 'sort_order' => 3],
            ['slug' => 'snack', 'name' => 'Snack', 'icon' => 'cookie', 'sort_order' => 4],
            ['slug' => 'minuman', 'name' => 'Minuman', 'icon' => 'cup-soda', 'sort_order' => 5],
            ['slug' => 'kebutuhan', 'name' => 'Kebutuhan Rumah', 'icon' => 'home', 'sort_order' => 6],
            ['slug' => 'elektronik', 'name' => 'Elektronik', 'icon' => 'smartphone', 'sort_order' => 7],
        ];
    }
}
