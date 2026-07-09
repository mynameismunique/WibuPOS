<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Kamisama Wibupos',
            'email' => 'admin@wibupos.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kasir Chan',
            'email' => 'kasir@wibupos.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
        ]);

        User::create([
            'name' => 'Kasir Sakura',
            'email' => 'sakura@wibupos.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
        ]);

        Category::factory(5)->create();

        Supplier::factory(5)->create();

        Product::factory(20)->create();
    }
}