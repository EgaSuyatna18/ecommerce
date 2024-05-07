<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Cart;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'role' => 'Admin',
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123')
        ]);

        User::factory()->create([
            'role' => 'Seller',
            'name' => 'Seller',
            'email' => 'seller@user.com',
            'password' => Hash::make('123')
        ]);

        User::factory()->create([
            'role' => 'Buyer',
            'name' => 'Buyer',
            'email' => 'buyer@user.com',
            'password' => Hash::make('123')
        ]);

        Store::factory()->create([
            'user_id' => 2,
            'store_image' => 'assets/default/store.png',
            'store_name' => 'Test Store',
            'address_id' => '12',
            'address' => 'Agam'
        ]);

        Product::factory(10)->create();

        Cart::factory(10)->create();
    }
}
