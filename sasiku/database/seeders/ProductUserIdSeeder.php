<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductUserIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user ID yang tersedia
        $userIds = \App\Models\User::pluck('id')->toArray();
        
        if (empty($userIds)) {
            $this->command->info('Tidak ada user ditemukan. Silakan buat user terlebih dahulu.');
            return;
        }
        
        // Ambil produk-produk yang tidak memiliki user_id
        $products = \App\Models\Product::whereNull('user_id')->get();
        
        foreach ($products as $product) {
            // Tetapkan user_id secara acak dari daftar user yang tersedia
            $randomUserId = $userIds[array_rand($userIds)];
            $product->update(['user_id' => $randomUserId]);
            
            $this->command->info("Produk {$product->name} telah diberi user_id: {$randomUserId}");
        }
        
        $this->command->info('Seeder ProductUserIdSeeder selesai.');
    }
}
