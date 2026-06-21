<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $products = [
            ['name' => 'Laptop', 'description' => 'High performance laptop', 'price' => 1500.00, 'stock' => 10],
            ['name' => 'Mouse', 'description' => 'Wireless mouse', 'price' => 25.00, 'stock' => 50],
            ['name' => 'Keyboard', 'description' => 'Mechanical keyboard', 'price' => 75.00, 'stock' => 30],
            ['name' => 'Monitor', 'description' => '27 inch monitor', 'price' => 300.00, 'stock' => 15],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
