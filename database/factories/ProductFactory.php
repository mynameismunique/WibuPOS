<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $names = [
            'Nendoroid ' . $this->faker->randomElement(['Naruto', 'Sasuke', 'Goku', 'Luffy', 'Gojo', 'Miku', 'Rem']),
            'Action Figure ' . $this->faker->randomElement(['One Piece', 'DBZ', 'JJK', 'Demon Slayer']),
            'Manga Volume ' . $this->faker->numberBetween(1, 50),
            'Dakimakura ' . $this->faker->randomElement(['Nezuko', 'Mai', 'Zero Two', 'Asuna']),
            'Gundam Model Kit ' . $this->faker->numberBetween(1, 20),
        ];

        return [
            'code' => 'PRD-' . $this->faker->unique()->numberBetween(1000, 9999),
            'name' => $this->faker->randomElement($names),
            'category_id' => Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id,
            'supplier_id' => Supplier::inRandomOrder()->first()->id ?? Supplier::factory()->create()->id,
            'purchase_price' => $this->faker->numberBetween(50000, 500000),
            'selling_price' => $this->faker->numberBetween(100000, 1000000),
            'stock' => $this->faker->numberBetween(1, 100),
            'min_stock' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->optional()->sentence(),
        ];
    }
}