<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Action Figure',
                'description' => 'Patung anime berkualitas tinggi',
                'created_at' => now(), 
                'updated_at' => now()],
            [
                'name' => 'Manga',
                'description' => 'Komik Jepang terbaru',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Anime DVD',
                'description' => 'Film dan series anime',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Merchandise',
                'description' => 'Aksesoris dan barang koleksi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Poster',
                'description' => 'Poster anime ukuran A3 dan A2',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Dakimakura',
                'description' => 'Bantal guling karakter favorit',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Gundam',
                'description' => 'Model kit robot Gundam',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'T-Shirt',
                'description' => 'Kaos anime exclusive',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}