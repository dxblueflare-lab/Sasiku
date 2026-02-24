<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert the Elektronik category
        DB::table('categories')->insert([
            'name' => 'Elektronik',
            'slug' => Str::slug('Elektronik'),
            'icon' => 'smartphone', // Using a relevant icon
            'sort_order' => 7, // Position after existing categories
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('categories')->where('slug', 'elektronik')->delete();
    }
};
