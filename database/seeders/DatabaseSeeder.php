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
            $this->call([
            CategorySeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
        ]);
    }
}