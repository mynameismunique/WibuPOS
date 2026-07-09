<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class; // Opsional, tapi bagus

    public function definition(): array
    {
        $categories = ['Action Figure', 'Manga', 'Anime DVD', 'Merchandise', 'Poster', 'Dakimakura', 'Gundam'];
        return [
            'name' => $this->faker->unique()->randomElement($categories),
            'description' => $this->faker->sentence(),
        ];
    }
}