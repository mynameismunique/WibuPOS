<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('suppliers')->insert([
            [
                'name' => 'AnimeShop Indonesia',
                'contact_person' => 'Syarahil Moch Hibatullah',
                'phone' => '081234567890',
                'email' => 'info@animeshop.co.id',
                'address' => 'Jl. Mangga Dua Raya No. 45, Jakarta Pusat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wibu Store Jakarta',
                'contact_person' => 'Adhitia Ridwanulloh',
                'phone' => '082345678901',
                'email' => 'wibu.store@wibustore.com',
                'address' => 'Jl. Gatot Subroto No. 12, Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Otaku Merchandise',
                'contact_person' => 'Bonardo Mandopa',
                'phone' => '083456789012',
                'email' => 'otaku.merch@otakumerch.com',
                'address' => 'Jl. Malioboro No. 78, Yogyakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Manga Importir',
                'contact_person' => 'Ipan',
                'phone' => '084567890123',
                'email' => 'manga.import@mangaimport.com',
                'address' => 'Jl. Raya Surabaya No. 34, Surabaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gundam Factory',
                'contact_person' => 'Achmad Nurfauzy',
                'phone' => '085678901234',
                'email' => 'gundam.factory@gundamfactory.com',
                'address' => 'Jl. Industri No. 56, Tangerang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}