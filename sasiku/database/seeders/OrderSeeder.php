<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = \App\Models\User::role('customer')->get();
        $products = \App\Models\Product::where('is_active', true)->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No customers or products found. Skipping order seeding.');

            return;
        }

        $statuses = ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'];
        $addresses = [
            'Jl. Merdeka No. 123, Jakarta Pusat',
            'Jl. Sudirman No. 45, Jakarta Selatan',
            'Jl. Thamrin No. 78, Jakarta Pusat',
            'Jl. Gatot Subroto No. 90, Jakarta Selatan',
            'Jl. Rasuna Said No. 56, Kuningan',
        ];

        // Create 15 orders with different statuses
        for ($i = 1; $i <= 15; $i++) {
            $customer = $customers->random();
            $status = $statuses[array_rand($statuses)];

            // Generate random items for this order
            $itemCount = rand(1, 4);
            $selectedProducts = $products->random($itemCount);
            $total = 0;
            $items = [];

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 5);
                $price = $product->price;
                $subtotal = $price * $quantity;
                $total += $subtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];
            }

            $order = \App\Models\Order::create([
                'order_number' => 'ORD'.str_pad($i, 5, '0', STR_PAD_LEFT),
                'user_id' => $customer->id,
                'total' => $total,
                'status' => $status,
                'shipping_address' => $addresses[array_rand($addresses)],
                'phone' => '08'.rand(100000000, 999999999),
                'notes' => rand(0, 1) ? 'Tolong dikirim secepatnya. Terima kasih!' : null,
                'created_at' => now()->subDays(rand(0, 30)),
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            $this->command->info("Created order: {$order->order_number} with ".count($items).' items');
        }
    }
}
