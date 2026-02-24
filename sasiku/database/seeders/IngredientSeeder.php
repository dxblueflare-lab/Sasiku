<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Tomat', 'description' => 'Buah-buahan segar yang biasa digunakan dalam masakan', 'category' => 'Sayuran'],
            ['name' => 'Bawang Merah', 'description' => 'Bumbu dasar dalam masakan Indonesia', 'category' => 'Bumbu'],
            ['name' => 'Bawang Putih', 'description' => 'Bumbu aromatik yang sering digunakan', 'category' => 'Bumbu'],
            ['name' => 'Cabai Merah', 'description' => 'Cabai besar yang memberikan rasa pedas', 'category' => 'Bumbu'],
            ['name' => 'Cabai Rawit', 'description' => 'Cabai kecil yang sangat pedas', 'category' => 'Bumbu'],
            ['name' => 'Wortel', 'description' => 'Sayuran akar yang kaya akan vitamin A', 'category' => 'Sayuran'],
            ['name' => 'Kentang', 'description' => 'Sayuran umbi yang serbaguna', 'category' => 'Sayuran'],
            ['name' => 'Bayam', 'description' => 'Sayuran hijau yang kaya zat besi', 'category' => 'Sayuran'],
            ['name' => 'Kangkung', 'description' => 'Sayuran hijau yang lembut', 'category' => 'Sayuran'],
            ['name' => 'Daun Bawang', 'description' => 'Herba aromatik untuk pelengkap makanan', 'category' => 'Herba'],
            ['name' => 'Seledri', 'description' => 'Herba dengan aroma khas', 'category' => 'Herba'],
            ['name' => 'Jahe', 'description' => 'Rimpang yang memberikan rasa hangat', 'category' => 'Rempah'],
            ['name' => 'Kunyit', 'description' => 'Rimpang kuning yang berkhasiat', 'category' => 'Rempah'],
            ['name' => 'Lengkuas', 'description' => 'Rimpang aromatik dalam masakan', 'category' => 'Rempah'],
            ['name' => 'Serai', 'description' => 'Herba aromatik dalam masakan Asia', 'category' => 'Herba'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
