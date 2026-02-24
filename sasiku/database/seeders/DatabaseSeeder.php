<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $adminRole = Role::where('name', 'admin')->first();
        $sellerRole = Role::where('name', 'seller')->first();
        $customerRole = Role::where('name', 'customer')->first();

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@sasiku.com'],
            [
                'name' => 'Admin SASIKU',
                'password' => Hash::make('password'),
            ]
        );
        if ($adminRole) {
            $admin->assignRole($adminRole);
        }

        // Create seller user
        $seller = User::firstOrCreate(
            ['email' => 'seller@sasiku.com'],
            [
                'name' => 'Seller SASIKU',
                'password' => Hash::make('password'),
            ]
        );
        if ($sellerRole) {
            $seller->assignRole($sellerRole);
        }

        // Create customer user
        $customer = User::firstOrCreate(
            ['email' => 'customer@sasiku.com'],
            [
                'name' => 'Customer SASIKU',
                'password' => Hash::make('password'),
            ]
        );
        if ($customerRole) {
            $customer->assignRole($customerRole);
        }
    }
}
