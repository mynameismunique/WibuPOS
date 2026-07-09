<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Kamisama Wibupos',
                'email' => 'admin@wibupos.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kasir Chan',
                'email' => 'kasir@wibupos.com',
                'password' => Hash::make('password'),
                'role' => 'cashier',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kasir Sakura',
                'email' => 'sakura@wibupos.com',
                'password' => Hash::make('password'),
                'role' => 'cashier',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}